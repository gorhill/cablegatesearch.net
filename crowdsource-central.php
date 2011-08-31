<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
.crowdpane {height:600px;overflow:auto;vertical-align:top}
@media only screen and (max-width:639px) {
	.crowdpane {width:100%}
	}
@media only screen and (min-width:640px) {
	.crowdpane {display:inline-block;width:49%}
	}
#canonicalid-suggestions {margin:0 0 0 1em;border:1px groove gray;padding:3px;width:80%;color:gray;background:#DFDDF0}
#canonicalid-suggestions > div {padding:1px;color:black;cursor:pointer;white-space:nowrap;overflow:hidden}
#canonicalid-suggestions > div:hover {background:#FFFAE8}
#canonicalid-suggestions > div > span:first-child {margin:0 1em 0 0;display:inline-block;min-width:12em}
#canonicalid-suggestions > div > a {margin:0 1em 0 0;display:inline-block;min-width:12em}
#canonicalid-suggestions > div > span:nth-of-type(2) {display:inline-block;font-weight:normal;font-variant:small-caps}
#canonicalid-suggestions > div > span:nth-of-type(2).not-published {font-variant:normal;font-style:normal;color:gray}
#canonicalid-input {width:40em}
#dsq-like-thread-button .dsq-toolbar-label {display:none}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<script src="mootools-more.js" type="text/javascript"></script>
<title>Crowdsource Central: Recent activity</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, browse">
<meta name="description" content="Crowdsource's recent activity on the cables from Wikileaks's Cablegate">
<link rel="canonical" href="http://www.cablegatesearch.net/crowdsource-central.php">
</head>
<body>
<h1>Crowdsource Central: Recent activity</h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><g:plusone size="medium"></g:plusone><script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div id="main">

<p style="font-size:smaller">This site aggregates and indexes the U.S. diplomatic cables published by <a href="http://wikileaks.org/cablegate.html">Wikileaks</a> since November 2010. If you consider these documents and <a href="http://mirror.wikileaks.info/">Wikileaks&rsquo; numerous other published leaks</a> are of public interest, and make you better informed, you might wish to <a href="http://wikileaks.org/support.html">support Wikileaks through donations</a>.</p>

<div class="crowdpane">
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: 'wlfind',
	  interval: 30000,
	  title: 'Wikileaks: wlfind',
	  subject: 'Cablegate: the crowd at work',
	  width: 'auto',
	  height: 510,
	  theme: {
		shell: {
		  background: '#8ec1da',
		  color: '#ffffff'
		},
		tweets: {
		  background: '#ffffff',
		  color: '#444444',
		  links: '#1985b5'
		}
	  },
	  features: {
		scrollbar: true,
		loop: true,
		live: true,
		hashtags: true,
		timestamp: true,
		avatars: true,
		toptweets: true,
		behavior: 'default'
	  }
	}).render().start();
	</script>
	</div>

<div class="crowdpane">
	<script type="text/javascript" src="http://cablegate-full-text-search.disqus.com/combination_widget.js?num_items=20&hide_mods=0&color=gray&default_tab=recent&excerpt_length=200"></script>
	</div>

<div style="margin:2em 0;border:1px solid #aaa;width:100%;border-width:1px 0;height:2px"></div>

<div>
	<p><span style="color:#800;font-weight:bold">Important note:</span> Post below to comment on generic topics (including suggestions for this site), <i>not</i> relating to a single specific cable.<br><br>To comment on a specific cable, please do so on the cable page itself. You might want to use the cable finder tool below which assists you in looking up a cable using its...

	<ul>
		<li>Official reference id (ex.: &ldquo;10BEIJING207&rdquo;);
		<li>WL's all-digit internal id (ex.: &ldquo;245489&rdquo;. Id values were inferred from <a href="http://www.guardian.co.uk/news/datablog/2010/nov/29/wikileaks-cables-data#data">The Guardian&rsquo;s CSV file</a>: rows were sorted by date, then origin, then tags);
		<li>Any text which contains a reference to a cable somewhere in it (ex.: &ldquo;http://wikileaks.org/cable/2010/01/10BEIJING207.html&rdquo;);
		</ul>
	</p>

	<p style="margin:1em 0 0 1em"><input id="canonicalid-input" type="text" value=""><div id="canonicalid-suggestions">...</div></p>
	</div>

<div style="margin:2em 0;border:1px solid #aaa;width:100%;border-width:1px 0 0 0;height:2px"></div>

<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'cablegate-full-text-search'; // required: replace example with your forum shortname
	var disqus_identifier = 'crowdsource-central';
	var disqus_url = 'http://www.cablegatesearch.net/crowdsource-central.php';
	var disqus_title = 'Crowdsource Central';
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
</div><!-- end main -->
<script type="text/javascript">
<!--
(function () {
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
	// reference id suggestion
	var canonicalIdSuggestionsCache = {};
	var reqCanonicalIdSuggestionsHandler = function (response) {
		if (!response || !response.cables) { return; }
		var suggestionsDIV = $('canonicalid-suggestions'),
			cables = response.cables,
			iCable = cables.length,
			cable, isPerfectMatch,
			suggestionParent, suggestionId, suggestionSubject;
		suggestionsDIV.empty();
		if (iCable) {
			while ( iCable-- ) {
				cable = cables[iCable];
				isNotPublished = /\?$/.test(cable.canonical_id);
				isPerfectMatch = (/^WIKILEAKS_ID-\d+$/.test(response.canonical_id) && isNotPublished) ||
				                  cable.canonical_id.toUpperCase() === response.canonical_id.toUpperCase();
				if (isNotPublished) {
					suggestionId = new Element('span',{
						text: cable.canonical_id
						});
					}
				else {
					suggestionId = new Element('a',{
						text: cable.canonical_id,
						href: 'cable.php?id=' + cable.canonical_id,
						target: '_blank'
						});
					}
				if (isPerfectMatch) {
					suggestionId.setStyle('font-weight', 'bold');
					}
				suggestionSubject = new Element('span',{
					text: cable.subject,
					'class': isNotPublished ? 'not-published' : '',
					});
				suggestionParent = new Element('div');
				suggestionParent.adopt(suggestionId, suggestionSubject);
				suggestionsDIV.grab(suggestionParent, 'top');
				}
			}
		else {
			suggestionParent = new Element('span', {html: 'No suggestion.'});
			suggestionsDIV.grab(suggestionParent);
			}
		canonicalIdSuggestionsCache[response.canonical_id] = suggestionsDIV.getChildren();
		}
	var fillCanonicalIdSuggestions = function () {
		var targetCanonicalId = $('canonicalid-input').value;
		if ( canonicalIdSuggestionsCache[targetCanonicalId] ) {
			var suggestionsDIV = $('canonicalid-suggestions');
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
				canonical_id: $('canonicalid-input').value
				};
			var dummy = new Request.JSON(reqOpts).get(reqArgs);
			}
		};
	var timeBufferedExec = new TimeBufferedExec(500);
	var changeCanonicalIdHandler = function () {
		// remove illegal characters
		var input = $('canonicalid-input'),
			corrected = input.value.replace(/[^A-Za-z0-9]+/g, '');
		if ( corrected !== input.value ) {
			input.value = corrected;
			}
		timeBufferedExec.execute(function () { fillCanonicalIdSuggestions(); });
		};
	var keyupCanonicalIdHandler = function (ev) {
		changeCanonicalIdHandler();
		};

	// initialization
	window.addEvent('domready',function () {
		// ref id tooltip
		var dummy = new Tips('#refid-tip', {className:'infotip'});
		// handlers
		$('canonicalid-input').readOnly = false;
		$('canonicalid-input').addEvents({
			change: changeCanonicalIdHandler,
			keyup: keyupCanonicalIdHandler
			});
		});
	}());
// -->
</script>
</body>
</html>
