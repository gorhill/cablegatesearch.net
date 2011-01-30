<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

// parse id
$id = 0;
if ( isset($_REQUEST['id']) ) {
	if ( ctype_digit($_REQUEST['id']) ) {
		$id = (int)$_REQUEST['id'];
		}
	else if ( preg_match('/^\\w+$/',$_REQUEST['id']) ) {
		$id = strtoupper($_REQUEST['id']);
		}
	}
$cache_id = "cable_{$id}";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
if ( $cable_data = get_cable_content($id) ) {
	$canonical_id = $cable_data['canonicalId'];
	$title = sprintf("Cable reference id: %s", htmlentities($canonical_id));
	$description = htmlentities($cable_data['subject']);
	}
else {
	$title = 'Cable not found';
	$description = '';
	$canonical_id = '';
	}

$hideHeader = isset($_COOKIE['cablegateHideHeaders']) && $_COOKIE['cablegateHideHeaders'] == 'true';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate-cart.css'); ?>
<?php include('cablegate.css'); ?>
body {background:white url('background1.png') repeat}
#cable-summary {width:100%}
#cable-summary td {padding:2px 0;vertical-align:top}
#cable-summary td:first-child {padding-right:1em;width:8em;white-space:nowrap}
#cable-summary tr > td:first-child {font-weight:bold}
#cable-summary tr:nth-of-type(8) > td:nth-of-type(2) {font-size:smaller}
#cable {margin:0;padding:0;max-width:60em}
#cable > div:first-child {border:1px solid #e8e8e8;border-bottom:none;padding:0.5em;font-size:12px;background-color:#e8e8e8}
#cable > div:first-child + div {border:1px solid #e8e8e8;border-top:none}
#cable > div:first-child + div {white-space:pre-line;font-family:'Consolas',monospace}
#cable > div:first-child + div > div {padding:0.5em}
#cable > div:first-child + div > div:first-child {border-bottom:1px dotted #9ab;padding-bottom:1em;font-size:10.5px}
#cable > div:first-child + div > div:first-child + div {padding-top:1em;position:relative}
#cable-body {background:white}
.cl-s {color:red}
.cl-c {color:#e47800}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<script src="mootools-more.js" type="text/javascript"></script>
<script src="cablegate-core.js" type="text/javascript"></script>
<script src="cablegate-cart.js" type="text/javascript"></script>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, browse">
<meta name="description" content="<?php echo $title, ': ', $description; ?>">
</head>
<body>
<h1><?php echo $title ?></h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-text="<?php echo $title; ?>" data-url="http://www.cablegatesearch.net/cable.php?id=<?php echo htmlentities(urlencode($canonical_id)); ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<?php if ( !empty($canonical_id) ) { ?>
<div id="cable"><!-- cable -->
<div id="cableid-<?php echo $cable_data['id']; ?>"><!-- cable summary -->
<table id="cable-summary" cellspacing="0" cellpadding="0">
<tr><td>Subject<td style="font-variant:small-caps;font-size:16px"><div class="cartToggler"></div><?php echo htmlentities($cable_data['subject']); ?>
<tr><td>Origin<td><?php echo $cable_data['origin']; ?>
<tr><td>Cable time<td><?php echo $cable_data['cableTime']; ?>
<tr><td>Classification<td<?php
echo stripos($cable_data['classification'],'secret') !== false ? ' class="cl-s"' : (stripos($cable_data['classification'],'confidential') !== false ? ' class="cl-c"' : '');
?>><?php echo htmlentities($cable_data['classification']); ?>
<tr><td>Reference id<td><?php echo htmlentities($canonical_id); ?>
<tr><td>Source<td><?php echo $cable_data['wikileakURL']; ?>
<tr><td>Release time<td><?php echo $cable_data['releaseTime']; ?>
<?php
$history = array();
$sqlquery = "
	SELECT
		cr.`release_time` AS `change_time`,
		`change`
	FROM
		`cablegate_releases` cr
		INNER JOIN
		`cablegate_changes` cc
		ON cr.`release_id` = cc.`release_id`
	WHERE
		`cable_id`={$cable_data['id']}
	ORDER BY
		`change_time` ASC
	";
if ( $sqlresult = mysql_query($sqlquery) ) {
	$changed_at_least_once = 0;
	$history_details = array(
		array('color'=>'#000', 'prompts'=>array('','')),
		array('color'=>'darkgreen', 'prompts'=>array('First added','Added again')),
		array('color'=>'blue', 'prompts'=>array('Modified','Modified')),
		array('color'=>'maroon', 'prompts'=>array('Removed','Removed')),
		);
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$change = (int)$sqlrow['change'];
		assert($change < count($history_details)-1);
		$history[] = sprintf(
			'<span style="color:%s">%s on %s UTC</span>',
			$history_details[$change]['color'],
			$history_details[$change]['prompts'][$changed_at_least_once],
			date('D, j M Y H:i',$sqlrow['change_time'])
			);
		$changed_at_least_once = 1;
		}
	}
?>
<tr><td>History<td><?php echo implode('<br>', $history); ?>
</table>
</div><!-- end cable summary -->
<div><!-- cable content --><div id="cable-header"<?php if ($hideHeader) {echo ' style="display:none"';} ?>><!-- header --><?php
echo $cable_data['header'];
?></div><!-- end header --><div id="cable-body"><!-- body --><span class="toggleHeader"><?php echo $hideHeader ? 'Show' : 'Hide'; ?> header</span><?php
echo $cable_data['content'];
?></div><!-- end body --></div><!-- end cable content -->
</div><!-- end cable -->
<?php } ?>
</div><!-- end main -->
<script type="text/javascript">
<!-- 
(function(){
	$$('.toggleHeader').each(function(e){
		e.addEvent('click',function(ev){
			var container=this.getParent('#cable > div:first-child + div');
			var header=container.getElement('div:first-child');
			var hideHeader=header.getStyle('display')!=='none';
			if (hideHeader){
				header.setStyle('display','none');
				this.set('text','Show header');
				}
			else {
				header.setStyle('display','');
				this.set('text','Hide header');
				}
			Cookie.write('cablegateHideHeaders',hideHeader,{duration:365});
			});
		});
	var q=window.location.href.match(/q=([^&]+)/);
	if (!q || q.length < 2) {return;}
	var expressions=decodeURIComponent(q[1]).split(' ');

	// Author: Raymond Hill
	// Version: 2011-01-17
	// Title: HTML text hilighter
	// Permalink: http://www.raymondhill.net/blog/?p=272
	// Purpose: Hilight portions of text inside a specified element, according to a search expression.
	// Key feature: Can safely hilight text across HTML tags.
	// Notes: Minified using YUI Compressor (http://refresh-sf.com/yui/),
	var doHighlight=function(A,c,z,s){var G=document;if(typeof A==="string"){A=G.getElementById(A)}if(typeof z==="string"){z=new RegExp(z,"ig")}s=s||0;var j=[],u=[],B=0,o=A.childNodes.length,v,w=0,l=[],k,d,h;for(;;){while(B<o){k=A.childNodes[B++];if(k.nodeType===3){j.push({i:w,n:k});v=k.nodeValue;u.push(v);w+=v.length}else{if(k.nodeType===1){if(k.tagName.search(/^(script|style)$/i)>=0){continue}if(k.tagName.search(/^(a|b|basefont|bdo|big|em|font|i|s|small|span|strike|strong|su[bp]|tt|u)$/i)<0){u.push(" ");w++}d=k.childNodes.length;if(d){l.push({n:A,l:o,i:B});A=k;o=d;B=0}}}}if(!l.length){break}h=l.pop();A=h.n;o=h.l;B=h.i}if(!j.length){return}u=u.join("");j.push({i:u.length});var p,r,E,y,D,g,F,f,b,m,e,a,t,q,C,n,x;for(;;){r=z.exec(u);if(!r||r.length<=s||!r[s].length){break}E=r.index;for(p=1;p<s;p++){E+=r[p].length}y=E+r[s].length;g=0;F=j.length;while(g<F){D=g+F>>1;if(E<j[D].i){F=D}else{if(E>=j[D+1].i){g=D+1}else{g=F=D}}}f=g;while(f<j.length){b=j[f];A=b.n;v=A.nodeValue;m=A.parentNode;e=A.nextSibling;t=E-b.i;q=Math.min(y,j[f+1].i)-b.i;C=null;if(t>0){C=v.substring(0,t)}n=v.substring(t,q);x=null;if(q<v.length){x=v.substr(q)}if(C){A.nodeValue=C}else{m.removeChild(A)}a=G.createElement("span");a.appendChild(G.createTextNode(n));a.className=c;m.insertBefore(a,e);if(x){a=G.createTextNode(x);m.insertBefore(a,e);j[f]={n:a,i:y}}f++;if(y<=j[f].i){break}}}};

	var nExpressions=expressions.length;
	if (!nExpressions){return;}
	var iExpression, expression;
	for (iExpression=0; iExpression<nExpressions; iExpression++) {
		expression=expressions[iExpression];
		// Dec. 28, 2010: numbers match regardless of leading zeros
		expression=expression.replace(/(^|-)(=?)(\d+)(-|$)/g,'$1$20*$3$4');
		// multi-terms expression
		if (expression.search('-')>0){ // multiple terms
			expression=expression.replace(/-/g,'\\W+');
			}
		if (expression.search('=')===0){ // exact expression
			expression='(\\b)('+expression.substr(1)+')(\\b)';
			}
		else { // starting with
			expression='(\\b)('+expression+')';
			}
		doHighlight('cable','hilite',new RegExp(expression,'ig'),2);
		}
})();
// -->
</script>
<p id="cart-tips">Marking a cable with <img style="vertical-align:bottom" width="16" height="16" src="bookmark.png" alt="In cart"> will place this cable in your <span style="font-weight:bold">private cart</span>. When viewing your <span style="font-weight:bold">private cart</span>, you can obtain a persistent snapshot of its content, for future reference or to share with others.</p>
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
?>
