<?php
include_once("cacher.php");
include_once("globals.php");

// get a cart
$cart = '';
$is_guest_cart = false;
if ( !empty($_GET['cart']) ) {
	$cart = $_GET['cart'];
	$is_guest_cart = true;
	}
else if ( !empty($_COOKIE['cablegateCart']) ) {
	$cart = $_COOKIE['cablegateCart'];
	}
if ( !preg_match('/^([-0-9a-zA-Z_]{3})*$/',$cart) ) {
	// convert from previous scheme?
	if (preg_match('/^([0-9a-fA-F]{5})+$/',$cart)) {
		$cart_tokens = str_split($cart,5);
		$cart = '';
		foreach ( $cart_tokens as $hex ) {
			$cart .= int2token(hexdec($hex));
			}
		if (!$is_guest_cart) {
			setcookie('cablegateCart', $cart, time()+60*60*24*365, '/');
			}
		}
	else {
		$cart = '';
		}
	}
// use cache
$cache_id = 'cart_' . ($is_guest_cart ? '' : 'p_' ) . sha1($cart);
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);

include_once('cablegate-functions.php');

$cart_type = $is_guest_cart ? 'Public' : 'Private';
$cart_is_empty = empty($cart);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
<?php include('cablegate-cart.css'); ?>
<?php include('cablegate-list.css'); ?>
#export {margin-top:1em;color:#666}
#export > div:first-child {margin-left:0.5em}
#export > div:first-child > div {border:1px solid #eee;border-bottom:none;padding:3px;display:inline-block;cursor:pointer}
#export > div:first-child + div {border:1px solid #eee;padding:0.5em 3px;overflow:auto}
#export > div:first-child + div > div {white-space:pre;font:12px monospace}
#cart-permalink {font-size:small;background-color:#eee}
</style>
<title>Cablegate's cables: <?= $cart_type ?> cart</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, cart">
<meta name="description" content="A page allowing you to store and retrieve hand-picked cables">
<?php
if (!$cart_is_empty ) {
	printf("<link rel=\"bookmark\" href=\"http://www.cablegatesearch.net/cart.php?cart=%s\">\n",$cart);
	}
?>
<?php include('mootools-core-1.3-loader.inc'); ?>
<!--[if lte IE 8]>
<style type="text/css">
#cable-list tr > th:first-child + th + th + th {padding:4px 0 0 0;font-size:smaller;text-align:right;white-space:nowrap}
#cable-list tr > td:first-child + td + td + td {width:5em;font-size:smaller;color:#888;text-align:right;white-space:nowrap}
</style>
<![endif]-->
<script type="text/javascript" src="mootools-more.js"></script>
<script type="text/javascript" src="cablegate-cart.js"></script>
<script type="text/javascript" src="cablegate.js"></script>
</head>
<body>
<h1>Cablegate's cables: <?= $cart_type ?> cart</h1>
<?php if ( !$cart_is_empty ) { ?>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="gorhill" data-text="Check these cables #cablegate" data-url="http://www.cablegatesearch.net/cart.php<?php echo "?cart=", urlencode($cart); ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span><!-- end twitter -->
<?php } ?>
<?php include('header.php'); ?>
<div id="main">
<p style="margin-top:0"><?php if (!$is_guest_cart) { ?>
This page shows the current content of your private cart.</p>
<p>You can publish, share or keep for future reference the current content of your private cart with this permalink: <a id="cart-permalink" href="cart.php?cart=<?php echo $cart; ?>">cart.php?cart=<?php
if ( strlen($cart) > 15 ) {
	preg_match('/^(......).*(......)$/', $cart, $match);
	printf("%s...%s", $match[1], $match[2]);
	}
else {
	echo $cart;
	}
?></a>.<br>Alternatively, you can use the Tweet button at the top-right corner of this page to share the content of this cart with others on Twitter.</p>
<?php } else { ?>
This is a public cart. You can't modify the content of a public cart.</p>
<?php } ?>
<table id="cable-list" cellspacing="0" cellpadding="0">
<tr><th><th>Cable date<th><a class="cartTogglerInfo" href="/cart.php"></a>Subject &mdash; Origin<th>Updated<br>... ago
<?php
// build query
$query = "
	SELECT DISTINCT
		c.`id`,
		c.`canonical_id`,
		c.`cable_time`,
		c.`change_time`,
		(c.`status` & 0x01) AS `removed`,
		(c.`status` & 0x02) AS `new_or_updated`,
		cl.`classification`,
		o.`origin`,
		c.`subject`
	FROM `cablegate_classifications` cl
		INNER JOIN (`cablegate_origins` o
		INNER JOIN `cablegate_cables` c
		ON o.`id` = c.`origin_id`)
		ON cl.`id` = c.`classification_id`
	WHERE
		0
	";
if (strlen($cart) > 0) {
	$cart_tokens = str_split($cart,3);
	foreach ( $cart_tokens as $token ) {
		$value = token2int($token);
		$query .= " OR c.id={$value}";
		}
	}
$query .= "
	ORDER BY
		c.`cable_time` DESC,
		c.`canonical_id`
	";
//printf("<p>%s</p>", $query);
$result = mysql_query($query);
if (!$result) { exit(mysql_error()); }
$num_cables = mysql_num_rows($result);
echo cables2rows($result);
?>
<?php if ($num_cables == 0) { ?>
<tr><td colspan="4" style="color:gray">[Empty]
<?php } ?>
<?php if (!$is_guest_cart && $num_cables > 0) { ?>
<tr><td colspan="4" style="text-align:right"><button>Remove all</button>
<?php } ?>
</table>
<?php if ( $num_cables ) { ?>
<h3>Export</h3>
<div id="export">
<?php
$TAB_MARGINBOTTOM = '0';
$TAB_BORDERBOTTOM = 'none';
$TAB_COLOR = '#aaa';
$TAB_BACKGROUNDCOLOR = '#eee';
$TAB_SELECTED_MARGINBOTTOM = '-1px';
$TAB_SELECTED_BORDERBOTTOM = '1px solid #fff';
$TAB_SELECTED_COLOR = '#000';
$TAB_SELECTED_BACKGROUNDCOLOR = '#fff';

$cables = array();
mysql_data_seek($result,0);
while ( $sqlrow = mysql_fetch_assoc($result) ) {
	$date_details = getdate($sqlrow['cable_time']);
	$cables[] = array(
		'canonical_id' => cp1252_to_htmlentities($sqlrow['canonical_id']),
		'subject' => cp1252_to_htmlentities(strtoupper($sqlrow['subject'])),
		'url' => sprintf('http://213.251.145.96/cable/%d/%02d/%s.html',
			$date_details['year'],
			$date_details['mon'],
			cp1252_to_htmlentities($sqlrow['canonical_id'])
			)
		);
	}
?>
<div> <!-- tab captions -->
<div style="margin-bottom:<?php echo $TAB_SELECTED_MARGINBOTTOM; ?>;border-bottom:<?php echo $TAB_SELECTED_BORDERBOTTOM; ?>;color:<?php echo $TAB_SELECTED_COLOR; ?>;background-color:<?php echo $TAB_SELECTED_BACKGROUNDCOLOR; ?>">HTML</div>
<div style="color:<?php echo $TAB_COLOR; ?>;background-color:<?php echo $TAB_BACKGROUNDCOLOR; ?>">BBCode</div>
<div style="color:<?php echo $TAB_COLOR; ?>;background-color:<?php echo $TAB_BACKGROUNDCOLOR; ?>">Text</div>
</div>
<div> <!-- tab containers -->
<div><?php
// html a tag list
foreach ( $cables as $cable ) {
	printf("&lt;a href=&quot;%s&quot;&gt;%s: %s&lt;/a&gt;\n", $cable['url'], $cable['canonical_id'], $cable['subject']);
	}
?>
</div>
<div style="display:none"><?php
// bbcode list
foreach ( $cables as $cable ) {
	printf("[url=%s]%s: %s[/url]\n", $cable['url'], $cable['canonical_id'], $cable['subject']);
	}
?>
</div>
<div style="display:none"><?php
// text list
foreach ( $cables as $cable ) {
	printf("%s: %s (%s)\n", $cable['canonical_id'], $cable['subject'], $cable['url']);
	}
?>
</div>
</div>
<script type="text/javascript">
<!--
$$('#export > div:first-child > div').each(function(tab,i){
	tab.addEvent('click',function(){
		$$('#export > div:first-child > div').each(function(tab,j){
			if (j===i){
				tab.setStyles({
					marginBottom:'<?php echo $TAB_SELECTED_MARGINBOTTOM; ?>',
					borderBottom:'<?php echo $TAB_SELECTED_BORDERBOTTOM; ?>',
					color:'<?php echo $TAB_SELECTED_COLOR; ?>',
					backgroundColor:'<?php echo $TAB_SELECTED_BACKGROUNDCOLOR; ?>'
					});
				}
			else {
				tab.setStyles({
					marginBottom:'<?php echo $TAB_MARGINBOTTOM; ?>',
					borderBottom:'<?php echo $TAB_BORDERBOTTOM; ?>',
					color:'<?php echo $TAB_COLOR; ?>',
					backgroundColor:'<?php echo $TAB_BACKGROUNDCOLOR; ?>'
					});
				}
			});
		$$('#export > div:first-child + div > div').each(function(container,j){
			if (j!==i){
				container.setStyle('display','none');
				}
			});
		$$('#export > div:first-child + div > div').each(function(container,j){
			if (j===i){
				container.setStyle('display','');
				}
			});
		});
	});
$$('#export > div:first-child + div > div').each(function(container){
	// select all on click
	container.addEvent('dblclick',function(){
		// http://stackoverflow.com/questions/985272/jquery-selecting-text-in-an-element-akin-to-highlighting-with-your-mouse
		var range;
		if (window.getSelection && document.createRange) {
			var sel=window.getSelection();
			sel.removeAllRanges();
			range=document.createRange();
			range.selectNodeContents(this);
			sel.addRange(range);
			}
		else if (document.body.createTextRange) {
			range=document.body.createTextRange();
			range.moveToElementText(this);
			range.select();
			}
		});
	});
// -->
</script>
<?php } ?>
<?php include('footer.php'); ?>
</div>
</div>
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
?>
