<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);
$cache_id = "overview";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
@media all and (max-width:720px) {
	#graph {display:none}
	}
#graph {border:0;width:95%}
#graph tr:first-child > td {border:0;padding:0;vertical-align:bottom}
#graph tr:first-child > td > a {margin:0;border:0;border-right:1px solid #eee;padding:0;display:block;background:#ddd}
#graph tr:first-child > td > a.p {border-right:1px solid #99f;background:#66f}
#list {margin-left:0;padding-left:0.5em;color:#999}
#list > li {margin:0 0.5em 0.5em 0;padding:0.25em 2px 0.25em 2px;border-top:1px dotted #ddd;display:inline-block;vertical-align:top;background:#f8f8f8}
#list > li > span {font-weight:bold}
#list > li > ul > li {width:16em;font-weight:normal}
</style>
<title>Cablegate's cables: Overview</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, release, notes">
<meta name="description" content="Experimental, under development">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more.js"></script>
</head>
<body>
<h1>Cablegate's cables: Overview</h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<?php
$countries = array();
$sqlquery = "SELECT * FROM `cablegate_countries`";
if ( $sqlresult = mysql_query($sqlquery) ) {
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$countries[intval($sqlrow['country_id'])] = $sqlrow['country'];
		}
	$countries[255] = 'All others';
	}

$sqlquery = "
	SELECT
		o.`id` AS `origin_id`,
		o.`origin`,
		o.`country_id`,
		REPLACE(REPLACE(REPLACE(REPLACE(o.`origin`,'Consulate ',''),'Embassy ',''),'Mission ',''),'REO ','') AS `city`,
		uc.`num_published_cables`,
		uc.`num_cables`,
		uc.`num_published_cables`/uc.`num_cables`*100 AS `percent_released`
	FROM
		`cablegate_origins` o
		INNER JOIN (
			SELECT
				`origin_id`,
				COUNT(`ucable_id`) AS `num_cables`,
				SUM(IF(`cable_id` > 0,1,0)) AS `num_published_cables`
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

// ----------------------------------------------------------------------------
// collect stats for graph and list

$country_stats = array();
$total_num_published_cables = $total_num_cables = 0;

if ( $sqlresult = mysql_query($sqlquery) ) {
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$num_published_cables = intval($sqlrow['num_published_cables']);
		$num_cables = intval($sqlrow['num_cables']);
		$country_id = intval($sqlrow['country_id']);
		if ( !isset($country_stats[$country_id]) ) {
			$country_stats[$country_id] = array(
				'country' => $countries[$country_id],
				'num_cables' => 0,
				'num_published_cables' => 0,
				'origins' => array()
				);
			}
		$country_stats[$country_id]['num_cables'] += $num_cables;
		$country_stats[$country_id]['num_published_cables'] += $num_published_cables;
		$country_stats[$country_id]['origins'][] = $sqlrow;
		$total_num_published_cables += $num_published_cables;
		$total_num_cables += $num_cables;
		}
	}

// ----------------------------------------------------------------------------
// graph

function sort_as_per_num_cables($a, $b) {
	$r = $b['num_cables'] - $a['num_cables'];
	if ( $r ) { return $r; }
	return strcmp($b['country'], $a['country']);
	}
uasort($country_stats, 'sort_as_per_num_cables');

// collapse all together countries with less than 200 cables
$collapsed_countries = array();
$collapsed_country_stats = array(
	'country' => '',
	'num_cables' => 0,
	'num_published_cables' => 0,
	'origins' => array()
	);
foreach ( $country_stats as $country_id => $country_details ) {
	if ( $country_details['num_cables'] >= 200 ) {
		continue;
		}
	$collapsed_countries[] = $country_details['country'];
	$collapsed_country_stats['num_cables'] += $country_details['num_cables'];
	$collapsed_country_stats['num_published_cables'] += $country_details['num_published_cables'];
	$collapsed_country_stats['origins'][] = $country_details['origins'];
	}
$collapsed_country_stats['country'] = implode(', ', $collapsed_countries);
$country_stats[255] = $collapsed_country_stats;

// maximum bar
$stats = reset($country_stats);
$max_num_cables = $stats['num_cables'];
?>
<h3>Overview of cables published vs. unpublished so far, by country</h3>
<p><?php echo number_format($total_num_published_cables); ?> cables (<?php echo number_format($total_num_published_cables/$total_num_cables*100, 1); ?>%) have been published out of <?php echo number_format($total_num_cables); ?> leaked cables.</p>
<table id="graph" cellspacing="0" cellpadding="0">
<?php
$MAX_BAR_HEIGHT = 200;
foreach ( $country_stats as $country_id => $country_details ) {
	if ( $country_details['num_cables'] < 200 ) {
		continue;
		}
	echo '<td';
	if ( !empty($td_class) ) {
		echo ' class="', $td_class, '"';
		}
	echo '>';
	$num_published_cables = $country_details['num_published_cables'];
	$num_cables = $country_details['num_cables'];
	$num_unpublished_cables = $num_cables - $num_published_cables;
	$href = "#country-{$country_id}";
	$title = sprintf('%s: %d/%d', htmlentities($country_details['country']), $num_published_cables, $num_cables);
	if ( $num_unpublished_cables ) {
		printf(
			'<a href="%s" style="height:%dpx" title="%s"></a>',
			$href,
			intval(ceil($num_unpublished_cables * $MAX_BAR_HEIGHT / $max_num_cables)),
			$title
			);
		}
	if ( $num_published_cables ) {
		printf(
			'<a href="%s" class="p" style="height:%dpx" title="%s"></a>',
			$href,
			intval(ceil($num_published_cables * $MAX_BAR_HEIGHT / $max_num_cables)),
			$title
			);
		}
	}
?>
</table>
<h3>All cables, % released, by country, origin</h3>
<?php

// ----------------------------------------------------------------------------
// list

// helper to translate percent to css color string
function percent_to_csscolor( $percent ) {
	$redblue = intval($percent > 50 ? 0 : 0x99 - $percent * 0x99 / 50);
	$green = intval($percent > 50 ? ($percent - 50) * 0x99 / 50 : 0x99 - $percent * 0x99 / 50);
	return sprintf("#%02x%02x%02x", $redblue, $green, $redblue);
	}

// compute percent-released
foreach ( $country_stats as $country_id => $country_details ) {
	$country_stats[$country_id]['percent_released'] = $country_details['num_published_cables'] / $country_details['num_cables'] * 100;
	}

// sort according to percent-released
function sort_as_per_percent_released($a, $b) {
	return strcmp($a['country'], $b['country']);
	}
uasort($country_stats, 'sort_as_per_percent_released');

echo '<ul id="list">';
foreach ( $country_stats as $country_id => $country_details ) {
	if ( $country_id == 255 ) { continue; }
	$anchor = "country-{$country_id}";
	echo '<li id="', $anchor, '"><span style="color:', percent_to_csscolor($country_details['percent_released']), '">', htmlentities($country_details['country']), '</span>';
	echo '<ul>';
	echo '<li>', number_format($country_details['num_published_cables']), '&thinsp;/&thinsp;', number_format($country_details['num_cables']);
	if ( count($country_details['origins']) > 1 ) {
		echo ' (', number_format($country_details['percent_released'], 1), '%)';
		}
	foreach ( $country_details['origins'] as $origin_details ) {
		if ( preg_match('/^(consulate |embassy |mission |reo )/i', $origin_details['origin'], $match) ) {
			$origin_prefix = $match[1];
			}
		else {
			$origin_prefix = '';
			}
		$percent = floatval($origin_details['percent_released']);
		if ( $percent == 0 ) {
			$percent_str = '&mdash;';
			}
		else if ( $percent < 1 ) {
			$percent_str = '< 1%';
			}
		else {
			$percent_str = sprintf(abs($percent-round($percent)) < 0.1 ? '%.0f%%' : '%.1f%%', $percent);
			}
		printf('<li>%s<a href="uorigin.php?oid=%s">%s</a>: <span style="color:%s">%s</span>',
			$origin_prefix,
			$origin_details['origin_id'],
			htmlentities(str_replace($origin_prefix, '', $origin_details['origin'])),
			percent_to_csscolor($percent),
			$percent_str
			);
		}
	echo '</ul>';
	}
echo '</ul>';
?>
<?php include('footer.php'); ?>
</div><!-- end main -->
</body>
</html><?php
// -----
db_close_compressed_cache();
}
?>
