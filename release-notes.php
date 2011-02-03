<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
<?php include('cablegate.css'); ?>
body {font:normal normal normal 13px/110% sans-serif;letter-spacing:0;word-spacing:0}
body {margin:0;position:relative}
body h1:first-child {font:normal small-caps normal 16px sans-serif;margin:0;padding:4px;background-color:#bcd;color:#000}
div {margin:0}
a {color:#000;text-decoration:none;opacity:1}
a:hover {color:#004;opacity:0.8}
#main {padding:2px}
#intro {font-size:x-small;color:gray}
</style>
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="cablegate-core.js"></script>
<title>Cablegate's cables: Full-text search engine / Release notes</title>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="keywords" content="cablegate, wikileaks, full, text, search, release, notes">
<meta name="description" content="Release notes concerning Cablegate's full-text search">
</head>
<body>
<h1>Cablegate's cables: Full-text search engine / Release notes</h1>
<?php include('header.php'); ?>
<div id="main">
<div>
<ul>
<li>Jan. 31, 2011<ul>
 <li>Added list of suggestions to input field in search.php.
 </ul>
<li>Jan. 5, 2011<ul>
 <li>The Cablegate full-text search tool now moved to its dedicated domain name: <a href="http://www.cablegatesearch.net/">cablegatesearch.net</a>.
 </ul>
<li>Dec. 30, 2010<ul>
 <li>Tags are now expanded in-place in the text of a cable, useful so that you don't have to refer to a separate glossary to figure what a particular tag actually means.
 <li>Credit to <a style="font-style:italic" href="http://cabletags.wordpress.com/2010/12/12/wikileaks-cable-tags-explained/">Cabletags</a> for its glossaries of tags</a>.
 <li>The definition used to expand a tag is taken into account during a full-text search operation.
 </ul>
<li>Dec. 28, 2010<ul>
 <li>I decided to now index numbers, these were left out until now.
 <li>Numbers are purged of leading zeros, to avoid index bloat, and this also makes more sense from the user's point of view: this avoid having to guess/remember the number of leading zeros before any particular numbers.
 </ul>
<li>Dec. 24, 2010<ul>
 <li>Searching for exact sequence of words now supported. When two or more words are separated with a dash (&lsquo;-&rsquo;), only cables in which the words immediately follow each other are returned.
 </ul>
<li>Dec. 9, 2010<ul>
 <li>First version of my full-text search tool for the Cablegate's cables released.
 </ul>
 </ul>
</div>
<?php include('contact-inc.html'); ?>
</div><!-- end main -->
<p id="cart-tips">Marking a cable with <img style="vertical-align:bottom" width="16" height="16" src="bookmark.png" alt="In cart"> will place this cable in your <span style="font-weight:bold">private cart</span>. When viewing your <span style="font-weight:bold">private cart</span>, you can obtain a persistent snapshot of its content, for future reference or to share with others.</p>
</body>
</html>
