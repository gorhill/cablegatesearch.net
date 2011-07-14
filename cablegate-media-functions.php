<?php
include_once('dbconnect.php');

/*****************************************************************************/

$PROVISIONAL_URL_ID_MIN = 1000000;
$PROVISIONAL_URL_ID_MAX = 100000000;

/*****************************************************************************/

function cable_attach_media_item($cable_id, $url, $contributor_key) {
	global $PROVISIONAL_URL_ID_MIN;
	global $PROVISIONAL_URL_ID_MAX;

	$answer = array('msg' => '');
	$url_escaped = mysql_real_escape_string($url);
	$canonical_id = '';
	$url_id = 0;
	$must_undelete = 0;
	$msg = false;

	// check contributor key
	$contributor_key_sha = empty($contributor_key) ? false : sha1($contributor_key);
	if ( $contributor_key_sha ) {
		$sqlquery = sprintf(
			"select `sha1` from `cablegate_contributors` where `sha1`='{$contributor_key_sha}'",
			mysql_real_escape_string($contributor_key)
			);
		$sqlresult = mysql_query($sqlquery);
		$is_valid_contributor = $sqlresult && mysql_num_rows($sqlresult);
		if ( !$is_valid_contributor ) {
			$msg = 'Invalid contributor key. Request discarded.';
			}
		}

	// see if specified cable exists
	if ( !$msg ) {
		$sqlquery = "select `canonical_id` from `cablegate_cables` where `id` = {$cable_id}";
		$sqlresult = mysql_query($sqlquery);
		if ( !$sqlresult || mysql_num_rows($sqlresult) !== 1 ) {
			$msg = 'Invalid cable id. Request discarded.';
			}
		else {
			$canonical_id = mysql_result($sqlresult, 0);
			}
		}

	// no url
	if ( !$msg && !preg_match('!^https?://[^./]+\.[^./]+!', $url) ) {
		$msg = 'Invalid URL. Request discarded.';
		}

	// see if url association already exists
	if ( !$msg ) {
		$sqlquery = "
			select u.`url_id`, (ua.`flags` & 0x01) as `must_undelete`
			from `cablegate_urls` u
			inner join `cablegate_urlassoc` ua
			on u.`url_id` = ua.`url_id`
			where ua.`cable_id` = {$cable_id} and u.`url` = '{$url_escaped}'
			";
		if ( $sqlresult = mysql_query($sqlquery) ) {
			if ( mysql_num_rows($sqlresult) > 0 ) {
				$url_id = intval(mysql_result($sqlresult, 0, 0));
				$must_undelete = intval(mysql_result($sqlresult, 0, 1));
				}
			if ( $url_id !== 0 && !$must_undelete ) {
				$msg = 'URL already exists. Request ignored.';
				}
			}
		}
	// error occurred, quit
	if ( $msg ) {
		$answer['msg'] = sprintf('<span style="color:red">%s</span>', $msg);
		return $answer;
		}

	// store url in db if valid contributor
	$pending = 1;
	if ( $contributor_key_sha ) {
		// see if url exists
		if ( $sqlresult = mysql_query("select `url_id` from `cablegate_urls` where `url` = '{$url_escaped}'") ) {
			if ( mysql_num_rows($sqlresult) > 0 ) {
				$url_id = intval(mysql_result($sqlresult, 0));
				}
			}
		// store url if it does not exist
		if ( !$url_id ) {
			mysql_query("insert ignore into `cablegate_urls` set `url` = '{$url_escaped}'");
			}
		// get url id
		if ( $sqlresult = mysql_query("select `url_id` from `cablegate_urls` where `url` = '{$url_escaped}'") ) {
			if ( mysql_num_rows($sqlresult) > 0 ) {
				$url_id = intval(mysql_result($sqlresult, 0));
				}
			}
		// store url association
		if ( $url_id ) {
			if ( $must_undelete ) {
				$sqlquery = "update `cablegate_urlassoc` set `flags`=(`flags` & ~0x01) where `cable_id`={$cable_id} and `url_id`={$url_id};";
				}
			else {
				$sqlquery = "insert into `cablegate_urlassoc` set `url_id`={$url_id},`cable_id`={$cable_id},`flags`=0x80;";
				}
			if ( $sqlresult = mysql_query($sqlquery) ) {
				cache_delete("cable_{$canonical_id}");
				cache_delete("cable_{$cable_id}");
				cache_delete("media");
				$pending = 0;
				}
			}
		}

	// if pending, create a provisional url id
	if ( !$url_id ) {
		$url_id = mt_rand($PROVISIONAL_URL_ID_MIN,$PROVISIONAL_URL_ID_MAX);
		}

	// log request
	$filename_prefix = preg_match('/^127\\./', $_SERVER['HTTP_HOST']) ? 'local' : 'remote' ;
	$filename = "./data/{$filename_prefix}-submitted-media-items.txt";
	$entry = "added\t{$pending}\t{$cable_id}\t{$url_escaped}\t{$url_id}\t{$contributor_key_sha}\n";
	if ( !file_put_contents($filename, $entry, FILE_APPEND) ) {
		$answer['msg'] = '<span style="color:red">Critical error: could not process your request. Try again later.</span>';
		return $answer;
		}
	@chmod($filename, 0666);

	// prepare answer
	$msg = 'URL successfully submitted.';
	if ( $pending ) {
		$msg .= ' Your submission will be reviewed by webmaster.';
		}
	$answer['msg'] = sprintf('<span style="color:green">%s</span>', $msg);
	$answer['cable_id'] = $cable_id;
	$answer['url'] = $url;
	$answer['url_id'] = $url_id;
	$answer['pending'] = $pending;

	return $answer;
	}

/*****************************************************************************/

function cable_detach_media_item($cable_id, $url_id, $contributor_key) {
	global $PROVISIONAL_URL_ID_MIN;

	$msg = false;
	$canonical_id = '';

	// check contributor key
	$contributor_key_sha = empty($contributor_key) ? false : sha1($contributor_key);
	if ( $url_id < $PROVISIONAL_URL_ID_MIN ) {
		$sqlquery = sprintf(
			"select `sha1` from `cablegate_contributors` where `sha1`='{$contributor_key_sha}'",
			mysql_real_escape_string($contributor_key)
			);
		$sqlresult = mysql_query($sqlquery);
		$is_valid_contributor = $sqlresult && mysql_num_rows($sqlresult);
		if ( !$contributor_key_sha || !$is_valid_contributor ) {
			$msg = 'Invalid contributor key. Request discarded.';
			}
		}

	// check cable id
	if ( !$msg ) {
		$sqlresult = mysql_query("SELECT `canonical_id` FROM `cablegate_cables` WHERE `id`={$cable_id}");
		if ( !$sqlresult || !mysql_num_rows($sqlresult) ) {
			$msg = 'Invalid cable id. Request discarded.';
			}
		else {
			$canonical_id = mysql_result($sqlresult, 0);
			}
		}

	// check url id
	if ( !$msg && $url_id < $PROVISIONAL_URL_ID_MIN ) {
		$sqlresult = mysql_query("SELECT `url_id` FROM `cablegate_urls` WHERE `url_id`={$url_id}");
		if ( !$sqlresult || !mysql_num_rows($sqlresult) ) {
			$msg = 'Invalid URL. Request discarded.';
			}
		}

	// check cable id-url id association
	if ( !$msg && $url_id < $PROVISIONAL_URL_ID_MIN ) {
		$sqlresult = mysql_query("SELECT `cable_id`,`url_id` FROM `cablegate_urlassoc` WHERE `cable_id`={$cable_id} AND `url_id`={$url_id}");
		if ( !$sqlresult || !mysql_num_rows($sqlresult) ) {
			$msg = 'Cable-URL association does not exists. Request discarded.';
			}
		}

	// quit if error
	if ( $msg ) {
		return array('msg'=>$msg);
		}

	// permission checks goes here: pending or immediate?

	// log request
	$filename_prefix = preg_match('/^127\\./', $_SERVER['HTTP_HOST']) ? 'local' : 'remote' ;
	$filename = "./data/{$filename_prefix}-submitted-media-items.txt";
	$entry = "removed\t0\t{$cable_id}\t\t{$url_id}\t{$contributor_key_sha}\n";
	if ( !file_put_contents($filename, $entry, FILE_APPEND) ) {
		return array('msg'=>'Critical error. Request discarded');
		}
	@chmod($filename, 0666);

	cache_delete("cable_{$canonical_id}");
	cache_delete("cable_{$cable_id}");
	cache_delete("media");

	// remove association
	if ( $url_id < $PROVISIONAL_URL_ID_MIN ) {
		$sqlresult = mysql_query("UPDATE `cablegate_urlassoc` SET `flags`=`flags` | 0x81 WHERE `cable_id`={$cable_id} AND `url_id`={$url_id}");
		if ( !$sqlresult || mysql_affected_rows() <= 0 ) {
			return array(
				'msg'=>'Request successful, removal awaiting review.',
				'cable_id'=>$cable_id,
				'url_id'=>$url_id,
				'pending'=>true
				);
			}
		}

	return array(
		'msg'=>'Request successful, URL removed.',
		'cable_id'=>$cable_id,
		'url_id'=>$url_id,
		'done'=>true
		);
	}

/*****************************************************************************/

function get_media_items_from_host($media_host, $media_host_id) {
	$answer = array(
		'media_host_id' => $media_host_id,
		'media_items' => array()
		);
	$sqlquery = "
		select u.`url_id`,u.`url`,IF(u.`title` IS NULL,'',UNCOMPRESS(u.`title`)) as `title`
		from `cablegate_urls` u
		inner join `cablegate_urlassoc` ua
		on u.`url_id` = ua.`url_id`
		where u.`url` rlike '^https?://(www[[:digit:]]*\\\\.)?%s(/.*)?$' and (ua.`flags` & 0x01) = 0
		group by u.`url`
		";
	$sqlquery = sprintf($sqlquery, mysql_real_escape_string(preg_quote($media_host)));
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$answer['media_items'][] = array(
				'id' => intval($sqlrow['url_id']),
				'title' => $sqlrow['title'],
				'url' => $sqlrow['url']
				);
			}
		}
	return $answer;
	}

/*****************************************************************************/

function get_cables_from_media_item_id($media_item_id) {
	$answer = array(
		'media_item_id' => $media_item_id,
		'cables' => array()
		);
	$sqlquery = "
		select ua.`cable_id`,c.`canonical_id`,c.`subject`,c.`cable_time`
		from `cablegate_cables` c
		inner join `cablegate_urlassoc` ua
		on c.`id` = ua.`cable_id`
		where ua.`url_id` = {$media_item_id} and (ua.`flags` & 0x01) = 0
		order by c.`cable_time`
		";
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$answer['cables'][] = array(
				'id' => intval($sqlrow['cable_id']),
				'canonical_id' => $sqlrow['canonical_id'],
				'subject' => $sqlrow['subject']
				);
			}
		}
	return $answer;
	}

/*****************************************************************************/

function get_media_items_from_cable_id($media_item_id, $cable_id) {
	$answer = array(
		'media_item_id' => $media_item_id,
		'cable_id' => $cable_id,
		'media_items' => array()
		);
	$sqlquery = "
		select ua.`url_id`,u.`url`,IF(u.`title` IS NULL,'',UNCOMPRESS(u.`title`)) as `title`
		from `cablegate_urls` u
		inner join `cablegate_urlassoc` ua
		on u.`url_id` = ua.`url_id`
		where ua.`cable_id` = {$cable_id} and ua.`url_id` != {$media_item_id}
		order by u.`url`
		";
	if ( $sqlresult = mysql_query($sqlquery) ) {
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$answer['media_items'][] = array(
				'id' => intval($sqlrow['url_id']),
				'title' => $sqlrow['title'],
				'url' => $sqlrow['url']
				);
			}
		}
	return $answer;
	}

/*****************************************************************************/
