<?php
// requires cablegate.css
?><div id="quote">&ldquo;All of them, those in power, and those who want the power, would pamper us, if we agreed to overlook their crookedness by wilfully restricting our activities.&rdquo; &mdash; <a href="http://en.wikipedia.org/wiki/Refus_global">&ldquo;Refus Global&ldquo;</a>, <a href="http://en.wikipedia.org/wiki/Paul-&Eacute;mile_Borduas">Paul-&Eacute;mile Borduas</a></div>
<div id="navi"><?php
$navi_entries = array(
	array('Full-text search', '/search.php'),
	array('Browse tags', '/browse.php'),
	array('Release history', '/history.php'),
	array('Private cart', '/cart.php'),
	array('Open sourcing', 'https://github.com/gorhill/cablegatesearch.net'),
	);
foreach ( $navi_entries as $entry ) {
	list($prompt, $url) = $entry;
	if ( strcmp($_SERVER['REQUEST_URI'], $url) ) {
		printf('<a href="%s">%s</a>', $url, $prompt);
		}
	else {
		printf('<span>%s</span>', $prompt);
		}
	}
?></div>
