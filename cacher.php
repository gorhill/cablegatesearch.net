<?php
include_once("globals-generated.php");
include_once("dbconnect.php");

// TODO: make it into a class

$CACHER_EXCLUDE_IPS_REGEX = '/^(127\\.0\\.\\d+\\.\\d+)$/';
$CACHER_DISABLED = false;
$CACHER_MAXITEMS_LO = 1900;
$CACHER_MAXITEMS_HI = 2000;

$CACHE_HANDLE = false;
$CACHE_DIR = $_SERVER['DOCUMENT_ROOT'] . '/cache/';

/*****************************************************************************
Cached output functions
*/

function cache_id_to_fullpath($cache_id) {
	global $CACHE_DIR;
	return 	$CACHE_DIR . $cache_id . '.blob';
	}

function db_cancel_cache() {
	global $CACHE_HANDLE;
	if ( !$CACHE_HANDLE ) return;
	ob_end_flush();
	$CACHE_HANDLE = false;
	}

function db_open_compressed_cache($cache_id) {
	global $CACHER_EXCLUDE_IPS_REGEX;
	global $CACHER_DISABLED;
	global $CACHE_HANDLE;
	global $CACHE_DIR;
	if ( $CACHE_HANDLE ) exit('db_open_compressed_cache(): fatal error, recursivity not allowed');
	// dont cache if cache id too long
	if ( $CACHER_DISABLED ) {
		return;
		}
	// don't cache if me
	if ( !empty($CACHER_EXCLUDE_IPS_REGEX) && preg_match($CACHER_EXCLUDE_IPS_REGEX,$_SERVER["REMOTE_ADDR"]) ) {
		return;
		}
	// don't cache if crawlers, bots, etc.
	if ( db_referrer_is_a_bot() ) {
		return;
		}
	$CACHE_HANDLE = $cache_id;
	ob_start();
	}

function db_close_compressed_cache() {
	global $CACHER_MAXITEMS_LO;
	global $CACHER_MAXITEMS_HI;
	global $CACHE_HANDLE;
	global $CACHE_DIR;
	if ( !$CACHE_HANDLE ) return;
	// http://www.ulf-wendel.de/php/show_source.php?file=out_cache_com
	$len = ob_get_length();            
	$content = ob_get_clean();
	// gzcompress() returns string as RFC1950: http://www.faqs.org/rfcs/rfc1950.html
	//    [CMF] [FLG] [...data...](?) [ADLER32](4)
	// ... to ...
	// gzencode() returns string as RFC1952: http://www.gzip.org/zlib/rfc-gzip.html
	//    [1F] [8B] [CM] [FLG] [MTIME](4) [XFL] [OS] [...data...](?) [CRC32](4) [ISIZE](4)
	$gzip_content = gzencode($content);
	// write file
	$fullpath = cache_id_to_fullpath($CACHE_HANDLE);
	@file_put_contents($fullpath,$gzip_content);
	@chmod($fullpath,0666);
	@touch($fullpath);
	$CACHE_HANDLE = false;
	// limit number of cache files
	if ( !(time() & 31) ) {
		$cache_files = @scandir($CACHE_DIR);
		$num_cache_files = count($cache_files);
		if ( $num_cache_files > $CACHER_MAXITEMS_HI ) {
			$sorted_cache_files = array();
			foreach ( $cache_files as $cache_file ) {
				$sorted_cache_files[(string)@filemtime($CACHE_DIR.$cache_file).$cache_file] = $cache_file;
				}
			ksort($sorted_cache_files);
			reset($sorted_cache_files);
			for ( ; --$num_cache_files > $CACHER_MAXITEMS_LO; ) {
				$cache_file_entry = each($sorted_cache_files);
				@unlink($CACHE_DIR.$cache_file_entry[1]);
				}
			}
		}
	// http://ca2.php.net/manual/en/function.gzcompress.php#88044
	$HTTP_ACCEPT_ENCODING = $_SERVER['HTTP_ACCEPT_ENCODING'];
	if ( headers_sent() ) {
		$encoding = false;
		}
	else if ( stripos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ) {
		$encoding = 'x-gzip';
		}
	else if ( stripos($HTTP_ACCEPT_ENCODING,'gzip') !== false ) {
		$encoding = 'gzip';
		}
	else {
		$encoding = false;
		}
	if ( $encoding ) {
		header('Content-encoding: '.$encoding);
		echo $gzip_content;
		}
	else {
		echo $content;
		}
	}

function db_get_compressed_cache($cache_id,$maxSeconds=0) {
	global $CABLEGATE_DATABASE_LAST_MODIFIED;

	$fullpath = cache_id_to_fullpath($cache_id);
	if ( !($gzip_content = @file_get_contents($fullpath)) ) {
		return null;
		}
	$update_time = @filemtime($fullpath) + 1000*61;
	// use cache only if entry not expired
	if ( $maxSeconds > 0 && $maxSeconds < (time()-$update_time) ) {
		return null;
		}
	// use cache only if dependency(ies) are older than cache
	if ( $update_time <= $CABLEGATE_DATABASE_LAST_MODIFIED ){
		return null;
		}
	return $gzip_content;
	}

function db_uncompress_cache($gzip_content) {
	if ( empty($gzip_content) ) {
		return false;
		}
	// gzencode() returns string as RFC1952: http://www.gzip.org/zlib/rfc-gzip.html
	//    [1F] [8B] [CM] [FLG] [MTIME](4) [XFL] [OS] [...data...](?) [CRC32](4) [ISIZE](4)
	// ... to ...
	// gzcompress() returns string as RFC1950: http://www.faqs.org/rfcs/rfc1950.html
	//    [CMF] [FLG] [...data...](?) [ADLER32](4)
	return gzinflate(substr($gzip_content,10,-8));
	}

function db_output_compressed($gzip_content) {
	if ( headers_sent() ) {
		$encoding = false;
		}
	else if ( !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'x-gzip') !== false ) {
		$encoding = 'x-gzip';
		}
	else if ( !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !== false ) {
		$encoding = 'gzip';
		}
	else {
		$encoding = false;
		}
	if ( $encoding ) {
		header('Content-encoding: '.$encoding);
		echo $gzip_content;
		}
	else {
		echo db_uncompress_cache($gzip_content);
		}
	}

function db_output_compressed_cache($cache_id, $maxSeconds=0) {
	if ( $gzip_content = db_get_compressed_cache($cache_id, $maxSeconds) ) {
		if ( headers_sent() ) {
			$encoding = false;
			}
		else if ( !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'x-gzip') !== false ) {
			$encoding = 'x-gzip';
			}
		else if ( !empty($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !== false ) {
			$encoding = 'gzip';
			}
		else {
			$encoding = false;
			}
		if ( $encoding ) {
			header('Content-encoding: '.$encoding);
			echo $gzip_content;
			}
		else {
			echo db_uncompress_cache($gzip_content);
			}
		return true;
		}
	return false;
	}

/*****************************************************************************
Other functions
*/
function db_referrer_is_a_bot() {
	// don't cache for crawlers, bots
	$db_cache_exclude = array(
		array('80legs',0),
		array('ask',0),
		array('AISearchBot',0),
		array('bot/',15),
		array('bot-',15),
		array('crawl',15),
		array('DigExt',15), // possibly an offline reading downloader -- rude!
		array('discobot',0),
		array('dotnetdotcom.org',0),
		array('Feedfetcher-Google',0),
		array('Gaisbot',0),
		array('Gigabot',0),
		array('Googlebot',0),
		array('HTTrack',15),
		array('ia_archiver',0),
		array('Jakarta',0),
		array('Java',0),
		array('legs',15),
		array('libwww',30),
		array('LinkScan',0),
		array('msnbot',0),
		array('MJ12bot/',0),
		array('MLBot',0),
		array('Nutch',0),
		array('Python',0),
		array('robot',15),
		array('ScoutJet',0),
		array('scrapybot',0),
		array('Searchbot',0),
		array('sitemap_builder',0),
		array('Slurp',0),
		array('spider',15),
		array('SLCC1;  .NET',0), // MS cloaked bot
		array('SV1;  .NET',0), // MS cloaked bot
		array('Teoma',0),
		array('Twiceler',0),
		array('Voila',0),
		array('Wget/',15),
		array('WordPress',0),
		array('Yandex',0),
		array('ZanranCrawler',0),
		);
	$agent = $_SERVER['HTTP_USER_AGENT'];
	// do not trust unspecified agents
	if ( empty($agent) ) {
		sleep(30);
		return true;
		}
	// check for known bots
	foreach ( $db_cache_exclude as $exclude ) {
		if ( stripos($agent,$exclude[0]) !== FALSE ) {
			// slow down bandwidth hoggers
			if ( $exclude[1] ) {
				sleep($exclude[1]);
				}
			return true;
			}
		}
	return false;
	}
?>
