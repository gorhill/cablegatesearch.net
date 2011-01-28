<?php
$DB_HOST = 'localhost';
$DB_USERID = 'your_username';
$DB_PASSWORD = 'your_password';
$DB_NAME = 'your_database';

if ( !mysql_connect($DB_HOST,$DB_USERID,$DB_PASSWORD) ) {
	exit("Server not found");
	}
if ( !mysql_select_db($DB_NAME) ) {
	exit("Database not found");
	}

// Cables/wikileaks date/time values are UTC
mysql_query("SET time_zone='UTC'");
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
