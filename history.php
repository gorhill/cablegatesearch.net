<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

$cache_id = "history";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
ul.releases {margin-left:0;padding-left:0}
li.release > ul {margin-top:0.5em}
li.release > ul > li {display:inline-block;width:18em;font-size:11px;white-space:nowrap;color:darkgreen}
li.release > ul > li a {color:inherit}
li.release > ul > li.a {color:darkgreen}
li.release > ul > li:before {content:"\002B\2009"}
li.release > ul > li.m {color:blue}
li.release > ul > li.m:before {content:"\2213\2009"}
li.release > ul > li.r {color:red}
li.release > ul > li.r:before {content:"\2212\2009"}
a.magnet {margin-left:3em;font-size:smaller;color:gray;cursor:pointer}
</style>
<title>Cablegate's cables: Release History</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, cables, history">
<meta name="description" content="History of all cables on this site">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more.js"></script>
<script type="text/javascript" src="cablegate-core.js"></script>
</head>
<body>
<h1>Cablegate's cables: Release History</h1>
<?php include('header.php'); ?>
<div id="main">
<div style="font-size:14px">
<?php
// First get number of cables involved
$sqlquery = "SELECT COUNT(DISTINCT `cable_id`) AS `num_cables` FROM `cablegate_changes`";
$num_cables = '?';
if ( $sqlresult = mysql_query($sqlquery) ) {
	$num_cables = mysql_result($sqlresult,0);
	}

// Get changes over releases
$sqlquery = "
	SELECT
		cre.`release_time`,
		cre.`magnet`,
		cch.`cable_id`,
		cch.`change`,
		cca.`canonical_id`
	FROM
		`cablegate_cables` cca
		INNER JOIN
		(
			`cablegate_releases` cre
			INNER JOIN
			`cablegate_changes` cch
			ON cre.`release_id` = cch.`release_id`
			)
		ON cca.`id` = cch.`cable_id`
	ORDER BY
		cre.`release_time` DESC,
		cca.`canonical_id` DESC
	";
if ( $sqlresult = mysql_query($sqlquery) ) {
	$release_magnets = array();
	$change_dates = array();
	printf('<p>%d additions/modifications/deletions concerning %d unique cables.</p><ul class="releases">', mysql_num_rows($sqlresult), $num_cables);
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$change = (int)$sqlrow['change'];
		$change_time = (int)$sqlrow['release_time'];
		if ( !isset($change_dates[$change_time]) ) {
			$change_dates[$change_time] = array();
			}
		$change_dates[$change_time][$sqlrow['canonical_id']] = ($change == 1 ? 'a' : ($change == 2 ? 'm' : 'r'));
		$release_magnets[$change_time] = $sqlrow['magnet'];
		}
	krsort($change_dates);
	foreach ($change_dates as $change_time => &$change_details) {
		$occurrences = array_count_values($change_details);
		$fragments = array();
		if ( isset($occurrences['a']) && $occurrences['a'] > 0 ) {
			$fragments[] = "<span class=\"a\">{$occurrences['a']} added</span>";
			}
		if ( isset($occurrences['m']) && $occurrences['m'] > 0 ) {
			$fragments[] = "<span class=\"m\">{$occurrences['m']} modified</span>";
			}
		if ( isset($occurrences['r']) && $occurrences['r'] > 0 ) {
			$fragments[] = "<span class=\"r\">{$occurrences['r']} removed</span>";
			}
		printf('<li class="release">%s UTC: %s<br><a class="magnet" href="%s">Torrent magnet for cablegate-%s.7z: %s</a><ul>',
			date('l, j F Y H:i ',$change_time),
			implode(', ',$fragments),
			htmlentities($release_magnets[$change_time]),
			date('YmjHi',$change_time),
			htmlentities($release_magnets[$change_time])
			);
		krsort($change_details);
		foreach ( $change_details as $canonical_id => &$change ) {
			printf(
				'<li%s><a href="cable.php?id=%s">%s</a>',
				$change == 'm' ? ' class="m"' : ($change == 'r' ? ' class="r"' : ''),
				htmlentities(urlencode($canonical_id)),
				htmlentities($canonical_id)
				);
			}
		echo '</ul><br>';
		}
	echo "\n</ul>\n";
	}
?>
</div>
<?php include('contact-inc.html'); ?>
</div><!-- end main -->
<p id="cart-tips">Marking a cable with <img style="vertical-align:bottom" width="16" height="16" src="bookmark.png" alt="In cart"> will place this cable in your <span style="font-weight:bold">private cart</span>. When viewing your <span style="font-weight:bold">private cart</span>, you can obtain a persistent snapshot of its content, for future reference or to share with others.</p>
</body>
</html><?php
// -----
db_close_compressed_cache();
}
?>
