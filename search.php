<?php
include_once("cacher.php");
include_once("cablegate-functions.php");

header_cache(120);

$raw_query = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
$canonical_query_name = get_canonical_query_name($raw_query);
$sort = isset($_REQUEST['sort']) && is_numeric($_REQUEST['sort']) ? max((int)min(floor((int)$_REQUEST['sort']),1),0) : 1;
$year_upper_limit = $sort ? 2099 : 2010;
$year_lower_limit = $sort ? 2010 : 1966;
$yt = isset($_REQUEST['yt']) && is_numeric($_REQUEST['yt']) ? max(min((int)floor((int)$_REQUEST['yt']),$year_upper_limit),$year_lower_limit) : $year_upper_limit;
$mt = isset($_REQUEST['mt']) && is_numeric($_REQUEST['mt']) ? max(min((int)floor((int)$_REQUEST['mt']),12),1) : 12;

$cache_id = sprintf('searchpage_%d_%d-%02d_%s', $sort, $yt, $mt, $canonical_query_name);
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
$prepdata = preprocess_query($raw_query);
$title = "Cablegate's cables: Full-text search";
if ( !empty($prepdata['normalized_query']) ) {
	$title .= " for &ldquo;{$prepdata['normalized_query']}&rdquo;";
	}
$qexpressions = stringify_expressions($prepdata['expressions'],'-',' ');

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
<?php include('cablegate-cart.css'); ?>
<?php include('cablegate-list.css'); ?>
#search-tips-toggle {margin:0.5em 0 0 0;display:inline-block;font-size:small;cursor:pointer}
#search-tips {margin:0;padding:0 0 0 2em;font-size:x-small}
#graph {margin-bottom:1em;border:1px solid #888;background-color:#f4f4f4;font-size:10px}
#graph tr:first-child td {margin:0;border:0;padding:0;width:5px;vertical-align:bottom}
#graph tr:first-child td:nth-child(4n+1) {border-left:1px solid #ddd}
#graph tr:first-child a {margin:0;border:0;border-left:1px solid #ddd;padding:0;display:block;width:4px;background-color:#ccc}
#graph tr:first-child a.in {border-left:1px solid #99f;background-color:#88f}
#graph tr:first-child + tr > td {border-top:1px solid #aaa;border-left:1px solid #ddd;color:#aaa}
#graph tr:first-child + tr > td a {color:#000}
#get-next-cables button {border:1px solid;border-collapse:collapse;border-color:#ddd #888 #888 #ddd}
</style>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="author" content="Raymond Hill">
<meta name="keywords" content="cablegate, wikileaks, full, text, search">
<meta name="description" content="A tool allowing you to perform full-text search and browse the leaked cables released by Wikileaks in the Cablegate event">
<?php include('mootools-core-1.3-loader.inc'); ?>
<!--[if lte IE 8]>
<style type="text/css">
#cable-list tr > th:first-child + th + th + th {padding:4px 0 0 0;font-size:smaller;text-align:right;width:5.5em;white-space:nowrap}
#cable-list tr > td:first-child + td + td + td {font-size:smaller;color:#888;text-align:right;white-space:nowrap}
</style>
<![endif]-->
<script type="text/javascript" src="mootools-more.js"></script>
<script type="text/javascript" src="cablegate-core.js"></script>
<script type="text/javascript" src="cablegate-cart.js"></script>
<script type="text/javascript" src="cablegate.js"></script>
</head>
<body>
<h1><?php echo $title; ?></h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-text="<?php echo $title, ' #cablegate'; ?>" data-url="http://t.co/OLECRvQ<?php if ( !empty($prepdata['urlencoded_query']) ) { echo "search.php?q={$prepdata['urlencoded_query']}"; } ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<div id="intro">This site is best viewed using a <a href="http://en.wikipedia.org/wiki/Acid3#Browsers_that_pass">modern, highly-compliant browser</a> <a href="http://acid3.acidtests.org/">(score >= 90)</a><noscript style="color:red">, with Javascript enabled</noscript>. <!--[if lte IE 8]> <span style="color:#c44">Internet Explorer 8 doesn't support all features, visual or otherwise, available on this page.</span> <![endif]-->Database content based on a snapshot of <a href="http://213.251.145.96/cablegate.html">Wikileaks' Cablegate</a> as of <span><?php echo $CABLEGATE_VERSION_DATE; ?></span> (<span class="since"><?php echo $CABLEGATE_VERSION_DATE; ?></span> ago). Other full-text search tools on the web: <a href="http://cablesearch.org/">CableSearch</a>, <a href="https://kabelsearch.org/">KABELS</a>, <a href="http://dazzlepod.com/cable/">dazzelpod</a>.</div>
<form id="form" method="get" action="search.php">
<div style="margin-top:1em">
<span style="margin:0 2em 0 0;display:inline-block;position:relative;vertical-align:top">Keyword(s)<br><input id="q" type="text" value="<?php echo htmlentities($raw_query); ?>" name="q" maxlength="100"><span id="qexpressions" style="display:none"><?php echo $qexpressions; ?></span><img id="clear-q" style="position:absolute;bottom:4px;right:4px;visibility:<?php echo empty($prepdata['normalized_query']) ? 'hidden' : 'visible'; ?>;z-index:1" src="edit-clear-2.png" width="16" height="16" alt="Reset" title="Reset query/results"></span><span style="margin:0 2em 0 0;display:inline-block;vertical-align:top">Sort by...<br><input type="radio" name="sort" value="0"<?php if (!$sort) { echo ' checked="checked"'; } ?>>Cable date<br><input type="radio" name="sort" value="1"<?php if ($sort) { echo ' checked="checked"'; } ?>>Leak date</span><span style="display:inline-block;vertical-align:top">&nbsp;<br><input type="submit" value="Retrieve" style="width:6em"></span>
</div>
</form>
<div id="search-tips-toggle">Search tips...</div><ul id="search-tips">
<li><b>&ldquo;secret&rdquo;</b> will return cables which contain the words <b>&ldquo;secret&rdquo;</b>, <b>&ldquo;secrets&rdquo;</b>, <b>&ldquo;secretary&rdquo;</b>, etc. (starting with)
<li>Equal (&lsquo;=&rsquo;) prefix: <b>&ldquo;=secret&rdquo;</b> will return cables which contain the word <b>&ldquo;secret&rdquo;</b>, but NOT <b>&ldquo;secrets&rdquo;</b>, <b>&ldquo;secretary&rdquo;</b>, etc. (exact match, per term-based)
<li>Dash (&lsquo;-&rsquo;) separator: <b>&ldquo;state-secret&rdquo;</b> will return ONLY cables which contain exactly <b>&ldquo;state&rdquo;</b>, IMMEDIATELY followed by <b>&ldquo;secret&rdquo;</b> (exact sequence of words).
<li>When searching for more than one word, only cables matching (as per above) <b>all</b> the words are returned.
<li>Example: searching for <a style="font-weight:bold" href="search.php?q=state+secret">&ldquo;state secret&rdquo;</a> returns 1153 cables, <a style="font-weight:bold" href="search.php?q=state+%3dsecret">&ldquo;state =secret&rdquo;</a> returns 674 cables, <a style="font-weight:bold" href="search.php?q=%3dstate+%3dsecret">&ldquo;=state =secret&rdquo;</a> returns 543 cables, <a style="font-weight:bold" href="search.php?q=state-secret">&ldquo;state-secret&rdquo;</a> returns 2 cables (as of Dec. 28, 2010).
<li>Leading zeros in numbers are disregarded, i.e., when searching for <b>&ldquo;51&rdquo;</b>, cables with <b>&ldquo;51&rdquo;</b>, but also <b>&ldquo;051&rdquo;</b>, <b>&ldquo;00000051&rdquo;</b>, etc. will be returned.
</ul>
<div style="margin:1em 0 1em 0;border-top:1px solid #aaa;height:1px"></div>
<?php
// query for list
$column_names_lookup_by_sort = array('cable','release');

$query = sprintf("
	SELECT SQL_CALC_FOUND_ROWS
		c.`id`,
		c.`canonical_id`,
		c.`cable_time`,
		c.`release_time`,
		(c.`status` & 0x01) AS `removed`,
		(c.`status` & 0x02) AS `new_or_updated`,
		cl.`classification`,
		o.`origin`,
		c.`subject`
	FROM `cablegate_classifications` cl
		INNER JOIN (`cablegate_origins` o
		INNER JOIN %s
		ON o.`id` = c.`origin_id`)
		ON cl.`id` = c.`classification_id`
	",
	$prepdata['subquery']
	);

if ( !$sort ) {
	$query .= sprintf("
		WHERE
			c.`%s_time` < UNIX_TIMESTAMP(DATE_ADD('%d-%02d-01',INTERVAL 1 MONTH))
		",
		$column_names_lookup_by_sort[$sort],
		$yt,
		$mt
		);
	}

$query .= sprintf("
	ORDER BY
		c.`%s_time` DESC,
		c.`%s_time` DESC
	LIMIT 100
	",
	$column_names_lookup_by_sort[$sort],
	$column_names_lookup_by_sort[$sort ^ 1]
	);
// printf("<p>%s</p>", $query);
// EXPLAIN SELECT SQL_CALC_FOUND_ROWS c.`id`, c.`canonical_id`, c.`cable_time`, c.`release_time`, (c.`status` & 0x01) AS `removed`, (c.`status` & 0x02) AS `new_or_updated`, cl.`classification`, o.`origin`, c.`subject` FROM `cablegate_classifications` cl INNER JOIN (`cablegate_origins` o INNER JOIN (`cablegate_cables` c INNER JOIN (SELECT `cable_id` FROM (SELECT a.`cable_id` FROM (SELECT DISTINCT `cable_id` FROM `cablegate_termassoc` ta INNER JOIN `cablegate_terms` t ON t.id = ta.term_id WHERE t.`term` LIKE 'oil%') a INNER JOIN (SELECT DISTINCT `cable_id` FROM `cablegate_termassoc` ta INNER JOIN `cablegate_terms` t ON t.id = ta.term_id WHERE t.`term` LIKE 'bush%') b ON a.`cable_id` = b.`cable_id`) a) t ON t.cable_id = c.`id`) ON o.`id` = c.`origin_id`) ON cl.`id` = c.`classification_id` ORDER BY c.`release_time` DESC, c.`cable_time` DESC LIMIT 100 
$result = mysql_query($query);
if (!$result) { exit(mysql_error()); }
$num_cables = mysql_num_rows($result);
$num_cables_no_limit = (int)mysql_result(mysql_query("SELECT FOUND_ROWS()"),0);
?>
<p><span style="font-size:larger"><?php
printf('<b>%d cable%s found.</b>',$num_cables_no_limit,$num_cables_no_limit > 1 ? 's' : '');
?></span>&nbsp;&nbsp;Show <select id="classification-filters" style="font:inherit"><option value="7" selected="selected">All<option value="4" class="cls">Secret<option value="6" class="clcs">Secret&thinsp;+&thinsp;confidential<option value="2" class="clc">Confidential<option value="3" class="cluc">Confidential&thinsp;+&thinsp;unclassified<option value="1" class="clu">Unclassified</select></p>
<?php if ( !$sort && $prepdata['by_cable_date']['quarter_max'] > 0 ) { ?>
<p><table id="graph" cellpadding="0" cellspacing="0"><tr>
<?php
// graph
$max_height = 100;
$xaxis_label_html = '';
$quarter_labels = array('','Jan-Mar','Apr-Jun','Jul-Sep','Oct-Dec');
$quarter_from = (int)sprintf('%d%02d',$yt,floor(($mt-1)/3)+1);
$year_first = max($prepdata['by_cable_date']['year_first']-2,1966);
$year_last = min($prepdata['by_cable_date']['year_last']+2,2010);
$year_first_empty = 2011;
$year_last_empty = 1965;
$urlencoded_sort = ($sort == 1 ? '' : '&amp;sort=0');

function empty_bars($year_first_empty,$year_last_empty,&$xaxis_label_html) {
	$num_empty_years = $year_last_empty - $year_first_empty + 1;
	if ( $num_empty_years <= 0 ) { return; }

	if ( $num_empty_years > 3 ) {
		echo str_repeat('<td>',12);
		$xaxis_label_html .= sprintf('<td colspan="4">%s<td colspan="4">...<td colspan="4">%s',substr((string)$year_first_empty,2),substr((string)$year_last_empty,2));
		return;
		}

	for ( $empty_year = $year_first_empty; $empty_year <= $year_last_empty; $empty_year++ ) {
		echo str_repeat('<td>',4);
		$xaxis_label_html .= sprintf('<td colspan="4">%s',substr((string)$empty_year,2));
		}
	}

for ( $year = $year_first; $year <= $year_last; $year++ ) {
	if ( !isset($prepdata['by_cable_date']['years'][(string)$year]) ) {
		$year_first_empty = min($year,$year_first_empty);
		$year_last_empty = max($year,$year_last_empty);
		continue;
		}
	if ( $year_first_empty <= $year_last_empty ) {
		empty_bars($year_first_empty,$year_last_empty,$xaxis_label_html);
		$year_first_empty = 2011;
		$year_last_empty = 1965;
		}
	for ( $iQuarter = 1; $iQuarter <= 4; $iQuarter++ ) {
		$quartertag = sprintf('%d%02d', $year, $iQuarter);
		$num_entries_per_quarter = isset($prepdata['by_cable_date']['quarters'][$quartertag]) ? $prepdata['by_cable_date']['quarters'][$quartertag] : 0;
		$bar_height = ceil($num_entries_per_quarter * $max_height / $prepdata['by_cable_date']['quarter_max']);
		echo '<td>';
		if ($bar_height == 0) {
			continue;
			}
		$quarter = (int)$quartertag;
		printf('<a href="search.php?q=%s&amp;yt=%d&amp;mt=%d%s" style="height:%dpx" title="%s %d: %d entr%s" rel="nofollow"%s></a>',
			$prepdata['urlencoded_query'],
			$year,
			($iQuarter-1)*3+3,
			$urlencoded_sort,
			$bar_height,
			$quarter_labels[$iQuarter],
			$year,
			$num_entries_per_quarter,
			$num_entries_per_quarter > 1 ? 'ies' : 'y',
			$quarter <= $quarter_from ? ' class="in"' : ''
			);
		}
	$xaxis_label_html .= '<td colspan="4">';
	if (isset($prepdata['by_cable_date']['years'][(string)$year])) {
		$num_entries_per_year = $prepdata['by_cable_date']['years'][(string)$year];
		$xaxis_label_html .= sprintf('<a href="search.php?q=%s&amp;yt=%d&amp;mt=12%s" title="%d: %d entr%s" rel="nofollow">%s</a>',
			$prepdata['urlencoded_query'],
			$year,
			$urlencoded_sort,
			$year,
			$num_entries_per_year,
			$num_entries_per_year > 1 ? 'ies' : 'y',
			substr((string)$year,2));
		}
	else {
		$xaxis_label_html .= sprintf('%s',substr((string)$year,2));
		}
	}

empty_bars($year_first_empty,$year_last_empty,$xaxis_label_html);

// x-axis labels
echo '<tr>', $xaxis_label_html;
?>
</table>
<?php } ?>
<table id="cable-list" cellspacing="0" cellpadding="0">
<tr><th><th>Cable date<th><a class="cartTogglerInfo" href="/cart.php"></a>Subject &mdash; Origin<th>Leak &lsquo;age&rsquo;
<?php
include_once('cablegate-functions.php');
echo cables2rows($result);

$num_cables_left = $num_cables_no_limit - $num_cables;
if ($num_cables_left) {
	$num_cables_next = min($num_cables_left,100);
?>
<tr id="get-next-cables">
<td><td><td colspan="2" style="padding:8px"><span id="get-next-cables-num_after"><?php echo $num_cables_left; ?></span> more cables not shown: Get next
<button id="get-next-cables-button" type="button"><?php echo $num_cables_next; ?></button>
<?php if ( $num_cables_left > 100 ) { ?>
<button id="get-next500-cables-button" type="button"><?php echo min(500,$num_cables_left); ?></button>
<?php } ?>
cables
<?php } ?>
</table>
<?php if ($num_cables_left > 0) { ?>
<script type="text/javascript">
<!--
var CablegateGetNextInfo={
	'command':'get_cable_entries',
	'raw_query':'<?php echo $raw_query; ?>',
	'sort':<?php echo $sort; ?>,
	'yt':<?php echo $yt; ?>,
	'mt':<?php echo $mt; ?>,
	'offset':100,
	'limit':<?php echo $num_cables_next; ?>,
	'num_total':<?php echo $prepdata['by_cable_date']['total']; ?>,
	'num_before':<?php echo $prepdata['by_cable_date']['total']-$num_cables_no_limit; ?>,
	'num_after':<?php echo $num_cables_left; ?>
	};
// -->
</script>
<?php } ?>
</div>
<?php include('contact-inc.html'); ?>
<p id="cart-tips">Marking a cable with <img style="vertical-align:bottom" width="16" height="16" src="bookmark.png" alt="In cart"> will place this cable in your <span style="font-weight:bold">private cart</span>. When viewing your <span style="font-weight:bold">private cart</span>, you can obtain a persistent snapshot of its content, for future reference or to share with others.</p>
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
?>
