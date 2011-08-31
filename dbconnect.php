<?php
$DB_HOST = array('main mysql server','alternate mysql server');
$DB_USERID = array('main server user name','alternate server user name');
$DB_PASSWORD = array('main server password','alternate server password');
$DB_NAME = array('main server database name','alternate server database name');
$DB_HANDLE = null;

function db_init() {
	global $DB_HOST;
	global $DB_USERID;
	global $DB_PASSWORD;
	global $DB_NAME;
	global $DB_HANDLE;

	if ( file_exists("{$_SERVER['DOCUMENT_ROOT']}/cache/db_maintenance") ) {
		exit('<p>Database is being updated. Try again in 15 minutes. You may want to try http://www.cablesearch.org/ or http://www.cabledrum.net/ meanwhile.</p>');
		}

	$mysql_server = 0;
	$DB_HANDLE = @mysql_connect($DB_HOST[$mysql_server], $DB_USERID[$mysql_server], $DB_PASSWORD[$mysql_server]);
	if ( !$DB_HANDLE ) {
		$mysql_server ^= 1;
		$DB_HANDLE = mysql_connect($DB_HOST[$mysql_server], $DB_USERID[$mysql_server], $DB_PASSWORD[$mysql_server]);
		}
	if ( !$DB_HANDLE ) {
		exit(
			"Database server not found: "
		  . str_replace($DB_USERID[$mysql_server], '[redacted]', mysql_error())
		  . "\n You may want to fall back to http://www.cabledrum.net/ or http://www.cablesearch.org/ until site is back.\n "
			);
		}
	if ( !mysql_select_db($DB_NAME[$mysql_server]) ) {
		exit("Database not found");
		}

	// Cables/wikileaks date/time values are UTC
	mysql_query("SET time_zone='UTC'");

	// http://ca.php.net/manual/en/function.mysql-set-charset.php#77565
	/*if ( function_exists('mysql_set_charset') ) {
		mysql_set_charset('latin1', $DB_HANDLE);
		}
	else {
		mysql_query("SET NAMES 'latin1'");
		}
	*/
	}

function db_query($query) {
	global $DB_HANDLE;
	if ( !$DB_HANDLE ) {
		db_init();
		}
	return mysql_query($query);
	}

function db_escape_string($s) {
	global $DB_HANDLE;
	if ( !$DB_HANDLE ) {
		db_init();
		}
	return mysql_real_escape_string($s);
	}

date_default_timezone_set('UTC');

// http://www.php.net/manual/en/function.get-magic-quotes-gpc.php#82524
function stripslashes_deep(&$value) {
	$value = is_array($value) ? array_map('stripslashes_deep',$value) : stripslashes($value);
	return $value;
	}
if ( (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) || (ini_get('magic_quotes_sybase') && strtolower(ini_get('magic_quotes_sybase'))!="off") ) {
	stripslashes_deep($_GET);
	stripslashes_deep($_POST);
	stripslashes_deep($_COOKIE);
	stripslashes_deep($_REQUEST);
	}
?>
