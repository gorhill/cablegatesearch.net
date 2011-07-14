<?php
$CABLE_CONTENT_SEPARATOR = ']]|||[[';
$WIKILEAKS_HOST = 'wikileaks.org';
$CART_BASE64_STR = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';

function token2int($tok) {
	global $CART_BASE64_STR;
	return (strpos($CART_BASE64_STR,substr($tok,0,1))<<12) + (strpos($CART_BASE64_STR,substr($tok,1,1))<<6) + (strpos($CART_BASE64_STR,substr($tok,2,1)));
	}

function int2token($val) {
	global $CART_BASE64_STR;
	return substr($CART_BASE64_STR,($val>>12)&0x3F,1) . substr($CART_BASE64_STR,($val>>6)&0x3F,1) . substr($CART_BASE64_STR,$val&0x3F,1);
	}
?>
