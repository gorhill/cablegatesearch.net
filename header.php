<?php
// requires cablegate.css
?><div id="quote">&ldquo;All of them, those in power, and those who want the power, would pamper us, if we agreed to overlook their crookedness by wilfully restricting our activities.&rdquo; &mdash; <a href="http://en.wikipedia.org/wiki/Refus_global">&ldquo;Refus Global&ldquo;</a>, <a href="http://en.wikipedia.org/wiki/Paul-&Eacute;mile_Borduas">Paul-&Eacute;mile Borduas</a></div>
<div id="navi"><?php
$navi_entries = array(
	array('Full-text search', '/search.php', 'Perform a full-text search of all released cables so far.'),
	array('Private cart', '/cart.php', 'Here you can see and manage the content of your private cart.'),
	array('Browse tags', '/browse.php', 'Browse the tags: Countries, origins, subjects, programs, organizations.'),
	array('Overview', '/overview.php', 'Overview of the published vs. unpublished status of all cables.'),
	array('Publishing history', '/history.php', 'What was published, modified, removed, and when.'),
	array('Media', '/media.php', 'Media coverage of the Cablegate&rsquo;s cables'),
	array('WL Central', 'http://wlcentral.org/', 'WikiLeaks news, analysis and action (external site).'),
	array('The magic of WikiLeaks: telling it like it is', 'http://www.theage.com.au/national/the-magic-of-wikileaks-telling-it-like-it-is-20110503-1e6ob.html','The battle over WikiLeaks is all about information - who owns it, who controls it, who needs it - and about one man\'s idea to set it free.'),
	array('PFC Bradley Manning, Conscience &amp; Agency', 'http://www.michaelmoore.com/words/mike-friends-blog/pfc-bradley-manning','&ldquo;The contents of the WikiLeaks revelations have pulled back the curtain on the degradation of our democratic system. It has become completely normal for decision-makers to promulgate foreign policies, diplomatic strategies, and military operating procedures that are hostile to the democratic ideals our country was founded upon. The incident I was part of&ndash;shown in the Collateral Murder video&ndash;becomes even more horrific when we grasp that it was not exceptional.&rdquo;')
//	array('Andrew Fowler on Assange', 'http://www.abc.net.au/local/stories/2011/04/07/3185014.htm','Investigative journalist Andrew Fowler has written how an Aussie computer hacker became the &ldquo;Most Dangerous Man in the World&rdquo;')
//	array('Article 19 of UDHR', 'http://www.un.org/en/documents/udhr/index.shtml#a19','Everyone has the right to freedom of opinion and expression; this right includes <b>freedom to hold opinions without interference and to seek, receive and impart information and ideas</b> through any media and regardless of frontiers.'),
	);
$separator = '';
foreach ( $navi_entries as $entry ) {
	list($prompt, $url, $title) = $entry;
	if ( strcmp($_SERVER['REQUEST_URI'], $url) ) {
		printf('%s<a href="%s" title="%s">%s</a>', $separator, $url, $title, $prompt);
		}
	else {
		printf('%s<span>%s</span>', $separator, $prompt);
		}
	$separator = ' &bull; ';
	}
?></div>
<script type="text/javascript">
<!--
(function(){
	window.addEvent('domready',function(){
		$$('#navi a').each(function(e){
			var tipContent = e.getProperty('title');
			var className = 'tiptext';
			var matches = tipContent.match(/[^ ]+\.jpg/g);
			if (matches && matches.length) {
				tipContent = '';
				for (var i=0; i<matches.length; i++) {
					if (i) {
						tipContent += '<br>';
						}
					tipContent += '<img src="' + matches[i] + '">';
					}
				className = 'tipimage';
				}
			var dummy = new Tips(e,{
				showDelay:250,
				className: className,
				title:'',
				offset:{y:24},
				fixed:true
				});
			e.store('tip:text', tipContent);
			});
		});
}());
// -->
</script>
