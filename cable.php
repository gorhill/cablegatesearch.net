<?php
include_once('cacher.php');
include_once("cablegate-functions.php");

header_cache(120);

// parse id
$id = 0;
if ( isset($_REQUEST['id']) ) {
	if ( ctype_digit($_REQUEST['id']) ) {
		$id = intval($_REQUEST['id']);
		}
	else if ( preg_match('/^\\w+$/',$_REQUEST['id']) ) {
		$id = strtoupper($_REQUEST['id']);
		}
	}
// parse version, 0 = latest
$cable_version = 0;
if ( isset($_REQUEST['version']) && ctype_digit($_REQUEST['version']) ) {
	$cable_version = intval($_REQUEST['version']);
	}
$cache_id = "cable_{$id}";
if ( $cable_version ) {
	$cache_id .= "_{$cable_version}";
	}
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
if ( $cable_data = get_cable_content($id, $cable_version) ) {
	$cable_id = $cable_data['id'];
	$canonical_id = $cable_data['canonicalId'];
	$title = sprintf("Cable reference id: #%s", htmlentities($canonical_id));
	$description = htmlentities($cable_data['subject']);
	}
else {
	$cable_id = 0;
	$canonical_id = '';
	$title = 'Cable not found';
	$description = '';
	}
$is_root_contributor = isset($_COOKIE['cablegateContributorKey']) && sha1($_COOKIE['cablegateContributorKey']) === '9c55688f1750d5296181903649fbcaae3eb530ee';
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
#cable-summary tr:first-child > td:first-child {vertical-align:middle}
#cable-summary tr:nth-of-type(2) > td:first-child + td {font-variant:small-caps;font-size:larger;line-height:120%}
#cable-summary tr:nth-of-type(7) > td:nth-of-type(2) a:first-child ~ a {margin-left:1em;font-size:smaller}
.infotip {width:16em}
#canonical_id-suggestions {padding:3px;position:absolute;min-width:16em;max-width:80%;color:gray;background:#DFDDF0;box-shadow:2px 2px 5px #888;-moz-box-shadow:2px 2px 5px #888;-webkit-box-shadow:2px 2px 5px #888;z-index:2}
#canonical_id-suggestions > div {padding:1px;color:black;cursor:pointer;white-space:nowrap;overflow:hidden}
#canonical_id-suggestions > div:hover {background:#FFFAE8}
#canonical_id-suggestions > div > span:first-child {display:inline-block;min-width:12em}
#canonical_id-suggestions > div > span:nth-of-type(2) {display:inline-block;font-weight:normal;font-variant:small-caps}
#canonical_id-suggestions > div > span:nth-of-type(2).not-published {font-variant:normal;font-style:normal;color:gray}
#media-items {margin:0 0 4px 0;max-height:10em;overflow:auto}
#media-items div.media-item {margin:0 0 0 1em;padding:0;border:0;text-indent:-1em}
#media-items div.media-item > a:before {content:"\2023\0020"}
#media-items div.media-item > img {vertical-align:bottom;cursor:pointer;opacity:0.25}
#media-items div.media-item > img:hover {vertical-align:bottom;cursor:pointer;opacity:1}
#add-media-item-button {opacity:0.25}
#add-media-item-button:hover {opacity:1}
#cable {margin:0;padding:0;max-width:720px;display:inline-block}
#cable > div:first-child {border:1px solid #e8e8e8;border-bottom:none;padding:0.5em;font-size:12px;background-color:#e8e8e8}
#cable > div:first-child + div {border:1px solid #e8e8e8;border-top:none}
#cable > div:first-child + div {white-space:pre-line;font-family:'Consolas',monospace}
#cable > div:first-child + div > div {padding:0.5em}
#cable > div:first-child + div > div:first-child {border-bottom:1px dotted #9ab;padding-bottom:1em;font-size:10.5px}
#cable > div:first-child + div > div:first-child + div {padding-top:1em;position:relative}
.cable-body {background:white}
del {color:#a00;background:#fdd;text-decoration:none}
ins {color:#080;background:#dfd;text-decoration:none}
.cl-s {color:red}
.cl-c {color:#e47800}
#disqus_section {margin:0 0 4em 0;padding:0;max-width:720px;opacity:0.25}
#disqus_section #disqus_thread {margin:0;padding:0}
@media only screen and (min-width:740px) and (max-width:1149px) {
	#cable {min-width:720px}
	#disqus_section {margin-top:1em}
	}
@media only screen and (min-width:1150px) {
	#cable {display:inline-block;min-width:720px}
	#disqus_section {display:inline-block;width:420px;vertical-align:top}
	#disqus_section #dsq-content #dsq-global-toolbar {margin:0}
	#disqus_goto_comments {display:none}
	}
#disqus_section:hover {opacity:1}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<script src="mootools-more.js" type="text/javascript"></script>
<script src="cablegate-cart.js" type="text/javascript"></script>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, browse">
<meta name="description" content="<?php echo $title, ': ', $description; ?>">
<?php
$canonical_url = 'http://www.cablegatesearch.net/cable.php?id=' . htmlentities(urlencode($canonical_id));
if ( $cable_version ) {
	$canonical_url .= '&amp;version=' . $cable_version;
	}
?><link rel="canonical" href="<?php echo $canonical_url; ?>">
</head>
<body>
<h1><?php echo $title ?></h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><g:plusone size="medium"></g:plusone><script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-text="<?php echo '#wlfind #', htmlentities($canonical_id); ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<?php if ( !empty($canonical_id) ) { ?>
<div id="cable"><!-- cable -->
<div id="cableid-<?php echo $cable_id; ?>"><!-- cable summary -->
<table id="cable-summary" cellspacing="0" cellpadding="0">
<tr><td>Reference id<td><input id="canonical_id-input" type="text" value="<?php echo htmlentities($canonical_id); ?>" readonly="readonly" style="font-size:inherit"> <span style="color:gray;font-size:smaller">aka Wikileaks id #<?php echo $cable_data['wikileaks_id']; ?></span> <span id="refid-tip" style="cursor:default;" title="You can enter the formal reference id (ex.: &lsquo;10ROME87&rsquo;), or the cable number as sometimes used by Wikileaks and media partners (ex.: &lsquo;244972&rsquo;).">&ensp;?&ensp;</span>
<div class="cartToggler"></div><div id="canonical_id-suggestions" style="display:none">...</div>
<tr><td>Subject<td><?php echo htmlentities($cable_data['subject']); ?>
<tr><td>Origin<td><a href="/search.php?q=<?php echo urlencode(preg_replace('/\\s+/', '-', $cable_data['origin'])); ?>"><?php echo $cable_data['origin']; ?></a> <span style="color:gray">(<?php echo $cable_data['country']; ?>)</span>
<tr><td>Cable time<td><?php echo $cable_data['cableTime']; ?>
<tr><td>Classification<td<?php
echo stripos($cable_data['classification'],'secret') !== false ? ' class="cl-s"' : (stripos($cable_data['classification'],'confidential') !== false ? ' class="cl-c"' : '');
?>><?php echo htmlentities($cable_data['classification']); ?>
<tr><td>Source<td><?php echo $cable_data['wikileakURL']; ?>
<!-- <tr><td>Release time<td><?php echo $cable_data['releaseTime']; ?> -->
<?php
$history = array();
$sqlquery = "
	SELECT
		cr.`release_time` AS `change_time`,
		cc.`change`
	FROM
		`cablegate_releases` cr
		INNER JOIN
		`cablegate_changes` cc
		ON cr.`release_id` = cc.`release_id`
	WHERE
		`cable_id`={$cable_id}
	ORDER BY
		`change_time` ASC
	";
if ( $sqlresult = db_query($sqlquery) ) {
	$history_details = array(
		array('color'=>'#000', 'prompt'=>''),
		array('color'=>'darkgreen', 'prompt'=>'First published'),
		array('color'=>'blue', 'prompt'=>'Modified'),
		array('color'=>'maroon', 'prompt'=>'Removed'),
		array('color'=>'gray', 'prompt'=>'Re-added without modification'),
		);
	$num_changes = mysql_num_rows($sqlresult);
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$change = (int)$sqlrow['change'];
		$change_time = (int)$sqlrow['change_time'];
		assert($change < count($history_details));
		$text = sprintf(
			'%s on %s UTC',
			$history_details[$change]['prompt'],
			date('D, j M Y H:i',$change_time)
			);
		if ( $num_changes > 1 ) {
			$history[] = sprintf(
				'<a style="color:%s;%s" href="cable.php?id=%s%s" rel="nofollow">%s</a>',
				$history_details[$change]['color'],
				$cable_version === $change_time ? 'font-weight:bold' : '',
				$canonical_id,
				($cable_version === $change_time) ? '' : "&amp;version={$change_time}",
				$text
				);
			}
		else {
			$history[] = $text;
			}
		}
	}
?>
<tr><td>History<td><?php echo implode('<br>', $history); ?>
<tr><td>Media&emsp;<img id="add-media-item-button" src="list-add-4.png" alt="Add media item" title="Add media item" style="vertical-align:top;cursor:pointer" width="14" height="14"><td><div id="media-items"><?php
// Find media items for this cable
$sqlquery =
	  "SELECT "
	.   "u.`url_id`,"
	.   "UNCOMPRESS(u.`title`) as `title`,"
	.   "u.`url` "
	. "FROM "
	.   "`cablegate_urls` u "
	.     "INNER JOIN "
	.     "`cablegate_urlassoc` ua "
	.     "ON ua.`url_id` = u.`url_id` "
	. "WHERE "
	.   "ua.`cable_id`={$cable_id} AND (ua.`flags` & 0x01) = 0 "
	. "GROUP BY "
	.   "u.`url_id`"
	;
if ( $sqlresult = db_query($sqlquery) ) {
	$urls = array();
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		$urls[] = $sqlrow;
		}
	if ( count($urls) ) {
		foreach ( $urls as $url_details ) {
			$title = empty($url_details['title'])
				? mb_convert_encoding(urldecode($url_details['url']), 'HTML-ENTITIES', 'Windows-1252')
				: $url_details['title']
				;
			printf(
				  '<div id="media-item-%s" class="media-item">'
				. '<a href="%s">%s</a>'
				. '<img src="edit-delete-5.png" alt="Remove media item" title="Remove media item" width="14" height="14" style="display:none">'
				. '</div>'
				,
				$url_details['url_id'],
				$url_details['url'],
				$title
				);
			}
		}
	}
?></div>
<div id="add-media-item-dialog" style="border:1px solid #eec;padding:0.5em;display:none;position:absolute;min-width:30em;max-width:50%;background:#ffe;z-index:1;-moz-box-shadow:3px 3px 3px #888;box-shadow:3px 3px 3px #888">
	<span style="color:gray">(Experimental)</span> <label>URL to a media item <i>expressly quoting and/or mentioning</i> the present cable (mere mirror of a cable is not considered a useful &lsquo;media item&rsquo;): </label><br><input id="add-media-item-dialog-url" type="text" maxlength="255" style="margin:0.25em 0 0 0;width:95%"><br>
	<div id="add-media-item-dialog-message" style="margin:0.5em 0 0 1em;font-size:smaller"></div><br>
	<button id="add-media-item-dialog-cancel">Close</button> <button id="add-media-item-dialog-ok">Add</button>
	<div style="margin-top:2em;font-size:smaller"><label>Contributor key (optional): </label><input id="add-media-item-dialog-contributor-key" type="text" size="32" maxlength="32" style="font-size:inherit">	<div style="color:gray">If no contributor key is supplied, submitted URLs will have to be vouched by the webmaster before appearing in the list. If an invalid contributor key is supplied, the submitted URL will be ignored. If a valid contributor key is supplied, the submitted URL will be immediately associated with the cable and visible to other visitors.<br>To obtain a valid contributor key, <a href="mailto:rhill@cablegatesearch.net?subject=cablegatesearch.net:%20Re.%20contributor key">email me</a>. (I welcome media representatives, authors, writers, etc.)</div></div>
	</div>
<tr id="disqus_goto_comments"><td>Comments<td><a href="#disqus_thread" data-disqus-identifier="<?php echo $canonical_id; ?>">? Comments</a>
</table>
</div><!-- end cable summary -->
<div class="cable-content"><!-- cable content --><div id="cable-header"><!-- header --><?php
echo $cable_data['header'];
?></div><!-- end header --><div class="cable-body"><!-- body --><span class="toggleHeader">Hide header</span><?php
echo $cable_data['content'];
?></div><!-- end body --></div><!-- end cable content -->
</div><!-- end cable -->
<div id="disqus_section">
	<p style="margin:0 0 1em 0;font-size:smaller;color:#a66">User-supplied content reflect the views of their respective authors, and not necessarily the view of the owner and moderator(s) of this web site. Posts with embedded links will have to be approved by a moderator. Only links to external web pages which <i>appear</i> to contribute complementary information to specifics in the cable will be allowed. Links to external web pages should not be construed as a statement of support of the external web sites by the owner and/or moderator(s) of cablegatesearch.net.</p>
	<a id="disqus_show_comments" style="margin:1em 0 2em 0;border:1px solid gray;padding:4px 8px;background:#eee;font-size:small" href="#disqus_thread" data-disqus-identifier="<?php echo $canonical_id; ?>">? Comments</a>
	<div id="disqus_thread"></div>
	<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		var disqus_shortname = 'cablegate-full-text-search';
		var disqus_identifier = '<?php echo $canonical_id; ?>';
		var disqus_url = 'http://www.cablegatesearch.net/cable.php?id=<?php echo $canonical_id; ?>';
		var disqus_title = '<?php echo str_replace("'", "\\'", "{$cable_data['origin']} ({$cable_data['country']}): {$canonical_id}"); ?>';
		/* * * DON'T EDIT BELOW THIS LINE * * */
		(function() {
			var disqus_show_comments = function() {
				$('disqus_show_comments').setStyle('display','none');
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				};
			disqus_show_comments();
			})();
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	    }());
	</script>
	<noscript><p>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></p></noscript>
	</div>
<?php } ?>
</div><!-- end main -->
<script type="text/javascript">
(function(){
	var q = window.location.href.match(/q=([^&]+)/);
	if ( !q || q.length < 2 ) { return; }
	var expressions = decodeURIComponent(q[1]).split(' ');

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
</script>
<script type="text/javascript">
(function () {
	var thisCableId = <?php echo $cable_id; ?>,
		thisCanonicalId = '<?php echo $canonical_id; ?>';

	// time-buffered execution object
	function TimeBufferedExec(delay) {
		this.timer = null;
		this.delay = delay;
		}
	TimeBufferedExec.prototype.execute = function (fn) {
		if ( this.timer ) {
			clearTimeout(this.timer);
			this.timer = null;
			}
		if ( fn ) {
			var me = this;
			this.timer = setTimeout(
				function () {
					fn();
					me.timer = null;
					},
				this.delay
				);
			}
		};
 
	var showCableHeader = function (show) {
		$$('.toggleHeader').each(function(el){
			var header = el.getParent('#cable > div:first-child + div > div:first-child');
			header.setStyle('display', show ? '' : 'none');
			el.set('text', show ? 'Hide header' : 'Show header');
			});
		};

	// coarse validation of URL
	var validateURL = function () {
		var mediaURL = $('add-media-item-dialog-url').value,
			valid = /^https?:\/\/[^.\/]+\.[^.\/]+/.test(mediaURL),
			color = valid ? '#000' : '#c00';
		$('add-media-item-dialog-url').setStyle('color', color);
		$('add-media-item-dialog-ok').disabled = !valid;
		return valid;
		};
	var startRequest = function () {
		$('add-media-item-dialog-message').innerHTML = 'Submitting URL...';
		$('add-media-item-dialog-ok').disabled = true;
		};
	var stopRequest = function (msg) {
		msg = msg || '<span style="color:red">An error occurred. Try again later.<\/span>';
		$('add-media-item-dialog-message').innerHTML = msg;
		$('add-media-item-dialog-ok').disabled = false;
		};
	var bindRemoveButton = function (e) {
		e.addEvent('click', removeURL);
		if (Cookie.read('cablegateContributorKey')){e.setStyle('display', '');}
		};
	var requestAddSuccessHandler = function (response) {
		var msg = response && response.msg ? response.msg : null;
		stopRequest(msg);
		if (!response || !response.url) { return; }
		$('add-media-item-dialog-url').value = '';
		validateURL();
		// first see if item is there, and if so, un-hide and un-disable it
		var link = $('media-item-'+String(response.url_id));
		if (link) {
			link.setStyle('color','');
			link.setStyle('display','');
			return;
			}
		// else we need to create HTML elements
		var mediaItemsContainer = $('media-items');
		// media item container
		var mediaItemContainer = new Element('div', {
			'class': 'media-item',
			id: 'media-item-'+String(response.url_id)
			});
		// link
		mediaItemContainer.grab(new Element('a', {
			href: response.url,
			html: response.url + (response.pending ? ' <span style="font-size:smaller">(temporary, until page is reloaded)<\/span>' : ''),
			styles: {color: response.pending ? 'gray' : ''}
			}));
		var removeButton = new Element('img', {
			src: 'edit-delete-5.png',
			alt: 'Remove media item',
			title: 'Remove media item',
			width: '14',
			height: '14',
			});
		mediaItemContainer.grab(removeButton);
		bindRemoveButton(removeButton);
		mediaItemsContainer.grab(mediaItemContainer);
		};
	var requestAddFailureHandler = function () {
		stopRequest();
		};
	var showDialog = function () {
		validateURL();
		$('add-media-item-dialog').setStyle('display', '');
		};
	var hideDialog = function () {
		$('add-media-item-dialog').setStyle('display', 'none');
		};
	var toggleDialog = function () {
		if ($('add-media-item-dialog').getStyle('display') === 'none'){
			showDialog();
			}
		else {
			hideDialog();
			}
		};
	var reqAddOptions = {
		url: 'cablegate-do.php',
		onSuccess: requestAddSuccessHandler,
		onFailure: requestAddFailureHandler,
		onTimeout: requestAddFailureHandler,
		timeout: 5000
		};
	var addURL = function () {
		// coarse validation of URL
		var mediaURL = $('add-media-item-dialog-url').value;
		if (!validateURL()) { return; }
		startRequest();
		var reqArgs = {
			command: 'cable_attach_media_item',
			cable_id: <?php echo $cable_id; ?>,
			url: mediaURL
			};
		var dummy = new Request.JSON(reqAddOptions).get(reqArgs);
		};
	var requestRemoveHandler = function (response) {
		if (!response) { return; }
		// request refused, say why
		if (!response.done && !response.pending) {
			if (response.msg){
				alert(response.msg);
				}
			return;
			}
		// something went wrong
		if (!response.cable_id || !response.url_id) {
			if (response.msg){
				alert(response.msg);
				}
			return;
			}
		// all fine, removed or dim URL (if request pending)
		var link = $('media-item-'+String(response.url_id));
		if (link) {
			if (response.pending) {
				link.setStyle('color','gray');
				}
			else {
				link.setStyle('display','none');
				}
			}
		};
	var reqRemoveOptions = {
		url: 'cablegate-do.php',
		onSuccess: requestRemoveHandler
		};
	var removeURL = function () {
		var mediaItemContainer = this.getParent('div.media-item'),
			matches = mediaItemContainer.id.match(/^media-item-(\d+)$/),
			url_id = matches && matches[1] ? parseInt(matches[1],10) : 0;
		if (!confirm('Media item will be detached from current cable. Proceed?')) { return; }
		var reqArgs = {
			command: 'cable_detach_media_item',
			cable_id: <?php echo $cable_id; ?>,
			url_id: url_id
			};
		var dummy = new Request.JSON(reqRemoveOptions).get(reqArgs);
		};

	var updateCookies = function () {
		Cookie.write('cablegateContributorKey', $('add-media-item-dialog-contributor-key').value, 365);
		};

	// reference id suggestion
	var canonicalIdSuggestionsCache = {};
	var syncCanonicalIdInput = function () {
		var canonicalIdINPUT = $('canonical_id-input');
		canonicalIdINPUT.setStyle('color', canonicalIdINPUT.value != thisCanonicalId ? 'red' : '');
		};
	var clickCanonicalIdSuggestion = function (ev) {
		var target = this.getElement('span:first-child').innerHTML,
			input = $('canonical_id-input');
		if ( /\?$/.test(target) ) {
			input.value = /^[^?]+/.exec(target);
			input.focus();
			changeCanonicalIdHandler();
			return false;
			}
		if ( target != thisCanonicalId ) {
			window.location.href = 'cable.php?id=' + String(target);
			}
		else {
			input.value = target;
			}
		syncCanonicalIdInput();
		ev.preventDefault();
		};
	var reqCanonicalIdSuggestionsHandler = function (response) {
		if (!response || !response.cables) { return; }
		var suggestionsDIV = $('canonical_id-suggestions'),
			cables = response.cables,
			iCable = cables.length,
			suggestionDIV, cable, isMe, isPerfectMatch;
		suggestionsDIV.empty();
		if (iCable) {
			while ( iCable-- ) {
				cable = cables[iCable];
				isNotPublished = /\?$/.test(cable.canonical_id);
				isMe = cable.canonical_id.toUpperCase() === thisCanonicalId.toUpperCase();
				isPerfectMatch = (/^WIKILEAKS_ID-\d+$/.test(response.canonical_id) && isNotPublished) ||
				                  cable.canonical_id.toUpperCase() === response.canonical_id.toUpperCase();
				suggestionDIV = new Element('div', {
					html: '<span>' + cable.canonical_id + '<\/span><span' + (isNotPublished ? ' class="not-published"' : '') + '>' + cable.subject + '<\/span>',
					styles: {
						color: isMe ? 'gray' : '',
						fontWeight: !isMe && isPerfectMatch ? 'bold' : ''
						},
					events: {
						mousedown: clickCanonicalIdSuggestion
						}
					});
				suggestionsDIV.grab(suggestionDIV, 'top');
				}
			}
		else {
			suggestionDIV = new Element('span', {html: 'No suggestion.'});
			suggestionsDIV.grab(suggestionDIV);
			}
		canonicalIdSuggestionsCache[response.canonical_id] = suggestionsDIV.getChildren();
		}
	var fillCanonicalIdSuggestions = function () {
		var targetCanonicalId = $('canonical_id-input').value;
		if ( canonicalIdSuggestionsCache[targetCanonicalId] ) {
			var suggestionsDIV = $('canonical_id-suggestions');
			suggestionsDIV.empty();
			suggestionsDIV.adopt(canonicalIdSuggestionsCache[targetCanonicalId]);
			}
		else {
			var reqOpts = {
				url: 'cablegate-do.php',
				onSuccess: reqCanonicalIdSuggestionsHandler
				};
			var reqArgs = {
				command: 'get_suggestions_from_canonical_id',
				canonical_id: $('canonical_id-input').value
				};
			var dummy = new Request.JSON(reqOpts).get(reqArgs);
			}
		};
	var focusCanonicalIdHandler = function () {
		fillCanonicalIdSuggestions();
		$('canonical_id-suggestions').setStyle('display', '');
		};
	var blurCanonicalIdHandler = function () {
		$('canonical_id-suggestions').setStyle('display', 'none');
		};
	var timeBufferedExec = new TimeBufferedExec(500);
	var changeCanonicalIdHandler = function () {
		// remove illegal characters
		var input = $('canonical_id-input'),
			corrected = input.value.replace(/[^A-Za-z0-9]+/g, '');
		if ( corrected !== input.value ) {
			input.value = corrected;
			}
		syncCanonicalIdInput();
		timeBufferedExec.execute(function () { fillCanonicalIdSuggestions(); });
		};
	var keyupCanonicalIdHandler = function (ev) {
		if ( ev.key === 'esc' ) {
			var el = $('canonical_id-input');
			el.value = thisCanonicalId;
			el.blur();
			syncCanonicalIdInput();
			return false;
			}
		changeCanonicalIdHandler();
		};

	// initialization
	window.addEvent('domready',function () {
		// init/show/hide cable header
		showCableHeader(Cookie.read('cablegateHideHeaders') !== 'true');
		$$('.toggleHeader').each(function(el){
			el.addEvent('click', function (ev) {
				var header = this.getParent('#cable > div:first-child + div > div:first-child');
					hideHeader = header.getStyle('display') !== 'none';
				showCableHeader(!hideHeader);
				Cookie.write('cablegateHideHeaders', hideHeader, {duration: 365});
				});
			});

		// ref id tooltip
		var dummy = new Tips('#refid-tip', {className:'infotip'});

		// open link in new tab
		$$('#media-items a').each(function (a) {
			a.target = '_blank';
			});

		// auto fill contributor key input field
		var ckey = Cookie.read('cablegateContributorKey') || '';
		$('add-media-item-dialog-contributor-key').value = ckey;

		// handlers
		$('add-media-item-button').addEvent('click', toggleDialog);
		$('add-media-item-dialog-cancel').addEvent('click', hideDialog);
		$('add-media-item-dialog-ok').addEvent('click', addURL);
		$('add-media-item-dialog-url').addEvent('keyup', function () { validateURL(); });
		$('add-media-item-dialog-contributor-key').addEvent('change', updateCookies);
		$$('#media-items div.media-item > img').each(bindRemoveButton);
		$('canonical_id-input').readOnly = false;
		$('canonical_id-input').addEvents({
			focus: focusCanonicalIdHandler,
			blur: blurCanonicalIdHandler,
			change: changeCanonicalIdHandler,
			keyup: keyupCanonicalIdHandler
			});

		// update input UI as per its content
		syncCanonicalIdInput();
		});
	}());
</script>
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
