<?php
include_once('cacher.php');
include_once('cablegate-functions.php');

header_cache(120);

$cache_id = "media";
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
#media-tree,#media-tree ul {margin:0;padding:0}
#media-tree li {margin:0 0 0 15px;padding:1px;font-size:12.5px;list-style-type:none;white-space:nowrap}
#media-tree span.expandable {margin:0 4px 0 0;display:inline-block;width:11px;height:11px;background:no-repeat left bottom;cursor:pointer}
#media-tree span.expandable.collapsed {background-image:url('open.png')}
#media-tree span.expandable.expanded {background-image:url('close.png')}
#media-tree > li > span:first-child + span {padding:1px 0;display:inline-block;line-height:110%}
#media-tree span.cc0 {font-size:12px}
#media-tree span.cc1 {font-size:14px}
#media-tree span.cc2 {font-size:16px}
#media-tree span.cc3 {font-size:18px}
#media-tree span.cc4 {font-size:20px}
#media-tree span.cc5 {font-size:24px}
#media-tree span.cc6 {font-size:26px}
#media-tree span.cc7 {font-size:28px}
#media-tree span.cc8 {font-size:30px}
#media-tree ul {margin:4px 0 0.5em 0}
#media-tree > li > ul > li > ul > li > a {font-variant:small-caps;color:#444}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<script src="mootools-more.js" type="text/javascript"></script>
<title>Media coverage of the Cablegate&rsquo;s cables</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, browse">
<meta name="description" content="Media coverage of the Cablegate's cables">
</head>
<body>
<h1>Media coverage of the Cablegate&rsquo;s cables</h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-text="Cablegate's cables: Media coverage" data-url="http://www.cablegatesearch.net/media.php">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">
<?php
$num_media_items = 0;
$hosts = array();
$sqlquery = "
	SELECT
		u.`url`,
		c.`canonical_id`,
		c.`subject`
	FROM
		`cablegate_cables` c
		INNER JOIN (`cablegate_urls` u
		INNER JOIN `cablegate_urlassoc` ua
		ON u.`url_id` = ua.`url_id`)
		ON c.`id` = ua.`cable_id`
	WHERE
		(ua.`flags` & 0x01) = 0
	ORDER BY
		u.`url`,
		c.`canonical_id`
	";
if ( $sqlresult = db_query($sqlquery) ) {
	while ( $sqlrow = mysql_fetch_assoc($sqlresult) ) {
		if ( preg_match('!http://(www\\d*\\.)?(wikileaks\\.)?(.*?)(/|$)!i', $sqlrow['url'], $matches) ) {
			$host = $matches[3];
			}
		else {
			$host = 'Unknown';
			}
		if ( !isset($hosts[$host]) ) {
			$hosts[$host] = array();
			}
		$url = $sqlrow['url'];
		if ( !isset($hosts[$host][$url]) ) {
			$hosts[$host][$url] = array();
			$num_media_items++;
			}
		$hosts[$host][$url][] = array(
			'canonical_id' => $sqlrow['canonical_id'],
			'subject' => $sqlrow['subject']
			);
		}
	ksort($hosts);
	}

// find out number of cables used as source materials
$num_source_cables = 0;
$sqlquery = "
	SELECT
		`cable_id`
	FROM
		`cablegate_urlassoc` ua
	WHERE
		(ua.`flags` & 0x01) = 0
	GROUP BY
		ua.`cable_id`
	";
if ( $sqlresult = db_query($sqlquery) ) {
	$num_source_cables = mysql_num_rows($sqlresult);
	}
?>
<p style="font-size:smaller;color:gray">Under construction. Experimental. <b>By no mean complete.</b> Huge backlog of Cablegate-related articles to fill-in. Any help is welcomed.<br>
Media tree is structured as follow: Media sources &rarr; Media items &rarr; Cables used as a source &rarr; Other media items mentioning the same cable.
</p>
<p style="font-size:larger"><?php echo number_format($num_source_cables); ?> unique cables used as source materials in <?php echo number_format($num_media_items); ?> unique media items from <?php echo number_format(count($hosts)); ?> publishers:</p>
<ul id="media-tree">
<?php
$host_id = 1;
foreach ( $hosts as $host => $urls ) {
	$count = count($urls);
	$count_class_no = min(intval($count/20), 8);
	$count_class = sprintf(' class="cc%d"', $count_class_no);
	echo '<li class="host" id="host-', $host_id, '"><span class="expandable collapsed"></span><span', $count_class, '>', htmlentities($host), ' (', number_format($count), ')</span><ul class="media-items" style="display:none"><li style="color:gray">Retrieving...</li></ul>';
	$host_id++;
	}
?>
</ul>
<?php include('footer.php'); ?>
</div><!-- end main -->
<script>
<!--
(function () {
	var requestOthersHandler = function (response) {
		if (!response || !response.media_item_id || !response.cable_id || !response.media_items) { return; }
		var cableLI = $('cable-'+String(response.media_item_id)+'-'+String(response.cable_id)),
			othersUL = cableLI.getElement('ul.others'),
			items = response.media_items,
			iItems = items.length,
			item, itemLI, itemA;
		othersUL.empty();
		while (iItems--) {
			item = items[iItems];
			itemA = new Element('a', {
				href: item.url,
				html: item.url
				});
			itemLI = new Element('li', {
				'class': 'other'
				});
			itemLI.grab(itemA);
			othersUL.grab(itemLI,'top');
			}
		// if no other media item covering the cable, say so
		if (!items.length) {
			othersUL.grab(new Element('li', {
				'class': 'other',
				html: '<span style="color:gray">No other media item found for this particular cable.</span>'
				}));
			}
		};
	var reqOthersOptions = {
		url: 'cablegate-do.php',
		onSuccess: requestOthersHandler
		};
	var expandCable = function (el) {
		var parentCable = el.getParent('li.cable');
		if (!parentCable) { return; }
		var expandButton = parentCable.getElement('span.expandable');
		expandButton.removeClass('collapsed');
		expandButton.addClass('expanded');
		var othersContainer = parentCable.getElement('ul.others');
		othersContainer.setStyle('display', '');
		var others = othersContainer.getChildren('.other');
		if (others.length) { return; }
		// retrieve items from server
		var id_fragments = parentCable.id.match(/-(\d+)-(\d+)$/),
			media_item_id = parseInt(/\d+/.exec(id_fragments[1]),10),
			cable_id = parseInt(/\d+/.exec(id_fragments[2]),10),
			args = {
			command: 'get_media_items_from_cable_id',
			media_item_id: media_item_id,
			cable_id: cable_id
			};
		var dummy = new Request.JSON(reqOthersOptions).get(args);
		};
	var collapseCable = function (el) {
		var parentCable = el.getParent('li.cable');
		if (!parentCable) { return; }
		var expandButton = parentCable.getElement('span.expandable');
		expandButton.removeClass('expanded');
		expandButton.addClass('collapsed');
		var othersContainer = parentCable.getElement('ul.others');
		othersContainer.setStyle('display', 'none');
		};
	var toggleCable = function(){
		if (this.hasClass('collapsed')) {
			expandCable(this);
			}
		else {
			collapseCable(this);
			}
		};

	var bindCableButton = function (el) {
		el.addEvent('click', toggleCable);
		};
	var requestCablesHandler = function (response) {
		if (!response || !response.media_item_id || !response.cables) { return; }
		var parentUL = $('media-item-'+String(response.media_item_id)).getElement('ul.cables'),
			cables = response.cables,
			iCables = cables.length,
			cable, cableLI, expandButton, cableA, othersContainerUL;
		parentUL.empty();
		while (iCables--) {
			cable = cables[iCables];
			expandButton = new Element('span', {
				'class': 'expandable collapsed'
				});
			cableA = new Element('a', {
				href: '/cable.php?id=' + cable.canonical_id,
				html: '<b>' + cable.canonical_id + ':</b> ' + cable.subject,
				target: '_blank'
				});
			othersContainerUL = new Element('ul', {
				'class': 'others',
				html: '<li style="color:gray">Retrieving...</li>',
				styles: {'display':'none'}
				});
			itemLI = new Element('li', {
				id: 'cable-'+String(response.media_item_id)+'-'+String(cable.id),
				'class': 'cable'
				});
			itemLI.adopt(expandButton, cableA, othersContainerUL);
			parentUL.grab(itemLI,'top');
			bindCableButton(expandButton);
			}
		};
	var reqCablesOptions = {
		url: 'cablegate-do.php',
		onSuccess: requestCablesHandler
		};
	var expandMediaItem = function (el) {
		var parentMediaItem = el.getParent('li.media-item');
		if (!parentMediaItem) { return; }
		var expandButton = parentMediaItem.getElement('span.expandable');
		expandButton.removeClass('collapsed');
		expandButton.addClass('expanded');
		var cablesContainer = parentMediaItem.getElement('ul.cables');
		cablesContainer.setStyle('display', '');
		var cables = cablesContainer.getChildren('.cable');
		if (cables.length) { return; }
		// retrieve items from server
		var args = {
			command: 'get_cables_from_media_item_id',
			media_item_id: parseInt(/\d+$/.exec(parentMediaItem.id),10)
			};
		var dummy = new Request.JSON(reqCablesOptions).get(args);
		};
	var collapseMediaItem = function (el) {
		var parentMediaItem = el.getParent('li.media-item');
		if (!parentMediaItem) { return; }
		var expandButton = parentMediaItem.getElement('span.expandable');
		expandButton.removeClass('expanded');
		expandButton.addClass('collapsed');
		var cablesContainer = parentMediaItem.getElement('ul.cables');
		cablesContainer.setStyle('display', 'none');
		};
	var toggleMediaItem = function () {
		if (this.hasClass('collapsed')) {
			expandMediaItem(this);
			}
		else {
			collapseMediaItem(this);
			}
		};

	var bindMediaItemButton = function (el) {
		el.addEvent('click', toggleMediaItem);
		};
	var requestMediaItemsHandler = function (response) {
		if (!response || !response.media_host_id || !response.media_items) { return; }
		var parentUL = $('host-'+String(response.media_host_id)).getElement('ul.media-items'),
			items = response.media_items,
			iItems = items.length,
			item, itemLI, expandButton, itemA, cablesContainerUL;
		parentUL.empty();
		while (iItems--) {
			item = items[iItems];
			expandButton = new Element('span', {
				'class': 'expandable collapsed'
				});
			itemA = new Element('a', {
				href: item.url,
				html: item.title.length ? item.title : item.url,
				target: '_blank'
				});
			cablesContainerUL = new Element('ul', {
				'class': 'cables',
				html: '<li style="color:gray">Retrieving...</li>',
				styles: {'display':'none'}
				});
			itemLI = new Element('li', {
				id: 'media-item-'+String(item.id),
				'class': 'media-item'
				});
			itemLI.adopt(expandButton, itemA, cablesContainerUL);
			parentUL.grab(itemLI,'top');
			bindMediaItemButton(expandButton);
			}
		};
	var reqMediaItemsOptions = {
		url: 'cablegate-do.php',
		onSuccess: requestMediaItemsHandler
		};
	var expandHost = function (el) {
		var parentHost = el.getParent('li.host');
		if (!parentHost) { return; }
		var expandButton = parentHost.getElement('span.expandable');
		expandButton.removeClass('collapsed');
		expandButton.addClass('expanded');
		var itemsContainer = parentHost.getElement('ul.media-items');
		itemsContainer.setStyle('display', '');
		var items = itemsContainer.getChildren('.media-item');
		if (items.length) { return; }
		// retrieve items from server
		var spanHost = parentHost.getElement('span.expandable + span');
		var args = {
			command: 'get_media_items_from_host',
			media_host: /[\w\.]+/.exec(spanHost.innerHTML)[0],
			media_host_id: parseInt(/\d+$/.exec(parentHost.id)[0],10)
			};
		var dummy = new Request.JSON(reqMediaItemsOptions).get(args);
		};
	var collapseHost = function (el) {
		var parentHost = el.getParent('li.host');
		if (!parentHost) { return; }
		var expandButton = parentHost.getElement('span.expandable');
		expandButton.removeClass('expanded');
		expandButton.addClass('collapsed');
		var itemsContainer = parentHost.getElement('ul.media-items');
		itemsContainer.setStyle('display', 'none');
		};
	var toggleHost = function () {
		if (this.hasClass('collapsed')) {
			expandHost(this);
			}
		else {
			collapseHost(this);
			}
		};
	var bindHostButton = function (el) {
		el.addEvent('click', toggleHost);
		};
	window.addEvent('domready',function () {
		$$('.host > .expandable').each(function(el){
			bindHostButton(el);
			});
		});
	}());
// -->
</script>
</body>
</html>
<?php
// -----
db_close_compressed_cache();
}
?>
