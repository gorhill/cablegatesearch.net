<?php
include_once('dbconnect.php');

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

/******************************************************************************

 rhill 2011-06-28:
   A plain "internal wikileaks id" can now be supplied, which will be
   translated into a list of canonical ids as follow:
   "wikileaks id" -> ucable_id above/below for which there is a
   non-zero cable_id -> canonical_id

 */

function get_suggestions_from_canonical_id($canonical_id) {
	// if provided canonical id is only made of digit, assume this
    // is a wikileaks id.
	if ( ctype_digit($canonical_id) ) {
		return get_suggestions_from_wikileaks_id($canonical_id);
		}

	$num_cables_max = 11;
	$answer = array(
		'canonical_id' => $canonical_id,
		'cables' => array()
		);
	// get the origin and cable time
	$sqlquery = sprintf(
		"select `origin_id`,`cable_time`
		from `cablegate_cables`
		where `canonical_id` = '%s'
		limit 1",
		mysql_real_escape_string($canonical_id)
		);
	// if we have a hit, use origin and cable time
	if ( ($sqlresult = mysql_query($sqlquery)) && ($sqlrow = mysql_fetch_assoc($sqlresult)) ) {
		$origin_id = intval($sqlrow['origin_id']);
		$cable_time = intval($sqlrow['cable_time']);
		// get preceding cables
		$sqlquery = sprintf("
			select `canonical_id`,`subject`
			from `cablegate_cables`
			where `origin_id` = {$origin_id} and cable_time < {$cable_time}
			order by `cable_time` desc
			limit %d",
			$num_cables_max >> 1
			);
		if ( $sqlresult = mysql_query($sqlquery) ) {
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				array_unshift($answer['cables'], $sqlrow);
				}
			}
		// get succeeding cables
		$sqlquery = sprintf("
			select `canonical_id`,`subject`
			from `cablegate_cables`
			where `origin_id` = {$origin_id} and cable_time >= {$cable_time}
			order by `cable_time`
			limit %d",
			$num_cables_max - count($answer['cables'])
			);
		if ( $sqlresult = mysql_query($sqlquery) ) {
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$answer['cables'][] = $sqlrow;
				}
			}
		}
	// otherwise use canonical id string as template
	else {
		$sqlquery = sprintf("
			select `canonical_id`,`subject`
			from `cablegate_cables`
			where `canonical_id` like '%s%%'
			order by `canonical_id`
			limit %d",
			mysql_real_escape_string($canonical_id),
			$num_cables_max
			);
		if ( $sqlresult = mysql_query($sqlquery) ) {
			while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
				$answer['cables'][] = $sqlrow;
				}
			}
		}

	return $answer;
	}

/*****************************************************************************/

function get_suggestions_from_wikileaks_id($wikileaks_id) {
	$num_cables_max = 11;
	$answer = array(
		'canonical_id' => "WIKILEAKS_ID-{$wikileaks_id}",
		'cables' => array()
		);
	// get preceding cables
	$sqlquery = sprintf("
		select c.`canonical_id`,c.`subject`
		from `cablegate_cables` c
		inner join `cablegate_ucables` uc
		on c.`id` = uc.`cable_id`
		where uc.`ucable_id` < {$wikileaks_id}
		order by  uc.`ucable_id` desc
		limit %d",
		$num_cables_max >> 1
		);
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			array_unshift($answer['cables'], $sqlrow);
			}
		}
	// get target cable
	$sqlquery = "
		select t.`canonical_id`,t.`cable_time`,t.`subject`,o.`origin`
		from `cablegate_origins` o
		inner join (
			select uc.*,c.`canonical_id`,c.`subject`
			from `cablegate_ucables` uc
			left join `cablegate_cables` c
			on uc.`cable_id` = c.`id`
			where uc.`ucable_id` = {$wikileaks_id}
			) t
		on o.`id` = t.`origin_id`
		";
	if ( $sqlresult = mysql_query($sqlquery) ) {
		if ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			if ( $sqlrow['canonical_id'] ) {
				$answer['canonical_id'] = $sqlrow['canonical_id'];
				$answer['cables'][] = array(
					'canonical_id' => $sqlrow['canonical_id'],
					'subject' => $sqlrow['subject']
					);
				}
			else {
				$year = date('y', intval($sqlrow['cable_time']));
				$origin = strtoupper(preg_replace('/(Embassy|Consulate|Mission|Secretary of)?\\s+/', '', $sqlrow['origin']));
				$answer['cables'][] = array(
					'canonical_id' => "{$year}{$origin}?",
					'subject' => '<i>Not published</i>'
					);
				}
			}
		}
	// get succeeding cables
	$sqlquery = sprintf("
		select c.`canonical_id`,c.`subject`,uc.`ucable_id`
		from `cablegate_cables` c
		inner join `cablegate_ucables` uc
		on c.`id` = uc.`cable_id`
		where uc.`ucable_id` > {$wikileaks_id}
		order by  uc.`ucable_id` asc
		limit %d",
		$num_cables_max - count($answer['cables'])
		);
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			if ( intval($sqlrow['ucable_id']) == $wikileaks_id ) {
				$answer['canonical_id'] = $sqlrow['canonical_id'];
				}
			$answer['cables'][] = array(
				'canonical_id' => $sqlrow['canonical_id'],
				'subject' => $sqlrow['subject']
				);
			}
		}

	return $answer;
	}

/*****************************************************************************/
