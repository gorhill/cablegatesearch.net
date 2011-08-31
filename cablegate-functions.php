<?php
include_once('cacher.php');
include_once('globals.php');

/*****************************************************************************/

function header_cache($minutes) {
	// http://www.sitepoint.com/article/php-anthology-2-5-caching/
	header("Expires: ".gmdate("D, d M Y H:i:s",time()+$minutes*60)." GMT");
	}

/*****************************************************************************/

function get_all_classifications() {
	static $classifications = false;
	if ( !$classifications ) {
		if ( $cache_content = cache_retrieve('data_classifications') ) {
			$classifications = unserialize($cache_content);
			}
		else if ( $sqlresult = db_query("select `id`,`classification` from `cablegate_classifications`") ) {
			$classifications = array();
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$classifications[intval($sqlrow['id'])] = $sqlrow['classification'];
				}
			cache_store('data_classifications', serialize($classifications));
			}
		}
	return $classifications;
	}

function get_classification_from_id($classification_id) {
	$classifications = get_all_classifications();
	if ( isset($classifications[$classification_id]) ) {
		return $classifications[$classification_id];
		}
	return '';
	}

/*****************************************************************************/

function get_all_origins() {
	static $origins = false;
	if ( !$origins ) {
		if ( $cache_content = cache_retrieve('data_origins') ) {
			$origins = unserialize($cache_content);
			}
		else if ( $sqlresult = db_query("select `id`,`origin` from `cablegate_origins`") ) {
			$origins = array();
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$origins[intval($sqlrow['id'])] = $sqlrow['origin'];
				}
			cache_store('data_origins', serialize($origins));
			}
		}
	return $origins;
	}

function get_origin_from_id($origin_id) {
	$origins = get_all_origins();
	if ( isset($origins[$origin_id]) ) {
		return $origins[$origin_id];
		}
	return '';
	}

/*****************************************************************************/

function get_origin_to_country_map() {
	static $origin_to_country_map = false;
	if ( !$origin_to_country_map ) {
		if ( $cache_content = cache_retrieve('data_origin_to_country_map') ) {
			$origin_to_country_map = unserialize($cache_content);
			}
		else if ( $sqlresult = db_query("select `id`,`origin`,`country_id` from `cablegate_origins`") ) {
			$origin_to_country_map = array();
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$origin_to_country_map[intval($sqlrow['id'])] = intval($sqlrow['country_id']);
				}
			cache_store('data_origin_to_country_map', serialize($origin_to_country_map));
			}
		}
	return $origin_to_country_map;
	}

function get_countryid_from_originid($origin_id) {
	$origin_to_country_map = get_origin_to_country_map();
	if ( isset($origin_to_country_map[$origin_id]) ) {
		return $origin_to_country_map[$origin_id];
		}
	return 0;
	}

/*****************************************************************************/

function get_all_countries() {
	static $countries = false;
	if ( !$countries ) {
		if ( $cache_content = cache_retrieve('data_countries') ) {
			$countries = unserialize($cache_content);
			}
		else if ( $sqlresult = db_query("select `country_id`,`country` from `cablegate_countries`") ) {
			$countries = array();
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$countries[intval($sqlrow['country_id'])] = $sqlrow['country'];
				}
			cache_store('data_countries', serialize($countries));
			}
		}
	return $countries;
	}

/*****************************************************************************/

function get_all_tags() {
	static $tags = false;
	if ( !$tags ) {
		if ( $cache_content = cache_retrieve('data_tag_definitions') ) {
			$tags = unserialize($cache_content);
			}
		else if ( $sqlresult = db_query("select `id`,`tag`,`definition` from `cablegate_tags`") ) {
			$tags = array();
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$tags[intval($sqlrow['id'])] = array(
					'tag' => $sqlrow['tag'],
					'def' => $sqlrow['definition']
					);
				}
			cache_store('data_tag_definitions', serialize($tags));
			}
		}
	return $tags;
	}

/*****************************************************************************/

function utf8_to_cp1252($v) {
	if ( is_string($v) ) {
		return iconv("UTF-8//TRANSLIT","CP1252",$v);
		}
	else if ( is_array($v) ) {
		foreach ( $v as $k => $i ) {
			$v[$k] = utf8_to_cp1252($i);
			}
		}
	return $v;
	}

function cp1252_to_utf8($v) {
	if ( is_string($v) ) {
		return iconv("CP1252//TRANSLIT","UTF-8",$v);
		}
	else if ( is_array($v) ) {
		foreach ( $v as $k => $i ) {
			$v[$k] = cp1252_to_utf8($i);
			}
		}
	return $v;
	}

function cp1252_to_htmlentities($v) {
	if ( is_string($v) ) {
		return mb_convert_encoding(htmlentities($v, ENT_QUOTES, 'cp1252'), 'HTML-ENTITIES', 'Windows-1252');
		}
	else if ( is_array($v) ) {
		foreach ( $v as $k => $i ) {
			$v[$k] = cp1252_to_htmlentities($i);
			}
		}
	return $v;
	}

/*****************************************************************************/
 
// Returns the details and content of a cable as a JSON object.

// @param mixed  $cable_id
//   canonical id (string) or database id (integer)

// @param int    $cable_version
//   which version to return. If 0, return plain text
//   of latest version, otherwise returns diff between
//   the specified version and first, original version
//   (if the cable is deemed sensitive no diff is
//   returned) (see cablegate-diff-granter.php script)

function get_cable_content($cable_id, $cable_version = 0) {
	global $CABLE_CONTENT_SEPARATOR;
	global $WIKILEAKS_HOST;

	if ( is_string($cable_id) && !ctype_digit($cable_id) ) {
		$canonical_id = $cable_id;
		}

	// get cable details
	$sqlquery = sprintf(
		  "SELECT "
		.     "c.`id`,"
		.     "c.`cable_time`,"
		.     "c.`release_time`,"
		.     "c.`change_time`,"
		.     "c.`canonical_id`,"
		.     "c.`status`,"
		.     "o.`origin`,"
		.     "co.`country`,"
		.     "cl.`classification`,"
		.     "c.`subject` "
		. "FROM `cablegate_countries` co "
		.     "INNER JOIN ("
		.         "`cablegate_origins` o "
		.         "INNER JOIN ("
		.             "`cablegate_classifications` cl "
		.             "INNER JOIN `cablegate_cables` c "
		.             "ON cl.`id` = c.`classification_id`"
		.             ") "
		.         "ON o.`id` = c.`origin_id`"
		.         ") "
		.     "ON co.`country_id` = o.`country_id` "
		. "WHERE "
		.     "%s"
		,
		isset($canonical_id)
			? sprintf("c.`canonical_id`='%s'", db_escape_string($canonical_id))
			: "c.`id`={$cable_id}"
		);

	if ( !($sqlresult = db_query($sqlquery)) || !($sqlrow = mysql_fetch_assoc($sqlresult))) {
		return false;
		}

	// create URL to the cable hosted on Wikileaks
	$date_details = getdate($sqlrow['cable_time']);
	$wikileaksURL = sprintf(
		'http://%s/cable/%d/%02d/%s.html',
		$WIKILEAKS_HOST,
		$date_details['year'],
		$date_details['mon'],
		urlencode($sqlrow['canonical_id'])
		);

	$answer = array(
		'id' => intval($sqlrow['id']),
		'canonicalId' => $sqlrow['canonical_id'],
		'cableURL' => sprintf(
			'<a target="_blank" href="cable.php?id=%s">%s</a>',
			urlencode($sqlrow['canonical_id']),
			$sqlrow['canonical_id']
			),
		'wikileakURL' => sprintf(
			'<a target="_blank" href="%s">%s</a>',
			$wikileaksURL,
			htmlentities($wikileaksURL)
			),
		'origin' => $sqlrow['origin'],
		'country' => $sqlrow['country'],
		'cableTime' => str_replace(' ','&nbsp;', date('D, j M Y H:i', $sqlrow['cable_time'])) . '&nbsp;UTC',
		'releaseTime' => str_replace(' ','&nbsp;', date('D, j M Y H:i', $sqlrow['release_time'])) . '&nbsp;UTC',
		'changeTime' => str_replace(' ','&nbsp;', date('D, j M Y H:i', $sqlrow['change_time'])) . '&nbsp;UTC',
		'classification' => $sqlrow['classification'],
		'status' => intval($sqlrow['status']),
		'subject' => $sqlrow['subject'],
		'header' => '',
		'content' => '',
		);

	// get wikileaks id
	$answer['wikileaks_id'] = 0;
	$sqlquery = "select `ucable_id` from `cablegate_ucables` where `cable_id`={$answer['id']}";
	if ( ($sqlresult = db_query($sqlquery)) && ($sqlrow = mysql_fetch_assoc($sqlresult)) ) {
		$answer['wikileaks_id'] = intval($sqlrow['ucable_id']);
		}

	// determine whether diff can be seen
	$showdiff = $cable_version !== 0;
	$sensitive = $showdiff && ($answer['status'] & 0x08);
	if ( $sensitive && !preg_match('/^(127\\.0\\.\\d+\\.\\d+)$/', $_SERVER["REMOTE_ADDR"]) ) {
		$answer['content'] = '<span class="webmaster-comment">[Edit history of this cable is withheld because of its sensitivity.]</span>';
		return $answer;
		}

	// get cable content
	if ( !$cable_version ) {
		$cable_version = PHP_INT_MAX;
		}
	$sqlquery = 
		  "SELECT "
		.     "re.`release_time`,"
		.     "ch.change,"
		.     "UNCOMPRESS(ch.`diff`) AS `diff` "
		. "FROM `cablegate_releases` re "
		.     "INNER JOIN `cablegate_changes` ch "
		.     "ON re.`release_id` = ch.`release_id` "
		. "WHERE "
		.     "ch.`cable_id` = {$answer['id']} "
		. "ORDER BY "
		.     "re.`release_time` ASC"
		;
	$sqlresult = db_query($sqlquery);
	if ( !$sqlresult ) {
		return $answer;
		}

	include_once('finediff.php');

	// expand content
	//$start_time = gettimeofday(true);
	$last_not_empty = 0;
	$diff_stack = array();
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		if ( intval($sqlrow['release_time']) > $cable_version ) {
			break;
			}
		list($header, $content) = explode($CABLE_CONTENT_SEPARATOR, $sqlrow['diff']);

		if ( !preg_match('/^d\\d+$/', $content) ) {
			$last_not_empty = count($diff_stack);
			}
		$diff_stack[] = array($header, $content);
		}

	$header = $content = '';
	if ( count($diff_stack) > 0 ) {
		$header = FineDiff::renderToTextFromOpcodes('', $diff_stack[0][0]);
		$content = FineDiff::renderToTextFromOpcodes('', $diff_stack[0][1]);
		}
	$last_diff_index = count($diff_stack) - 1;

	if ( $last_diff_index > 0 ) {
		if ( $showdiff ) {
			$header = FineDiff::renderDiffToHTMLFromOpcodes($header, $diff_stack[$last_diff_index][0]);
			$content = FineDiff::renderDiffToHTMLFromOpcodes($content, $diff_stack[$last_diff_index][1]);
			}
		else {
			$header = FineDiff::renderToTextFromOpcodes($header, $diff_stack[min($last_diff_index, $last_not_empty)][0]);
			$content = FineDiff::renderToTextFromOpcodes($content, $diff_stack[min($last_diff_index, $last_not_empty)][1]);
			}
		}

	$answer['header'] = cp1252_to_htmlentities($header);

	if ( !$showdiff ) {
		$answer['content'] = cp1252_to_htmlentities($content);
		$answer['content'] = preg_replace_callback('/ \\[\\[(.+?)\\]\\]/','webmaster_comment_to_link', $answer['content']);
		$answer['content'] = preg_replace(
			'/&para;(\\d{1,3})(\\.?)(\\D)/',
			'<a id="para-'.$answer['id'] . '-\\1" href="cable.php?id=' . $answer['canonicalId'] . '#para-' . $answer['id'] . '-\\1">&para;\\1\\2\\3</a>',
			$answer['content']
			);
		}
	else {
		$answer['content'] = $content;
		}

	//printf("%.3f ms<br>", (gettimeofday(true)-$start_time)*1000);

	return $answer;
	}

function webmaster_comment_to_link($matches) {
	return sprintf(
		'<a class="webmaster-comment" href="search.php?q=%s" rel="nofollow">&thinsp;[%s]</a>',
		htmlentities(urlencode(preg_replace('/[\\W_]+/', '-', $matches[1]))),
		htmlentities($matches[1])
		);
	}

/*****************************************************************************/

// Convert cable data to an HTML row.

function cable2row($sqlrow, $sort = 1) {
	$classification = get_classification_from_id($sqlrow['classification_id']);
	$classification_class = stripos(
		$classification,'secret') !== false
		? 'cls'
		: (stripos(
			$classification,'confidential') !== false
			? 'clc'
			: 'clu'
			)
		;
	if ( stripos($classification,'noforn') !== false ) {
		$classification_class .= ' noforn';
		}
	$status = intval($sqlrow['status']);
	$origin = get_origin_from_id($sqlrow['origin_id']);
	$country_id = get_countryid_from_originid($sqlrow['origin_id']);
	$countries = get_all_countries();
	$country = $country_id
		? sprintf(" (%s)", $countries[$country_id])
		: ''
		;
	$sort_uri_component = '';
	if ( !$sort ) {
		$sort_uri_component = '&amp;sort=0';
		}
	return sprintf(
		  '<td class="%s">'
		. '<td%s>%s'
		. '<td>'
		.   '<span></span>'
		.   '<a href="cable.php?id=%s"%s>%s</a>'
		.   ' &mdash; '
		.   '<a href="search.php?q=%s%s">%s%s</a>'
		. '<td class="since">'
		.   '%s',
		$classification_class,
		$status & 0x04 ? ' class="reported"' : '',
		date('Y, M j',$sqlrow['cable_time']),
		htmlentities(urlencode($sqlrow['canonical_id'])),
		$status & 0x01 ? ' class="removed"' : ($status & 2 ? ' class="added"' : ''),
		cp1252_to_htmlentities($sqlrow['subject']),
		cp1252_to_htmlentities(urlencode(str_replace(' ','-',$origin))),
		$sort_uri_component,
		cp1252_to_htmlentities($origin),
		cp1252_to_htmlentities($country),
		date('c', $sqlrow['change_time'])
		);
	}

/*****************************************************************************
 *
 * Convert multiple cables' data to HTML rows.
 *
 */

function cables2rows($sqlresult, $sort = 1) {
	$two_days_ago = time() - 60 * 60 * 24 * 2;
	ob_start();
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		printf(
			'<tr id="cableid-%d">%s',
			$sqlrow['id'],
			cable2row($sqlrow, $sort)
			);
		}
	return ob_get_clean();
	}

/*****************************************************************************
 *
 * Convert multiple cables' data to JSON data.
 *
 */

function cables2json($sqlresult, $sort = 1) {
	$entries = array();
	$two_days_ago = time() - 60 * 60 * 24 * 2;
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$entry = array();
		$entry['id'] = intval($sqlrow['id']);
		$entry['html'] = cable2row($sqlrow, $sort);
		$entries[] = $entry;
		}
	return $entries;
	}

/*****************************************************************************/
