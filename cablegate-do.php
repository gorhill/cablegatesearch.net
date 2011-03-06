<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

$command = '';
if (isset($_REQUEST['command'])) {
	$command = $_REQUEST['command'];
	}

switch ($command) {
	case 'get_cable_content':
		header_cache(60*2);
		if (!isset($_REQUEST['id']) || !ctype_digit($_REQUEST['id'])) {exit("{}");}
		$cable_id = (int)$_REQUEST['id'];
		$cache_id = "cable_preview_{$cable_id}";
		if ( !db_output_compressed_cache($cache_id) ) {
			db_open_compressed_cache($cache_id);
			// -----
			$result = get_cable_content($cable_id);
			if (empty($result)) {db_cancel_cache();}
			echo json_encode(cp1252_to_utf8($result));
			// -----
			db_close_compressed_cache();
			}
		break;

	case 'get_cable_entries':
		header_cache(30);
		$raw_query = isset($_REQUEST['raw_query']) ? utf8_to_cp1252($_REQUEST['raw_query']) : '';
		$sort = isset($_REQUEST['sort']) && is_numeric($_REQUEST['sort']) ? max((int)min(floor((int)$_REQUEST['sort']),1),0) : 0;
		$year_upper_limit = $sort ? 2099 : 2010;
		$year_lower_limit = $sort ? 2010 : 1966;
		$yt = isset($_REQUEST['yt']) && is_numeric($_REQUEST['yt']) ? max(min((int)floor((int)$_REQUEST['yt']),$year_upper_limit),$year_lower_limit) : $year_upper_limit;
		$mt = isset($_REQUEST['mt']) && is_numeric($_REQUEST['mt']) ? max(min((int)floor((int)$_REQUEST['mt']),12),1) : 12;
		$offset = isset($_REQUEST['offset']) && ctype_digit($_REQUEST['offset']) ? (int)$_REQUEST['offset'] : 0;
		$limit = isset($_REQUEST['limit']) && ctype_digit($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 0;
		$cache_id = sprintf('searchlines_%d_%d-%02d_%d_%d_%s', $sort, $yt, $mt, $offset, $limit, get_canonical_query_name($raw_query));
		if ( !db_output_compressed_cache($cache_id) ) {
			db_open_compressed_cache($cache_id);
			// -----
			$result = get_cable_entries($raw_query,$sort,$yt,$mt,$offset,$limit);
			if (empty($result)) {db_cancel_cache();}
			echo $result;
			// -----
			db_close_compressed_cache();
			}
		break;

	case 'get_keyword_suggestions':
		header_cache(60*12);
		$startwith = isset($_REQUEST['startwith']) ? utf8_to_cp1252($_REQUEST['startwith']) : '';
		$answer = array(
			'startwith' => $startwith,
			'suggestions' => array()
			);
		if ( strlen($startwith) > 1 ) {
			$limit = isset($_REQUEST['limit']) && ctype_digit($_REQUEST['limit']) ? intval($_REQUEST['limit']) : 10;
			$sqlquery = sprintf(
				"
				SELECT ct.`term_id`,ct.`term`,COUNT(`cable_id`) AS `numCables`
				FROM `cablegate_termassoc` cta
				INNER JOIN (
					SELECT `id` AS `term_id`,`term`
					FROM `cablegate_terms` ct
					WHERE `term` LIKE '%s%%'
					ORDER BY `term` ASC
					LIMIT %d
					) ct
				ON cta.`term_id` = ct.`term_id`
				GROUP BY `term_id`
				",
				mysql_real_escape_string($startwith),
				$limit
				);
			if ( $sqlresult = mysql_query($sqlquery) ) {
				if ( mysql_num_rows($sqlresult) ) {
					while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
						$answer['suggestions'][] = "{$sqlrow['term']} <span>({$sqlrow['numCables']})</span>";
						}
					}
				else {
					$answer['suggestions'][] = "<span>(No matches)</span>";
					}
				}
			}
		echo json_encode(cp1252_to_utf8($answer));
		break;

	case 'get_cable_subjects':
		header_cache(60);
		$canonical_ids = isset($_REQUEST['canonicalIds']) ? utf8_to_cp1252($_REQUEST['canonicalIds']) : '';
		$cache_id = "do_get-cable-subjects_" . md5($canonical_ids);
		if ( !db_output_compressed_cache($cache_id) ) {
			db_open_compressed_cache($cache_id);
			// -----
			echo json_encode(cp1252_to_utf8(get_cable_subjects($canonical_ids)));
			// -----
			db_close_compressed_cache();
			}
		break;

	default:
		exit('Invalid command');
	}

/*****************************************************************************/

function get_cable_subjects($canonical_ids) {
	$answer = array('subjects' => array());
	$canonical_ids = explode(',', $canonical_ids);
	sort($canonical_ids, SORT_REGULAR);
	$sqlquery = "SELECT `canonical_id`,`subject` FROM `cablegate_cables` WHERE ";
	$sqlquerywhere = array();
	foreach ( $canonical_ids as $canonical_id ) {
		$sqlqueryparts[] = sprintf("`canonical_id`='%s'", mysql_real_escape_string($canonical_id));
		}
	$sqlquery .= implode(' OR ', $sqlqueryparts);
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$answer['subjects'][$sqlrow['canonical_id']] = $sqlrow['subject'];
			}
		}
	return $answer;
	}

?>
