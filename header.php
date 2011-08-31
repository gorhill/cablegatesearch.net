<?php
// requires cablegate.css
?><div id="quote">&ldquo;All of them, those in power, and those who want the power, would pamper us, if we agreed to overlook their crookedness by wilfully restricting our activities.&rdquo; &mdash; <a href="http://en.wikipedia.org/wiki/Refus_global">&ldquo;Refus Global&ldquo;</a>, <a href="http://en.wikipedia.org/wiki/Paul-&Eacute;mile_Borduas">Paul-&Eacute;mile Borduas</a></div>
<div id="navi"><?php
$navi_entries = array(
	array('Full-text search', '/search.php', 'Perform a full-text search of all released cables so far.'),
	array('Private cart', '/cart.php', 'Here you can see and manage the content of your private cart.'),
	array('Browse tags', '/browse.php', 'Browse the tags: Countries, origins, subjects, programs, organizations.'),
	array('Overview', '/overview.php', 'Overview of the published vs. unpublished status of all cables.'),
	array('History', '/history.php', 'What was published, modified, removed, and when.'),
	array('Media', '/media.php', 'Media coverage of the Cablegate&rsquo;s cables'),
	array('Crowdsource Central', '/crowdsource-central.php', 'Crowdsource Central: Recent activity, and a place for general comments on the site.'),
	array('WL Central', 'http://wlcentral.org/', 'WikiLeaks news, analysis and action (external site).'),
	array('The magic of WikiLeaks: telling it like it is', 'http://www.theage.com.au/national/the-magic-of-wikileaks-telling-it-like-it-is-20110503-1e6ob.html','The battle over WikiLeaks is all about information - who owns it, who controls it, who needs it - and about one man\'s idea to set it free.'),
	array('PFC Bradley Manning, Conscience &amp; Agency', 'http://www.michaelmoore.com/words/mike-friends-blog/pfc-bradley-manning','&ldquo;The contents of the WikiLeaks revelations have pulled back the curtain on the degradation of our democratic system. It has become completely normal for decision-makers to promulgate foreign policies, diplomatic strategies, and military operating procedures that are hostile to the democratic ideals our country was founded upon. The incident I was part of&ndash;shown in the Collateral Murder video&ndash;becomes even more horrific when we grasp that it was not exceptional.&rdquo;'),
//	array('Andrew Fowler on Assange', 'http://www.abc.net.au/local/stories/2011/04/07/3185014.htm','Investigative journalist Andrew Fowler has written how an Aussie computer hacker became the &ldquo;Most Dangerous Man in the World&rdquo;'),
//	array('Article 19 of UDHR', 'http://www.un.org/en/documents/udhr/index.shtml#a19','Everyone has the right to freedom of opinion and expression; this right includes <b>freedom to hold opinions without interference and to seek, receive and impart information and ideas</b> through any media and regardless of frontiers.'),
	array('Manning&rsquo;s alleged chat logs diff', '/manning-logs-diff.php', 'What was held back by Wired'),
	array('WikiLeaks and a Truth Revolution', 'http://www.youtube.com/watch?v=hd0Z4G8V1uo', '&ldquo;We are a group of people from around the world who have come together to defend WikiLeaks, whistleblowers, and legitimate democracies.<br><br>&ldquo;The US government is attempting to destroy WL and muzzle Assange, while making a horrifying example out of whistleblower and American hero, Bradley Manning.<br><br>&ldquo;This is occurring after an atrocious and inexcusable war was started based on lies. Those who started this war and who have wreaked untold harm upon millions are not being held accountable. The US government is abusing secrecy, denying us access to accurate information that sets national and international policy, and has engaged in an unprecedented attack on whistleblowers. Our institutional mechanisms of accountability are weak and ineffective. Lying, or distortion of information, is becoming the norm in too many institutions.<br><br>&ldquo;These are the hallmarks of a dying democracy. We will not accept this. We defend fundamental human rights and freedoms and legitimate democracies. We demand the truth from our wayward leaders.<br><br>&ldquo;We stand with WikiLeaks.<br><br>&ldquo;We stand with Bradley Manning.<br><br>&ldquo;Join us.&rdquo;'),
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
