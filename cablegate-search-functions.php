<?php
include_once('dbconnect.php');
include_once('globals.php');
include_once('finediff.php');

/*****************************************************************************/

// This class is used to index the current content of the
// Cablegate library.
//
// The indexing can be full or incremental. A full indexing ensure the index
// data is optimized, but generate a huge amount of SQL statements to build
// the index data in the database. An incremental indexing generate the
// minimum amount of SQL statements, at the expense of the index data ever
// slightly moving away from its optimal state. It might be a good idea
// to go through a full indexing once in a long while.
//
// The class does not write to the database, it rather generate the
// SQL statements required to bring the index data up to date.
//
// A PHP command-line client should be used in case of indexing, as
// this remove the memory/CPU limits. Usage example:
//
//   // use 'true' for incremental indexing
//   $cablegate_indexer = new Cablegate_Indexer(false);
//   $cablegate_indexer->index_to_sql_statements("indexing.sql");

class Cablegate_Indexer {

	// class' public area

	// magic values so that content of specific fields can be searched for
	// without worrying about hits in other fields
	public static $ORIGIN_PRESENTER = '78a8445uz7ss';
	public static $COUNTRY_PRESENTER = 'ov7upap4fbi7';
	public static $CLASSIFICATION_PRESENTER = 'ta92vhwid597';
	public static $HEADER_PRESENTER = 'iuq7ynn6veok';
	public static $BODY_PRESENTER = '45nc834q9iak';

	// Generate a variable-length token
	// first bit of first byte of a variable-length token
	// is always 0, otherwise 1
	public static function get_variable_length_token_from_id($term_id) {
		assert($term_id);
		$token_str = '';
		while ( $term_id ) {
			$token_char = $term_id & 0x7F;
			$term_id >>= 7;
			if ( $term_id ) {
				$token_char |= 0x80;
				}
			$token_str .= pack('C', $token_char);
			}
		return $token_str;
		}

	// $extra_chars allows the caller to have his own valid characters,
	// useful for when particular characters are used as search operators
	// for further processing. At indexing time however, there are no
	// such extra characters.
	public static function get_normalized_terms_from_text($text, $extra_chars = '') {
		// normalize...
		// ... accented characters
		$text = strtr(
			$text,
			"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
			"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
			);
		// ... case
		$text = strtolower($text);

		// split into words
		$word_chars = '0123456789abcdefghijklmnopqrstuvwxyz' . $extra_chars;
		$terms = array();
		$start = $end = 0;
		for (;;) {
			// skip to next word
			$end += strcspn($text, $word_chars, $end);
			$start = $end;

			// skip to next non-word
			$end += strspn($text, $word_chars, $end);
			if ( $end === $start ) {
				break;
				}

			$term = substr($text, $start, $end - $start);

			// specific processing

			// remove leading zeroes of numbers
			if ( $term[0] === '0' ) {
				if ( ctype_digit($term) ) {
					$term = preg_replace('/^0+(\\d+)$/', '\\1', $term);
					}
				}

			// normalize sequences of 3 or more 'x' as 3 'x'
			else if ( $term[0] === 'x' ) {
				$term = preg_replace('/^x{3,}$/', 'xxx', $term);
				}

			// TODO: in many cases, the redacted part is merged with
			// the following/previous unredacted word: fix this

			// TODO: fix typos, merged words, etc.? For suspected
			// typos, index best guess as well?

			$terms[] = $term;
			}

		return $terms;
		}

	public static function get_country_filter($country) {
		return   Cablegate_Indexer::$COUNTRY_PRESENTER
		       . '-'
		       . Cablegate_Indexer::get_expression_hash($country);
		}

	public static function get_origin_filter($origin) {
		return   Cablegate_Indexer::$ORIGIN_PRESENTER
		       . '-'
		       . Cablegate_Indexer::get_expression_hash($origin);
		}

	public static function get_classification_filter($classification) {
		return   Cablegate_Indexer::$CLASSIFICATION_PRESENTER
		       . '-'
		       . Cablegate_Indexer::get_expression_hash($classification);
		}

	/*********************************************************************/

	// instances' public area

	public function __construct($starttime = PHP_INT_MAX) {
		$this->incremental = $starttime !== 0;

		// collect details about all existing terms
		$this->term_id_generator = 1;
		$this->in_db_term_id_to_term_map = array();
		printf("\nCablegate_Indexer::__construct(): Fetching list of terms...");
		$sqlquery = "SELECT `id`,`term` FROM `cablegate_terms`";
		$sqlresult = db_query($sqlquery);
		assert($sqlresult);
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$term_id = intval($sqlrow['id']);
			$term = $sqlrow['term'];
			$this->term_to_properties_map["s{$term}"] = array(
				'provisional_id' => $term_id,
				'final_id' => $term_id,
				'count' => 0,
				);
			$this->term_id_generator = max($this->term_id_generator, $term_id+1);
			$this->in_db_term_id_to_term_map[$term_id] = $term;
			}
		printf("\nCablegate_Indexer::__construct(): %d terms fetched.", count($this->term_to_properties_map));

		// collect cable ids which need indexing
		$this->cable_ids = array();
		$this->in_db_cable_id_to_tokenized_content_hash_map = array();
		printf("\nCablegate_Indexer::__construct(): Fetching list of cables ids...");
		// if a time value is provided, use it against `change_time` to
		// determine which cables need reindexing, otherwise only reindex cables
		// which are not indexed at all
		$sqlquery = "SELECT c.`id` FROM `cablegate_cables` c ";
		if ( $starttime !== 0 ) {
			if ( $starttime !== PHP_INT_MAX ) {
				$sqlquery = $sqlquery
						  . "WHERE c.`change_time` >= {$starttime}"
						  ;
				}
			else {
				$sqlquery = $sqlquery
						  . "LEFT JOIN `cablegate_contents` co "
						  . "ON c.`id` = co.`id` "
						  . "WHERE co.`id` IS NULL"
						  ;
				}
			}
		$sqlresult = db_query($sqlquery);
		assert($sqlresult);
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$cable_id = intval($sqlrow['id']);
			$this->cable_ids[$cable_id] = $cable_id;
			$this->in_db_cable_id_to_tokenized_content_hash_map[$cable_id] = '';
			}
		printf("\nCablegate_Indexer::__construct(): %d cables ids fetched.", count($this->cable_ids));

		// collect hashes of tokenized content of cables to process
		if ( count($this->cable_ids) ) {
			$min_cable_id = min($this->cable_ids);
			$max_cable_id = max($this->cable_ids);
			$sqlquery = "SELECT `id`,`hash` "
				      . "FROM `cablegate_contents` "
				      . "WHERE `id` >= {$min_cable_id} AND `id` <={$max_cable_id}";
			if ( $sqlresult = db_query($sqlquery) ) {
				while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
					$cable_id = intval($sqlrow['id']);
					if ( isset($this->cable_ids[$cable_id]) ) {
						$this->in_db_cable_id_to_tokenized_content_hash_map[$cable_id] = $sqlrow['hash'];
						}
					}
				}
			}
		}

	public function index_to_sql_statements($filename) {
		$this->gather_all();
		// skip if optimization if incremental
		if ( $this->incremental ) {
			$this->generate_sql_statements_incremental($filename);
			}
		else {
			$this->optimize();
			$this->generate_sql_statements_full($filename);
			}
		}

	/*********************************************************************/

	// private stuff area

	private function gather_all() {
		// store presenters locally, so that we can expand within
		// string literals
		$origin_presenter = Cablegate_Indexer::$ORIGIN_PRESENTER;
		$country_presenter = Cablegate_Indexer::$COUNTRY_PRESENTER;
		$classification_presenter = Cablegate_Indexer::$CLASSIFICATION_PRESENTER;
		$header_presenter = Cablegate_Indexer::$HEADER_PRESENTER;
		$body_presenter = Cablegate_Indexer::$BODY_PRESENTER;
		$expression_hashes = array();

		// first analyze text to index
		printf("\nAnalyzing contents of all cables...");

		foreach ( $this->cable_ids as $cable_id ) {
			$cable_fields = $this->get_searchable_fields($cable_id);

			// TODO: preload all outside loop?
			if ( !isset($expression_hashes[$cable_fields['origin']]) ) {
				$expression_hashes[$cable_fields['origin']] = Cablegate_Indexer::get_expression_hash($cable_fields['origin']);
				}
			if ( !isset($expression_hashes[$cable_fields['country']]) ) {
				$expression_hashes[$cable_fields['country']] = Cablegate_Indexer::get_expression_hash($cable_fields['country']);
				}
			if ( !isset($expression_hashes[$cable_fields['classification']]) ) {
				$expression_hashes[$cable_fields['classification']] = Cablegate_Indexer::get_expression_hash($cable_fields['classification']);
				}

			// merge together info to be included in index
			$text_to_index =
				  "{$cable_fields['canonical_id']}\n"
				. "{$origin_presenter} {$cable_fields['origin']}\n"
				. "{$origin_presenter} {$expression_hashes[$cable_fields['origin']]}\n"
				. "{$country_presenter} {$cable_fields['country']}\n"
				. "{$country_presenter} {$expression_hashes[$cable_fields['country']]}\n"
				. "{$classification_presenter} {$cable_fields['classification']}\n"
				. "{$classification_presenter} {$expression_hashes[$cable_fields['classification']]}\n"
				. "{$header_presenter} {$cable_fields['header']}\n"
				. "{$body_presenter} {$cable_fields['body']}\n"
				;

			$this->gather_one($cable_id, $text_to_index);
			}
		}

	private function gather_one($cable_id, $text) {
		$tokenized_content = array();
		foreach ( Cablegate_Indexer::get_normalized_terms_from_text($text) as $term ) {
			// create an entry if this is a new term
			if ( !isset($this->term_to_properties_map["s{$term}"]) ) {
				$provisional_id = $this->term_id_generator++;
				$this->term_to_properties_map["s{$term}"] = array(
					'provisional_id' => $provisional_id,
					'final_id' => $provisional_id,
					'count' => 1,
					);
				$tokenized_content[] = $provisional_id;
				}
			else {
				$this->term_to_properties_map["s{$term}"]['count']++;
				$tokenized_content[] = $this->term_to_properties_map["s{$term}"]['provisional_id'];
				}
			}
		$this->cable_id_to_tokenized_content_map[$cable_id] = implode(',', $tokenized_content);
		}

	private function get_searchable_fields($cable_id) {
		global $CABLE_CONTENT_SEPARATOR;

		$cable_details = array(
			'canonical_id' => '',
			'origin' => '',
			'country' => '',
			'classification' => '',
			'header' => '',
			'body' => '',
			);
		// get cable details
		$sqlquery =
			  "SELECT "
			.     "c.`canonical_id`,"
			.     "o.`origin`,"
			.     "co.`country`,"
			.     "cl.`classification` "
			. "FROM "
			.     "`cablegate_classifications` cl "
			.     "INNER JOIN ("
			.         "`cablegate_countries` co "
			.         "INNER JOIN ("
			.             "`cablegate_origins` o "
			.             "INNER JOIN `cablegate_cables` c "
			.             "ON o.`id` = c.`origin_id` "
			.             ") "
			.         "ON co.`country_id` = o.`country_id` "
			.         ") "
			.     "ON cl.`id` = c.`classification_id` "
			. "WHERE "
			.     "c.`id` = {$cable_id}"
			;
		$sqlresult = db_query($sqlquery);
		assert($sqlresult);
		if ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$cable_details['canonical_id'] = $sqlrow['canonical_id'];
			$cable_details['origin'] = $sqlrow['origin'];
			$cable_details['country'] = $sqlrow['country'];
			$cable_details['classification'] = $sqlrow['classification'];
			}
		// get cable header and body content
		$sqlquery =
			  "SELECT "
			.     "UNCOMPRESS(ch.`diff`) AS `diff` "
			. "FROM "
			.     "`cablegate_releases` re "
			.     "INNER JOIN `cablegate_changes` ch "
			.     "ON re.`release_id` = ch.`release_id` "
			. "WHERE "
			.     "ch.`cable_id` = {$cable_id} "
			. "ORDER BY "
			.     "re.`release_time`"
			;
		$sqlresult = db_query($sqlquery);
		assert($sqlresult);
		if ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			list($header_opcodes, $body_opcodes) = explode($CABLE_CONTENT_SEPARATOR, $sqlrow['diff']);
			$cable_details['header'] = FineDiff::renderToTextFromOpcodes('', $header_opcodes);
			$cable_details['body'] = FineDiff::renderToTextFromOpcodes('', $body_opcodes);
			$num_diffs = mysql_num_rows($sqlresult);
			if ( $num_diffs > 1 ) {
				mysql_data_seek($sqlresult, $num_diffs-1);
				$sqlrow = mysql_fetch_assoc($sqlresult);
				list($header_opcodes, $body_opcodes) = explode($CABLE_CONTENT_SEPARATOR, $sqlrow['diff']);
				$cable_details['header'] = FineDiff::renderToTextFromOpcodes($cable_details['header'], $header_opcodes);
				$cable_details['body'] = FineDiff::renderToTextFromOpcodes($cable_details['body'], $body_opcodes);
				}
			}

		return $cable_details;
		}

	// compare term priority.
	private static function terms_compare($a, $b) {
		if ( $r = $b['count'] - $a['count'] ) {
			return $r;
			}
		return $a['provisional_id'] - $b['provisional_id'];
		}

	// The more frequent a term, the smaller the id which will
	// identify it. This way we can generate space-efficient
	// tokenized content. As an example, for about 16K cables,
	// random vs. optimized tokenized contents means
	// ~53MB vs. ~30MB
	private function optimize() {
		printf("\nOptimizing index of searchable terms...");

		assert(!$this->incremental);

		// order according to count
		uasort(
			$this->term_to_properties_map,
			array("Cablegate_Indexer", "terms_compare")
			);

		// then use sorted position as id
		$provisional_id_to_final_id_map = array();
		$this->term_id_generator = 1;
		foreach ( $this->term_to_properties_map as &$term_properties ) {
			$final_id = $this->term_id_generator++;
			$term_properties['final_id'] = $final_id;
			$provisional_id_to_final_id_map[$term_properties['provisional_id']] = $final_id;
			}

		// remap tokenized content
		foreach ( $this->cable_id_to_tokenized_content_map as $cable_id => $provisional_tokenized_content ) {
			$provisional_tokenized_content = explode(',', $provisional_tokenized_content);
			$final_tokenized_content = array();
			foreach ( $provisional_tokenized_content as $provisional_id ) {
				$final_tokenized_content[] = $provisional_id_to_final_id_map[intval($provisional_id)];
				}
			$this->cable_id_to_tokenized_content_map[$cable_id] = implode(',', $final_tokenized_content);
			}
		}

	// TODO: Use LOAD DATA INFILE, but I can't for now, as the server on
	// which my site sits uses MySQL version 4.1.
	private function generate_sql_statements_incremental($filename) {
		printf("\nGenerating SQL statements...");

		$sql_filename = "{$filename}.sql";

		$fhandle = fopen($sql_filename, 'wb');
		assert($fhandle);

		// `cablegate_terms`
		$updated_term_id_to_term_map = array();
		$added_term_id_to_term_map = array();

		// disable keys to speed up db update
		fwrite($fhandle, "ALTER TABLE `cablegate_terms` DISABLE KEYS;\n");

		foreach ( $this->term_to_properties_map as $term_key => $term_properties ) {
			$term = substr($term_key, 1);
			$final_id = $term_properties['final_id'];
			if ( !isset($this->in_db_term_id_to_term_map[$final_id]) ) {
				$added_term_id_to_term_map[$final_id] = $term;
				}
			else if ( $this->in_db_term_id_to_term_map[$final_id] !== $term ) {
				$updated_term_id_to_term_map[$final_id] = $term;
				}
			}

		// terms to add
		$per_statement_term_id_to_term_map_array = array_chunk($added_term_id_to_term_map, 100, true);
		foreach ( $per_statement_term_id_to_term_map_array as $per_statement_term_id_to_term_map ) {
			$sql = array();
			$sql[] = "INSERT IGNORE INTO `cablegate_terms` (`id`,`term`) VALUES";
			$per_statement_values = array();
			$per_line_term_id_to_term_map_array = array_chunk($per_statement_term_id_to_term_map, 10, true);
			foreach ( $per_line_term_id_to_term_map_array as $per_line_term_id_to_term_map ) {
				$per_line_values = array();
				foreach ( $per_line_term_id_to_term_map as $term_id => $term ) {
					$per_line_values[] = "({$term_id},'{$term}')";
					}
				$per_statement_values[] = implode(',', $per_line_values);
				}
			$sql[] = sprintf("\t%s;", implode(",\n\t", $per_statement_values));
			$sql[] = '';
			fwrite($fhandle, implode("\n", $sql));
			}

		// terms to update
		foreach ( $updated_term_id_to_term_map as $term_id => $term ) {
			fwrite(
				$fhandle,
				"UPDATE `cablegate_terms` SET `term`='{$term}' WHERE `id`={$term_id};\n"
				);
			}

		// terms to delete
		foreach ( $this->in_db_term_id_to_term_map as $term_id => $term ) {
			if ( $term_id >= $this->term_id_generator ) {
			fwrite(
				$fhandle,
				"DELETE FROM `cablegate_terms` WHERE `id`={$term_id}; # '{$term}'\n"
				);
				}
			}

		// optimize table order
		fwrite($fhandle, "ALTER TABLE `cablegate_terms` ORDER BY `term`,`id`;\n");

		// `cablegate_contents` and `cablegate_termassoc`

		// disable keys to speed up db update
		fwrite($fhandle, "ALTER TABLE `cablegate_termassoc` DISABLE KEYS;\n");
		fwrite($fhandle, "ALTER TABLE `cablegate_contents` DISABLE KEYS;\n");

		foreach ( $this->cable_id_to_tokenized_content_map as $cable_id => $final_tokenized_content ) {
			$final_tokenized_content = explode(',', $final_tokenized_content);
			$sql = array();

			// `cablegate_contents`

			// create variable-length tokenized content
			$variable_length_tokenized_content = array();
			foreach ( $final_tokenized_content as $term_id ) {
				$variable_length_tokenized_content[] = Cablegate_Indexer::get_variable_length_token_from_id($term_id);
				}
			$variable_length_tokenized_content = implode('', $variable_length_tokenized_content);
			$tokenized_content_hash = md5($variable_length_tokenized_content, true);

			// skip if no change
			if ( isset($this->in_db_cable_id_to_tokenized_content_hash_map[$cable_id]) &&
			     $tokenized_content_hash === $this->in_db_cable_id_to_tokenized_content_hash_map[$cable_id] ) {
				continue;
				}

			$sql[] = "DELETE FROM `cablegate_contents` where `id`={$cable_id};";
			$sql[] = "INSERT INTO `cablegate_contents` "
			       . "SET "
			       .     "`id`={$cable_id},"
			       .     "`hash`=UNHEX('"
			       .     bin2hex($tokenized_content_hash)
			       .     "'),"
			       .     "`tokenized`=UNHEX(";
			$per_statement_values = array();
			// bigdump.php doesn't like queries spanning more than 300 lines.
			$num_bytes_per_line = max(strlen($variable_length_tokenized_content) >> 8, 76);
			foreach ( str_split($variable_length_tokenized_content, $num_bytes_per_line) as $tokenized_content_fragment ) {
				$per_statement_values[] = "'" . bin2hex($tokenized_content_fragment) . "'";
				}
			$sql[] = sprintf("\t%s\n\t);", implode("\n\t", $per_statement_values));

			// `cablegate_termassoc`
			$sql[] = "DELETE FROM `cablegate_termassoc` where `cable_id`={$cable_id};";
			$sql[] = "INSERT INTO `cablegate_termassoc` (`cable_id`,`term_id`) VALUES";
			$per_statement_values = array();
			$term_ids = array_keys(array_flip($final_tokenized_content));
			$term_id_lines = array_chunk($term_ids, 16);
			foreach ( $term_id_lines as $term_id_line ) {
				$per_line_values = array();
				foreach ( $term_id_line as $term_id ) {
					$per_line_values[] = "({$cable_id},{$term_id})";
					}
				$per_statement_values[] = implode(',', $per_line_values);
				}
			$sql[] = sprintf("\t%s;", implode(",\n\t", $per_statement_values));
			$sql[] = '';

			// save SQL statements
			fwrite($fhandle, implode("\n", $sql));
			}

		// optimize table order
		//fwrite($fhandle, "ALTER TABLE `cablegate_termassoc` ORDER BY `term_id`,`cable_id`;\n");
		fwrite($fhandle, "ALTER TABLE `cablegate_contents` ORDER BY `id`;\n");

		fwrite($fhandle, "ALTER TABLE `cablegate_terms` ENABLE KEYS;\n");
		fwrite($fhandle, "ALTER TABLE `cablegate_termassoc` ENABLE KEYS;\n");
		fwrite($fhandle, "ALTER TABLE `cablegate_contents` ENABLE KEYS;\n");

		fclose($fhandle);
		}

	// TODO: Use LOAD DATA INFILE, but I can't for now, as the server on
	// which my site sits uses MySQL version 4.1.
	private function generate_sql_statements_full($fullpath) {
		printf("\nGenerating SQL statements...");

		$directory = preg_replace('![^/]+$!', '', $fullpath);
		if ( empty($directory) ) {
			$directory = './';
			}
		$filename = preg_replace('!^.+/!', '', $fullpath);
		assert(!empty($filename));

		$sql_fhandle = fopen("{$directory}{$filename}.sql", 'wb');
		assert($sql_fhandle);

		// `cablegate_terms`

		$terms_data_fhandle = fopen("{$directory}{$filename}_terms.data", 'wb');
		assert($terms_data_fhandle);

		$line_separator = '';
		foreach ( $this->term_to_properties_map as $term_key => $term_properties ) {
			$term = substr($term_key, 1);
			$final_id = $term_properties['final_id'];
			fwrite($terms_data_fhandle, "{$line_separator}{$final_id}\t{$term}");
			$line_separator = "\n";
			}

		fclose($terms_data_fhandle);

		// use transient table
		fwrite($sql_fhandle, "DROP TABLE IF EXISTS `cablegate_terms_transient`;\n");
		fwrite($sql_fhandle, "CREATE TABLE `cablegate_terms_transient` LIKE `cablegate_terms`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_terms_transient` DISABLE KEYS;\n");

		fwrite($sql_fhandle, "LOAD DATA LOCAL INFILE './{$filename}_terms.data' INTO TABLE `cablegate_terms_transient`;\n");

		fwrite($sql_fhandle, "ALTER TABLE `cablegate_terms_transient` ORDER BY `term`,`id`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_terms_transient` ENABLE KEYS;\n");

		// `cablegate_contents` and `cablegate_termassoc`

		$contents_data_fhandle = fopen("{$directory}{$filename}_contents.data", 'wb');
		assert($contents_data_fhandle);
		$termassoc_data_fhandle = fopen("{$directory}{$filename}_termassoc.data", 'wb');
		assert($termassoc_data_fhandle);

		$line_separator = '';

		foreach ( $this->cable_id_to_tokenized_content_map as $cable_id => $final_tokenized_content ) {
			$final_tokenized_content = explode(',', $final_tokenized_content);

			// `cablegate_contents`

			// create variable-length tokenized content
			$variable_length_tokenized_content = array();
			foreach ( $final_tokenized_content as $term_id ) {
				$variable_length_tokenized_content[] = Cablegate_Indexer::get_variable_length_token_from_id($term_id);
				}
			$variable_length_tokenized_content = implode('', $variable_length_tokenized_content);
			$variable_length_tokenized_content_hash = md5($variable_length_tokenized_content, true);

			fwrite(
				$contents_data_fhandle,
				sprintf(
					"{$line_separator}{$cable_id}\t%s\t%s",
					str_replace("\t", '\\t', db_escape_string($variable_length_tokenized_content_hash)),
					str_replace("\t", '\\t', db_escape_string($variable_length_tokenized_content))
					)
				);

			// `cablegate_termassoc`

			$term_ids = array_keys(array_flip($final_tokenized_content));
			foreach ( $term_ids as $term_id ) {
				fwrite($termassoc_data_fhandle, "{$line_separator}{$term_id}\t{$cable_id}");
				$line_separator = "\n";
				}
			}

		fclose($contents_data_fhandle);
		fclose($termassoc_data_fhandle);

		// use transient tables
		fwrite($sql_fhandle, "DROP TABLE IF EXISTS `cablegate_contents_transient`;\n");
		fwrite($sql_fhandle, "CREATE TABLE `cablegate_contents_transient` LIKE `cablegate_contents`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_contents_transient` DISABLE KEYS;\n");
		fwrite($sql_fhandle, "LOAD DATA LOCAL INFILE './{$filename}_contents.data' INTO TABLE `cablegate_contents_transient`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_contents_transient` ORDER BY `id`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_contents_transient` ENABLE KEYS;\n");

		fwrite($sql_fhandle, "DROP TABLE IF EXISTS `cablegate_termassoc_transient`;\n");
		fwrite($sql_fhandle, "CREATE TABLE `cablegate_termassoc_transient` LIKE `cablegate_termassoc`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_termassoc_transient` DISABLE KEYS;\n");
		fwrite($sql_fhandle, "LOAD DATA LOCAL INFILE './{$filename}_termassoc.data' INTO TABLE `cablegate_termassoc_transient`;\n");
		//fwrite($sql_fhandle, "ALTER TABLE `cablegate_termassoc_transient` ORDER BY `term_id`,`cable_id`;\n");
		fwrite($sql_fhandle, "ALTER TABLE `cablegate_termassoc_transient` ENABLE KEYS;\n");

		fwrite($sql_fhandle, "DROP TABLE `cablegate_terms`;\n");
		fwrite($sql_fhandle, "RENAME TABLE `cablegate_terms_transient` TO `cablegate_terms`;\n");
		fwrite($sql_fhandle, "DROP TABLE `cablegate_termassoc`;\n");
		fwrite($sql_fhandle, "RENAME TABLE `cablegate_termassoc_transient` TO `cablegate_termassoc`;\n");
		fwrite($sql_fhandle, "DROP TABLE `cablegate_contents`;\n");
		fwrite($sql_fhandle, "RENAME TABLE `cablegate_contents_transient` TO `cablegate_contents`;\n");

		fclose($sql_fhandle);
		}

	private static function get_expression_hash($expression) {
		return strtolower(md5(implode('-', Cablegate_Indexer::get_normalized_terms_from_text($expression))));
		}

	// term key (string) => array( 'count' => (int), etc.
	// term key is created by prefixing an 's' in front of the term,
	// this to avoid PHP auto-casting string of digits as integer
	// numbers
	private $term_to_properties_map = array();
	private $in_db_term_id_to_term_map = array();
	private $term_id_generator = 1;

	private $incremental = true;

	private $cable_ids = array();
	private $cable_id_to_tokenized_content_map = array();
	private $in_db_cable_id_to_tokenized_content_hash_map = array();
	}

/*****************************************************************************/

// Turn a raw query into a table-specifier MySQL query, and pre-compute
// global data if needed.
//
// It works like this:
//
// Normalize raw query (remove non-word characters, collect words)
// Collect expressions. An expression can be:
//     A single word
//     A single word preceded by '='
//     A sequence of words (sequence of words delimited by "...", or sequence
//       of words separated by - in the raw query)
// Note: 'blah' and '=blah' will be considered two different words internally.
//
// Subquery building part 1:
// From the collection of expressions, create a collection of unique words,
//   in order to eliminate potentially duplicated words.
// For each unique word, create an outer MySQL subquery which further filters
//   inner subquery on the word.
// Performance: The layered subqueries should be created with the word
//   having the least database occurrences in the innermost subquery, and
//   the word having the most occurrences in the outermost subquery. Since
//   we don't keep count of occurrences, we will presume the longer the word,
//   the less likely it will occur.
// Performance: If a word occurs *only* inside an exact sequence of words, use
//   [= 'word'] operator instead of [like 'word%']
//
// Subquery building part 2:
// If there is an expression with more than one word, create a tokenized
// version of the sequence of words, and wrap the current MySQL subquery to
// filter according to tokenized expression.
//
// TODO: Support subtract operator?
//
// Get global data resulting from running the resulting query.
//
// Cache all of the above computed and collected data for performance purpose.

function preprocess_query(
	$raw_query,
	$cable_date_timeline = false,
	$publication_date_timeline = false
	)
{
	$canonical_query_name = get_canonical_query_name($raw_query);

	// Preprocessed data exists?
	$preprocessed_fname = sprintf('preproc_%s.txt', $canonical_query_name);
	if ( $s = cache_retrieve($preprocessed_fname) ) {
		$preprocessed = unserialize($s);
		}
	else {
		$preprocessed = array();
		}

	// Does preprocessed data contain all we need?
	$need_query = !isset($preprocessed['subquery']);
	$need_cable_date_timeline = $cable_date_timeline && !isset($preprocessed['by_cable_date']);
	$need_publication_date_timeline = $publication_date_timeline && !isset($preprocessed['by_publication_date']);

	if ( !$need_query && !$need_cable_date_timeline && !$need_publication_date_timeline ) {
		return $preprocessed;
		}

	// Not all pre-processed data not found, compute missing part(s)
	list($normalized_query, $urlencoded_query, $expressions) = parse_raw_query($raw_query);

	// extract unique keywords
	$keywords = array_flatten($expressions);

	// create subquery according to keyword(s)
	if ( $need_query ) {
		if ( count($keywords) > 0 ) {
			if ( count($keywords) > 1 ) {
				$union_subqueries = array();
				foreach ( $keywords as $keyword ) {
					$union_subqueries[] = sprintf(
						  "(SELECT `cable_id` "
						. "FROM `cablegate_termassoc` ta "
						. "INNER JOIN `cablegate_terms` t "
						. "ON t.id = ta.term_id "
						. "WHERE t.`term` LIKE '%s' "
						. "GROUP BY `cable_id`)"
						,
						translate_query_term_to_sqlpattern($keyword)
						);
					}
				$subsqlquery = sprintf(
					  "SELECT `cable_id` "
					. "FROM (%s) a "
					. "GROUP BY `cable_id` "
					. "HAVING COUNT(`cable_id`) = %d"
					,
					implode(' UNION ALL ', $union_subqueries),
					count($keywords)
					);
				// extra step for expressions which are exact sequences of keywords
				if ( count($keywords) !== count($expressions) ) {
					foreach ( $expressions as $expression ) {
						if ( count($expression) > 1 ) {
							// rhill 2011-08-04: one or more term in the expression might
							// not exist, in which case, ensure returned result set is
							// empty 
							$tokenized_expression = tokenize_expression($expression);
							$subsqlquery = sprintf(
								  "SELECT a.`cable_id` "
								. "FROM `cablegate_contents` co "
								. "INNER JOIN (%s) a "
								. "ON a.`cable_id`=co.`id` "
								. "WHERE %s"
								,
								$subsqlquery,
								$tokenized_expression
									? sprintf("LOCATE(UNHEX('%s'),co.`tokenized`) != 0", bin2hex($tokenized_expression))
									: '0'
								);
							}
						}
					}
				// wrap up query
				$subsqlquery = sprintf(
					  "`cablegate_cables` c "
					. "INNER JOIN (%s) a "
					. "ON c.`id` = a.`cable_id`"
					,
					$subsqlquery
					);
				}
			else {
				$subsqlquery = sprintf(
					  "`cablegate_cables` c "
					. "INNER JOIN ("
					.     "SELECT `cable_id` "
					.     "FROM `cablegate_termassoc` ta "
					.     "INNER JOIN `cablegate_terms` t "
					.     "ON t.id = ta.term_id "
					.     "WHERE t.`term` "
					.     "LIKE '%s' "
					.     "GROUP BY ta.`cable_id`"
					.     ") a "
					. "ON c.`id` = a.`cable_id`"
					,
					translate_query_term_to_sqlpattern($keywords[0])
					);
				}
			}
		else {
			$subsqlquery = "`cablegate_cables` c";
			}

		$preprocessed['normalized_query'] = $normalized_query;
		$preprocessed['urlencoded_query'] = $urlencoded_query;
		$preprocessed['expressions'] = $expressions;
		$preprocessed['keywords'] = $keywords;
		$preprocessed['subquery'] = $subsqlquery;
		}

	// At this point, we have a portion of MySQL query, which can be
	// used as a table reference, aliased as `c`, which contains search
	// query data, as per specified search rules

	// Collect sort-by-cable-date data
	if ( $need_cable_date_timeline ) {
		$sortby_data = array(
			'total' => 0,
			'year_max' => 0,
			'quarter_max' => 0,
			'month_max' => 0,
			'years' => array(),
			'year_first' => 2010,
			'year_last' => 1966,
			'quarters' => array(),
			);

		$sqlquery =
			  "SELECT "
			.     "YEAR(FROM_UNIXTIME(c.`cable_time`)) AS `year`,"
			.     "MONTH(FROM_UNIXTIME(c.`cable_time`)) AS `month`,"
			.     "QUARTER(FROM_UNIXTIME(c.`cable_time`)) AS `quarter`,"
			.     "COUNT(DISTINCT c.`id`) AS `count` "
			. "FROM {$preprocessed['subquery']} "
			. "GROUP BY `year`,`month`";
		$result = db_query($sqlquery);
		if (!$result) {
			exit(sprintf("Database error: %s\n", mysql_error()));
			}

		while ( $row = mysql_fetch_assoc($result) ) {
			$count = intval($row['count']);
			$year_str = $row['year'];
			if (!isset($sortby_data['years'][$year_str])) {
				$sortby_data['years'][$year_str] = $count;
				}
			else {
				$sortby_data['years'][$year_str] += $count;
				}
			$quarter_str = sprintf('%s%02s',$year_str,$row['quarter']);
			if (!isset($sortby_data['quarters'][$quarter_str])) {
				$sortby_data['quarters'][$quarter_str] = $count;
				}
			else {
				$sortby_data['quarters'][$quarter_str] += $count;
				}
			$sortby_data['total'] += $count;
			$sortby_data['months'][sprintf('%s%02s',$year_str,$row['month'])] = $count;
			$sortby_data['year_max'] = max($sortby_data['year_max'], $sortby_data['years'][$year_str]);
			$sortby_data['quarter_max'] = max($sortby_data['quarter_max'], $sortby_data['quarters'][$quarter_str]);
			$sortby_data['month_max'] = max($sortby_data['month_max'], $count);
			$year_val = intval($year_str);
			$sortby_data['year_first'] = min($year_val, $sortby_data['year_first']);
			$sortby_data['year_last'] = max($year_val, $sortby_data['year_last']);
			}

		$preprocessed['by_cable_date'] = $sortby_data;
		}

	// Collect sort-by-publication-date data
	if ( $need_publication_date_timeline ) {
		$sortby_data = array(
			'total' => 0,
			'year_max' => 0,
			'quarter_max' => 0,
			'month_max' => 0,
			'years' => array(),
			'year_first' => 2010,
			'year_last' => 2012,
			'quarters' => array()
			);
		/*
		$sqlquery = "
			  "SELECT "
			.     "YEAR(FROM_UNIXTIME(c.`release_time`)) AS `year`,"
			.     "MONTH(FROM_UNIXTIME(c.`release_time`)) AS `month`,"
			.     "QUARTER(FROM_UNIXTIME(c.`release_time`)) AS `quarter`,"
			.     "COUNT(DISTINCT c.`id`) AS `count` "
			. "FROM {$preprocessed['subquery']} "
			. "GROUP BY `year`,`month`";
		$result = db_query($sqlquery);
		if (!$result) {
			exit("Database error\n");
			}

		while ($row = mysql_fetch_assoc($result)) {
			$count = intval($row['count']);
			$year_str = $row['year'];
			if (!isset($sortby_data['years'][$year_str])) {
				$sortby_data['years'][$year_str] = $count;
				}
			else {
				$sortby_data['years'][$year_str] += $count;
				}
			$quarter_str = sprintf('%s%02s',$year_str,$row['quarter']);
			if (!isset($sortby_data['quarters'][$quarter_str])) {
				$sortby_data['quarters'][$quarter_str] = $count;
				}
			else {
				$sortby_data['quarters'][$quarter_str] += $count;
				}
			$sortby_data['months'][sprintf('%s%02s',$year_str,$row['month'])] = $count;
			$sortby_data['total'] += $count;
			$sortby_data['year_max'] = max($sortby_data['year_max'],$sortby_data['years'][$year_str]);
			$sortby_data['quarter_max'] = max($sortby_data['quarter_max'],$sortby_data['quarters'][$quarter_str]);
			$sortby_data['month_max'] = max($sortby_data['month_max'],$count);
			$year_val = intval($year_str);
			$sortby_data['year_first'] = min($year_val,$sortby_data['year_first']);
			$sortby_data['year_last'] = max($year_val,$sortby_data['year_last']);
			}
		*/
		$preprocessed['by_publication_date'] = $sortby_data;
		}

	// Save preprocessed data only if not a bot
	if ( !db_referrer_is_a_bot() ) {
		cache_store($preprocessed_fname, serialize($preprocessed));
		}

	return $preprocessed;
	}

/*****************************************************************************/

function expression_sort($a,$b) {
	return strcmp($a[0],$b[0]);
	}

function stringify_expressions($expressions,$inner,$outer) {
	$canonical_query = array();
	foreach ( $expressions as $expression ) {
		$canonical_query[] = implode($inner,$expression);
		}
	return implode($outer,$canonical_query);
	}

function raw_query_to_normalized_expressions($raw_query) {
	$expressions = array();

	if (empty($raw_query)) {
		return $expressions;
		}

	$terms = Cablegate_Indexer::get_normalized_terms_from_text($raw_query, '-="');

	// Jan. 18, 2011: Normalize accented character
	$normalized_query = strtr($raw_query,
		"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
		);
	$normalized_query = strtolower($normalized_query);

	// get rid of all non-supported character
	$normalized_query = preg_replace('/[^-="a-z0-9]+/', ' ', $normalized_query);	

	// split into raw expressions
	$raw_expressions = preg_split('/"([^"]*)"|\\s+/', $normalized_query, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);

	foreach ( $raw_expressions as $raw_expression ) {
		$raw_expression = preg_replace('/[- ]+/','-',$raw_expression);
		$raw_expression = trim($raw_expression,'- ');

		// split into expressions, which can be single words, or dash-separated sequences of words
		if (!preg_match_all('/=?\\w+(-?[\\w])*/',$raw_expression,$expression_matches)) {
			continue;
			}
		foreach ( $expression_matches[0] as $expression_match ) {
			if (preg_match_all('/=?\\w+/', $expression_match, $keyword_matches)) {
				$expression = array();
				foreach ( $keyword_matches[0] as $keyword_match ) {
					$expression[] = preg_replace('/^(=?)0+(\\d+)$/','\\1\\2',$keyword_match); // remove leading zeros off numbers
					}
				// if a multiple keywords expression, discard meaningless '=' prefix if any
				if ( count($expression) > 1 ) {
					$expression[0] = preg_replace('/^=/','',$expression[0]);
					}
				// rhill 2011-08-26: Emergency fix: Remove single character keyword unless exact match
				if ( count($expression) > 1 || strlen($expression[0]) > 1 ) {
					$expressions[] = $expression;
					}
				}
			}
		}

	usort($expressions,'expression_sort');

	return $expressions;
	}

function get_canonical_query_name($raw_query) {
	return stringify_expressions(raw_query_to_normalized_expressions($raw_query),'-','_');
	}

function parse_raw_query($raw_query) {
	if ( empty($raw_query) ) {
		return array('','',array());
		}

	// Jan. 18, 2011: Normalize accented character
	$normalized_query = strtr($raw_query,
		"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
		);
	$normalized_query = strtolower($normalized_query);

	$urlencoded_query = urlencode($raw_query);
	$expressions = raw_query_to_normalized_expressions($raw_query);
	return array($normalized_query, $urlencoded_query, $expressions);
	}

function translate_query_term_to_sqlpattern($qterm) {
	if ( $qterm[0] === '=' ) {
		return db_escape_string(substr($qterm,1));
		}
	return db_escape_string($qterm) . '%';
	}

/*****************************************************************************/

// Transform a series of terms into a string of tokens.
// Returns false is at least of of the term in the series can't be
// tokenized.

function tokenize_expression($keywords) {
	static $KEYWORD_TOKENS = array();

	$sqlconditions = array();
	foreach ( $keywords as $keyword ) {
		if ( !isset($KEYWORD_TOKENS[$keyword]) ) {
			$sqlconditions[] = sprintf("`term`='%s'", db_escape_string($keyword));
			}
		}
	if ( count($sqlconditions) ) {
		$sqlquery = "SELECT `id`,`term` "
		          . "FROM `cablegate_terms` "
		          . "WHERE "
		          . implode(' OR ', $sqlconditions)
		          ;
		if ( !($sqlresult = db_query($sqlquery)) ) {
			exit("tokenize_expression(): Fatal DB error\n");
			}
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$KEYWORD_TOKENS[$sqlrow['term']] = Cablegate_Indexer::get_variable_length_token_from_id(intval($sqlrow['id']));
			}
		}
	$tokenized_keywords = array();
	foreach ( $keywords as $keyword ) {
		// rhill 2011-08-04: if at least one keyword is not in the
		// database, no point in looking further
		if ( !isset($KEYWORD_TOKENS[$keyword]) ) {
			return false;
			}
		$tokenized_keywords[] = $KEYWORD_TOKENS[$keyword];
		}
	return implode('', $tokenized_keywords);
	}

/**
 rhill 2011-06-22:
   Performance: ensure keywords are uniques + sort keywords from
   longest to shortest, as longer keywords have lower probability
   to be found than shorter ones.

 rhill 2011-06-26:
   maintain '=', so that the SQL query can be optimized.
   TODO: should we maintain equality for last keyword of
         an expression?
 */
function array_flatten_cmp($a, $b) {
	return strlen($b) - strlen($a);
	}
function array_flatten($aa) {
	$r = array();
	foreach ( $aa as $as ) {
		if ( count($as) === 1 ) {
			$r[$as[0]] = true;
			}
		else {
			foreach ( $as as $s ) {
				if ( $s[0] !== '=' ) {
					$s = "={$s}";
					}
				$r[$s] = true;
				}

/* This version search losely on the last term, not sure if it's better..
			$ilast = count($as) - 1;
			foreach ( $as as $i => $s ) {
				if ( $s[0] !== '=' && $i < $ilast ) {
					$s = "={$s}";
					}
				$r[$s] = true;
				}
*/
			}
		}
	uksort($r, 'array_flatten_cmp');
	return array_keys($r);
	}

/*****************************************************************************
 * Returns a list of cables as a JSON object.
 *
 * @param string $raw_query the raw, possibly unparsed, query
 * @param int    $sort      the sort order: 0=cable time, reverse
 *                                          1=release time, reverse
 * @param int    $yt        the maximum year, cables which cable or
 *                          release time (according to $sort) are
 *                          above $yt will not be returned
 * @param int    $mt        the maximum month, cables which cable or
 *                          release time (according to $sort) are
 *                          above $yt-$mt will not be returned
 * @param int    $offset    how many cable entries to skip
 * @param int    $limit     the maximum number of cables to return
 *
 * @TODO  Avoid using an offset, as per:
 *        http://www.facebook.com/note.php?note_id=206034210932&id=102841356695
 *        release_time <= x AND (release_time < x OR cable_time < y)
 */

function get_cable_entries($raw_query, $sort, $yt, $mt, $offset, $limit) {
	$prepdata = preprocess_query($raw_query);
	$column_names_lookup_by_sort = array('cable','change');
	$sqlquery = sprintf(
		  "SELECT DISTINCT "
		.     "c.`id`,"
		.     "c.`canonical_id`,"
		.     "c.`cable_time`,"
		.     "c.`change_time`,"
		.     "c.`status`,"
		.     "c.`classification_id`,"
		.     "c.`origin_id`,"
		.     "c.`subject`"
		. "FROM "
		.     "%s "
		,
		$prepdata['subquery']
		);

	// When using release time, there is no way yet to specify a
	// maximum year-month, so no need to filter according to time
	// in such case
	if ( !$sort ) {
		$sqlquery .= sprintf(
			  "WHERE "
			.     "c.`%s_time` < UNIX_TIMESTAMP(DATE_ADD('%d-%02d-01',INTERVAL 1 MONTH)) "
			,
			$column_names_lookup_by_sort[$sort],
			$yt,
			$mt
			);
		}
	$sqlquery .= sprintf(
		  "ORDER BY "
		.     "c.`%s_time` DESC,"
		.     "c.`%s_time` DESC "
		. "LIMIT %d,%d"
		,
		$column_names_lookup_by_sort[$sort],
		$column_names_lookup_by_sort[$sort ^ 1],
		$offset,
		$limit
		);
	$sqlresult = db_query($sqlquery);
	if ( !$sqlresult ) {
		exit(mysql_error());
		}
	return json_encode(cp1252_to_utf8(array('cables'=>cables2json($sqlresult, $sort))));
	}

/*****************************************************************************/
