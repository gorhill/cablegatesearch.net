<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

if ( isset($_REQUEST['oid']) && ctype_digit($_REQUEST['oid']) ) {
	$origin_id = (int)$_REQUEST['oid'];
	}
else {
	$origin_id = 0;
	}

$cache_id = "uorigin_{$origin_id}";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----

// get origin details
$origin = '?';
$sqlquery = "
	SELECT
		o.`origin`
	FROM
		`cablegate_origins` o
	WHERE
		o.`id` = {$origin_id}
	";
if ( $sqlresult = db_query($sqlquery) ) {
	if ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$origin = $sqlrow['origin'];
		}
	}
$title = sprintf('Unreleased cables from %s', htmlentities($origin));
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
#graph {margin-bottom:1em;border:1px solid #888;background-color:#f8f8f8;font-size:10px}
#graph tr:first-child td {margin:0;border:0;padding:0;width:7px;vertical-align:bottom}
#graph tr:first-child td:nth-child(4n+1) {border-left:1px solid #ddd}
#graph tr:first-child a {margin:0;border:0;border-left:1px solid #eef;padding:0;display:inline-block;width:6px;background:#ddf}
#graph tr:first-child a.r {margin:0;border:0;border-left:1px solid #99f;padding:0;display:inline-block;width:6px;background:#88f}
#graph tr:first-child a.in {border-left:1px solid #99f;background-color:#88f}
#graph tr:first-child + tr > td {border-top:1px solid #aaa;border-left:1px solid #ddd;color:#aaa}
#graph tr:first-child + tr > td a {color:#000}
#cables {width:99%;font-size:12px}
#cables tr:nth-of-type(even) {background:#f8f8f8}
#cables tr:nth-of-type(odd) {background:#eee}
#cables tr:hover {background:#FFFAE8}
#cables th {text-align:left;white-space:nowrap}
#cables td,#cables th {padding:3px 0.5em 3px 2px;border:0;border-bottom:1px solid white;vertical-align:top}
#cables td:first-child {width:8em;white-space:nowrap}
#cables td:nth-of-type(2) {padding-left:1em;font-variant:small-caps;color:#666;font-size:11px}
#cables td:nth-of-type(2) > a,#cables td:nth-of-type(2) > span {margin-left:-1em;display:block;font-size:14px}
#cables td:nth-of-type(3) {text-align:right}
</style>
<title>Cablegate's cables: <?php echo $title; ?></title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, cables, history">
<meta name="description" content="History of all cables on this site">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more.js"></script>
<script type="text/javascript" src="cablegate-uorigin.js"></script>
</head>
<body>
<h1>Cablegate's cables: <?php echo $title; ?></h1>
<?php include('header.php'); ?>
<div id="main">
<p style="margin-top:0;color:gray;font-size:smaller">This page lists all the cables for a specific location as per the content of <a href="http://www.guardian.co.uk/news/datablog/2010/nov/29/wikileaks-cables-data#data">this spreadsheet</a>, published by <em>The Guardian</em> (which contains only date, time, location, and tags). An attempt is made to programmatically match entries with already released cables. As of now, the matching is performed using the cable's location and date/time, which can lead to erroneous matching once in a while (ex.: when many entries of a particular location have the same exact date/time.) This page is an early implementation of suggestions from <a href="http://www.wlcentral.org/">WL Central.org</a>'s x7o.</p>
<div style="font-size:14px">
<?php

/*****************************************************************************/

function get_tag_translation_table() {
	if ( $cache_content = cache_retrieve('uorigin_tag_translation_table') ) {
		return unserialize($cache_content);
		}
	if ( $tags = get_all_tags() ) {
		$tags_translation_table = array();
		foreach ( $tags as $tag_id => &$tag_details ) {
			$tags_translation_table["{$tag_details['tag']}{{$tag_id}}"] = "{$tag_details['def']} ({$tag_details['tag']})";
			}
		cache_store('uorigin_tag_translation_table', serialize($tags_translation_table));
		return $tags_translation_table;
		}
	return false;
	}

/*****************************************************************************/

// get tag translation table (key to efficiently expand tag definitions)
$tags_translated_table = array();
$tags_translation_table = get_tag_translation_table();

// we will time-period-coalesce cables for the graph
$num_cables_per_quarter = array();
$num_released_cables_per_quarter = array();

// get all cables for a given origin
$sqlquery = "
	SELECT
		uc.`ucable_id`,
		uc.`cable_id`,
		uc.`cable_time`,
		IF(c.`subject` IS NOT NULL,c.`subject`,'') AS `subject`,
		IF(c.`canonical_id` IS NOT NULL,c.`canonical_id`,'') AS `canonical_id`,
		uc.`tags`
	FROM
		`cablegate_ucables` uc
		LEFT JOIN
		`cablegate_cables` c
		ON uc.`cable_id` = c.`id`
	WHERE
		uc.`origin_id` = {$origin_id}
	ORDER BY
		uc.`cable_time` DESC
	";
// printf('<p>%s</p>', $sqlquery);
if ( $sqlresult = db_query($sqlquery) ) {
	$current_quarterkey = 0;
	$current_year = 0;
	ob_start();
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$cable_date_details = getdate((int)$sqlrow['cable_time']);
		$year = $cable_date_details['year'];
		$quarter = floor(($cable_date_details['mon'] - 1) / 3) + 1;
		if ( !isset($num_cables_per_quarter[$year]) ) {
			$num_cables_per_quarter[$year] = array($quarter=>1);
			}
		else if ( !isset($num_cables_per_quarter[$year][$quarter]) ) {
			$num_cables_per_quarter[$year][$quarter] = 1;
			}
		else {
			$num_cables_per_quarter[$year][$quarter]++;
			}

		// generate subject line
		$subject = $sqlrow['subject'];
		if ( !empty($subject) ) {
			$subject = sprintf(
				'<a href="cable.php?id=%s">%s: %s</a>',
				$sqlrow['canonical_id'],
				$sqlrow['canonical_id'],
				$subject
				);
			if ( !isset($num_released_cables_per_quarter[$year]) ) {
				$num_released_cables_per_quarter[$year] = array($quarter=>1);
				}
			else if ( !isset($num_released_cables_per_quarter[$year][$quarter]) ) {
				$num_released_cables_per_quarter[$year][$quarter] = 1;
				}
			else {
				$num_released_cables_per_quarter[$year][$quarter]++;
				}
			}

		// generate an anchor, used by graph
		$quarterkey = $year * 10 + $quarter;
		if ( $quarterkey != $current_quarterkey ) {
			if ( $year != $current_year ) {
				$anchor = sprintf(' id="y%d"', $year);
				}
			else {
				$anchor = sprintf(' id="q%d"', $quarterkey);
				}
			$current_quarterkey = $quarterkey;
			$current_year = $year;
			}
		else {
			$anchor = '';
			}

		// translate tags
		// reuse already translated sequences of tags whenever possible
		if ( !isset($tags_translated_table[$sqlrow['tags']]) ) {
			$tags_to_translate = preg_split('/([-\\/a-zA-Z0-9]+\\{\\d+\\})/',$sqlrow['tags'], -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
			$tags_translated = '';
			foreach ( $tags_to_translate as $tag_to_translate ) {
				if ( isset($tags_translation_table[$tag_to_translate]) ) {
					$tags_translated .= $tags_translation_table[$tag_to_translate];
					}
				else {
					$tags_translated .= $tag_to_translate;
					}
				}
			$tags_translated_table[$sqlrow['tags']] = $tags_translated;
			}
		else {
			$tags_translated = htmlentities($tags_translated_table[$sqlrow['tags']]);
			}

		printf('<tr><td%s>%s<td>%s%s<td>%d',
			$anchor,
			date('Y, M j', $sqlrow['cable_time']),
			$subject,
			$tags_translated,
			$sqlrow['ucable_id']
			);
		}
	$table_html = ob_get_clean();
	}

function recursive_sum($a, $b) {
	return $a + (is_array($b) ? array_reduce($b, 'recursive_sum') : $b);
	}

function recursive_max($a, $b) {
	return max($a, (is_array($b) ? array_reduce($b, 'recursive_max') : $b));
	}

$num_cables = array_reduce($num_cables_per_quarter, 'recursive_sum');
$num_released_cables = array_reduce($num_released_cables_per_quarter, "recursive_sum");

if ( $num_cables ) {
?>
<p><a href="/search.php?q=<?php echo urlencode(sprintf('"%s"',htmlentities($origin))); ?>"><?php echo htmlentities($origin); ?></a>: <?php
printf('%d cable%s (%.1f%%) published out of %d',
	$num_released_cables,
	$num_released_cables > 1 ? 's' : '',
	$num_released_cables / $num_cables * 100,
	$num_cables
	);
?> cables.</p>
<table id="graph" cellpadding="0" cellspacing="0"><tr>
<?php
// Graph
$max_height = 150;
$xaxis_label_html = array();
$quarter_labels = array('','Jan-Mar','Apr-Jun','Jul-Sep','Oct-Dec');
$years = array_keys($num_cables_per_quarter);
$year_first = max(min($years)-2,1966);
$year_last = min(max($years)+2,2010);
$year_first_empty = 2011;
$year_last_empty = 1965;
$max_cables_per_quarter = array_reduce($num_cables_per_quarter, 'recursive_max');

function empty_bars($year_first_empty,$year_last_empty,&$xaxis_label_html) {
	$num_empty_years = $year_last_empty - $year_first_empty + 1;
	if ( $num_empty_years <= 0 ) { return; }
	if ( $num_empty_years > 3 ) {
		echo str_repeat('<td>',12);
		$xaxis_label_html[] = sprintf('<td colspan="4">%s<td colspan="4">...<td colspan="4">%s',substr((string)$year_first_empty,2),substr((string)$year_last_empty,2));
		return;
		}
	for ( $empty_year = $year_first_empty; $empty_year <= $year_last_empty; $empty_year++ ) {
		echo str_repeat('<td>',4);
		$xaxis_label_html[] = sprintf('<td colspan="4">%s',substr((string)$empty_year,2));
		}
	}

$current_year = 0;
for ( $year = $year_first; $year <= $year_last; $year++ ) {
	if ( !isset($num_cables_per_quarter[$year]) ) {
		$year_first_empty = min($year,$year_first_empty);
		$year_last_empty = max($year,$year_last_empty);
		continue;
		}
	if ( $year_first_empty <= $year_last_empty ) {
		empty_bars($year_first_empty,$year_last_empty,$xaxis_label_html);
		$year_first_empty = 2011;
		$year_last_empty = 1965;
		}
	for ( $quarter = 1; $quarter <= 4; $quarter++ ) {
		$quarterkey = $year * 10 + $quarter;
		$num_cables = isset($num_cables_per_quarter[$year][$quarter]) ? $num_cables_per_quarter[$year][$quarter] : 0;
		$num_released_cables = isset($num_released_cables_per_quarter[$year]) && isset($num_released_cables_per_quarter[$year][$quarter]) ? $num_released_cables_per_quarter[$year][$quarter] : 0;
		$bar_height = ceil($num_cables * $max_height / $max_cables_per_quarter);
		$released_bar_height = ceil($num_released_cables * $max_height / $max_cables_per_quarter);
		echo '<td>';
		if ($bar_height == 0) {
			continue;
			}
		if ( $year != $current_year ) {
			$anchor = "y{$year}";
			$current_year = $year;
			}
		else {
			$anchor = "q{$quarterkey}";
			}
		if ( $bar_height - $released_bar_height ) {
			printf('<a href="#%s" style="height:%dpx" title="%s %d: %d unpublished cable%s"></a>',
				$anchor,
				$bar_height - $released_bar_height,
				$quarter_labels[$quarter],
				$year,
				$num_cables,
				$num_cables > 1 ? 's' : ''
				);
			}
		if ( $released_bar_height ) {
			printf('<a class="r" href="#%s" style="height:%dpx" title="%s %d: %d published cable%s"></a>',
				$anchor,
				$released_bar_height,
				$quarter_labels[$quarter],
				$year,
				$num_released_cables,
				$num_released_cables > 1 ? 's' : ''
				);
			}
		}
	$xaxis_label_html[] = '<td colspan="4">';
	if (isset($num_cables_per_quarter[$year])) {
		$num_cables = array_sum($num_cables_per_quarter[$year]);
		$xaxis_label_html[] = sprintf('<a href="#y%d" title="%d: %d cable%s">%s</a>',
			$year,
			$year,
			$num_cables,
			$num_cables > 1 ? 's' : '',
			substr((string)$year,2)
			);
		}
	else {
		$xaxis_label_html[] = sprintf('%s',substr((string)$year,2));
		}
	}

empty_bars($year_first_empty,$year_last_empty,$xaxis_label_html);

// x-axis labels
echo '<tr>', implode('',$xaxis_label_html);
?>
</table>
<p>Filter(s): <input id="filter" type="text" size="40"> <span id="num-filtered-out"></span><br><span style="font-size:10px;color:gray">Only cables which contains all keywords will be displayed. You can also prefix keyword(s) with dash ('-') to instead filter out cables containing that/these keywords.</span></p>
<table id="cables" cellspacing="0" cellpadding="0">
<tr><th>Cable date<th>Cable (if any) / tags<th>Wikileaks id
<?php echo $table_html; ?>
</table>
<?php
	}
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
