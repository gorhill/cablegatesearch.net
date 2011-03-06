<?php
// requires cablegate.css
?><div id="quote">&ldquo;All of them, those in power, and those who want the power, would pamper us, if we agreed to overlook their crookedness by wilfully restricting our activities.&rdquo; &mdash; <a href="http://en.wikipedia.org/wiki/Refus_global">&ldquo;Refus Global&ldquo;</a>, <a href="http://en.wikipedia.org/wiki/Paul-&Eacute;mile_Borduas">Paul-&Eacute;mile Borduas</a></div>
<div id="navi"><?php
$navi_entries = array(
	array('Full-text search', '/search.php', 'Perform a full-text search of all released cables so far.'),
	array('Browse tags', '/browse.php', 'Browse the tags: Countries, origins, subjects, programs, organizations.'),
	array('Publishing history', '/history.php', 'What was published, modified, removed, and when.'),
	array('Private cart', '/cart.php', 'Here you can see and manage the content of your private cart.'),
	array('Extras', '/extras.php', 'Unsorted stuff as of now.'),
	array('WL Central', 'http://wlcentral.org/', 'WikiLeaks news, analysis and action (external site).'),
//	array('Julian Assange speech in Melbourne', 'http://www.youtube.com/watch?v=zL6433U87HU',''),
//	array('Four Corners: &ldquo;The Forgotten Man&rdquo;','http://www.abc.net.au/4corners/special_eds/20110214/leaks/default.htm',''),
	array('My pick: &ldquo;Bradley Manning could face death: for what?&rdquo;', 'http://www.salon.com/news/opinion/glenn_greenwald/2011/03/03/manning/','Manning: &ldquo;well, it was forwarded to [WikiLeaks] ... hopefully worldwide discussion, debates, and reforms ... i want people to see the truth ... regardless of who they are ... because without information, you cannot make informed decisions as a public.&rdquo;')
	);
foreach ( $navi_entries as $entry ) {
	list($prompt, $url, $title) = $entry;
	if ( strcmp($_SERVER['REQUEST_URI'], $url) ) {
		printf('<a href="%s" title="%s">%s</a> ', $url, $title, $prompt);
		}
	else {
		printf('<span>%s</span>', $prompt);
		}
	}
?></div>
<script type="text/javascript">
<!--
(function(){
	window.addEvent('domready',function(){
		$$('#navi a').each(function(e){
			var dummy = new Tips(e,{
				showDelay:250,
				title:'',
				text:'title',
				className:'cable-tip',
				offset:{y:24},
				fixed:true
				});
			});
		});
}());
// -->
</script>
