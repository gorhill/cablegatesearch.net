<?php
include_once('cacher.php');
include_once('globals.php');

function header_cache($minutes) {
	// http://www.sitepoint.com/article/php-anthology-2-5-caching/
	header("Expires: ".gmdate("D, d M Y H:i:s",time()+$minutes*60)." GMT");
	}

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

	// Jan. 18, 2011: Normalize accented character
	$normalized_query = strtr($raw_query,
		"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
		);
	$normalized_query = strtolower($normalized_query);

	// get rid of all non-supported character
	$normalized_query = preg_replace('/[^-="a-zA-Z0-9]+/',' ',$normalized_query);	

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
			if (preg_match_all('/=?\\w+/',$expression_match,$keyword_matches)) {
				$expression = array();
				foreach ( $keyword_matches[0] as $keyword_match ) {
					$expression[] = preg_replace('/^(=?)0+(\\d+)$/','\\1\\2',$keyword_match); // remove leading zeros off numbers
					}
				// if a multiple keywords expression, discard meaningless '=' prefix if any
				if ( count($expression) > 1 ) {
					$expression[0] = preg_replace('/^=/','',$expression[0]);
					}
				$expressions[] = $expression;
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
	if (empty($raw_query)) {
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
	return array($normalized_query,$urlencoded_query,$expressions);
	}

function translate_query_term_to_sqlpattern($qterm) {
	if (substr($qterm,0,1)==='=') {
		return mysql_real_escape_string(substr($qterm,1));
		}
	return mysql_real_escape_string($qterm) . '%';
	}

$KEYWORD_TOKENS = array();
function tokenize_keyword($keyword) {
	global $KEYWORD_TOKENS;
	if (!isset($KEYWORD_TOKENS[$keyword])) {
		$sqlquery = sprintf("SELECT `id` FROM `cablegate_terms` WHERE `term`='%s'",mysql_real_escape_string($keyword));
		if ( !($sqlresult = mysql_query($sqlquery)) ) { exit("tokenize_keyword(): Fatal DB error\n"); }
		if ( !($row = mysql_fetch_assoc($sqlresult)) ) { exit(sprintf("tokenize_keyword(): Term '%s' not found in DB\n",$keyword)); }
		$KEYWORD_TOKENS[$keyword] = pack('VX',(int)$row['id']);
		}
	return $KEYWORD_TOKENS[$keyword];
	}

function tokenize_expression($keywords) {
	global $KEYWORD_TOKENS;
	$sqlconditions = '';
	foreach ( $keywords as $keyword ) {
		if (!isset($KEYWORD_TOKENS[$keyword])) {
			if ( !empty($sqlconditions) ) {
				$sqlconditions .= ' OR ';
				}
			$sqlconditions .= sprintf("`term`='%s'",mysql_real_escape_string($keyword));
			}
		}
	if (!empty($sqlconditions)) {
		$sqlquery = "SELECT `id`,`term` FROM `cablegate_terms` WHERE {$sqlconditions}";
		if ( !($result = mysql_query($sqlquery)) ) {
			exit("tokenize_expression(): Fatal DB error\n");
			}
		while ( $row = mysql_fetch_assoc($result) ) {
			$KEYWORD_TOKENS[$row['term']] = pack('VX',(int)$row['id']);
			}
		}
	$tokenized_expression = '';
	foreach ( $keywords as $keyword ) {
		$tokenized_expression .= $KEYWORD_TOKENS[$keyword];
		}
	return $tokenized_expression;
	}

function array_flatten($a) {
	$r = array();
	foreach ( $a as $v ) {
		$r = array_merge($r,$v);
		}
	return $r;
	}

function preprocess_query($raw_query) {
	$canonical_query_name = get_canonical_query_name($raw_query);
	// get preprocess data for this query
	$preprocessed = false;
	$preprocessed_fname = sprintf('./cache/preproc_%s.txt', $canonical_query_name);
	if (file_exists($preprocessed_fname)) {
		if ($s = file_get_contents($preprocessed_fname)) {
			$preprocessed = unserialize($s);
			}
		}
	if ( $preprocessed ) {
		return $preprocessed;
		}

	list($normalized_query,$urlencoded_query,$expressions) = parse_raw_query($raw_query);

	// extract keywords
	$keywords = array_flatten($expressions);

	// create subquery according to keyword(s)
	if (count($keywords) > 0) {
		if (count($keywords) > 1) {
			$subsqlquery = sprintf("SELECT DISTINCT `cable_id` FROM `cablegate_termassoc` ta INNER JOIN `cablegate_terms` t ON t.id = ta.term_id WHERE t.`term` LIKE '%s'", translate_query_term_to_sqlpattern($keywords[0]));
			for ($i = 1; $i < count($keywords); $i++) {
				$subsqlquery = sprintf("SELECT a.`cable_id` FROM (SELECT DISTINCT `cable_id` FROM `cablegate_termassoc` ta INNER JOIN `cablegate_terms` t ON t.id = ta.term_id WHERE t.`term` LIKE '%s') a INNER JOIN (%s) b ON a.`cable_id` = b.`cable_id`",translate_query_term_to_sqlpattern($keywords[$i]),$subsqlquery);
				}
			// extra step for expressions made-up of multiple keywords
			if ( count($keywords) !== count($expressions) ) {
				foreach ( $expressions as $expression ) {
					if ( count($expression) <= 1 ) { continue; }
					$tokenized_expression = tokenize_expression($expression);
					$subsqlquery = sprintf("SELECT a.`cable_id` FROM `cablegate_contents` co INNER JOIN (%s) a ON a.`cable_id`=co.`id` WHERE LOCATE('%s',co.`tokenized`) != 0",$subsqlquery,mysql_real_escape_string($tokenized_expression));
					}
				}
			// wrap up query
			$subsqlquery = sprintf("(`cablegate_cables` c INNER JOIN (SELECT `cable_id` FROM (%s) a) t ON t.cable_id = c.`id`)",$subsqlquery);
			}
		else {
			$subsqlquery = sprintf("(`cablegate_cables` c INNER JOIN (SELECT DISTINCT ta.`cable_id` FROM `cablegate_termassoc` ta INNER JOIN `cablegate_terms` t ON t.id = ta.term_id WHERE t.`term` LIKE '%s') t ON t.cable_id = c.`id`)",translate_query_term_to_sqlpattern($keywords[0]));
			}
		}
	else {
		$subsqlquery = "`cablegate_cables` c";
		}

	$preprocessed = array(
		'normalized_query'=>$normalized_query,
		'urlencoded_query'=>$urlencoded_query,
		'expressions'=>$expressions,
		'keywords'=>$keywords,
		'subquery'=>$subsqlquery,
		'by_cable_date'=>array(
			'total'=>0,
			'year_max'=>0,
			'quarter_max'=>0,
			'month_max'=>0,
			'years'=>array(),
			'year_first'=>2010,
			'year_last'=>1966,
			'quarters'=>array()
			),
		'by_leak_date'=>array(
			'total'=>0,
			'year_max'=>0,
			'quarter_max'=>0,
			'month_max'=>0,
			'years'=>array(),
			'year_first'=>2010,
			'year_last'=>2012,
			'quarters'=>array()
			)
		);

	// collect sort-by cable date data
	$sortby_data = &$preprocessed['by_cable_date'];
	$sqlquery = "
		SELECT
			YEAR(FROM_UNIXTIME(c.`cable_time`)) AS `year`,
			MONTH(FROM_UNIXTIME(c.`cable_time`)) AS `month`,
			QUARTER(FROM_UNIXTIME(c.`cable_time`)) AS `quarter`,
			COUNT(DISTINCT c.`id`) AS `count`
		FROM
			$subsqlquery
		GROUP BY
			`year`,
			`month`
		";

	$result = mysql_query($sqlquery);
	if (!$result) {
		exit(sprintf("Database error: %s\n",mysql_error()));
		}
	while ($row = mysql_fetch_assoc($result)) {
		$count = (int)$row['count'];
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
		$year_val = (int)$year_str;
		$sortby_data['year_first'] = min($year_val,$sortby_data['year_first']);
		$sortby_data['year_last'] = max($year_val,$sortby_data['year_last']);
		}

	// collect sort-by leak date data
/*
	$sortby_data = &$preprocessed['by_leak_date'];
	$sqlquery = "
		SELECT
			YEAR(FROM_UNIXTIME(c.`release_time`)) AS `year`,
			MONTH(FROM_UNIXTIME(c.`release_time`)) AS `month`,
			QUARTER(FROM_UNIXTIME(c.`release_time`)) AS `quarter`,
			COUNT(DISTINCT c.`id`) AS `count`
		FROM
			$subsqlquery
		GROUP BY
			`year`,
			`month`
		";
	$result = mysql_query($sqlquery);
	if (!$result) {exit("Database error\n");}
	while ($row = mysql_fetch_assoc($result)) {
		$count = (int)$row['count'];
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
		$year_val = (int)$year_str;
		$sortby_data['year_first'] = min($year_val,$sortby_data['year_first']);
		$sortby_data['year_last'] = max($year_val,$sortby_data['year_last']);
		}
*/
	// save preprocessed data only if not a bot
	if (!db_referrer_is_a_bot()) {
		file_put_contents($preprocessed_fname,serialize($preprocessed));
		}

	return $preprocessed;
	}

function utf8_to_cp1252($v) {
	if (is_string($v))	{
		return iconv("UTF-8//TRANSLIT","CP1252",$v);
		}
	else if (is_array($v)) {
		foreach ( $v as $k => $i ) {
			$v[$k] = utf8_to_cp1252($i);
			}
		}
	return $v;
	}

function cp1252_to_utf8($v) {
	if (is_string($v))	{
		return iconv("CP1252//TRANSLIT","UTF-8",$v);
		}
	else if (is_array($v)) {
		foreach ( $v as $k => $i ) {
			$v[$k] = cp1252_to_utf8($i);
			}
		}
	return $v;
	}

function cp1252_to_htmlentities($v) {
	if (is_string($v))	{
		return htmlentities($v,ENT_COMPAT,'cp1252');
		}
	else if (is_array($v)) {
		foreach ( $v as $k => $i ) {
			$v[$k] = cp1252_to_htmlentities($i);
			}
		}
	return $v;
	}

function webmaster_comment_to_link($matches) {
	return sprintf('<a class="webmaster-comment" href="search.php?q=%s" rel="nofollow">&thinsp;[%s]</a>',htmlentities(urlencode(preg_replace('/[\\W_]+/','-',$matches[1]))),htmlentities($matches[1]));
	}

function get_cable_content($cable_id) {
	global $CABLE_CONTENT_SEPARATOR;
	if ( is_string($cable_id) && !ctype_digit($cable_id) ) {
		$canonical_id = $cable_id;
		}
	$content = "Error: Couldn't get cable content.";
	$sqlquery = "
		SELECT
			c.`id`,
			c.`cable_time`,
			c.`release_time`,
			c.`canonical_id`,
			c.`status`,
			o.`origin`,
			cl.`classification`,
			c.`subject`,
			UNCOMPRESS(co.`content`) AS `content`
		FROM `cablegate_contents` co
			INNER JOIN (`cablegate_origins` o
			INNER JOIN (`cablegate_classifications` cl
			INNER JOIN `cablegate_cables` c
			ON cl.`id` = c.`classification_id`)
			ON o.`id` = c.`origin_id`)
			ON co.`id` = c.`id`
		WHERE
		";
	$sqlquery .= isset($canonical_id) ? sprintf("c.`canonical_id`='%s'",mysql_real_escape_string($canonical_id)) : "c.`id`={$cable_id}";
	if (($result = mysql_query($sqlquery)) && ($row = mysql_fetch_assoc($result))) {
		$date_details = getdate($row['cable_time']);
		$wikileaksURL = sprintf('http://213.251.145.96/cable/%d/%02d/%s.html',$date_details['year'],$date_details['mon'],urlencode($row['canonical_id']));
		list($header,$body) = explode($CABLE_CONTENT_SEPARATOR,$row['content']);
		// cable was dropped from latest release
		if ($row['status'] & 1) {
			$body = '<span class="webmaster-comment">[Removed from an earlier Cablegate release]</span>' . "\n\n" . $body;
			}
		// webmaster comment => link + specific styles:
		//  tags
		$body = preg_replace_callback('/ \\[\\[(.+?)\\]\\]/','webmaster_comment_to_link',$body);
		return array(
			'id'=>$row['id'],
			'canonicalId'=>$row['canonical_id'],
			'cableURL'=>sprintf('<a target="_blank" href="cable.php?id=%s">%s</a>',urlencode($row['canonical_id']),$row['canonical_id']),
			'wikileakURL'=>sprintf('<a target="_blank" href="%s">%s</a>',$wikileaksURL,htmlentities($wikileaksURL)),
			'origin'=>$row['origin'],
			'cableTime'=>str_replace(' ','&nbsp;',date('D, j M Y H:i',$row['cable_time'])).'&nbsp;UTC',
			'releaseTime'=>str_replace(' ','&nbsp;',date('D, j M Y H:i',$row['release_time'])).'&nbsp;UTC',
			'classification'=>$row['classification'],
			'subject'=>$row['subject'],
			'header'=>$header,
			'content'=>$body
			);
		}
	return false;
	}

function elapsed_hours_from_date($datestr) {
	$then = strtotime($datestr . '+0000'); // mysql knowns no tz
	return (int)((time() - $then) / 3600 + 0.5);
	}

function string_from_elapsed_hours($hours) {
	if ( $hours < 1 ) {
		return "< 1 hour";
		}
	if ( $hours == 1 ) {
		return "1 hour";
		}
	if ( $hours < 48 ) {
		return "{$hours} hours";
		}
	$days = (int)($hours / 24 + 0.5);
	if ( $days < 30 ) {
		return "{$days} days";
		}
	$weeks = (int)($days / 7 + 0.5);
	if ( $weeks < 8 ) {
		return "{$weeks} weeks";
		}
	$months = (int)($weeks / 4 + 0.5);
	if ( $months < 24 ) {
		return "{$months} months";
		}
	$years = (int)($months / 12 + 0.5);
	return "{$years} years";
	}

function cable2row($sqlrow) {
	$classiclass = stripos($sqlrow['classification'],'secret') !== false ? 'cls' : (stripos($sqlrow['classification'],'confidential') !== false ? 'clc' : 'clu');
	return sprintf('<td class="%s"><td>%s<td><a href="cable.php?id=%s"%s>%s</a> &mdash; <a href="search.php?q=%s">%s</a><td class="since">%s',
		$classiclass,
		date('Y, M j',$sqlrow['cable_time']),
		htmlentities(urlencode($sqlrow['canonical_id'])),
		$sqlrow['removed'] ? ' class="removed"' : ((int)$sqlrow['new_or_updated'] != 0 ? ' class="added"' : ''),
		cp1252_to_htmlentities($sqlrow['subject']),
		cp1252_to_htmlentities(urlencode(str_replace(' ','-',$sqlrow['origin']))),
		cp1252_to_htmlentities($sqlrow['origin']),
		date('c',$sqlrow['release_time'])
		);
	}

function cables2rows($sqlresult) {
	$two_days_ago = time() - 60 * 60 * 24 * 2;
	ob_start();
	while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
		printf('<tr id="cableid-%d">%s',$sqlrow['id'],cable2row($sqlrow));
		}
	return ob_get_clean();
	}

function cables2json($sqlresult) {
	$entries = array();
	$two_days_ago = time() - 60 * 60 * 24 * 2;
	while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
		$entry = array();
		$entry['id'] = (int)$sqlrow['id'];
		$entry['html'] = cable2row($sqlrow);
		$entries[] = $entry;
		}
	return $entries;
	}

function get_cable_entries($raw_query,$sort,$yt,$mt,$offset,$limit) {
	$prepdata = preprocess_query($raw_query);
	$column_names_lookup_by_sort = array('cable','release');
	// query for list
	$sqlquery = sprintf("
		SELECT DISTINCT
			c.`id`,
			c.`canonical_id`,
			c.`cable_time`,
			c.`release_time`,
			(c.`status` & 0x01) AS `removed`,
			(c.`status` & 0x02) AS `new_or_updated`,
			cl.`classification`,
			o.`origin`,
			c.`subject`
		FROM `cablegate_classifications` cl
			INNER JOIN (`cablegate_origins` o
			INNER JOIN %s
			ON o.`id` = c.`origin_id`)
			ON cl.`id` = c.`classification_id`
		",
		$prepdata['subquery']
		);
	if ( !$sort ) {
		$sqlquery .= sprintf("
			WHERE
				c.`%s_time` < UNIX_TIMESTAMP(DATE_ADD('%d-%02d-01',INTERVAL 1 MONTH))
			",
			$column_names_lookup_by_sort[$sort],
			$yt,
			$mt
			);
		}
	$sqlquery .= sprintf("
		ORDER BY
			c.`%s_time` DESC,
			c.`%s_time` DESC
		LIMIT %d,%d
		",
		$column_names_lookup_by_sort[$sort],
		$column_names_lookup_by_sort[$sort ^ 1],
		$offset,
		$limit
		);
	$sqlresult = mysql_query($sqlquery);
	if (!$sqlresult) { exit(mysql_error()); }
	return json_encode(cp1252_to_utf8(array('cables'=>cables2json($sqlresult))));
	}
?>
