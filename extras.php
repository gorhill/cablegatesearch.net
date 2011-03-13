<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);
$cache_id = "extras";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
#uorigins > li {display:inline-block;width:24em;color:#888}
.g {color:#0a0}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<title>Cablegate's cables: Extras</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, release, notes">
<meta name="description" content="Experimental, under development">
</head>
<body>
<h1>Cablegate's cables: Extras</h1>
<?php include('header.php'); ?>
<div id="main">
<h3>All cables, % released, by origin</h3>
<div>
<?php
$sqlquery = "
	SELECT
		o.`id`,
		o.`origin`,
		REPLACE(REPLACE(REPLACE(REPLACE(o.`origin`,'Consulate ',''),'Embassy ',''),'Mission ',''),'REO ','') AS `city`,
		uc.`num_cables` / uc.`num_ucables` * 100 AS `percent_released`
	FROM
		`cablegate_origins` o
		INNER JOIN (
			SELECT
				`origin_id`,
				COUNT(`ucable_id`) AS `num_ucables`,
				SUM(IF(`cable_id` > 0,1,0)) AS `num_cables`
			FROM
				`cablegate_ucables`
			GROUP BY
				`origin_id`
			) uc
		ON uc.`origin_id` = o.`id`
	ORDER BY
		`city`
	";
// printf('<p>explain %s</p>', $sqlquery);
if ( $sqlresult = mysql_query($sqlquery) ) {
	echo '<ul id="uorigins">';
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		if ( preg_match('/^(consulate |embassy |mission |reo )/i',$sqlrow['origin'],$match) ) {
			$origin_prefix = $match[1];
			}
		else {
			$origin_prefix = '';
			}
		$percent = (float)$sqlrow['percent_released'];
		if ( $percent < 100 ) {
			$percent_str = ($percent == 0 ? '&mdash;' : ($percent < 1.0 ? '< 1%' : sprintf(abs($percent-round($percent)) < 0.1 ? '%.0f%%' : '%.1f%%', $percent)));
			}
		else {
			$percent_str = '<span class="g">100%</span>';
			}
		printf('<li>%s<a href="uorigin.php?oid=%s">%s</a>: %s',
			$origin_prefix,
			$sqlrow['id'],
			htmlentities(str_replace($origin_prefix,'',$sqlrow['origin'])),
			$percent_str
			);
		}
	echo '</ul>';
	}
echo mysql_error();
?>
</div>
<?php include('footer.php'); ?>
</div><!-- end main -->
</body>
</html><?php
// -----
db_close_compressed_cache();
}
?>
