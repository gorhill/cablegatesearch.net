<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

$now_period = intval(date('Ym'));

if ( isset($_REQUEST['period']) ) {
	if ( !preg_match('/^201\\d(0[1-9]|1[012])$/', $_REQUEST['period']) ) {
		exit('Invalid period');
		}
	$request_period = $_REQUEST['period'];
	}
else {
	$request_period = $now_period;
	}
$request_period_year = intval(substr($request_period,0,4));
$request_period_month = intval(substr($request_period,4,2));

$cache_id = "history_{$request_period}";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
$MONTHS = array(
	1 => 'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December'
	);
$title_period = "{$MONTHS[$request_period_month]} {$request_period_year}";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
#graph {margin-left:3em;padding:2px 2px 0 2px;border:1px solid #aaa}
#graph td {color:#888}
#graph td.in {color:black;background:#fff}
#graph tr:first-child > td {padding:0 0 0 1px;width:20px;vertical-align:bottom}
#graph tr:first-child > td a {display:inline-block;width:20px}
#graph tr:first-child > td.in a.a {background:#80bf80}
#graph tr:first-child > td a.a {background:#cce5cc}
#graph tr:first-child > td.in a.m {background:#8080ff}
#graph tr:first-child > td a.m {background:#ccccff}
#graph tr:first-child > td.in a.r {background:#ff8080}
#graph tr:first-child > td a.r {background:#ffcccc}
#graph tr:first-child ~ tr {font-size:10px}
#graph tr:first-child ~ tr > td:first-child ~ td {border-left:1px solid #aaa}
#graph tr:first-child + tr > td {text-align:center}
#graph tr:first-child + tr + tr > td {padding:2px 1px 0 1px}
ul.releases {margin-left:0;padding-left:0}
li.release > ul {margin-top:0.5em}
li.release > ul > li {display:inline-block;width:18em;font-size:11px;white-space:nowrap;color:darkgreen}
li.release > ul > li a {color:inherit}
li.release > ul > li a:hover {opacity:1}
li.release > ul > li:hover {background-color:#ffd}
li.release > ul > li:before {content:"\002B\2009"}
li.release > ul > li.m {color:blue}
li.release > ul > li.m:before {content:"\2213\2009"}
li.release > ul > li.r {color:red}
li.release > ul > li.r:before {content:"\2212\2009"}
li.release > ul > li.nc {color:gray}
li.release > ul > li.nc:before {content:"\3D\2009"}
.c,.u,.s,li.release > ul > li > span {margin:0 2px 2px 0;display:inline-block;width:7px;height:11px;vertical-align:bottom}
.c,li.release > ul > li > span {background:#ffe4aa}
.u,li.release > ul > li > span.u {background:#aaffba}
.s,li.release > ul > li > span.s {background:#ffaaaa}
li.release > ul > li > span.noforn {background-image:url('noforn-mini.png');background-repeat:no-repeat;background-position:left 2px}
.a {color:darkgreen}
.m {color:blue}
.r {color:red}
.nc {color:gray}
a.magnet {margin-left:3em;font-size:smaller;color:gray;cursor:pointer}
.cable-tip {font-variant:small-caps;max-width:20em}
</style>
<title>Cablegate's cables: Publishing history for <?php echo $title_period; ?></title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, cables, history">
<meta name="description" content="History of all cables on this site">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more.js"></script>
</head>
<body>
<h1>Cablegate's cables: Publishing history for <?php echo $title_period; ?></h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="http://www.cablegatesearch.net/history.php<?php
if ( $request_period != $now_period ) {
	echo "?period={$request_period}";
	}
?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span><?php include('header.php'); ?>
<div id="main">
<?php
function canonical_compare($a, $b) {
	// isolate parts
	if ( preg_match('/^(\\d+)(\\D+)(\\d+)$/', $a, $match) ) {
		$a_year = intval($match[1]) + 1900;
		$a_origin = $match[2];
		$a_id = intval($match[3]);
		if ( preg_match('/^(\\d+)(\\D+)(\\d+)$/', $b, $match) ) {
			$b_year = intval($match[1]) + 1900;
			$b_origin = $match[2];
			$b_id = intval($match[3]);
			$r = strcmp($a_origin, $b_origin);
			if ( !$r ) {
				if ( $a_year < 1950 ) {
					$a_year += 100;
					}
				if ( $b_year < 1950 ) {
					$b_year += 100;
					}
				$r = $b_year - $a_year;
				if ( !$r ) {
					$r = $b_id - $a_id;
					}
				}
			return $r;
			}
		}
	return strcmp($a, $b);
	}

// overview
// 8 hours is added to release time since the server is on the west coast
// TODO: avoid hard coding tz offset
$sqlquery = "
	SELECT
		FROM_UNIXTIME(cre.`release_time`+28800, '%Y%m') AS `period`,
		SUM(IF(cch.`change`=1,1,0)) AS `num_added`,
		SUM(IF(cch.`change`=2,1,0)) AS `num_modified`,
		SUM(IF(cch.`change`=3,1,0)) AS `num_removed`,
		SUM(IF(cch.`change`=4,1,0)) AS `num_readded`
	FROM
		`cablegate_releases` cre
		INNER JOIN
		`cablegate_changes` cch
		ON cre.`release_id` = cch.`release_id`
	GROUP BY
		`period`
	";
// printf('<p>explain %s;</p>', $sqlquery);
if ( $sqlresult = db_query($sqlquery) ) {
	$changes_per_month = array();
	$total_num_added = 0;
	$total_num_modified = 0;
	$total_num_removed = 0;
	$total_num_readded = 0;
	$max_changes_per_month = 0;
	$max_bar_height = 150;
	$years_axis_last_year = 9999;
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$period = $sqlrow['period'];
		$year = intval(substr($period,0,4));
		$num_added = intval($sqlrow['num_added']);
		$num_modified = intval($sqlrow['num_modified']);
		$num_removed = intval($sqlrow['num_removed']);
		$num_readded = intval($sqlrow['num_readded']);
		$total_num_added += $num_added;
		$total_num_modified += $num_modified;
		$total_num_removed += $num_removed;
		$total_num_readded += $num_readded;
		$changes_per_month[$period] = array($num_added, $num_modified, $num_removed);
		$max_changes_per_month = max($max_changes_per_month, $num_added + $num_modified + $num_removed);
		$years_axis_last_year = min($years_axis_last_year,$year);
		}
?>
<p style="margin-top:0.5em">All time: <span class="a"><?php echo number_format($total_num_added); ?> published</span>, <span class="m"><?php echo number_format($total_num_modified); ?> modified</span>, <span class="r"><?php echo number_format($total_num_removed); ?> removed</span> of which <span class="nc"><?php echo $total_num_readded; ?> have been restored without modifications</span>.</p>
<table id="graph" cellspacing="0" cellpadding="0">
<?php
	$months_axis_html = '<tr>';
	$years_axis_html = '<tr>';
	$num_month_columns = 0;
	foreach ( $changes_per_month as $period => $changes ) {
		$year = (int)substr($period,0,4);
		$month = (int)substr($period,4,2);
		$column_class = $period == $request_period ? ' class="in"' : '';
		list($num_added, $num_modified, $num_removed) = $changes;
		printf('<td%s>', $column_class);
		if ( $num_removed ) {
			printf('<a class="r" href="/history.php%s" style="height:%dpx" title="%s %d: %d removed"></a>',
				$period != $now_period ? "?period={$period}" : '',
				(int)ceil($num_removed*$max_bar_height/$max_changes_per_month),
				$MONTHS[$month],
				$year,
				$num_removed
				);
			}
		if ( $num_modified ) {
			printf('<a class="m" href="/history.php%s" style="height:%dpx" title="%s %d: %d modified"></a>',
				$period != $now_period ? "?period={$period}" : '',
				(int)ceil($num_modified*$max_bar_height/$max_changes_per_month),
				$MONTHS[$month],
				$year,
				$num_modified
				);
			}
		if ( $num_added ) {
			printf('<a class="a" href="/history.php%s" style="height:%dpx" title="%s %d: %d added"></a>',
				$period != $now_period ? "?period={$period}" : '',
				(int)ceil($num_added*$max_bar_height/$max_changes_per_month),
				$MONTHS[$month],
				$year,
				$num_added
				);
			}
		$months_axis_html .= sprintf('<td%s>%s', $column_class, substr($MONTHS[$month],0,3));
		if ( $year != $years_axis_last_year ) {
			$column_class = $years_axis_last_year == $request_period_year ? ' class="in"' : '';
			if ( $num_month_columns > 1 ) {
				$years_axis_html .= sprintf('<td%s colspan="%d">%d',
					$column_class,
					$num_month_columns,
					$years_axis_last_year
					);
				}
			else {
				$years_axis_html .= sprintf('<td%s>%d',
					$column_class,
					$years_axis_last_year
					);
				}
			$years_axis_last_year = $year;
			$num_month_columns = 0;
			}
		$num_month_columns++;
		}
	if ( $num_month_columns > 1 ) {
		$column_class = $years_axis_last_year == $request_period_year ? ' class="in"' : '';
		$years_axis_html .= sprintf('<td%s colspan="%d">%d',
			$column_class,
			$num_month_columns,
			$years_axis_last_year
			);
		}
	else {
		$years_axis_html .= sprintf('<td%s>%d',
			$column_class,
			$years_axis_last_year
			);
		}
	echo $months_axis_html, $years_axis_html;
	echo '</table>';
	}

// Get changes over releases
$cable_subject_array = array();
$release_time_beg = strtotime("{$MONTHS[$request_period_month]} {$request_period_year}");
$release_time_end = strtotime("{$MONTHS[$request_period_month]} {$request_period_year} +1 month");
$sqlquery = "
	SELECT
		cre.`release_time`,
		cre.`magnet`,
		cch.`cable_id`,
		cch.`change`,
		cca.`canonical_id`,
		cca.`classification_id`,
		cca.`subject`
	FROM
		`cablegate_cables` cca
		INNER JOIN (
			`cablegate_changes` cch
			INNER JOIN (
				SELECT
					`release_id`,
					`release_time`,
					CAST(FROM_UNIXTIME(`release_time`,'%Y') AS UNSIGNED) AS `release_year`,
					CAST(FROM_UNIXTIME(`release_time`,'%m') AS UNSIGNED) AS `release_month`,
					`magnet`
				FROM
					`cablegate_releases`
				WHERE
					`release_time` >= {$release_time_beg} AND
					`release_time` < {$release_time_end}
				) cre
			ON cre.`release_id` = cch.`release_id`
			)
		ON cca.`id` = cch.`cable_id`
	ORDER BY
		cre.`release_time` DESC,
		cca.`canonical_id` DESC
	LIMIT
		15000
	";
// printf('<p>explain %s;</p>', $sqlquery);
if ( $sqlresult = db_query($sqlquery) ) {

	$CLASSIFICATION_ID_TO_CLASS_MAP = array(
		'',
		' class="u"',
		'',
		' class="s"',
		' class="s noforn"',
		' class="noforn"',
		' class="u"'
		);
?>
<p style="margin-left:3em;color:gray"><span class="u"></span>Unclassified&emsp;<span class="c"></span>Confidential&emsp;<span class="s"></span>Secret</p>
<div style="margin:1em 0;border:0;border-top:1px dotted #aaa;width:100%;height:1px"></div>
<?php
	echo '<ul class="releases">';
	$release_magnets = array();
	$releases = array();
	$cable_details_map = array();
	$change_classes = array(
		1 => '',
		' class="m"',
		' class="r"',
		' class="nc"' // no change
		);
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$change = (int)$sqlrow['change'];
		$release_time = (int)$sqlrow['release_time'];
		if ( !isset($releases[$release_time]) ) {
			$releases[$release_time] = array();
			}
		$releases[$release_time][$sqlrow['canonical_id']] = $change;
		$cable_details_map[$sqlrow['canonical_id']] = array(
			'classification_id' => $sqlrow['classification_id'],
			'subject' => $sqlrow['subject']
			);
		$release_magnets[$release_time] = $sqlrow['magnet'];
		}
	krsort($releases);
	foreach ($releases as $release_time => &$change_details) {
		$occurrences = array_count_values($change_details);
		$fragments = array();
		if ( isset($occurrences[1]) && $occurrences[1] > 0 ) {
			$fragments[] = '<span class="a">'
			             . number_format($occurrences[1])
			             . ' added</span>';
			}
		if ( isset($occurrences[2]) && $occurrences[2] > 0 ) {
			$fragments[] = '<span class="m">'
			             . number_format($occurrences[2])
			             . ' modified</span>';
			}
		if ( isset($occurrences[3]) && $occurrences[3] > 0 ) {
			$fragments[] = '<span class="r">'
			             . number_format($occurrences[3])
			             . ' removed</span>';
			}
		if ( !empty($release_magnets[$release_time]) ) {
			$magnet_link = sprintf(
				'<a class="magnet" href="%s">Torrent magnet for cablegate-%s.7z: %s</a>',
				htmlentities($release_magnets[$release_time]),
				date('YmjHi',$release_time),
				htmlentities($release_magnets[$release_time])
				);
			}
		else {
			$magnet_link = sprintf(
				'<a class="magnet" href="#">From crawl operation completed on %s UTC</a>',
				date('Y-m-j H:i',$release_time)
				);
			}
		printf('<li class="release">%s UTC: %s<br>%s<ul>',
			date('l, j F Y H:i ',$release_time),
			implode(', ',$fragments),
			$magnet_link
			);
		uksort($change_details, 'canonical_compare');
		foreach ( $change_details as $canonical_id => &$change ) {
			printf(
				'<li%s><span%s></span><a href="cable.php?id=%s">%s</a>',
				$change_classes[$change],
				$CLASSIFICATION_ID_TO_CLASS_MAP[$cable_details_map[$canonical_id]['classification_id']],
				htmlentities(urlencode($canonical_id)),
				htmlentities($canonical_id)
				);
			//$cable_subject_array[] = $cable_details_map[$canonical_id]['subject'];
			}
		echo '</ul><br>';
		}
	echo "\n</ul>\n";
	}
?>
<?php include('footer.php'); ?>
</div><!-- end main -->
<script type="text/javascript">
<!--
(function(){
	var atags = [];
	var atags_index = 0;
	var cableTip = null;
	var cableHovered = null;
	var tipRequestHandler = function(response) {
		if (response.subjects) {
			Object.each(response.subjects, function(subject, canonicalId) {
				$$('a[href="cable.php?id='+canonicalId+'"]').each(function(atag){
					atag.store('tip:text',subject);
					// update text in tip if needed
					if (atag === cableHovered && cableTip) {
						cableTip.getElement('.tip-text').set('text',subject);
						}
					});
				});
			}
		};
	var tipRequest = function(e) {
		var canonicalIds = [e.innerHTML];
		// request subject from server, request a bunch while at it
		var li = e.getParent('li');
		var sibling = li;
		var atag;
		while (canonicalIds.length < 15) {
			sibling = sibling.getPrevious('li');
			if (!sibling) {
				break;
				}
			atag = sibling.getElement('a[href^="cable.php"]');
			if (atag && atag.retrieve('tip:text') == '...') {
				canonicalIds.push(atag.innerHTML);
				}
			}
		sibling = li;
		while (canonicalIds.length < 30) {
			sibling = sibling.getNext('li');
			if (!sibling) {
				break;
				}
			atag = sibling.getElement('a[href^="cable.php"]');
			if (atag && atag.retrieve('tip:text') == '...') {
				canonicalIds.push(atag.innerHTML);
				}
			}
		var args = {
			command: 'get_cable_subjects',
			canonicalIds: canonicalIds.join(',')
			};
		var options={
			url: 'cablegate-do.php',
			onSuccess: tipRequestHandler
			};
		var jsonRequest=new Request.JSON(options).get(args);
		};
	var tipOnShowHandler = function(tip, hovered) {
		cableTip = tip;
		cableHovered = hovered;
		var subject = hovered.retrieve('tip:text', null);
		if (subject === '...') {
			tipRequest(hovered);
			}
		tip.setStyle('display','block');
		};
	var asyncInit = function() {
		var atags_count = 250,
			atags_slice = [],
			atag;
		var tipOptions = {
			showDelay: 500,
			className: 'cable-tip',
			fixed: true,
			onShow: tipOnShowHandler
			};
		while ( atags_count-- ) {
			atag = atags[atags_index];
			if (!atag) {break;}
			atags_slice.push(atag);
			atag.store('tip:text', '...');
			atag.target = '_blank';
			atags_index++;
			}
		var dummy = new Tips(atags_slice, tipOptions);
		if (atags.length && atags_index >= atags.length) {
			atags = [];
			}
		else {
			setTimeout(asyncInit, 500);
			}
		};
	var init = function() {
		atags = $$('a[href^="cable.php"]');
		setTimeout(asyncInit, 500);
		}
	window.addEvent('domready',init);
}());
// -->
</script>
</body>
</html><?php
// -----
db_close_compressed_cache();
}
