<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

// parse tag ids stack
$stack_of_tags = array();
if ( isset($_REQUEST['tags']) && preg_match('/^\\d+(,\\d+)*$/',$_REQUEST['tags'],$matches) ) {
	$a = explode(',',$_REQUEST['tags']);
	foreach ( $a as $v ) {
		$stack_of_tags[] = (int)$v;
		}
	}
$cache_id = "browse_" . implode('-',$stack_of_tags);
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
$MAX_COUNT = 300;
$MAX_FONTSIZE = 48;
$MIN_FONTSIZE = 11;
$DEFAULT_FONTSIZE = 18;
$FONT_RANGE = $MAX_FONTSIZE - $MIN_FONTSIZE;
$TAGIDS_TO_IGNORE = array(
	11, /* External Political Relations */
	15  /* Internal Governmental Affairs */
	);
$STRINGIFIED_TAGIDS_TO_IGNORE = implode(',',$TAGIDS_TO_IGNORE);

$stringified_stack_of_tags = implode(',',$stack_of_tags);
$nTags = count($stack_of_tags);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
h3 {padding:4px;background-color:#eee;font-size:14px;line-height:200%;font-weight:normal}
h3 a {border-bottom:1px dotted #006}
div {margin:0;padding:0}
#main {padding:2px}
#intro {font-size:x-small;color:gray}
.topics {text-align:center;color:#ccc}
.topics div {margin:2px 10px;padding:2px;border:1px dotted #ccc;display:inline-block;overflow:hidden;vertical-align:middle}
.topics div a {color:inherit;white-space:nowrap}
.t0 {color:#888;background:#f6f6f6}
.t0:hover {color:#f6f6f6;background:#888}
.t1 {color:#900;background:#fff6f6}
.t1:hover {color:#fff6f6;background:#900}
.t2 {color:#070;background:#f6fff6}
.t2:hover {color:#f6fff6;background:#070}
.t3 {color:#00a;background:#f6f6ff}
.t3:hover {color:#f6f6ff;background:#00a}
.t4 {color:#068;background:#f0faff}
.t4:hover {color:#f0faff;background:#068}
.t5 {color:#860;background:#fffaf0}
.t5:hover {color:#fffaf0;background:#860}
.rmtag {border:0;color:#aaa}
.rmtag:hover {color:red}
</style>
<title>Cablegate's cables: Browse by tags</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, browse">
<meta name="description" content="Cablegate's cable: Browse by tags">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more-browser.js"></script>
<script type="text/javascript" src="cablegate-core.js"></script>
<?php
if ( !$nTags ) {
?>
<script type="text/javascript" src="rotater.js"></script>
<script type="text/javascript" src="tabs.js"></script>
<?php
	}
?>
</head>
<body>
<h1>Cablegate's cables: Browse by tags</h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="gorhill" data-text="Cablegate's cables #cablegate: Browse by tags" data-url="http://www.cablegatesearch.net/browse.php<?php
if ( count($stack_of_tags) > 0 ) {
	echo '?tags=', htmlentities(urlencode($_REQUEST['tags']));
	}
?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<div>
<p>Under construction. This page allows you to visually appreciate the number of cables for any given tags. Clicking on a particular tag allows you to &ldquo;drill-in&rdquo; and see the number of cables as a result of the intersection with the &ldquo;drilled-in&rdquo; tags.</p>
<?php

//
/*****************************************************************************/
// Drilled in

if ( $nTags > 0 ) {
	// create an sql query to intersect all sets of cables obtained from each tag from the tag stacks
	$subquery = "select cable_id from cablegate_tagassoc where tag_id={$stack_of_tags[0]}";
	for ( $iTag = 1; $iTag < $nTags; $iTag++ ) {
		$subquery = "select a.cable_id from (select cable_id from cablegate_tagassoc where tag_id={$stack_of_tags[$iTag]}) a inner join ({$subquery}) b on a.cable_id = b.cable_id";
		}
	$subquery = "select tag_id,count(cable_id) as num_cables from (select a.tag_id,a.cable_id from cablegate_tagassoc a inner join ({$subquery}) b on b.cable_id = a.cable_id) a where tag_id not in({$STRINGIFIED_TAGIDS_TO_IGNORE},{$stringified_stack_of_tags}) group by tag_id";

	// first determine min,max for proper scaling
	$sqlquery = "select max(a.num_cables) as `max_num_cables`,min(a.num_cables) as `min_num_cables` from ({$subquery}) a";
	//printf("<p>{$sqlquery}</p>");
	$sqlresult = mysql_query($sqlquery);
	$sqlrow = mysql_fetch_assoc($sqlresult);
	$max_num_cables = (int)$sqlrow['max_num_cables'];
	$min_num_cables = (int)$sqlrow['min_num_cables'];
	$range = $max_num_cables - $min_num_cables;

	// create title according to content of stack of tags
	$tag_details = array();
	$sqlquery = "
		select
			`id`,
			`tag`,
			`definition`
		from
			`cablegate_tags`
		where
			`id` in ({$stringified_stack_of_tags})
		";
	$sqlresult = mysql_query($sqlquery);
	echo mysql_error();
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$tag_details[$sqlrow['id']] = array($sqlrow['tag'], $sqlrow['definition']);
		}
	printf('<h3><a href="browse.php">Go to top</a>&ensp;|&ensp;');
	$query_terms = array();
	$query = '';
	$title_separator = '';
	foreach ( $stack_of_tags as $tag_id ) {
		list($tag, $definition) = $tag_details[$tag_id];
		$tag_rendered = empty($definition) ? $tag : "{$definition} ({$tag})";
		$query_terms[] = sprintf(
			"%%3D%s%s%s",
			htmlentities(urlencode(preg_replace('/\\s+/','-',$tag))),
			!empty($definition) ? '+%3D' : '',
			htmlentities(urlencode(preg_replace('/\\s+/','-',$definition)))
			);
		printf(
			'%s&ldquo;<a rel="nofollow" href="search.php?q=%s">%s</a>&rdquo;&thinsp;<a rel="nofollow" class="rmtag" href="browse.php?tags=%s" title="Remove this tag">&#x2717;</a>',
			$title_separator,
			implode('+', $query_terms),
			htmlentities($tag_rendered),
			htmlentities(urlencode(str_replace(',,',',',trim(str_replace($tag_id,'',$stringified_stack_of_tags),','))))
			);
		$title_separator = '&ensp;&amp;&ensp;';
		}
	//printf('&ensp;&asymp;&ensp;%d cable%s</h3><div class="topics">',$num_cables,$num_cables>1?'s':'');
	printf('</h3><div class="topics">');

	// compute number of cables per tags
	$sqlquery = "select t.`id`,t.`type`,t.`tag`,a.`num_cables`,if(char_length(t.`definition`)!=0,t.`definition`,t.`tag`) as `definition` from `cablegate_tags` t inner join ({$subquery}) a on a.`tag_id` = t.`id` order by `definition`";
	//printf("<p>{$sqlquery}</p>");
	$sqlresult = mysql_query($sqlquery);
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$num_cables = (int)$sqlrow['num_cables'];
		$definition = preg_replace('/;.*$/','',$sqlrow['definition']);
		$fontsize = $range > 0 ? (int)round(($num_cables - $min_num_cables) * $FONT_RANGE / $range + $MIN_FONTSIZE) : $DEFAULT_FONTSIZE;
		printf(
			'<div class="t%d"><a rel="nofollow" style="font-size:%dpx;line-height:%dpx" href="browse.php?tags=%s" title="&ldquo;%s&rdquo;: %d cable%s">%s</a></div>',
			$sqlrow['type'],
			$fontsize,
			$fontsize+4,
			htmlentities(urlencode("{$stringified_stack_of_tags},{$sqlrow['id']}")),
			htmlentities($sqlrow['tag']),
			$num_cables,
			$num_cables > 1 ? 's' : '',
			preg_replace('/ +/','&thinsp;',htmlentities($definition))
			);
		}
	echo '</div>';
	}

//
/*****************************************************************************/
// Top page

else {
	$TOPICS = array(
		'Countries' => 1,
		'Origins' => 5,
		'Subjects' => 2,
		'Programs' => 3,
		'Organizations' => 4
		);

	foreach ( $TOPICS as $topic => $type ) {
		printf('<h3>%s</h3>', htmlentities($topic));
		printf('<div class="topics">', htmlentities($topic));
		$sqlquery = "select max(num_cables) as `max_num_cables`,min(num_cables) as `min_num_cables` from `cablegate_tags` t inner join (select `tag_id`,count(`cable_id`) as `num_cables` from `cablegate_tagassoc` group by `tag_id`) ta on ta.tag_id = t.id where t.type={$type}";
		$sqlresult = mysql_query($sqlquery);
		echo mysql_error();
		$sqlrow = mysql_fetch_assoc($sqlresult);
		$max_num_cables = (int)$sqlrow['max_num_cables'];
		$min_num_cables = (int)$sqlrow['min_num_cables'];
		$range = $max_num_cables - $min_num_cables;

		$sqlquery = "select t.id,t.`type`,t.tag,ta.num_cables,if(char_length(t.definition)!=0,t.definition,t.tag) as `definition` from `cablegate_tags` t inner join (select `tag_id`,count(`cable_id`) as `num_cables` from `cablegate_tagassoc` group by `tag_id` order by `num_cables` desc) ta on ta.tag_id = t.id where t.type={$type} order by `definition`";
		$sqlresult = mysql_query($sqlquery);
		while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
			$num_cables = (int)$sqlrow['num_cables'];
			$definition = preg_replace('/;.*$/','',$sqlrow['definition']);
			$definition = preg_replace('/^(consulate|embassy) /i','',$definition);
			$fontsize = (int)round(($num_cables - $min_num_cables) * $FONT_RANGE / $range + $MIN_FONTSIZE);
			printf(
				'<div class="t%d"><a rel="nofollow" style="font-size:%dpx;line-height:%dpx" href="browse.php?tags=%d" title="&ldquo;%s&rdquo;: %d cable%s">%s</a></div>',
				$sqlrow['type'],
				$fontsize,
				$fontsize+4,
				(int)$sqlrow['id'],
				htmlentities($sqlrow['tag']),
				$num_cables,
				$num_cables > 1 ? 's' : '',
				preg_replace('/ +/','&thinsp;',htmlentities($definition))
				);
			}
		echo '</div>';
		}
	}

//
/*****************************************************************************/
//

?>
</div>
<?php include('contact-inc.html'); ?>
</div><!-- end main -->
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
?>
