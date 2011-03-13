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
//	array('&ldquo;Bradley Manning could face death: for what?&rdquo;', 'http://www.salon.com/news/opinion/glenn_greenwald/2011/03/03/manning/','Manning: &ldquo;well, it was forwarded to [WikiLeaks] ... hopefully worldwide discussion, debates, and reforms ... i want people to see the truth ... regardless of who they are ... because without information, you cannot make informed decisions as a public.&rdquo;')
	array('SMH: &ldquo;Cutting Assange loose demeans our nation&rdquo;', 'http://www.smh.com.au/opinion/politics/cutting-assange-loose-demeans-our-nation-20110311-1br15.html','... Contrast the deafening Australian silence in response to Assange&rsquo;s pleas for help, with the pressure and determination being exercised by the US in support of an American citizen &ndash; a CIA operative who killed two Pakistanis in front of witnesses, he claims in self defence. ...<br><br>In another serious misjudgment, though, Gillard has failed to see Assange is widely admired for his courage and determination - WikiLeaks has contributed to enhancing democracy globally. ...')
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
?></div><a href="http://march12.rsf.org/en/" style="margin:0;padding:0;display:block;position:absolute;right:2px;width:128px;height:128px;background:transparent url('13.png') no-repeat right top;z-index:0;cursor:pointer" title="World day against cyber-censorship"></a>
<script type="text/javascript">
<!--
(function(){
	window.addEvent('domready',function(){
		$$('#navi a').each(function(e){
			var dummy = new Tips(e,{
				showDelay:250,
				title:'',
				text:'title',
				offset:{y:24},
				fixed:true
				});
			});
		});
}());
// -->
</script>
