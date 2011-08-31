<?php
include_once('cacher.php');
$cache_id = 'manning-logs-diff';
if ( !db_output_compressed_cache($cache_id) ) {
db_open_compressed_cache($cache_id);
// -----
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Manning&rsquo;s alleged chat logs diff</title>
<style type="text/css">
<?php include('cablegate.css'); ?>
#logs {font:13px sans-serif;color:#444;line-height:175%}
.known {color:#444}
ins {background-color:#dfd;color:black;text-decoration:none;}
ins.notbywired {background-color:#ddfffa}
ins.wiredquote-0606 {background-color:#eee;color:#444}
ins.wiredquote-0610 {background-color:#eee;color:#444}
del {background-color:#fdd;color:black;text-decoration:none;}
.date {margin:1em 0;padding:2px 0 2px 1em;width:100%;font-size:16px;color:#888;background-color:#eef}
.date a {color:inherit}
.timelapse {margin:1em 0;padding:2px 0 2px 2em;width:100%;font-size:10px;color:#aaa;background-color:#eef;line-height:125%}
</style>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php include('mootools-core-1.3-loader.inc'); ?>
<script type="text/javascript" src="mootools-more.js"></script>
</head>
<body>
<h1>Manning&rsquo;s alleged chat logs diff</h1>
<span style="display:inline-block;position:absolute;top:4px;right:0"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></span>
<?php include('header.php'); ?>
<div style="margin:1em 0;font:13px serif">
<p>Essentially, this page highlights what was <i>not</i> known prior to the release of the full logs.<br><br>Log materials from <a href="http://firedoglake.com/merged-manning-lamo-chat-logs/"><i>FireDogLake</i></a> and <a href="http://www.wired.com/threatlevel/2011/07/manning-lamo-logs/"><i>Wired</i></a>. See <a href="http://www.salon.com/news/opinion/glenn_greenwald/2011/07/14/wired/index.html">Glenn Greenwald's commentary</a> on the release of the full logs.</p>
<p>Important note: I don't know how genuine these logs are, hence the &lsquo;alleged&rsquo; qualifier where used, implicit where not used. I don't know whether they are complete, whether they are completely original, whether &lsquo;bradass87&rsquo; was really Bradley Manning, and at all time, whether &lsquo;info@adrianlamo.com&rsquo; was really Adrian Lamo, and at all time.</p>
<ul>
<li><span class="known">[... text ...]</span> What was published by <i>Wired</i> as the <a href="http://www.wired.com/threatlevel/2010/06/wikileaks-chat/">&ldquo;partial logs&rdquo; in June 2010</a>;
<li><ins class="wiredquote-0606">[... text ...]</ins> What was <i>quoted</i> by <i>Wired</i> in June 2010 <a href="http://www.wired.com/threatlevel/2010/06/leak/">there</a> and <a href="http://www.wired.com/threatlevel/2010/06/conscience/">there</a>, but <i>not</i> included in the &ldquo;partial logs&rdquo;;
<li><ins class="notbywired">[... text ...]</ins> What was held back by <i>Wired</i>, but disclosed by other sources (as compiled by <a href="http://firedoglake.com/merged-manning-lamo-chat-logs/"><i>FireDogLake</i></a>) prior to the release of the &ldquo;full logs&rdquo;;
<li><ins>[... text ...]</ins> What was not published by <i>Wired</i> and others prior to the release of the &ldquo;full logs&rdquo; (as published by <i>Wired</i> on July 13th, 2011);
<li><del>[... text ...]</del> What was not part of the logs, according to the &ldquo;full logs&rdquo; as published by <i>Wired</i> on July 13th, 2011.</ul></p>
<p>Jump to: <a href="#date20100521">May 21st</a>, <a href="#date20100522">May 22nd</a>, <a href="#date20100523">May 23rd</a>, <a href="#date20100524">May 24th</a>, <a href="#date20100525">May 25th</a></p>
</div>
<div style="border:0;border-top:1px dotted #aaa;border-bottom:1px dotted #aaa;width:100%;height:1px;"></div>
<div id="logs">
<div class="date" id="date20100521"><a href="#date20100521">&#xA7;&nbsp;</a>May 21, 2010</div>
<ins>(1:40:51 PM) bradass87 has not been authenticated yet. You should authenticate this buddy.<br>
(1:40:51 PM) Unverified conversation with bradass87 started.<br>
</ins>(1:41:12 PM) <b>bradass87:</b> hi<br>
(1:44:04 PM) <b>bradass87:</b> how are you?<br>
(1:47:01 PM) <b>bradass87:</b> im an army intelligence analyst, deployed to eastern baghdad, pending discharge for “adjustment disorder” <del>[...]</del><ins>in lieu of “gender identity disorder”</ins><br>
(1:56:24 PM) <b>bradass87:</b> im sure you’re pretty busy...<br>
(1:58:31 PM) <b>bradass87:</b> if you had unprecedented access to classified networks 14 hours a day 7 days a week for 8+ months, what would you do?<br>
(1:58:31 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: Tired of being tired<br>
(2:17:29 PM) <b>bradass87:</b> ?<br>
<div class="timelapse">Time lapse</div>
(6:07:29 PM) <b>info@adrianlamo.com:</b> What’s your MOS?<br>
<div class="date" id="date20100522"><a href="#date20100522">&#xA7;&nbsp;</a>May 22, 2010</div>
(3:16:24 AM) <b>bradass87:</b> re: “What’s your MOS?” -- Intelligence Analyst (35F)<br>
<ins>(3:16:24 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: Tired of being tired
</ins>
<div class="timelapse">Time lapse</div>
<ins>(10:13:20 AM) <b>bradass87:</b> The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(10:13:27 AM) Unverified conversation with bradass87 started.<br>
(10:13:27 AM) <b>bradass87:</b> [resent] &lt;HTML&gt;ping<br>
(10:13:50 AM) <b>info@adrianlamo.com:</b> hello<br>
(10:13:57 AM) <b>bradass87:</b> re: “What’s your MOS?” -- Intelligence Analyst (35F)<br>
(10:14:08 AM) <b>info@adrianlamo.com:</b> *nod*<br>
(10:14:27 AM) <b>bradass87:</b> anyway, how are you?<br>
(10:14:28 AM) <b>info@adrianlamo.com:</b> my ex was 97B<br>
(10:14:44 AM) <b>bradass87:</b> ick<br>
(10:14:50 AM) <b>bradass87:</b> 35M now-a-days<br>
(10:14:50 AM) <b>info@adrianlamo.com:</b> made for quiet dinner convo. neither of us talked about our days ;><br>
(10:15:29 AM) <b>bradass87:</b> so yeah<br>
(10:15:41 AM) <b>bradass87:</b> im in a sticky situation...<br>
(10:16:56 AM) <b>bradass87:</b> its nice to meet you btw... only starting to familiarize myself with whats available in open source<br>
(10:17:45 AM) <b>info@adrianlamo.com:</b> open source or OSINT? ;P<br>
(10:17:51 AM) <b>info@adrianlamo.com:</b> Pleased to meet you.<br>
(10:17:54 AM) <b>bradass87:</b> same deal<br>
(10:19:00 AM) <b>bradass87:</b> im kind of coming out of a cocoon... its going to take some time, but i hopefully wont be a ghost anymore<br>
(10:19:53 AM) <b>info@adrianlamo.com:</b> You mentioned gender identity, I believe.<br>
(10:19:59 AM) <b>bradass87:</b> ive had an unusual, and very stressful experience over the last decade or so<br>
(10:20:53 AM) <b>bradass87:</b> yes... questioned my gender for several years... sexual orientation was easy to figure out... but i started to come to terms with it during the first few months of my deployment<br>
(10:21:09 AM) <b>info@adrianlamo.com:</b> May I ask the particulars?<br>
(10:21:34 AM) <b>info@adrianlamo.com:</b> I’m bi myself, and my ex is MTF.<br>
(10:21:34 AM) <b>bradass87:</b> im fairly open... but careful, so yes..<br>
(10:22:00 AM) <b>bradass87:</b> im aware of your bi part<br>
(10:22:24 AM) <b>bradass87:</b> uhm, trying to keep a low profile for now though, just a warning<br>
(10:23:34 AM) <b>info@adrianlamo.com:</b> I’m a journalist and a minister. You can pick either, and treat this as a confession or an interview (never to be published) & enjoy a modicum of legal protection.<br>
(10:24:07 AM) <b>bradass87:</b> assange level?<br>
(10:25:12 AM) <b>bradass87:</b> or are you socially engineering ;P<br>
(10:25:51 AM) <b>info@adrianlamo.com:</b> You must not have done your research :P<br>
(10:25:57 AM) <b>info@adrianlamo.com:</b> I could have flipped for the FBI.<br>
(10:26:05 AM) <b>info@adrianlamo.com:</b> Gotten a sweeter deal.<br>
(10:26:10 AM) <b>info@adrianlamo.com:</b> Before they fucked up.<br>
(10:26:14 AM) <b>info@adrianlamo.com:</b> And I got one anyway.<br>
(10:26:14 AM) <b>bradass87:</b> indeed<br>
(10:26:16 AM) <b>info@adrianlamo.com:</b> I held out.<br>
(10:27:04 AM) <b>info@adrianlamo.com:</b> I know what being in a little room having U.S. Code & its consequences explained to you by people who don’t smile is like.<br>
(10:27:06 AM) <b>bradass87:</b> btw, reminds me... saw a USAF report mentioning something about an “Adrian Lamo” being in possession of French classified material<br>
(10:27:57 AM) <b>bradass87:</b> it flips both ways unfortunately... Title 10, Section 654 of US Code<br>
(10:28:06 AM) <b>bradass87:</b> (DADT)<br>
(10:28:29 AM) <b>info@adrianlamo.com:</b> Of course, you could be false flagging me. I say “Can I see it?” and bam, I’m a criminal.<br>
(10:28:52 AM) <b>bradass87:</b> do they do that?<br>
(10:29:10 AM) <b>info@adrianlamo.com:</b> You don’t know?<br>
(10:29:33 AM) <b>bradass87:</b> no idea... FBI is the only beast i know nothing about<br>
(10:29:43 AM) <b>bradass87:</b> i play with foreigners<br>
(10:29:46 AM) <b>info@adrianlamo.com:</b> They have a grudge.<br>
(10:30:09 AM) <b>info@adrianlamo.com:</b> They had to apologize for how they handled my case. In public.<br>
(10:30:13 AM) <b>bradass87:</b> DoS, DoD, CIA, NSA, those are what i know<br>
(10:30:15 AM) <b>info@adrianlamo.com:</b> To the press.<br>
(10:30:25 AM) <b>info@adrianlamo.com:</b> They _hate_ that.<br>
(10:30:32 AM) <b>bradass87:</b> PR games<br>
(10:30:57 AM) <b>info@adrianlamo.com:</b> My file runs 3000 pages. I don’t know how typical that is.<br>
(10:31:07 AM) <b>bradass87:</b> very atypical<br>
(10:31:16 AM) <b>bradass87:</b> im sorry i dont have access to LES material<br>
(10:31:29 AM) <b>info@adrianlamo.com:</b> I wouldn’t ask you to use such access.<br>
(10:31:40 AM) <b>bradass87:</b> i know, i’d offer it<br>
(10:31:53 AM) <b>bradass87:</b> hold on<br>
(10:33:28 AM) <b>bradass87:</b> this is what i do for friends: http://bit.ly/aLoqUi<br>
(10:35:14 AM) <b>bradass87:</b> [the one below it is mine too]<br>
(10:35:30 AM) <b>bradass87:</b> &gt;sigh&lt;<br>
(10:36:46 AM) <b>bradass87:</b> living such an opaque life, has forced me never to take transparency, openness, and honesty for granted<br>
(10:37:31 AM) <b>bradass87:</b> so...<br>
(10:38:37 AM) <b>info@adrianlamo.com:</b> I’ve been a friend to Wikileaks – I’ve repeatedly asked people who download Hackers Wanted to donate.<br>
(10:38:44 AM) <b>info@adrianlamo.com:</b> And donated myself.<br>
(10:38:49 AM) <b>bradass87:</b> i know<br>
(10:38:59 AM) <b>bradass87:</b> actually how i noticed you<br>
(10:39:20 AM) <b>info@adrianlamo.com:</b> Whether I’ve given material, isn’t material. Semi-pun intended.<br>
(10:39:28 AM) <b>bradass87:</b> during my usual open source collection [twitter, news.google.com, etc.]<br>
(10:40:08 AM) <b>bradass87:</b> &gt;nod&lt;<br>
(10:40:51 AM) <b>bradass87:</b> they’ve got a lot of ammunition, its the support they need from the public in publishing the material coming through soon<br>
(10:41:42 AM) <b>info@adrianlamo.com:</b> In general terms, have you seen my name anywhere else I’m not aware of? I specify no particular venue.<br>
(10:41:59 AM) <b>bradass87:</b> not really...<br>
(10:42:55 AM) <b>bradass87:</b> uhm OGA networks have you at 7 results, all OSINT copy/pastes... not connected to Law Enforcement stuff<br>
(10:44:10 AM) <b>bradass87:</b> 1 mention of your name with the french classified material... but it was from a product that is over-written daily... since the producer doesn’t archive, couldn’t access the full bit<br>
(10:45:13 AM) <b>bradass87:</b> im sorry, if seem kind of creepy<br>
(10:45:18 AM) <b>bradass87:</b> s/if/if i<br>
(10:45:32 AM) <b>info@adrianlamo.com:</b> You don’t know how creepy my contacts get.<br>
(10:45:49 AM) <b>bradass87:</b> how does this one rate ?<br>
(10:46:10 AM) <b>bradass87:</b> quantitively... 1-10 scale perhaps?<br>
(10:47:16 AM) <b>info@adrianlamo.com:</b> 7ish. 1/1 on reliability/quality of data based on statements made. Even odds on being a false flag.<br>
(10:47:20 AM) <b>info@adrianlamo.com:</b> Nothing personal.<br>
(10:47:57 AM) <b>bradass87:</b> its ok<br>
(10:48:00 AM) <b>info@adrianlamo.com:</b> This is dangerous. I’ve learned my lessons in tightropes.<br>
(10:48:05 AM) <b>bradass87:</b> i’ve got time<br>
(10:48:43 AM) <b>info@adrianlamo.com:</b> Would you know if a specific person had authored a report/paper?<br>
(10:49:23 AM) <b>bradass87:</b> not really...<br>
(10:49:42 AM) <b>bradass87:</b> bureaucrats usually aren’t that intelligent i find<br>
(10:49:54 AM) <b>bradass87:</b> [re: false flag]<br>
(10:50:03 AM) <b>info@adrianlamo.com:</b> Webster, Timothy D.<br>
(10:51:05 AM) <b>bradass87:</b> who’s that?<br>
(10:51:21 AM) <b>bradass87:</b> he’s an author obviously<br>
(10:51:28 AM) <b>bradass87:</b> Sex and Intimacy [goog]<br>
(10:51:59 AM) <b>info@adrianlamo.com:</b> SA with NGA (former)<br>
(10:52:18 AM) <b>bradass87:</b> squints<br>
(10:52:22 AM) <b>bradass87:</b> &gt;shiver&lt;<br>
(10:53:01 AM) <b>bradass87:</b> squints creep me out<br>
(10:53:06 AM) <b>info@adrianlamo.com:</b> Specialty FCI in cyber-areas.<br>
(10:53:53 AM) <b>bradass87:</b> no idea...<br>
(10:54:45 AM) <b>bradass87:</b> im not really sure where this is going... apart from awkward weirdness<br>
(10:55:31 AM) <b>info@adrianlamo.com:</b> I apologize if I’ve made you feel awkward.<br>
(10:55:37 AM) <b>bradass87:</b> no, its me<br>
(10:55:54 AM) <b>bradass87:</b> i said too much too fast<br>
(10:55:59 AM) <b>info@adrianlamo.com:</b> He wrote a paper a while back, I was curious how it had been received by the IC.<br>
(10:56:36 AM) <b>bradass87:</b> i guess i can find out, though im restricted to SIPR now, because of the discharge proceedings<br>
(10:58:10 AM) <b>bradass87:</b> am i coming off too quick? ive closed myself off for awhile... so<br>
(10:58:41 AM) <b>bradass87:</b> i thought i’d reach out to someone who would possibly understand...<br>
(10:59:07 AM) <b>bradass87:</b> &gt;– [this person is kind of fragile]<br>
(10:59:29 AM) <b>bradass87:</b> :’(<br>
(11:00:53 AM) <b>bradass87:</b> anyway, i’m going to go to the PX for a minute... i’ll be back in about 30-40 min?<br>
(11:01:39 AM) <b>info@adrianlamo.com:</b> i’ll be around<br>
(11:01:43 AM) <b>info@adrianlamo.com:</b> i usually am<br>
(11:01:44 AM) <b>bradass87:</b> k<br>
(11:01:47 AM) <b>bradass87:</b> ttyl<br>
(11:01:48 AM) <b>info@adrianlamo.com:</b> around and understanding both<br>
(11:02:17 AM) <b>info@adrianlamo.com:</b> be well, and stay out of trouble<br>
(11:22:11 AM) <b>bradass87:</b> wow, that was quick<br>
(11:22:50 AM) <b>bradass87:</b> uhm... anyway... i guess i can talk a little bit about myself... i mean, i’ve really got nothing to lose [i know, sounds desperate]<br>
(11:23:19 AM) <b>bradass87:</b> i was born in central oklahoma, grew up in a small town called crescent, just north of oklahoma city<br>
(11:23:59 AM) <b>bradass87:</b> dad was a manager of computer programmers at hertz corporation, doing legacy maint., etc<br>
(11:24:41 AM) <b>bradass87:</b> mother was british (specifically welsh), married father while he was stationed at an air force base in southwest wales<br>
(11:25:18 AM) <b>info@adrianlamo.com:</b> I’m of Scottish & Welsh descent.<br>
(11:25:22 AM) <b>info@adrianlamo.com:</b> On one side.<br>
(11:27:18 AM) <b>bradass87:</b> i was a short (still am), very intelligent (could read at 3 and multiply / divide by 4), very effeminate, and glued to a computer screen at these young ages [MSDOS / Windows 3.1 timeframe]... i played SimCity [the original] obsessively<br>
(11:27:40 AM) <b>bradass87:</b> an easy target by kindergarten...<br>
(11:28:07 AM) <b>bradass87:</b> grew up in a highly evangelical town with more church pews than people<br>
(11:28:48 AM) <b>bradass87:</b> so, i got pretty messed up at school... “girly boy” “teacher’s pet”, etc<br>
(11:29:57 AM) <b>bradass87:</b> home was the same, alcoholic father and mother... mother was very nice, but very needy emotionally... father was very wealthy (lots of nice toys / computer stuff), but abusive<br>
(11:31:07 AM) <b>bradass87:</b> my favorite things growing up were reading my encyclopaedia, watching PBS (the only channel i could get on my TV) building with lego, and playing on my dad’s hand-me-down computers<br>
(11:31:42 AM) <b>bradass87:</b> i lived in the middle of nowhere, so i had no neighbors to hang out with... and my dad would never take me anyway, because after work he’d hit the bottle<br>
(11:32:58 AM) <b>bradass87:</b> i was a science fair buff... won grand prize in my town 3 years in a row... and played on the “academic bowl team” as team leader (which meant state championship!)<br>
(11:33:46 AM) <b>bradass87:</b> i didnt like getting beat up or called gay [didn't really know what gay meant, but knew it was something bad]<br>
(11:34:06 AM) <b>bradass87:</b> so i joined sports teams, and started becoming an athlete<br>
(11:34:19 AM) <b>bradass87:</b> around this time (middle school)... my parents divorced<br>
(11:36:34 AM) <b>bradass87:</b> my father in a drunken stupor got angry with me because i was doing some noisy homework while he was watching TV... he went into his bedroom, pulled out a shotgun, and chased me out of the house... the door was deadbolted, so i couldn’t get out before he caught up with me... so my mother (also wasted) threw a lamp over his head... and i proceeded to fight him, breaking his nose, and made it out of the house... my father let off one or two shots, causing damage, but injuring nobody, except for the belt lashing i got for “making him shoot up the house”<br>
(11:36:59 AM) <b>bradass87:</b> i went to school the next day, and my teachers noticed the wounds, and got social workers involved<br>
(11:37:11 AM) <b>bradass87:</b> he immediately stopped drinking, and my mother filed for divorce<br>
(11:37:29 AM) <b>bradass87:</b> after the divorce, my mother attempted suicide...<br>
(11:38:23 AM) <b>bradass87:</b> after taking care of her for awhile, and gaining custody of me, my mother took me to her hometown, haverfordwest, wales... to live and go to school<br>
(11:38:49 AM) <b>bradass87:</b> i spent four years in the UK, continuing my education<br>
(11:39:13 AM) <b>bradass87:</b> i also started playing around more and more with computers, specificially webservers<br>
(11:39:54 AM) <b>bradass87:</b> to try and mitigate various financial problems while going to school, i got the idea with a rather sly friend to form an internet startup...<br>
(11:40:25 AM) <b>bradass87:</b> http://web.archive.org/web/*/http://www.angeldyne.com &lt;- archive<br>
(11:40:57 AM) <b>bradass87:</b> we fell out over various issues... and the project was ended, luckily without any losses<br>
(11:41:57 AM) <b>bradass87:</b> i learned a lot about running LAMP servers... sql jazz, routing, as well as the business stuff, PR etc...<br>
(11:42:24 AM) <b>bradass87:</b> after that fell through, my education started to slip behind... as my mother started getting very ill<br>
(11:42:43 AM) <b>bradass87:</b> she had a minor stroke... then a mild one... and i was getting desperate<br>
(11:43:02 AM) <b>bradass87:</b> so i called my father, and begged him to live in the US again<br>
(11:43:19 AM) <b>bradass87:</b> my passport had expired though... so i had to travel overnight to london<br>
(11:44:11 AM) <b>bradass87:</b> i stayed at a hostel in the kings cross area overnight, and left to go to hyde park [where all the embassies are]<br>
(11:45:13 AM) <b>bradass87:</b> what really sucked though, was that as i entered the station... all hell started breaking loose... there was a horrific boom, screaming, sirens, and thick black smoke... it was july 7th 2005...<br>
(11:45:39 AM) <b>bradass87:</b> i panicked and went by foot, not knowing what was going on<br>
(11:45:47 AM) <b>info@adrianlamo.com:</b> sorry for latency ... things demanding my attention are exceeding my capacity to allocate resources, forcing me to double-book mentally, and that only scales so far.<br>
(11:46:04 AM) <b>bradass87:</b> its ok, im just venting a lot<br>
(11:47:28 AM) <b>bradass87:</b> im very isolated atm... lost all of my emotional support channels... family, boyfriend, trusting colleagues... im a mess<br>
(11:49:02 AM) <b>bradass87:</b> im in the desert, with a bunch of hyper-masculine trigger happy ignorant rednecks as neighbors... and the only safe place i seem to have is this satellite internet connection<br>
(11:49:51 AM) <b>bradass87:</b> and i already got myself into minor trouble, revealing my uncertainty over my gender identity... which is causing me to lose this job... and putting me in an awkward limbo<br>
(11:50:54 AM) <b>bradass87:</b> i wish it were as simple as “hey, go transition”... but i need to get paperwork sorted... financial stuff sorted... legal stuff... and im still deployed, so i have to redeploy back to the US and be outprocessed<br>
(11:52:09 AM) <b>bradass87:</b> i could be hanging out here in limbo as a super-intelligent, awkwardly effeminate supply guy [pick up these boxes and move them] for up to two months<br>
(11:52:23 AM) <b>bradass87:</b> at the very least, i managed to keep my security clearance [so far]<br>
(11:57:49 AM) <b>bradass87:</b> im sorry, im a total mess right now... :’(<br>
(11:58:33 AM) <b>bradass87:</b> and little does anyone know, but among this “visible” mess, theres the mess i created that no-one knows about yet<br>
(11:58:59 AM) <b>bradass87:</b> i have no idea what im doing right now<br>
(12:00:34 PM) <b>bradass87:</b> im so sorry<br>
(12:04:36 PM) <b>info@adrianlamo.com:</b> don’t be sorry, just give me a chance to read :P<br>
(12:06:18 PM) <b>info@adrianlamo.com:</b> how did this not come up as an issue in your background check? I’m guessing you have an S and not a TS.<br>
(12:06:29 PM) <b>bradass87:</b> TS/SCI<br>
(12:06:47 PM) <b>bradass87:</b> i enlisted in 2007... height of iraq war, no-one double checked much<br>
(12:07:06 PM) <b>info@adrianlamo.com:</b> Well, hell, if you made it in, maybe I should reconsider the offer I got from what used to be JTF-CNO.<br>
(12:07:09 PM) <b>bradass87:</b> background checks are jokes anyway<br>
(12:07:23 PM) <b>info@adrianlamo.com:</b> It’s hit-or-miss.<br>
(12:08:04 PM) <b>bradass87:</b> JTF-CNO wouldn’t have been worth it<br>
(12:10:21 PM) <b>bradass87:</b> they are a mess, and wholly dependent on frivolous network security contracts and physically securing networks<br>
(12:10:58 PM) <b>info@adrianlamo.com:</b> I doubt they’d hire me to dick around with that.<br>
(12:11:03 PM) <b>bradass87:</b> i’ve been penetrating *.smil.mil networks for over a year<br>
(12:11:21 PM) <b>bradass87:</b> as well as *.sgov.gov<br>
(12:11:49 PM) <b>bradass87:</b> ive created a massive mess<br>
(12:12:30 PM) <b>bradass87:</b> and no-one has a clue, because 95% of efforts are on physical security of classified networks... and managing OPSEC on unclassified networks<br>
(12:12:46 PM) <b>info@adrianlamo.com:</b> Want to go to the press? :)<br>
(12:12:51 PM) <b>bradass87:</b> no<br>
(12:12:59 PM) <b>bradass87:</b> theres an issue with that<br>
(12:13:01 PM) <b>info@adrianlamo.com:</b> open offer.<br>
</ins><ins class="notbywired">(12:15:11 PM) <b>bradass87:</b> hypothetical question: if you had free reign over classified networks for long periods of time... say, 8-9 months... and you saw </ins><ins class="wiredquote-0606">incredible things, awful things... things that belonged in the public domain, and not on some server stored in a dark room in Washington DC</ins><ins class="notbywired">... what would you do?<br>
(12:16:38 PM) <b>bradass87:</b> or Guantanamo, Bagram, Bucca, Taji, VBC for that matter...<br>
(12:17:47 PM) <b>bradass87:</b> things that would have an impact on 6.7 billion people<br>
(12:21:24 PM) <b>bradass87:</b> say... a database of half a million events during the iraq war... from 2004 to 2009... with reports, date time groups, lat-lon locations, casualty figures... ? or 260,000 state department cables from embassies and consulates all over the world, explaining how the first world exploits the third, in detail, from an internal perspective?<br>
(12:22:49 PM) <b>bradass87:</b> the air-gap has been penetrated... =L<br>
(12:23:19 PM) <b>info@adrianlamo.com:</b> how so?<br>
(12:26:09 PM) <b>info@adrianlamo.com:</b> yt?<br>
(12:26:09 PM) <b>bradass87:</b> lets just say *someone* i know intimately well, has been penetrating US classified networks, mining data like the ones described... and been transferring that data from the classified networks over the “air gap” onto a commercial network computer... sorting the data, compressing it, encrypting it, and uploading it to a crazy white haired aussie who can’t seem to stay in one country very long =L<br>
(12:27:13 PM) <b>bradass87:</b> im here<br>
(12:27:24 PM) <b>info@adrianlamo.com:</b> Depends. What are the particulars?<br>
(12:28:19 PM) <b>bradass87:</b> theres substantial lag i think<br>
(12:29:52 PM) <b>info@adrianlamo.com:</b> I don’t understand.<br>
(12:30:13 PM) <b>bradass87:</b> what was the last message you recieved?<br>
(12:30:47 PM) <b>info@adrianlamo.com:</b> (12:28:19 PM) <b>bradass87:</b> theres substantial lag i think<br>
(12:30:56 PM) <b>bradass87:</b> before that<br>
(12:31:09 PM) <b>info@adrianlamo.com:</b> (12:26:09 PM) bradass87: lets just say *someone* i know intimately well, has been penetrating US classified networks, mining data like the ones described... and been transferring that data from the classified networks over the “air gap” onto a commercial network computer... sorting the data, compressing it, encrypting it, and uploading it to a crazy white haired aussie who can’t seem to stay in one country very long =L (12:27:13 PM) bradass87: im here (12:27:24 PM) info@adrianlamo.com: Depends. What are the particulars?<br>
(12:31:43 PM) <b>bradass87:</b> crazy white haired dude = Julian Assange<br>
(12:33:05 PM) <b>bradass87:</b> in other words... ive made a huge mess :’</ins><ins>(</ins><br>
<ins class="notbywired">(12:35:17 PM) <b>bradass87:</b> im sorry... im just emotionally fractured<br>
(12:39:12 PM) <b>bradass87:</b> im a total mess<br>
(12:41:54 PM) <b>bradass87:</b> </ins><ins class="wiredquote-0610">i think im in more potential heat than you ever were</ins><ins class="notbywired"><br>
(12:41:54 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(12:45:59 PM) <b>info@adrianlamo.com:</b> not mandatorily<br>
(12:46:08 PM) <b>info@adrianlamo.com:</b> there are always outs<br>
(12:46:17 PM) <b>info@adrianlamo.com:</b> how long have you helped WIkileaks?<br>
(12:49:09 PM) <b>bradass87:</b> since they released the 9/11 “pager messages”<br>
(12:49:38 PM) <b>bradass87:</b> i immediately recognized that they were from an NSA database, and i felt comfortable enough to come forward<br>
(12:50:20 PM) <b>bradass87:</b> so... right after thanksgiving timeframe of 2009<br>
</ins><ins class="wiredquote-0606">(12:52:33 PM) <b>bradass87:</b> Hilary Clinton, and several thousand diplomats around the world are going to have a heart attack when they wake up one morning, and finds an entire repository of classified foreign policy is available, in searchable format to the public</ins><ins class="notbywired">... =L<br>
(12:53:41 PM) <b>bradass87:</b> s/Hilary/Hillary<br>
(12:54:47 PM) <b>info@adrianlamo.com:</b> What sort of content?<br>
(12:56:36 PM) <b>info@adrianlamo.com:</b> brb cigarette<br>
(12:56:43 PM) <b>info@adrianlamo.com:</b> keep typing &lt;3<br>
(12:59:41 PM) <b>bradass87:</b> uhm... crazy, </ins><ins class="wiredquote-0606">almost criminal political backdealings.</ins><ins class="notbywired">.. the non-PR-versions of world events and crises... uhm... all kinds of stuff like everything from the buildup to the Iraq War during Powell, to what the actual content of “aid packages” is: for instance, PR that the US is sending aid to pakistan includes funding for water/food/clothing... that much is true, it includes that, but the other 85% of it is for F-16 fighters and munitions to aid in the Afghanistan effort, so the US can call in Pakistanis to do aerial bombing instead of americans potentially killing civilians and creating a PR crisis<br>
(1:00:57 PM) <b>bradass87:</b> theres so much... it affects everybody on earth... </ins><ins class="wiredquote-0606">everywhere there’s a US post</ins><ins class="notbywired">... </ins><ins class="wiredquote-0606">there’s a diplomatic scandal that will be revealed</ins><ins class="notbywired">... Iceland, the Vatican, Spain, Brazil, Madascar, if its a country, and its recognized by the US as a country, its got dirt on it<br>
(1:01:27 PM) <b>bradass87:</b> i need one myself<br>
(1:10:38 PM) <b>bradass87:</b> </ins><ins class="wiredquote-0606">its open diplomacy... world-wide anarchy in CSV format... its Climategate with a global scope, and breathtaking depth... its beautiful, and horrifying</ins><ins class="notbywired">...<br>
(1:10:38 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(1:11:54 PM) <b>bradass87:</b> and... its important that it gets out... i feel, for some bizarre reason<br>
(1:12:02 PM) <b>bradass87:</b> it might actually change something<br>
(1:13:10 PM) <b>bradass87:</b> i just... dont wish to be a part of it... at least not now... im not ready... i wouldn’t mind going to prison for the rest of my life, or being executed so much, if it wasn’t for the possibility of having pictures of me... plastered all over the world press... </ins><del>[...]</del><ins>as boy...</ins><br>
<ins class="notbywired">(1:14:11 PM) <b>bradass87:</b> i’ve totally lost my mind... i make no sense... the CPU is not made for this motherboard...<br>
</ins><ins>(1:14:42 PM) <b>bradass87:</b> s/as boy/as a boy<br>
</ins><ins class="notbywired">(1:30:32 PM) <b>bradass87:</b> &gt;sigh&lt;<br>
(1:31:40 PM) <b>bradass87:</b> i just wanted enough time to figure myself out... to be myself... and be running around all the time, trying to meet someone else’s expectations<br>
(1:32:01 PM) <b>bradass87:</b> *and not be<br>
(1:33:03 PM) <b>bradass87:</b> im just kind of drifting now...<br>
(1:34:11 PM) <b>bradass87:</b> waiting to redeploy to the US, be discharged... </ins><del>[...]</del><ins>and figure out how on earth im going to transition<br>
</ins><ins class="notbywired">(1:34:45 PM) <b>bradass87:</b> all while witnessing the world freak out as its most intimate secrets are revealed<br>
(1:35:06 PM) <b>bradass87:</b> its such an awkward place to be in, emotionally and psychologically<br>
(1:35:06 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
</ins>(1:39:03 PM) <b>bradass87:</b> i cant believe what im confessing to you :’(<br>
(1:40:20 PM) <b>bradass87:</b> ive been so isolated so long... i just wanted to be nice, and live a normal life... but events kept forcing me to figure out ways to survive... smart enough to know whats going on, but helpless to do anything... no-one took any notice of me<br>
(1:40:43 PM) <b>bradass87:</b> :’(<br>
(1:43:51 PM) <b>info@adrianlamo.com:</b> back<br>
(1:43:59 PM) <b>bradass87:</b> im self medicating like crazy when im not toiling in the supply office (my new location, since im being discharged, im not offically intel anymore)<br>
(1:44:11 PM) <b>bradass87:</b> you missed a lot...<br>
(1:45:00 PM) <b>info@adrianlamo.com:</b> what kind of scandal?<br>
(1:45:16 PM) <b>bradass87:</b> hundreds of them<br>
(1:45:40 PM) <b>info@adrianlamo.com:</b> like what? I’m genuinely curious about details.<br>
(1:46:01 PM) <b>bradass87:</b> i dont know... theres so many... i dont have the original material anymore<br>
(1:46:18 PM) <b>bradass87:</b> uhmm... the Holy See and its position on the Vatican sex scandals<br>
(1:46:26 PM) <b>info@adrianlamo.com:</b> play it by ear<br>
(1:46:29 PM) <b>bradass87:</b> the broiling one in Germany<br>
(1:47:36 PM) <b>bradass87:</b> im sorry, there’s so many... its impossible for any one human to read all quarter-million... and not feel overwhelmed... and possibly desensitized<br>
(1:48:20 PM) <b>bradass87:</b> the scope is so broad... and yet the depth so rich<br>
(1:48:50 PM) <b>info@adrianlamo.com:</b> give me some bona fides ... yanno? any specifics.<br>
(1:49:40 PM) <b>bradass87:</b> this one was a test: Classified cable from US Embassy Reykjavik on Icesave dated 13 Jan 2010<br>
(1:50:30 PM) <b>bradass87:</b> the result of that one was that the icelandic ambassador to the US was recalled, and fired<br>
(1:51:02 PM) <b>bradass87:</b> thats just one cable...<br>
(1:51:14 PM) <b>info@adrianlamo.com:</b> Anything unreleased?<br>
(1:51:25 PM) <b>bradass87:</b> i’d have to ask assange<br>
(1:51:53 PM) <b>bradass87:</b> i zerofilled the original<br>
(1:51:54 PM) <b>info@adrianlamo.com:</b> why do you answer to him?<br>
(1:52:29 PM) <b>bradass87:</b> i dont... i just want the material out there... i dont want to be a part of it<br>
<ins class="notbywired">(1:52:54 PM) <b>info@adrianlamo.com:</b> i’ve been considering helping wikileaks with opsec<br>
(1:53:13 PM) <b>bradass87:</b> they have decent opsec... im obviously violating it<br>
(1:53:34 PM) <b>bradass87:</b> im a wreck<br>
(1:53:47 PM) <b>bradass87:</b> im a total fucking wreck right now<br>
</ins><ins>(1:54:04 PM) <b>info@adrianlamo.com:</b> not really. 2600 is an ally of wikileaks.<br>
(1:54:10 PM) <b>info@adrianlamo.com:</b> how old are you?<br>
(1:54:15 PM) <b>bradass87:</b> 22<br>
(1:54:55 PM) <b>bradass87:</b> but im not a source for you... im talking to you as someone who needs moral and emotional fucking support<br>
(1:55:02 PM) <b>bradass87:</b> :’(<br>
(1:55:10 PM) <b>info@adrianlamo.com:</b> i told you, none of this is for print<br>
(1:55:16 PM) <b>bradass87:</b> ok, ok<br>
(1:55:19 PM) <b>info@adrianlamo.com:</b> i want to know who i’m supporting<br>
(1:55:25 PM) <b>info@adrianlamo.com:</b> no names as yet<br>
(1:55:26 PM) <b>bradass87:</b> im flipping out...<br>
(1:55:32 PM) <b>info@adrianlamo.com:</b> security.<br>
(1:55:43 PM) <b>bradass87:</b> huh?<br>
(1:55:51 PM) <b>info@adrianlamo.com:</b> re. no names as yet.<br>
(1:55:56 PM) <b>info@adrianlamo.com:</b> except brad, i assume.<br>
(1:56:23 PM) <b>bradass87:</b> ive already sent you full name in emails...<br>
(1:56:43 PM) <b>info@adrianlamo.com:</b> oh! you’re the PGP guy<br>
(1:56:52 PM) <b>bradass87:</b> yeah, im sorry<br>
(1:56:57 PM) <b>info@adrianlamo.com:</b> i’m an idiot<br>
(1:57:33 PM) <b>bradass87:</b> im pretty reckless at this point<br>
(1:57:53 PM) <b>bradass87:</b> but im trying not to end up with 5.56mm rounds in my forehead...<br>
(1:58:38 PM) <b>bradass87:</b> that i fired..<br>
(2:00:18 PM) <b>bradass87:</b> im not lying when i say im totally out of it right now<br>
(2:01:02 PM) <b>bradass87:</b> ok, so... im not suicidal quite yet...<br>
(2:01:14 PM) <b>bradass87:</b> but im pretty desperate for some non-isolation<br>
(2:02:34 PM) <b>bradass87:</b> idk anymore<br>
</ins>(2:04:29 PM) <b>bradass87:</b> im a source, not quite a volunteer<br>
(2:05:38 PM) <b>bradass87:</b> i mean, im a high profile source... and i’ve developed a relationship with assange... but i dont know much more than what he tells me, which is very little<br>
(2:05:58 PM) <b>bradass87:</b> it took me four months to confirm that the person i was communicating was in fact assange<br>
(2:10:01 PM) <b>info@adrianlamo.com:</b> how’d you do that?<br>
(2:12:45 PM) <b>bradass87:</b> I gathered more info when i questioned him whenever he was being tailed in Sweden by State Department officials... i was trying to figure out who was following him... and why... and he was telling me stories of other times he’s been followed... and they matched up with the ones he’s said publicly<br>
(2:14:28 PM) <b>info@adrianlamo.com:</b> did that bear out? the surveillance?<br>
(2:14:46 PM) <b>bradass87:</b> based on the description he gave me, I assessed it was the Northern Europe Diplomatic Security Team... trying to figure out how he got the Reykjavik cable...<br>
(2:15:57 PM) <b>bradass87:</b> they also caught wind that he had a video... of the Gharani airstrike in afghanistan, which he has, but hasn’t decrypted yet... the production team was actually working on the Baghdad strike though, which was never really encrypted<br>
(2:16:22 PM) <b>bradass87:</b> he’s got the whole 15-6 for that incident... so it wont just be video with no context<br>
(2:16:55 PM) <b>bradass87:</b> but its not nearly as damning... it was an awful incident, but nothing like the baghdad one<br>
(2:17:59 PM) <b>bradass87:</b> the investigating officers left the material unprotected, sitting in a directory on a centcom.smil.mil<br>
(2:18:03 PM) <b>bradass87:</b> server<br>
(2:18:56 PM) <b>bradass87:</b> but they did zip up the files, aes-256, with an excellent password... so afaik it hasn’t been broken yet<br>
(2:19:12 PM) <b>bradass87:</b> 14+ chars...<br>
(2:19:37 PM) <b>bradass87:</b> i can’t believe what im telling you =L<br>
<ins>(2:19:50 PM) <b>bradass87:</b> ive had too many chinks in my armor :’(<br>
(2:20:52 PM) <b>bradass87:</b> im a broken soul =L<br>
(2:21:22 PM) <b>bradass87:</b> i need to go eat, ill brb<br>
(2:21:26 PM) <b>info@adrianlamo.com:</b> *hug*<br>
(2:21:39 PM) <b>bradass87:</b> thank you :’( it means a lot<br>
(2:54:21 PM) <b>bradass87:</b> im sorry<br>
(2:54:21 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(2:55:00 PM) <b>bradass87:</b> im just... ugh<br>
</ins><ins class="notbywired">(2:56:34 PM) <b>bradass87:</b> my family is non-supportive... </ins><ins>my boyfriend ditched me without telling me...</ins><ins class="notbywired"> im losing my job... losing my career options... i dont have much more except for this laptop, some books, and a hell of a story<br>
</ins><ins>(2:57:25 PM) <b>bradass87:</b> ...im honestly, scared<br>
(2:57:32 PM) <b>bradass87:</b> and i have no-one i trust<br>
(2:58:21 PM) <b>bradass87:</b> i need a lot of help...<br>
(2:58:48 PM) <b>bradass87:</b> i dont know if i can rebuild from here...<br>
(3:00:43 PM) <b>info@adrianlamo.com:</b> you can always rebuild.<br>
(3:01:03 PM) <b>bradass87:</b> yes, but i cant KEEP rebuilding all the damn time... im exhausted<br>
</ins><ins class="notbywired">(3:01:26 PM) <b>bradass87:</b> i didnt get into my bout with homelessness across the country in ‘06<br>
(3:01:45 PM) <b>bradass87:</b> i drifted from oklahoma city, to tulsa, to chicago, and finally landed at my aunt’s house in DC<br>
(3:02:29 PM) <b>bradass87:</b> im exhausted... in desperation to get somewhere in life... i joined the army... and that’s proven to be a disaster now<br>
</ins><ins>(3:02:49 PM) <b>bradass87:</b> i’ve done a lot of random stuff, that no-one knows about...<br>
(3:03:09 PM) <b>bradass87:</b> its just such a disconnect between myself, and what i know... and what people see<br>
</ins><ins class="notbywired">(3:04:57 PM) <b>bradass87:</b> and now i’m quite possibly on the verge of being the most notorious “hacktivist” or whatever you want to call it... its all a big mess i’ve created.</ins><ins>.. im sorry, adrian...<br>
(3:05:51 PM) <b>bradass87:</b> im pouring my heart out to someone i’ve never met, and i dont exactly have a lot of proof of anything<br>
(3:05:59 PM) <b>bradass87:</b> im shattered<br>
(3:06:47 PM) <b>bradass87:</b> im so exhausted :’(<br>
(3:07:10 PM) <b>bradass87:</b> im a real downer...<br>
(3:11:13 PM) <b>info@adrianlamo.com:</b> no apologies needed<br>
(3:12:00 PM) <b>bradass87:</b> &gt;gulp&lt;<br>
(3:12:34 PM) <b>bradass87:</b> i wish i could explain the pain<br>
(3:12:39 PM) <b>info@adrianlamo.com:</b> are you on Facebook?<br>
(3:12:56 PM) <b>info@adrianlamo.com:</b> As an aside, are you concerned about prosecution?<br>
(3:13:02 PM) <b>bradass87:</b> sort of... you cant find me<br>
(3:13:15 PM) <b>info@adrianlamo.com:</b> Your MICE seems to be ideology.<br>
(3:14:37 PM) <b>info@adrianlamo.com:</b> I can’t find a SPC in 2BCT 10MTN S2?<br>
(3:15:14 PM) <b>bradass87:</b> AKO?<br>
(3:15:39 PM) <b>info@adrianlamo.com:</b> Nope.<br>
(3:16:06 PM) <b>bradass87:</b> http://www.us.army.mil/ login: first.last<br>
(3:16:45 PM) <b>bradass87:</b> pass: [redacted] [no spaces]<br>
(3:17:06 PM) <b>info@adrianlamo.com:</b> wanna sponsor me for an AKO account? I used to have one ;&gt;<br>
(3:17:14 PM) <b>bradass87:</b> sure<br>
(3:17:32 PM) <b>bradass87:</b> use mine, its not really of any use to me right now<br>
(3:17:47 PM) <b>info@adrianlamo.com:</b> negatory<br>
(3:17:48 PM) <b>bradass87:</b> sorry “! @ #”<br>
(3:18:05 PM) <b>info@adrianlamo.com:</b> i just wanted adrian.lamo@us.army.mil back<br>
(3:18:24 PM) <b>bradass87:</b> ok<br>
(3:18:59 PM) <b>info@adrianlamo.com:</b> remember, finding stuff is what I do. and curiosity is my game.<br>
(3:19:08 PM) <b>bradass87:</b> i know<br>
(3:19:23 PM) <b>info@adrianlamo.com:</b> including your personal ad from 3 years ago.<br>
(3:19:32 PM) <b>bradass87:</b> which one?<br>
(3:19:50 PM) <b>info@adrianlamo.com:</b> i closed the window; it wasn’t relevant<br>
(3:20:13 PM) <b>bradass87:</b> oh... via bradass87... i dont know how that one got set up...<br>
(3:20:14 PM) <b>info@adrianlamo.com:</b> sadly, it lacked a photo<br>
(3:20:33 PM) <b>bradass87:</b> its from some kind of weird fetish site...<br>
(3:20:37 PM) <b>bradass87:</b> they wouldn’t let me delete it<br>
(3:21:07 PM) <b>bradass87:</b> im pretty ghostly... interwebbies-wise<br>
(3:21:43 PM) <b>bradass87:</b> is there a public facebook i can add you from?<br>
(3:22:59 PM) <b>bradass87:</b> wow, xanga... didnt know i had a xanga account<br>
(3:23:15 PM) <b>info@adrianlamo.com:</b> what do you mean re. facebook<br>
(3:24:06 PM) <b>bradass87:</b> mine is not public... you must be a friend to see it... or a friend of a friend to even know it exists<br>
(3:24:23 PM) <b>info@adrianlamo.com:</b> facebook.com/felon<br>
(3:24:54 PM) <b>bradass87:</b> requested<br>
(3:25:41 PM) <b>bradass87:</b> god that pacman thing is starting to get annoying<br>
(3:26:14 PM) <b>bradass87:</b> enjoyed it at first, but now everytime i open a new browser window... whoo-whoo-whoo-whoo-whoo<br>
(3:26:53 PM) <b>bradass87:</b> let me make more info available to you<br>
(3:27:00 PM) <b>bradass87:</b> hold on, need change my privacy settings<br>
(3:28:10 PM) <b>info@adrianlamo.com:</b> you’re kinda cute.<br>
(3:28:44 PM) <b>bradass87:</b> refresh, you should be able to see more... check to see if you can see more photo albums<br>
(3:29:33 PM) <b>bradass87:</b> http://sphotos.ak.fbcdn.net/hphotos-ak-snc3/hs024.snc3/11156_220539393205_642858205_4368726_2680909_n.jpg<br>
(3:29:46 PM) <b>bradass87:</b> one of the few times you will ever see the inside of a SCIF<br>
(3:30:09 PM) <b>bradass87:</b> the map in the background is classified SECRET//REL TO USA, MCFI<br>
(3:31:11 PM) <b>bradass87:</b> behind the cabinet, with the blue bucket on top... is the entrance to the SIGINT section<br>
(3:31:42 PM) <b>bradass87:</b> is where they process all the recorded phone data from towers in all of eastern baghdad<br>
(3:32:27 PM) <b>bradass87:</b> interrogator chick on top right corner<br>
(3:33:04 PM) <b>bradass87:</b> you can see me slowly descending spiritually in the wall posts<br>
(3:35:09 PM) <b>bradass87:</b> i cant really seem to define my ideology<br>
(3:36:07 PM) <b>info@adrianlamo.com:</b> You already have my most permissive privacy settings.<br>
(3:36:26 PM) <b>bradass87:</b> you can see all of my albums?<br>
(3:38:39 PM) <b>bradass87:</b> we have two mutual friends, how interesting<br>
(3:40:08 PM) <b>bradass87:</b> small world<br>
(3:41:39 PM) <b>bradass87:</b> &gt;sigh&lt;<br>
(3:41:51 PM) <b>bradass87:</b> lauren your “ex” ?<br>
(3:42:15 PM) <b>bradass87:</b> tyler watkins would be mine... fucking ditched me<br>
(3:42:30 PM) <b>bradass87:</b> im still utterly flabberghasted<br>
(3:43:13 PM) <b>bradass87:</b> i dont know... i cant seem to hold a relationship... i’ve got so much baggage<br>
(3:45:04 PM) <b>bradass87:</b> im all mixed up<br>
(3:46:14 PM) <b>bradass87:</b> lost a lot... in a short period of time<br>
(3:48:20 PM) <b>bradass87:</b> im a mess, huh<br>
(3:49:41 PM) <b>info@adrianlamo.com:</b> i’m familiar with loss<br>
(3:49:52 PM) <b>info@adrianlamo.com:</b> lauren’s in AZ<br>
(3:50:36 PM) <b>info@adrianlamo.com:</b> was that a yay or nay on the AKO sponsorship, or does your acc’t have that ability?<br>
(3:51:31 PM) <b>bradass87:</b> cant seem to do it without confirmation of spouse anymore... seems to be no way around it... also, you’d be booted out by the time i get discharged<br>
(3:55:06 PM) <b>bradass87:</b> i dont know how im going to break the news to everyone...<br>
(3:56:16 PM) <b>bradass87:</b> how would you rate the ethics of my situation?<br>
(4:03:06 PM) <b>bradass87:</b> ugh, im a mess<br>
(4:07:14 PM) <b>bradass87:</b> what ideology do i seem to be following?<br>
(4:16:28 PM) <b>bradass87:</b> :sigh:<br>
(4:16:34 PM) <b>bradass87:</b> *sigh*<br>
(4:28:34 PM) <b>bradass87:</b> i’ll work on the ako tomorrow... its getting awfully late... need sleep<br>
(4:54:44 PM) <b>info@adrianlamo.com:</b> sorry ... i’m just swamped today. i’ll be more talkative in the future.<br>
(4:55:16 PM) <b>info@adrianlamo.com:</b> keep your chin up. for me. *re-hug*
</ins>
<div class="date" id="date20100523"><a href="#date20100523">&#xA7;&nbsp;</a>May 23, 2010</div>
<ins>(7:18:03 AM) <b>bradass87:</b> The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(7:19:05 AM) Unverified conversation with bradass87 started.<br>
</ins>(7:19:12 AM) <b>info@adrianlamo.com:</b> hey you<br>
(7:19:19 AM) <b>info@adrianlamo.com:</b> resend?<br>
(7:19:19 AM) <b>bradass87:</b> whats up?<br>
(7:19:29 AM) <b>bradass87:</b> i just said hello<br>
(7:19:46 AM) <b>info@adrianlamo.com:</b> waking up. got up about an hour ago, 0615.<br>
(7:20:10 AM) <b>bradass87:</b> heh, the evening is still young here<br>
(7:20:26 AM) <b>info@adrianlamo.com:</b> how’re you feeling today?<br>
(7:20:37 AM) <b>bradass87:</b> im feeling a little better...<br>
(7:20:52 AM) <b>bradass87:</b> i had a lot on my mind, keeping to myself<br>
(7:22:18 AM) <b>info@adrianlamo.com:</b> anything new & exciting?<br>
(7:24:21 AM) <b>bradass87:</b> no, was outside in the sun all day... 110 degrees F, doing various details for a visiting band and some college team’s cheerleaders...<br>
(7:24:43 AM) <b>info@adrianlamo.com:</b> cheerleaders.<br>
(7:24:46 AM) <b>bradass87:</b> ran a barbecue... but no-one showed up... threw a lot of food away<br>
(7:25:20 AM) <b>bradass87:</b> yes, football cheerleaders... visiting on off season... apart of Morale Welfare and Recreation (MWR) projects<br>
(7:25:39 AM) <b>info@adrianlamo.com:</b> *sigh*<br>
(7:26:01 AM) <b>bradass87:</b> &gt;shrug&lt;<br>
(7:26:37 AM) <b>bradass87:</b> im sunburned... and smell like charcoal, sweat, and sunscreen... thats about all thats new<br>
(7:26:47 AM) <b>info@adrianlamo.com:</b> Is there a Baghdad 2600 meeting? ;&gt;<br>
(7:28:04 AM) <b>bradass87:</b> there’s only one other person im aware of that actually knows anything about computer security... he’s a SIGINT analyst, of course<br>
(7:28:41 AM) <b>info@adrianlamo.com:</b> Is he the other one who pokes around t he network?<br>
(7:29:26 AM) <b>bradass87:</b> no... afaik, he doesn’t play around with classified networks... but im sure he’s capable<br>
(7:30:09 AM) <b>info@adrianlamo.com:</b> then it stands to reason that you have at least 3 people who have some infosec knowledge<br>
(7:31:15 AM) <b>bradass87:</b> im not quite sure what you’re saying<br>
(7:31:23 AM) <b>bradass87:</b> infosec knowledge of what?<br>
(7:31:29 AM) <b>bradass87:</b> the networks?<br>
(7:32:13 AM) <b>bradass87:</b> i know a lot of computer security people<br>
(7:32:44 AM) <b>info@adrianlamo.com:</b> i mean, in a way that would lend itself to a meeting.<br>
(7:33:33 AM) <b>info@adrianlamo.com:</b> i’m writing a message trying to tie meetings together globally with a sampling of only ~3000 people to work with and get to go out and evangelize, so i have it on the brain<br>
(7:33:50 AM) <b>bradass87:</b> not really... different types of people... know how to, but dont<br>
(7:34:33 AM) <b>bradass87:</b> you don’t want these people having a meeting<br>
(7:34:48 AM) <b>bradass87:</b> though... i guess you do<br>
<ins>(7:35:37 AM) <b>bradass87:</b> other person knows a lot about phones... how to tap cellular phones (its his job, after all)<br>
(7:35:56 AM) <b>bradass87:</b> PROPHET team<br>
(7:36:22 AM) <b>bradass87:</b> http://www.globalsecurity.org/intell/systems/prophet.htm<br>
(7:36:47 AM) <b>info@adrianlamo.com:</b> Can they do CDMA or GSM over-the-air vs. at the switch?<br>
(7:37:07 AM) <b>bradass87:</b> both<br>
(7:37:16 AM) <b>bradass87:</b> v3 as well<br>
(7:37:48 AM) <b>bradass87:</b> over-the-air and at switches and towers...<br>
(7:38:06 AM) <b>bradass87:</b> redundancy for locational refinement<br>
(7:38:14 AM) <b>info@adrianlamo.com:</b> I assume the same could be done in the U.S.<br>
(7:38:37 AM) <b>bradass87:</b> of course<br>
(7:39:14 AM) <b>info@adrianlamo.com:</b> Too bad Philip Agee died. You and he would have fun conversations.<br>
(7:39:43 AM) <b>bradass87:</b> well, im not an expert in SIGINT... im just familiar<br>
(7:40:06 AM) <b>info@adrianlamo.com:</b> Neither was he. He just didn’t like what he saw in the course of his work.<br>
(7:40:11 AM) <b>info@adrianlamo.com:</b> And wrote about it.<br>
(7:40:43 AM) <b>info@adrianlamo.com:</b> “Inside the Company” – followed by “On the Run”, predictably.<br>
(7:40:56 AM) <b>bradass87:</b> i know that approximately 85-90% of global transmissions are sifted through by NSA... but vast majority is noise... so its getting harder and harder for them to track anything down...<br>
(7:41:31 AM) <b>bradass87:</b> its like finding a needle in a haystack...<br>
(7:42:11 AM) <b>info@adrianlamo.com:</b> Especially the way I speak Spanish. Rapidfire, few pauses between words :p<br>
(7:43:11 AM) <b>bradass87:</b> heh<br>
(7:43:41 AM) <b>info@adrianlamo.com:</b> Colombians in Colombia think all Americans are CIA. It’s kind of funny.<br>
(7:44:01 AM) <b>bradass87:</b> but once a single piece of information is found... then the databases can be sifted and sifted and sifted some more, for refinement, so other intelligence functions can get in the act<br>
(7:44:09 AM) <b>info@adrianlamo.com:</b> Fortunately, there are plenty of Colombians with my skin tone.<br>
(7:44:20 AM) <b>bradass87:</b> &gt;nod&lt;<br>
(7:45:52 AM) <b>bradass87:</b> im not all that paranoid about NSA / SIGINT services... you just have to be OPSEC savvy, and you’re all good<br>
(7:46:27 AM) <b>bradass87:</b> and FISA actually does come in very handy<br>
(7:46:46 AM) <b>bradass87:</b> though, its frequently overlooked<br>
(7:47:36 AM) <b>bradass87:</b> i.e.: they’ll collect signal information, to refine other intel sources and try to collect evidence...<br>
(7:47:57 AM) <b>bradass87:</b> erasing the signal data<br>
(7:48:11 AM) <b>bradass87:</b> since its not legally “evidence”<br>
(7:49:38 AM) <b>bradass87:</b> and yes, illegal wiretaps are used in coordination between NSA and FBI... though its not seen as illegal, because often the data is only used to give leads<br>
(7:49:42 AM) <b>bradass87:</b> and not evidence<br>
(7:50:49 AM) <b>info@adrianlamo.com:</b> *nod*<br>
(7:50:52 AM) <b>bradass87:</b> one of the reasons assange uses his rubberhose plausibly deniable whole-disk encryption setup<br>
(7:51:46 AM) <b>bradass87:</b> i can see both sides of the whole illegal wiretap debate<br>
(7:52:17 AM) <b>bradass87:</b> it IS awfully useful in catching bad people... but innocent privacy IS violated...<br>
(7:52:37 AM) <b>bradass87:</b> but everyone does it now...<br>
(7:53:08 AM) <b>bradass87:</b> its an inevitability... thats my honest opinion<br>
(7:53:31 AM) <b>bradass87:</b> so, i encrypt as much as i can<br>
(7:54:31 AM) <b>info@adrianlamo.com:</b> how much encryption can be trusted?<br>
(7:54:38 AM) <b>info@adrianlamo.com:</b> say, is PGP secure? OTR?<br>
(7:55:13 AM) <b>bradass87:</b> depends... depends on the algorithm... depends on how safe you keep your private keys<br>
(7:55:26 AM) <b>bradass87:</b> DES / Triple DES... you’re doomed in minutes<br>
(7:55:46 AM) <b>bradass87:</b> AES variants... take brute force<br>
(7:56:06 AM) <b>bradass87:</b> days to weeks to break<br>
(7:56:24 AM) <b>bradass87:</b> its about securing the keys, using complex enough keys...<br>
(7:56:42 AM) <b>bradass87:</b> and sticking to Rijndael variants<br>
(7:57:15 AM) <b>info@adrianlamo.com:</b> Does keylength matter past 2048?<br>
(7:57:28 AM) <b>bradass87:</b> it can<br>
(7:58:06 AM) <b>bradass87:</b> RSA 1024 takes a few weeks... university of michigan finally broke it with a partial<br>
(7:59:00 AM) <b>bradass87:</b> 2048... never heard of it being broken publicly... NSA can feasibly do it, if they want to allocate national level “number-crunching” time to do it...<br>
(7:59:56 AM) <b>info@adrianlamo.com:</b> What about OTR?<br>
(8:00:33 AM) <b>bradass87:</b> OTR is good... but change fingerprints every few weeks<br>
(8:00:59 AM) <b>bradass87:</b> its not frequently used by terrorists... so... its not a priority to find a crack<br>
(8:01:25 AM) <b>bradass87:</b> the whole pidgin / adium learning curve has its advantage<br>
</ins>(8:01:30 AM) <b>info@adrianlamo.com:</b> Does Assange use AIM or other messaging services? I’d like to chat with him one of these days about opsec. My only credentials beyond intrusion are that the FBI never got my data or found me, before my negotiated surrender, but that’s something.<br>
(8:01:53 AM) <b>info@adrianlamo.com:</b> And my data was never recovered.<br>
(8:02:07 AM) <b>bradass87:</b> no he does not use AIM<br>
(8:02:37 AM) <b>info@adrianlamo.com:</b> How would I get ahold of him?<br>
(8:02:59 AM) <b>bradass87:</b> he would come to you<br>
(8:03:26 AM) <b>info@adrianlamo.com:</b> I’ve never failed to get ahold of someone.<br>
(8:03:29 AM) <b>bradass87:</b> he does use OTR though... but discusses nothing OPSEC<br>
(8:03:42 AM) <b>info@adrianlamo.com:</b> I cornered Ashcroft IRL, in the end.<br>
(8:04:19 AM) <b>bradass87:</b> he *might* use the ccc.de jabber server... but you didn’t hear that from me<br>
(8:04:33 AM) <b>info@adrianlamo.com:</b> gotcha<br>
(8:06:00 AM) <b>bradass87:</b> im going to grab some dinner, ttyl<br>
(8:06:18 AM) <b>info@adrianlamo.com:</b> http://www.facebook.com/photo.php?pid=31130826&id=704990<br>
(8:06:47 AM) <b>info@adrianlamo.com:</b> i didn’t pass security, either. or rather, i did ;><br>
(8:06:52 AM) <b>info@adrianlamo.com:</b> enjoy dinner.<br>
(8:06:55 AM) <b>info@adrianlamo.com:</b> twys.<br>
<div class="timelapse">Time lapse</div>
(9:12:38 AM) <b>bradass87:</b> bk<br>
<ins>(9:12:38 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
</ins>(9:22:54 AM) <b>bradass87:</b> interesting... marine uniform... illegal, but certainly easy<br>
(9:24:11 AM) <b>bradass87:</b> why ashcroft?<br>
(9:24:24 AM) <b>bradass87:</b> oh, nevermind... DoJ<br>
(9:24:29 AM) <b>bradass87:</b> &gt;yawn&lt;<br>
(9:26:52 AM) <b>bradass87:</b> im really not familiar at all with FBI stuff<br>
(9:27:04 AM) <b>bradass87:</b> americans have so many more rights than non-americans<br>
(9:31:42 AM) <b>bradass87:</b> its awful<br>
(9:46:11 AM) <b>info@adrianlamo.com:</b> Ashcroft´s DOJ tried to use the USA PATRIOT Act on me.<br>
(10:06:24 AM) <b>info@adrianlamo.com:</b> around?<br>
(10:12:34 AM) <b>bradass87:</b> yeah<br>
(10:12:57 AM) <b>info@adrianlamo.com:</b> are you baptist by any chance?<br>
(10:13:34 AM) <b>bradass87:</b> raised catholic... never believed a word of it<br>
(10:13:59 AM) <b>bradass87:</b> im godless... i guess i follow humanist values though<br>
(10:14:15 AM) <b>bradass87:</b> have custom dogtags that say “Humanist” <del>[...]</del><br>
<ins>(10:15:19 AM) <b>bradass87:</b> always been too intellectual, if not just plain queer, for religion<br>
(10:15:48 AM) <b>bradass87:</b> why?<br>
(10:17:15 AM) <b>info@adrianlamo.com:</b> regional religions in the U.S. – incorrect hunch<br>
(10:17:34 AM) <b>bradass87:</b> i suffered out there<br>
</ins>(10:17:56 AM) <b>bradass87:</b> i was the only non-religous person in town<br>
(10:18:17 AM) <b>bradass87:</b> more pews than people...<br>
(10:18:37 AM) <b>bradass87:</b> i understand them though<br>
(10:18:53 AM) <b>bradass87:</b> im not mean to them... they *really* don’t know<br>
(10:19:39 AM) <b>bradass87:</b> i politely disagree... but they are the ones who get uncomfortable when i make, very politely, good leading points...<br>
(10:20:48 AM) <b>bradass87:</b> (by leading points, i mean ask multiple questions, with obvious answers, then ask a question based on the answers from the previous questions that challenges their normal response to the same question)<br>
(10:21:26 AM) <b>bradass87:</b> [excellent example of this: http://www.youtube.com/watch?v=2yhN1IDLQjo]<br>
(10:28:21 AM) <b>bradass87:</b> new yorker is running 10k word article on wl.org on 30 may, btw<br>
<ins>(10:28:21 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
</ins>(10:33:07 AM) <b>info@adrianlamo.com:</b> one moment fone<br>
(10:33:30 AM) <b>bradass87:</b> (tracking device)<br>
(10:37:28 AM) <b>bradass87:</b> trust level increasing? [quantify]<br>
<ins>(10:58:30 AM) <b>bradass87:</b> http://sphotos.ak.fbcdn.net/hphotos-ak-snc3/hs005.snc3/11240_209778763205_642858205_4266300_6312600_n.jpg<br>
(10:58:30 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(11:09:27 AM) <b>bradass87:</b> :whistle:<br>
(11:09:27 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(11:16:39 AM) <b>bradass87:</b> here’s an awkward pic... i look so short -_- http://sphotos.ak.fbcdn.net/hphotos-ak-snc1/hs146.snc1/5413_150043228205_642858205_3563600_6825681_n.jpg<br>
(11:17:45 AM) <b>info@adrianlamo.com:</b> was on the phone. may have a gig copy-editing.<br>
(11:21:34 AM) <b>info@adrianlamo.com:</b> ironic, huh?<br>
(11:21:55 AM) <b>info@adrianlamo.com:</b> well, not ironic<br>
(11:21:57 AM) <b>info@adrianlamo.com:</b> just funny<br>
(11:22:14 AM) <b>info@adrianlamo.com:</b> all the things i could do, but i copy-edit<br>
(11:28:38 AM) <b>bradass87:</b> lol<br>
(11:28:38 AM) <b>bradass87:</b> not much different from my (previous?) job<br>
(11:28:42 AM) <b>bradass87:</b> take slides from subordinate battalions, change wording, improve spelling, replace battalion symbols with brigade symbols, disseminate throughout brigade and forward to division<br>
(11:29:12 AM) <b>bradass87:</b> leaves a computer savvy guy a lot of time to pry around<br>
(11:31:13 AM) <b>bradass87:</b> i dont know what im going to do now... =L<br>
(11:31:13 AM) <b>bradass87:</b> well, wait... obviously<br>
(11:31:17 AM) <b>bradass87:</b> i guess i could start electrolysis as soon im back in the states... even before im outprocessed<br>
(11:36:12 AM) <b>bradass87:</b> still gonna be weird watching the world change on the macro scale, while my life changes on the micro<br>
(11:36:12 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(11:36:12 AM) <b>bradass87:</b> never been good at the micro<br>
(12:12:01 PM) <b>bradass87:</b> fucking satellite internet :@<br>
(12:12:01 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(12:13:25 PM) <b>bradass87:</b> light dust storm... might go in and out of Cx<br>
(12:33:53 PM) <b>bradass87:</b> still there?<br>
(12:33:53 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(12:38:30 PM) <b>bradass87:</b> ping<br>
(1:08:40 PM) <b>bradass87:</b> ping<br>
(1:24:21 PM) <b>bradass87:</b> did you know it took NSA 6 months, and 50 people to figure out how to tap the iPhone<br>
(1:24:21 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I have more messages than resources allocatable to action them. Please be very patient.<br>
(1:26:16 PM) <b>bradass87:</b> they honestly didn’t know what was going on, because of the sudden format switch when AT&T made the contract<br>
(1:26:32 PM) <b>bradass87:</b> =P<br>
(1:27:42 PM) <b>bradass87:</b> [not 100% if thats true, but i've heard enough variations by NSA types to believe it]<br>
(1:27:46 PM) <b>bradass87:</b> *sure<br>
(1:35:13 PM) <b>bradass87:</b> ping<br>
(1:40:41 PM) <b>bradass87:</b> ping<br>
(1:41:29 PM) <b>bradass87:</b> [sorry, have a lot on my mind... i like talking]<br>
(1:55:28 PM) <b>bradass87:</b> &lt;– sleep [you can reply, ill check in morning]
</ins>
<div class="timelapse">Time lapse</div>
<ins>(12:24:04 PM) <b>bradass87:</b> hello again<br>
(12:24:04 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(12:24:15 PM) bradass87 has not been authenticated yet. You should authenticate this buddy.<br>
(12:24:15 PM) Unverified conversation with bradass87 started.<br>
(12:24:58 PM) <b>bradass87:</b> hello again<br>
(12:26:54 PM) <b>bradass87:</b> The New York Times
Published, January 20, 1919<br><br>
OPEN DIPLOMACY.<br><br>
“Open diplomacy” does not mean<br>
that every word said in preparing a<br>
treaty should be shouted to the whole<br>
world and submitted to all the mis-<br>
constructions that malevolence, folly,<br>
and evil ingenuity could put upon it.<br>
Open diplomacy is the opposite of se-<br>
cret diplomacy, which consisted in the<br>
underhand negotiation of treaties<br>
whose very existence was kept from<br>
the world. It consisted also in the<br>
modification of openly negotiated<br>
treaties by secret treaties by some<br>
of the Powers behind the backs of the<br>
others. It is against this kind of<br>
double dealing and secret dealing, the<br>
mother of wars, that the world<br>
protested. It has demanded the sub-<br>
stitution of open diplomacy for secret<br>
diplomacy. But open diplomacy does<br>
not turn a peace conference into a<br>
debating society.<br><br>
It would be reasonable for the<br>
newspaper correspondents at Ver-<br>
sailles to expect that the delicate work<br>
of reconciling divergent points of view<br>
on so tender a subject as national in-<br>
terests should be wholly conducted in<br>
their presence. The conferees, by re-<br>
serving the right of holding executive<br>
sessions while they admit the corre-<br>
spondants to open sessions, have gone<br>
as far as the needs of the public de-<br>
manned. The world has intrusted the<br>
Peace Conference with the work of<br>
preparing the treaty. It wishes to<br>
know what is done, and why it is<br>
done; but the sensible part of it, at<br>
any rate, has no desire to have spread<br>
before it all the heart-to-heart talks<br>
and turns of phrase of men perform-<br>
ing the gigantic task of reconciling<br>
national differences and coming to<br>
agreement. It wishes to give malice<br>
and anti-Ally propaganda as little as<br>
possible to distort and warp. It<br>
knows from four years’ experience<br>
what infinite possibilities are in<br>
that line.<br><br>
Copyright Â© The New York Times
</ins>
<div class="timelapse">Time lapse</div>
<ins>(01:58:40 PM) <b>bradass87:</b> hi<br>
(02:00:30 PM) <b>info@adrianlamo.com:</b> hey<br>
(02:00:37 PM) <b>info@adrianlamo.com:</b> just woke up from a nap<br>
(02:00:42 PM) <b>bradass87:</b> :)<br>
(02:00:58 PM) <b>info@adrianlamo.com:</b> feel hung over, without any alcohol to blame for it<br>
(02:01:10 PM) <b>info@adrianlamo.com:</b> how’s stuff?<br>
(02:01:14 PM) <b>bradass87:</b> haven’t had any alcohol since September<br>
(02:01:24 PM) <b>info@adrianlamo.com:</b> i don’t usually drink<br>
(02:01:28 PM) <b>bradass87:</b> nor do i<br>
(02:01:52 PM) <b>bradass87:</b> but i had a few drinks in September, since i knew i wasn’t going to have any for awhile<br>
(02:02:05 PM) <b>info@adrianlamo.com:</b> good enough reason.<br>
(02:02:12 PM) <b>bradass87:</b> uhm, i was reduced in rank today<br>
(02:03:23 PM) <b>info@adrianlamo.com:</b> to what?<br>
(02:03:27 PM) <b>bradass87:</b> received a “Company Grade Article 15″ -- a formality (they only reduced me in grade, and aren’t making me do “extra duty”) since they needed to punish me in some way<br>
(02:03:36 PM) <b>bradass87:</b> PFC<br>
(02:04:59 PM) <b>bradass87:</b> i punched a colleague in the face during an argument... (</ins><ins class="wiredquote-0610">something I NEVER DO...!?</ins><ins>) its whats sparked this whole saga<br>
(02:06:24 PM) <b>info@adrianlamo.com:</b> did they have it oming?<br>
(02:06:33 PM) <b>bradass87:</b> yes<br>
(02:06:44 PM) <b>bradass87:</b> as a result, i was referred (forced) to behavioral health... to evaluate me... as a result, my commander had access to all of my mental health files... ergo how they found out about my cross-dressing history, discomfort with my role in society, and the environment i’ve placed myself in<br>
(02:07:03 PM) <b>bradass87:</b> </ins><ins class="wiredquote-0610">it was a minor incident</ins><ins>... </ins><ins class="wiredquote-0610">but it brought attention to me</ins><ins><br>
(02:07:46 PM) <b>bradass87:</b> the person kind of deserved it... but kind of didn’t... it wasn’t worth this mess at all<br>
(02:08:14 PM) <b>bradass87:</b> (had a lot of high fives and “Go Mannings!”)<br>
(02:08:31 PM) <b>bradass87:</b> not proud of it at all<br>
(02:08:38 PM) <b>info@adrianlamo.com:</b> These things happen.<br>
(02:08:41 PM) <b>bradass87:</b> and very surprised<br>
(02:08:52 PM) <b>bradass87:</b> im not a violent person<br>
(02:09:05 PM) <b>bradass87:</b> (odd to hear from someone in the Army?)<br>
(02:09:13 PM) <b>info@adrianlamo.com:</b> neither am i. but i’ll be violent if i have to.<br>
(02:09:58 PM) <b>info@adrianlamo.com:</b> most people in the Army aren’t in specialties that involve directly servicing targets.<br>
(02:10:14 PM) <b>bradass87:</b> im glad you realize that<br>
(02:10:27 PM) <b>bradass87:</b> (forgot you dated a CI guy)<br>
(02:11:16 PM) <b>info@adrianlamo.com:</b> I make it my business to know as much as I can about relevant topics.<br>
(02:11:43 PM) <b>bradass87:</b> indeed, a heavy curiosity<br>
(02:11:51 PM) <b>bradass87:</b> find much more about me?<br>
(02:12:13 PM) <b>info@adrianlamo.com:</b> Only by talking to you :)<br>
(02:12:27 PM) <b>info@adrianlamo.com:</b> it’d be rude to deep search you.<br>
(02:12:45 PM) <b>bradass87:</b> its something im used to<br>
(02:12:58 PM) <b>bradass87:</b> i barely exist...<br>
(02:13:07 PM) <b>bradass87:</b> because i anticipate interest<br>
(02:13:15 PM) <b>info@adrianlamo.com:</b> words and actions say more than records on paper<br>
(02:13:29 PM) <b>bradass87:</b> &gt;nod&lt; know this all too well<br>
(02:13:54 PM) <b>bradass87:</b> gathering as many documents as possible re: my career<br>
(02:14:12 PM) <b>bradass87:</b> trying to control the narrative<br>
(02:14:50 PM) <b>bradass87:</b> From an award recommendation (never completed): “SPC Manning’s persistence led to the disruption of “Former Special Groups” in the New Baghdad area. SPC Manning’s tracking of targets led to the identification of previously unknown enemy support zones. His analysis led to heavy targeting of insurgent leaders in the area that consistently disrupted their operations. SPC Manning’s dedication led to the detainment of Malik Fadil al-Ugayli, a Tier 2 level target within the Commando OE.”<br>
Recommended awards for assisting in the disruption of Former Special Groups (FSG) in Southeastern Baghdad, identifying and disrupting operations from previously unknown enemy support zones in Hayy Zafaraniyah, and assisting in the detainment of Malik Fadil al-Ugayli, a Tier 2 level target.<br>
(02:16:47 PM) <b>bradass87:</b> Malik was a heavy cell phone user<br>
(02:17:42 PM) <b>info@adrianlamo.com:</b> I gave mine to a friend to make one call a mile away and then went dark.<br>
(02:17:47 PM) <b>info@adrianlamo.com:</b> During my hunt.<br>
(02:17:57 PM) <b>bradass87:</b> smart move<br>
(02:19:54 PM) <b>bradass87:</b> my speciality is (was) tracking a Shi’a group called Khatiai’b Hizbollah... they were OPSEC savvy as all fuck... didn’t even know the group existed until 2008... Iranian backed group... they make al-Qaeda knock offs look like kids...<br>
(02:20:17 PM) <b>bradass87:</b> they’re the most dangerous guys in the world...<br>
(02:20:28 PM) <b>bradass87:</b> Hezbollah... that is<br>
(02:21:10 PM) <b>info@adrianlamo.com:</b> Only because they are savvy in helping their communities and building goodwill.<br>
(02:21:39 PM) <b>info@adrianlamo.com:</b> otherwise they’re just light infantry.<br>
(02:21:52 PM) <b>bradass87:</b> they also specialize in the construction of EFPs<br>
(02:22:02 PM) <b>bradass87:</b> so good, we cant trace anything<br>
(02:22:11 PM) <b>bradass87:</b> not a sensor, not a cell phone... nothing but a crater<br>
(02:22:35 PM) <b>bradass87:</b> they’re ghosts<br>
(02:22:54 PM) <b>info@adrianlamo.com:</b> They taught Israel a few memorable lessons.<br>
(02:23:16 PM) <b>bradass87:</b> they stopped targeting us, thank fsm<br>
(02:23:35 PM) <b>bradass87:</b> they’ve moved into the political phase of their operations<br>
(02:23:51 PM) <b>info@adrianlamo.com:</b> Fucks are our allies and still spy on us as much as they please. And it’s kosher; cos it’s part of the game.<br>
(02:23:58 PM) <b>info@adrianlamo.com:</b> Israel, that is.<br>
(02:24:23 PM) <b>bradass87:</b> well, we’ve got plenty of assets watching them too... all NF stuff of course<br>
(02:24:51 PM) <b>info@adrianlamo.com:</b> that’s different. we’re the Godd Guys (TM)<br>
(02:24:56 PM) <b>info@adrianlamo.com:</b> *good<br>
</ins>(02:26:01 PM) <b>bradass87:</b> i dont believe in good guys versus bad guys anymore... i only a plethora of states acting in self interest... with varying ethics and moral standards of course, but self-interest nonetheless<br>
(02:26:18 PM) <b>bradass87:</b> s/only/only see/<br>
(02:26:47 PM) <b>info@adrianlamo.com:</b> the tm meant i was being facetious<br>
(02:26:59 PM) <b>bradass87:</b> gotchya<br>
(02:27:47 PM) <b>bradass87:</b> i mean, we’re better in some respects... we’re much more subtle... use a lot more words and legal techniques to legitimize everything<br>
(02:28:00 PM) <b>bradass87:</b> its better than disappearing in the middle of the night<br>
(02:28:19 PM) <b>bradass87:</b> but just because something is more subtle, doesn’t make it right<br>
(02:29:04 PM) <b>bradass87:</b> i guess im too idealistic<br>
(02:31:02 PM) <b>bradass87:</b> i think the thing that got me the most... that made me rethink the world more than anything<br>
(02:35:46 PM) <b>bradass87:</b> was watching 15 detainees taken by the Iraqi Federal Police... for printing “anti-Iraqi literature”... the iraqi federal police wouldn’t cooperate with US forces, so i was instructed to investigate the matter, find out who the “bad guys” were, and how significant this was for the FPs... it turned out, they had printed a scholarly critique against PM Maliki... i had an interpreter read it for me... and when i found out that it was a benign political critique titled “Where did the money go?” and following the corruption trail within the PM’s cabinet... i immediately took that information and *ran* to the officer to explain what was going on... he didn’t want to hear any of it... he told me to shut up and explain how we could assist the FPs in finding *MORE* detainees...<br>
(02:35:46 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(02:36:27 PM) <b>bradass87:</b> everything started slipping after that... i saw things differently<br>
(02:37:37 PM) <b>bradass87:</b> i had always questioned the things worked, and investigated to find the truth... but that was a point where i was a *part* of something... i was actively involved in something that i was completely against...<br>
(02:38:12 PM) <b>info@adrianlamo.com:</b> That could happen in Colombia.<br>
(02:38:21 PM) <b>info@adrianlamo.com:</b> Different cultures, dude.<br>
(02:38:28 PM) <b>info@adrianlamo.com:</b> Life is cheaper.<br>
(02:38:34 PM) <b>bradass87:</b> oh im quite aware<br>
(02:38:45 PM) <b>info@adrianlamo.com:</b> What would you do if your role /w Wikileaks seemed in danger of being blown?<br>
(02:38:48 PM) <b>bradass87:</b> but i was a part of it... and completely helpless...<br>
(02:39:01 PM) <b>info@adrianlamo.com:</b> sometimes we’re all helpless<br>
(02:39:34 PM) <b>bradass87:</b> try and figure out how i could get my side of the story out... before everything was twisted around to make me look like Nidal Hassan<br>
(02:40:15 PM) <b>bradass87:</b> i dont think its going to happen<br>
(02:40:26 PM) <b>bradass87:</b> i mean, i was never noticed<br>
(02:41:10 PM) <b>bradass87:</b> regularly ignored... except when i had something essential... then it was back to “bring me coffee, then sweep the floor”<br>
(02:42:24 PM) <b>bradass87:</b> i never quite understood that<br>
(02:42:44 PM) <b>bradass87:</b> felt like i was an abused work horse...<br>
(02:43:33 PM) <b>bradass87:</b> also, theres god awful accountability of IP addresses...<br>
(02:44:47 PM) <b>bradass87:</b> the network was upgraded, and patched up so many times... and systems would go down, logs would be lost... and when moved or upgraded... hard drives were zeroed<br>
(02:45:12 PM) <b>bradass87:</b> its impossible to trace much on these field networks...<br>
(02:46:10 PM) <b>bradass87:</b> and who would honestly expect so much information to be exfiltrated from a field network?<br>
(02:46:25 PM) <b>info@adrianlamo.com:</b> I’d be one paranoid boy in your shoes.<br>
(02:47:07 PM) <b>bradass87:</b> the CM video came from a server in our domain! and not a single person noticed<br>
(02:47:21 PM) <b>info@adrianlamo.com:</b> CM?<br>
(02:48:17 PM) <b>bradass87:</b> Apache Weapons Team video of 12 JUL 07 airstrike on Reuters Journos... some sketchy but fairly normal street-folk... and civilians<br>
(02:48:52 PM) <b>info@adrianlamo.com:</b> How long between the leak and the publication?<br>
(02:49:18 PM) <b>bradass87:</b> some time in february<br>
(02:49:25 PM) <b>bradass87:</b> it was uploaded<br>
(02:50:04 PM) <b>info@adrianlamo.com:</b> uploaded where? how would i transmit something if i had similarly damning data<br>
(02:51:49 PM) <b>bradass87:</b> uhm... preferably openssl the file with aes-256... then use sftp at prearranged drop ip addresses<br>
(02:52:08 PM) <b>bradass87:</b> keeping the key separate... and uploading via a different means<br>
(02:52:31 PM) <b>info@adrianlamo.com:</b> so i myself would be SOL w/o a way to prearrange<br>
(02:54:33 PM) <b>bradass87:</b> not necessarily... the HTTPS submission should suffice legally... though i’d use tor on top of it...<br>
(02:54:43 PM) <b>bradass87:</b> but you’re data is going to be watched<br>
(02:54:44 PM) <b>bradass87:</b> *your<br>
(02:54:49 PM) <b>bradass87:</b> by someone, more than likely<br>
(02:54:53 PM) <b>info@adrianlamo.com:</b> submission where?<br>
(02:55:07 PM) <b>bradass87:</b> wl.org submission system<br>
(02:55:23 PM) <b>info@adrianlamo.com:</b> in the massive queue?<br>
(02:55:54 PM) <b>bradass87:</b> lol, yeah, it IS pretty massive...<br>
(02:55:56 PM) <b>bradass87:</b> buried<br>
(02:56:04 PM) <b>bradass87:</b> i see what you mean<br>
(02:56:35 PM) <b>bradass87:</b> long term sources do get preference... i can see where the “unfairness” factor comes in<br>
(02:56:53 PM) <b>info@adrianlamo.com:</b> how does that preference work?<br>
(02:57:47 PM) <b>bradass87:</b> veracity... the material is easy to verify...<br>
(02:58:27 PM) <b>bradass87:</b> because they know a little bit more about the source than a purely anonymous one<br>
(02:59:04 PM) <b>bradass87:</b> and confirmation publicly from earlier material, would make them more likely to publish... i guess...<br>
(02:59:16 PM) <b>bradass87:</b> im not saying they do... but i can see how that might develop<br>
(03:00:18 PM) <b>bradass87:</b> if two of the largest public relations “coups” have come from a single source... for instance<br>
(03:02:03 PM) <b>bradass87:</b> you yeah... purely *submitting* material is more likely to get overlooked without contacting them by other means and saying hey, check your submissions for x...<br>
<ins>(03:02:03 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(03:02:19 PM) <b>bradass87:</b> s/you/so<br>
(03:03:38 PM) <b>bradass87:</b> iono, im not so paranoid... ive seen the way the system works, and the way the public reacts, and the way the PR people react... ive never felt threatened<br>
(03:06:10 PM) <b>bradass87:</b> i dont know whats wrong with me...<br>
(03:07:01 PM) <b id="d231507">bradass87:</b> </ins><ins class="wiredquote-0610">i just</ins><ins>... </ins><ins class="wiredquote-0610">couldnt let these things stay inside of the system</ins><ins>... </ins><ins class="wiredquote-0610">and inside of my head</ins><ins>...</ins><br>
(03:07:26 PM) <b>bradass87:</b> i recognized the value of some things...<br>
(03:07:33 PM) <b>bradass87:</b> knew what they meant... dug deeper<br>
(03:07:53 PM) <b>bradass87:</b> i watched that video cold, for instance<br>
(03:10:32 PM) <b>bradass87:</b> at first glance... it was just a bunch of guys getting shot up by a helicopter... no big deal... about two dozen more where that came from right... but something struck me as odd with the van thing... and also the fact it was being stored in a JAG officer’s directory... so i looked into it... eventually tracked down the date, and then the exact GPS co-ord... and i was like... ok, so thats what happened... cool... then i went to the regular internet... and it was still on my mind... so i typed into goog... the date, and the location... and then i see this http://www.nytimes.com/2007/07/13/world/middleeast/13iraq.html<br>
(03:11:07 PM) <b>bradass87:</b> i kept that in my mind for weeks... probably a month and a half... before i forwarded it to <del>[Wikileaks]</del><ins>them</ins><br>
(03:11:54 PM) <b>bradass87:</b> then there was the Finkel book<br>
(03:12:16 PM) <b>bradass87:</b> im almost certain he had a copy<br>
<ins>(03:12:16 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(03:13:31 PM) <b>bradass87:</b> </ins><ins class="wiredquote-0610">it was unreal... i mean, i’ve identified bodies before... its rare to do so, but usually its just some nobody</ins><ins><br>
(03:13:48 PM) <b id="d231513">bradass87:</b> </ins><ins class="wiredquote-0610">it humanized the whole thing... re-sensitized me</ins><ins><br>
(03:15:38 PM) <b>bradass87:</b> i dont know... im just, weird i guess<br>
(03:15:49 PM) <b>bradass87:</b> i cant separate myself from others<br>
(03:16:12 PM) <b>bradass87:</b> i feel connected to everybody... like they were distant family<br>
(03:16:24 PM) <b>bradass87:</b> i... care?<br>
(03:17:27 PM) <b>bradass87:</b> http://www.kxol.com.au/images/pale_blue_dot.jpg &lt;– sums it up for me<br>
(03:18:17 PM) <b>bradass87:</b> i probably shouldn’t have read sagan, feynman, and so many intellectual authors last summer...<br>
(03:21:11 PM) <b>bradass87:</b> &gt;sigh&lt;<br>
(03:22:14 PM) <b>info@adrianlamo.com:</b> i get that<br>
(03:22:45 PM) <b>bradass87:</b> get what... that connection?<br>
(03:23:38 PM) <b>info@adrianlamo.com:</b> yeah.<br>
(03:24:08 PM) <b>info@adrianlamo.com:</b> which is why i’m sad for the people i sometimes have to hurt.<br>
(03:24:10 PM) <b>bradass87:</b> we’re human... and we’re killing ourselves... and no-one seems to see that... and it bothers me<br>
(03:24:26 PM) <b>bradass87:</b> apathy<br>
(03:25:28 PM) <b>bradass87:</b> apathy is far worse than the active participation<br>
(03:26:23 PM) <b>bradass87:</b> &gt;hug&lt;<br>
(03:29:31 PM) <b>bradass87:</b> http://vimeo.com/5081720 Elie Wiesel summed it up pretty well for me... though his story is much much more important that mine<br>
(03:29:48 PM) <b>bradass87:</b> *than<br>
(03:31:33 PM) <b>bradass87:</b> I prefer a painful truth over any blissful fantasy.<br>
(03:31:48 PM) <b>bradass87:</b> s/a/the<br>
(03:32:05 PM) <b>info@adrianlamo.com:</b> *hugback*<br>
(03:34:16 PM) <b>bradass87:</b> :*<br>
(03:35:44 PM) <b>bradass87:</b> i think ive been traumatized too much by reality, to care about consequences of shattering the fantasy<br>
(03:36:18 PM) <b>bradass87:</b> im not brave, im weak<br>
(03:39:00 PM) <b>info@adrianlamo.com:</b> sometimes they’re the same thing<br>
(03:40:33 PM) <b>info@adrianlamo.com:</b> brb<br>
(03:40:43 PM) <b>bradass87:</b> k<br>
(03:52:34 PM) <b>bradass87:</b> like i think ive said before.... im not so much scared of getting caught and facing consequences at this point... as i am </ins><ins class="wiredquote-0610">of being misunderstood, and never having the chance to live the life i wanted to</ins><ins>...<br>
(03:52:34 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(03:53:38 PM) <b>bradass87:</b> im way way way too easy to marginalize...<br>
(03:55:52 PM) <b>bradass87:</b> i dont like this person that people see... no-one knows who i am inside
</ins>
<div class="timelapse">Short time lapse</div>
<ins>(04:24:21 PM) <b>info@adrianlamo.com:</b> are you in the green zone? *random*<br>
(04:26:02 PM) <b>info@adrianlamo.com:</b> i know all about having a persona vs. a real person<br>
(04:26:06 PM) <b>info@adrianlamo.com:</b> &lt;3<br>
(04:28:46 PM)<b>info@adrianlamo.com:</b> yt?
</ins>
<div class="timelapse">Time lapse</div>
<ins>(06:19:10 PM) bradass87 has signed off.
</ins>
<div class="date" id="date20100524"><a href="#date20100524">&#xA7;&nbsp;</a>May 24, 2010</div>
<ins>(01:37:03 AM) bradass87 has signed on.<br>
(01:37:51 AM) <b>bradass87:</b> no no... im at FOB hammer (re: green zone); persona is killing the fuck out of me at this point... =L<br>
(01:37:51 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(01:37:55 AM) Error setting up private conversation: Malformed message received<br>
(01:37:55 AM) We received an unreadable encrypted message from bradass87.<br>
(01:37:58 AM) <b>bradass87:</b> [resent] &lt;HTML&gt;no no... im at FOB hammer (re: green zone); persona is killing the fuck out of me at this point... =L<br>
(01:38:07 AM) bradass87 has ended his/her private conversation with you; you should do the same.<br>
(01:38:18 AM) Error setting up private conversation: Malformed message received<br>
(01:38:20 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:38:30 AM) Error setting up private conversation: Malformed message received<br>
(01:38:33 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:38:43 AM) Error setting up private conversation: Malformed message received<br>
(01:38:46 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:38:57 AM) Error setting up private conversation: Malformed message received<br>
(01:38:59 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:39:10 AM) Error setting up private conversation: Malformed message received<br>
(01:39:13 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:39:22 AM) Error setting up private conversation: Malformed message received<br>
(01:39:25 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:39:36 AM) Error setting up private conversation: Malformed message received<br>
(01:39:39 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:39:49 AM) Error setting up private conversation: Malformed message received<br>
(01:39:52 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:40:02 AM) Error setting up private conversation: Malformed message received<br>
(01:40:04 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:40:15 AM) Error setting up private conversation: Malformed message received<br>
(01:40:18 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:40:30 AM) Error setting up private conversation: Malformed message received<br>
(01:40:31 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:40:41 AM) Error setting up private conversation: Malformed message received<br>
(01:40:45 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:40:54 AM) Error setting up private conversation: Malformed message received<br>
(01:40:57 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:41:08 AM) Error setting up private conversation: Malformed message received<br>
(01:41:10 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:41:21 AM) Error setting up private conversation: Malformed message received<br>
(01:41:23 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:41:37 AM) Error setting up private conversation: Malformed message received<br>
(01:41:50 AM) Error setting up private conversation: Malformed message received<br>
(01:41:52 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:42:03 AM) Error setting up private conversation: Malformed message received<br>
(01:42:05 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:42:19 AM) Error setting up private conversation: Malformed message received<br>
(01:45:17 AM) The encrypted message received from bradass87 is unreadable, as you are not currently communicating privately.<br>
(01:45:20 AM) Unverified conversation with bradass87 started.<br>
(01:45:20 AM) <b>bradass87:</b> [resent] &lt;HTML&gt;otr fritzing<br>
(01:45:40 AM) bradass87 has ended his/her private conversation with you; you should do the same.<br>
(01:45:46 AM) The following message received from bradass87 was not encrypted: [otr is bugging out]<br>
(01:45:54 AM) Unverified conversation with bradass87 started.<br>
(01:46:02 AM) <b>bradass87:</b> no no... im at FOB hammer (re: green zone); persona is killing the fuck out of me at this point... =L<br>
(01:46:15 AM) <b>bradass87:</b> [phew, seems to be working now]<br>
(01:47:36 AM) <b>info@adrianlamo.com:</b> :)<br>
(01:48:50 AM) <b>bradass87:</b> “SPC Manning’s persistence led to the disruption of “Former Special Groups” in the New Baghdad area. SPC Manning’s tracking of targets led to the identification of previously unknown enemy support zones. His analysis led to heavy targeting of insurgent leaders in the area that consistently disrupted their operations. SPC Manning’s dedication led to the detainment of Malik Fadil al-Ugayli, a Tier 2 level target within the Commando OE.”<br>
(01:49:17 AM) <b>bradass87:</b> oh sent you that last night, nevermind<br>
(01:49:59 AM) <b>bradass87:</b> im hoping i can get a decent job through connections<br>
(01:50:48 AM) <b>info@adrianlamo.com:</b> what kind of work?<br>
(01:50:59 AM) <b>bradass87:</b> &gt;shrug&lt;<br>
(01:51:11 AM) <b>bradass87:</b> i’m good at so much<br>
(01:51:34 AM) <b>bradass87:</b> proving it is the issue... ergo contacts<br>
(01:51:36 AM) <b>bradass87:</b> im such a ghost<br>
(01:53:36 AM) <b>bradass87:</b> graphics design, web development, intelligence analysis, mathematics, cryptography, economics, and both domestic and international politics<br>
(01:53:48 AM) <b>bradass87:</b> dont really have a specialty; can roam<br>
(01:54:47 AM) <b>bradass87:</b> if it involves thought, rather than menial action... i can probably do it<br>
(02:06:07 AM) <b>bradass87:</b> im an east coaster... so i’ll probably roam up and down from Boston to DC for awhile... building connections<br>
(02:07:34 AM) <b>bradass87:</b> im writing my resume already<br>
(02:10:58 AM) <b>bradass87:</b> i need to build a portfolio<br>
(02:11:17 AM) <b>bradass87:</b> so i might freelance for a few weeks<br>
(02:19:39 AM) <b>bradass87:</b> </ins><ins class="wiredquote-0610">assange offered me a position at wl... but im not interested right now... too much excess baggage</ins><ins><br>
(02:20:19 AM) <b>bradass87:</b> its also a shoe-string op... cant make much of living doing that<br>
(02:31:38 AM) <b>bradass87:</b> i dont know what to call myself
</ins>
<div class="timelapse">Time lapse</div>
<ins>(05:15:39 AM) bradass87 has signed off.
</ins>
<div class="timelapse">Time lapse</div>
<ins>(07:21:07 AM) bradass87 has signed on.<br>
(07:31:09 AM) <b>bradass87:</b> hello<br>
(07:33:22 AM) <b>info@adrianlamo.com:</b> hey<br>
(07:33:56 AM) <b>info@adrianlamo.com:</b> tell him i’ll do opsec for ‘em<br>
(07:34:03 AM) <b>info@adrianlamo.com:</b> is he gay?<br>
(07:34:11 AM) <b>info@adrianlamo.com:</b> *random*<br>
(07:34:18 AM) <b>bradass87:</b> are you talking to the right person?<br>
(07:34:23 AM) <b>info@adrianlamo.com:</b> yeah<br>
(07:34:36 AM) <b>bradass87:</b> white haired crazy dude?<br>
(07:34:38 AM) <b>info@adrianlamo.com:</b> continuing convo where it dropped<br>
(07:34:43 AM) <b>info@adrianlamo.com:</b> yeah<br>
(07:34:49 AM) <b>bradass87:</b> ah... no...<br>
(07:34:52 AM) <b>bradass87:</b> very str8<br>
(07:35:47 AM) <b>bradass87:</b> had a camera smuggled via rectum once... he commented that he’s “definitely not gay”<br>
(07:37:44 AM) <b>bradass87:</b> [long story]<br>
(08:01:09 AM) bradass87 has become idle.<br>
(08:05:33 AM) bradass87 has signed off.
</ins>
<div class="timelapse">Time lapse</div>
<ins>(10:29:02 AM) bradass87 has signed on.<br>
(10:29:02 AM) bradass87 is no longer idle.<br>
The Twitter account of a "Breanna Manning" in Washington DC<br>
(10:33:58 AM) <b>bradass87:</b> im already starting to give “Breanna” a digital presence... twitter, youtube accounts set up in her name<br>
(10:35:02 AM) <b>bradass87:</b> domain and server set up some time this week... going to design and build an entire content management system from scratch<br>
(10:35:43 AM) <b>bradass87:</b> literally going backwards four years to start over...<br>
(10:56:28 AM) <b>bradass87:</b> this is such a disaster... //CRISIS//<br>
(11:02:24 AM) <b>bradass87:</b> i need a lot more than a hug :(<br>
(11:03:06 AM) <b>bradass87:</b> if im on my own... im on my own, i guess... but people are gonna see my true colors either way
</ins>
<div class="timelapse">Time lapse</div>
<ins>(05:35:45 PM) bradass87 has signed on.<br>
(05:46:39 PM) <b>info@adrianlamo.com:</b> hey<br>
(05:47:10 PM) <b>info@adrianlamo.com:</b> how’s stuff? :-*
</ins>
<div class="date" id="date20100525"><a href="#date20100525">&#xA7;&nbsp;</a>May 25, 2010</div>
<ins>(01:20:55 AM) bradass87 has signed on.<br>
(01:27:30 AM) <b>bradass87:</b> im alive<br>
(01:27:40 AM) <b>bradass87:</b> and breathing<br>
(01:28:10 AM) <b>info@adrianlamo.com:</b> good to hear :)<br>
(01:28:27 AM) <b>info@adrianlamo.com:</b> SITREP<br>
(01:35:50 AM) <b>bradass87:</b> 1 PAX up<br>
(01:36:28 AM) <b>bradass87:</b> i had an hour session with my therapist<br>
(01:36:40 AM) <b>bradass87:</b> i didnt say word for like 30 minutes<br>
(01:36:47 AM) <b>bradass87:</b> i just sat there, and he took notes<br>
(01:37:18 AM) <b>bradass87:</b> im an awkward patient<br>
(01:38:13 AM) <b>bradass87:</b> its difficult to communicate with therapists<br>
(01:38:27 AM) <b>bradass87:</b> i try to explain something, and they twist it around<br>
(01:39:04 AM) <b>bradass87:</b> and then they ask why i dont want to say anything<br>
(01:39:43 AM) <b>bradass87:</b> one of my friends is in the Democratic Primary for a South Dakota Senate seat... Angie Buhl... we played Guitar Hero together<br>
(01:40:15 AM) <b>bradass87:</b> very very gay friendly... =)<br>
(01:41:22 AM) <b>bradass87:</b> State Senate that is... [not federal]<br>
(01:42:05 AM) <b>bradass87:</b> http://www.angiebuhl.com/<br>
(01:42:36 AM) <b>info@adrianlamo.com:</b> I gathered<br>
(01:43:53 AM) <b>bradass87:</b> same circle of friends as [redacted]... he’s cute, but he’s a bottom... so we didn’t work out [redacted]<br>
(01:44:40 AM) <b>bradass87:</b> slept with him a few times, but sex was awkward...<br>
(01:44:50 AM) <b>info@adrianlamo.com:</b> howso?<br>
(01:45:04 AM) <b>bradass87:</b> two bottoms...<br>
(01:45:40 AM) <b>bradass87:</b> so, yeah... we’re friends<br>
(01:46:48 AM) <b>bradass87:</b> though, its been a year... and political friends can forget you exist in three news cycles<br>
(01:47:19 AM) <b>bradass87:</b> kind of reinforces my cynicism<br>
(01:47:55 AM) <b>bradass87:</b> i still have a little spark of a dream though... call me crazy...<br>
(01:48:30 AM) <b>bradass87:</b> but, i’d like to insert myself into politics, as a technical person with real ideas...<br>
(01:49:28 AM) <b>bradass87:</b> too many words in political spheres... too short of an attention span... too short of goals<br>
(01:50:38 AM) <b>bradass87:</b> humanity can accomplish so much... but its like herding cats<br>
(01:50:57 AM) <b>bradass87:</b> getting the smart people with ideas to cooperate, that is<br>
(01:51:59 AM) <b>bradass87:</b> im probably suffering from depression<br>
(01:51:59 AM) <b>bradass87:</b> ={<br>
(01:52:03 AM) <b>bradass87:</b> ={<br>
(01:52:06 AM) <b>bradass87:</b> =P<br>
(01:52:15 AM) <b>info@adrianlamo.com:</b> Who isn’t :(<br>
(01:52:20 AM) <b>bradass87:</b> goddamn, i missed the “P” key twice<br>
(01:52:27 AM) <b>info@adrianlamo.com:</b> I’m supposedly bipolar.<br>
(01:52:38 AM) <b>bradass87:</b> oh well, still not medicated<br>
(01:53:00 AM) <b>bradass87:</b> i dont believe a third of the DSM-IV-TR<br>
(01:53:58 AM) <b>bradass87:</b> so many Disorders that so many people fall into... it just seems like a method to categorize a person, medicate them, and make money from prescription medications<br>
(01:54:04 AM) <b>info@adrianlamo.com:</b> brb<br>
(01:54:31 AM) <b>bradass87:</b> i’d like to meet a single person that wouldn’t fall into a Disorder in the DSM-IV-TR<br>
(01:55:31 AM) <b>bradass87:</b> [I'm random, too]<br>
(02:01:12 AM) <b>info@adrianlamo.com:</b> no such animal<br>
(02:02:25 AM) <b>bradass87:</b> indeed<br>
(02:02:39 AM) <b>bradass87:</b> http://www.facebook.com/profile.php?id=647441030<br>
</ins>(02:03:10 AM) <b>bradass87:</b> amazing how the world works<br>
(02:03:27 AM) <b>bradass87:</b> takes 6 degrees of separation to a whole new level<br>
(02:04:12 AM) <b>info@adrianlamo.com:</b> hey, vacaville<br>
(02:04:18 AM) <b>info@adrianlamo.com:</b> er<br>
(02:04:23 AM) <b>info@adrianlamo.com:</b> vacaville<br>
(02:05:12 AM) <b>bradass87:</b> its almost bookworthy in itself, how this played<br>
(02:07:41 AM) <b>bradass87:</b> event occurs in 2007, i watch video in 2009 with no context, do research, forward information to group of FOI activists, more research occurs, video is released in 2010, those involved come forward to discuss event, i witness those involved coming forward to discuss publicly, even add them as friends on FB... without them knowing who i am<br>
(02:08:37 AM) <b>bradass87:</b> they touch my life, i touch their life, they touch my life again... full circle<br>
(02:08:58 AM) <b>info@adrianlamo.com:</b> Life’s funny.<br>
(02:09:24 AM) <b>info@adrianlamo.com:</b> *random* are you concerned about CI/CID looking into your Wiki stuff? I was always paranoid.<br>
(02:09:40 AM) <b>bradass87:</b> CID has no open investigation<br>
(02:10:28 AM) <b>bradass87:</b> State Department will be uber-pissed... but <del>i</del><ins>I</ins> dont think they’re capable of tracing everything...<br>
(02:10:44 AM) <b>info@adrianlamo.com:</b> what about CI?<br>
(02:10:51 AM) <b>bradass87:</b> might be a congressional investigation, and a joint effort to figure out what happened<br>
(02:11:23 AM) <b>bradass87:</b> CI probably took note, but it had no effect on operations<br>
(02:11:48 AM) <b>bradass87:</b> so, it was publicly damaging, but didn’t increase attacks or rhetoric...<br>
(02:12:10 AM) <b>info@adrianlamo.com:</b> *nod*<br>
(02:12:34 AM) <b>bradass87:</b> re: joint effort will be purely political, “fact finding”... “how can we stop this from happening again”<br>
(02:12:46 AM) <b>bradass87:</b> regarding State Dept. cables<br>
(02:13:12 AM) <b>info@adrianlamo.com:</b> Would the cables come from State?<br>
(02:13:21 AM) <b>bradass87:</b> yes<br>
(02:13:25 AM) <b>bradass87:</b> State Department<br>
(02:13:29 AM) <b>info@adrianlamo.com:</b> I was always a commercial intruder.<br>
(02:13:51 AM) <b>info@adrianlamo.com:</b> Why does your job afford you access?<br>
(02:13:59 AM) <b>info@adrianlamo.com:</b> except for the UN.<br>
(02:14:03 AM) <b>bradass87:</b> because i have a workstation<br>
(02:14:15 AM) <b>info@adrianlamo.com:</b> and World Bank.<br>
(02:14:17 AM) <b>bradass87:</b> *had*<br>
(02:14:36 AM) <b>info@adrianlamo.com:</b> So you have these stored now?<br>
(02:14:54 AM) <b>bradass87:</b> i had two computers... one connected to SIPRNET the other to JWICS...<br>
(02:15:07 AM) <b>bradass87:</b> no, they’re government laptops<br>
(02:15:18 AM) <b>bradass87:</b> they’ve been zerofilled<br>
(02:15:22 AM) <b>bradass87:</b> because of the pullout<br>
(02:15:57 AM) <b>bradass87:</b> evidence was destroyed... by the system itself<br>
(02:16:10 AM) <b>info@adrianlamo.com:</b> So how would you deploy the cables? If at all.<br>
(02:16:26 AM) <b>bradass87:</b> oh no... cables are reports<br>
(02:16:34 AM) <b>info@adrianlamo.com:</b> ah<br>
(02:16:38 AM) <b>bradass87:</b> State Department Cable = a Memorandum<br>
(02:16:48 AM) <b>info@adrianlamo.com:</b> embassy cables?<br>
(02:16:54 AM) <b>bradass87:</b> yes<br>
(02:17:00 AM) <b>bradass87:</b> 260,000 in all<br>
(02:17:10 AM) <b>bradass87:</b> i mentioned this previously<br>
(02:17:14 AM) <b>info@adrianlamo.com:</b> yes<br>
(02:17:31 AM) <b>info@adrianlamo.com:</b> stored locally, or retreiveable?<br>
(02:17:35 AM) <b>bradass87:</b> brb latrine =P<br>
(02:17:43 AM) <b>bradass87:</b> i dont have a copy anymore<br>
(02:17:59 AM) <b>info@adrianlamo.com:</b> *nod*<br>
(02:18:09 AM) <b>bradass87:</b> they were stored on a centralized server...<br>
(02:18:34 AM) <b>info@adrianlamo.com:</b> what’s your endgame plan, then?<br>
(02:18:36 AM) <b>bradass87:</b> it was vulnerable as fuck<br>
(02:20:57 AM) <b>bradass87:</b> well, it was forwarded to WL<br>
(02:21:18 AM) <b>bradass87:</b> and god knows what happens now<br>
(02:22:27 AM) <b>bradass87:</b> hopefully worldwide discussion, debates, and reforms<br>
(02:23:06 AM) <b>bradass87:</b> if not... than we’re doomed<br>
(02:23:18 AM) <b>bradass87:</b> as a species<br>
(02:24:13 AM) <b>bradass87:</b> i will officially give up on the society we have if nothing happens<br>
(02:24:58 AM) <b>bradass87:</b> the reaction to the video gave me immense hope... CNN’s iReport was overwhelmed... Twitter exploded...<br>
(02:25:18 AM) <b>bradass87:</b> people who saw, knew there was something wrong<br>
(02:26:10 AM) <b>bradass87:</b> Washington Post sat on the video... David Finkel acquired a copy while embedded out here<br>
(02:26:36 AM) <b>bradass87:</b> [also reason as to why there's probably no investigation]<br>
(02:28:10 AM) <b>bradass87:</b> i want people to see the truth... regardless of who they are... because without information, you cannot make informed decisions as a public<br>
(02:28:10 AM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(02:28:50 AM) <b>bradass87:</b> if i knew then, what i knew now... kind of thing...<br>
(02:29:31 AM) <b>bradass87:</b> or maybe im just young, naive, and stupid...<br>
(02:30:09 AM) <b>info@adrianlamo.com:</b> which do you think it is?<br>
(02:30:29 AM) <b>bradass87:</b> im hoping for the former<br>
(02:30:53 AM) <b>bradass87:</b> it cant be the latter<br>
(02:31:06 AM) <b>bradass87:</b> because if it is... were fucking screwed<br>
(02:31:12 AM) <b>bradass87:</b> (as a society)<br>
(02:31:49 AM) <b>bradass87:</b> and i dont want to believe that we’re screwed<br>
(02:32:53 AM) <b>bradass87:</b> food time... ttys<br>
<ins>(02:32:58 AM) <b>info@adrianlamo.com:</b> kk<br>
(02:33:00 AM) <b>info@adrianlamo.com:</b> and<br>
(02:33:03 AM) <b>info@adrianlamo.com:</b> fwiw<br>
(02:33:10 AM) <b>info@adrianlamo.com:</b> me neither<br>
(03:14:33 AM) <b>bradass87:</b> &gt;phew&lt;<br>
(03:14:37 AM) <b>bradass87:</b> its hot as fuck<br>
(03:16:02 AM) <b>bradass87:</b> 36Â°C | 96Â°F
Wind: N at 11 km/h
Humidity: 5%<br>
(03:16:44 AM) <b>info@adrianlamo.com:</b> wb<br>
(03:16:55 AM) <b>bradass87:</b> its raining there<br>
(03:17:03 AM) <b>bradass87:</b> ?<br>
(03:17:16 AM) <b>info@adrianlamo.com:</b> rain is nicce<br>
(03:17:26 AM) <b>info@adrianlamo.com:</b> welcome nack<br>
(03:17:36 AM) <b>bradass87:</b> nvm, just cloudy<br>
(03:18:16 AM) <b>bradass87:</b> t/y<br>
(03:18:38 AM) <b>bradass87:</b> 12Â°C | 54Â°F
Current: Cloudy
Wind: S at 8 km/h
Humidity: 100%<br>
(03:19:21 AM) <b>bradass87:</b> =P<br>
(03:19:45 AM) <b>bradass87:</b> here, its hot, dry... and fucking hot<br>
(03:19:58 AM) <b>bradass87:</b> [double emphasis on hot]<br>
(03:20:12 AM) <b>bradass87:</b> its also rather dusty<br>
(03:20:41 AM) <b>bradass87:</b> i’d prefer the heat over the peanut butter that forms when it rains<br>
(03:21:01 AM) <b>bradass87:</b> i grow 3 inches in height when it rains here<br>
(03:22:22 AM) <b>bradass87:</b> its a desert, but the ground is slightly fertile here... its a fine silt that forms clay<br>
(03:22:59 AM) <b>bradass87:</b> “Fertile Crescent”<br>
(03:24:51 AM) <b>bradass87:</b> vegetation is sparse... an odd mixture of deciduous and tropical trees and shrubs<br>
(03:25:18 AM) <b>bradass87:</b> and usually keeled over slightly, from wind erosion<br>
(03:26:00 AM) <b>bradass87:</b> i dont think 99% of the people i work with would make such observations<br>
(03:26:52 AM) <b>bradass87:</b> humans brought a lot of gravel and pebbles in from turkish pits...<br>
(03:27:14 AM) <b>bradass87:</b> so that KBR contractors dont get their feet too dirty when it rains<br>
(03:30:28 AM) <b>bradass87:</b> im still slowly trying to download that “leaked” documentary<br>
(03:31:16 AM) <b>info@adrianlamo.com:</b> :)<br>
(03:31:33 AM) <b>info@adrianlamo.com:</b> it was rly leakeddd<br>
(03:31:51 AM) <b>bradass87:</b> satellite internet is not very good... falls in and out depending on weather... bandwidth ebbs and flows<br>
(03:33:22 AM) <b>info@adrianlamo.com:</b> brb sleep<br>
(03:33:30 AM) <b>bradass87:</b> then there’s the points when generators are switched over every 24-48 hours<br>
(03:33:38 AM) <b>bradass87:</b> ttyl... im going back to work<br>
(03:33:56 AM) <b>info@adrianlamo.com:</b> &lt;,,,,,,,,,,3<br>
(03:34:37 AM) <b>info@adrianlamo.com:</b> b<br>
(03:34:52 AM) <b>info@adrianlamo.com:</b> er<br>
(03:35:01 AM) <b>info@adrianlamo.com:</b> brb sleep
</ins>
<div class="timelapse">Time lapse</div>
<ins>(04:06:46 AM) bradass87 has signed off.
</ins>
<div class="timelapse">Time lapse</div>
<ins>(06:22:53 AM) bradass87 has signed on.<br>
(06:42:38 AM) bradass87 has signed off.
</ins>
<div class="timelapse">Time lapse</div>
<ins>(01:35:26 PM) bradass87 has signed on.<br>
(01:37:27 PM) <b>bradass87:</b> &gt;yawn&lt;<br>
(01:38:43 PM) <b>info@adrianlamo.com:</b> g’day ace<br>
(01:39:09 PM) <b>bradass87:</b> its late... internet just came back up for me<br>
(01:39:25 PM) <b>info@adrianlamo.com:</b> *nod*<br>
(01:40:18 PM) <b>bradass87:</b> wtf<br>
(01:40:44 PM) <b>bradass87:</b> my ex is wearing my pink shirt at a damn “tea party” counterprotest http://sphotos.ak.fbcdn.net/hphotos-ak-ash1/hs461.ash1/25335_588945795969_22802130_34042846_5101765_n.jpg<br>
(01:40:44 PM) <b>info@adrianlamo.com:</b> ?<br>
(01:40:56 PM) <b>info@adrianlamo.com:</b> that jerk!<br>
(01:41:03 PM) <b>bradass87:</b> =L<br>
(01:41:25 PM) <b>bradass87:</b> oh well, its just A&F<br>
(01:41:36 PM) <b>bradass87:</b> he hates A&F... i have proof he wore it<br>
(01:42:28 PM) <b>info@adrianlamo.com:</b> are you seeing anyone in the .mil?<br>
(01:42:40 PM) <b>bradass87:</b> ew, no<br>
(01:43:01 PM) <b>bradass87:</b> i dated once... having two paranoid people doesn’t work<br>
(01:43:12 PM) <b>info@adrianlamo.com:</b> my ex said CI was lousy with queers ;&gt;<br>
(01:43:18 PM) <b>bradass87:</b> i’ve had sex with .mil people... but overall its bad<br>
(01:43:32 PM) <b>bradass87:</b> CI?<br>
(01:43:37 PM) <b>bradass87:</b> why would CI be involved<br>
(01:43:45 PM) <b>info@adrianlamo.com:</b> my ex was 97B<br>
(01:44:14 PM) <b>bradass87:</b> i forget it was probably pretty bad in the past<br>
(01:44:33 PM) <b>bradass87:</b> DADT isnt really enforced<br>
(01:44:56 PM) <b>bradass87:</b> top interrogator here has a civil union in NJ<br>
(01:45:18 PM) <b>bradass87:</b> i punched a dyke in the phace...<br>
(01:45:22 PM) <b>info@adrianlamo.com:</b> lol<br>
(01:45:43 PM) <b>bradass87:</b> half the S2 shop was at least bi<br>
(01:45:57 PM) <b>info@adrianlamo.com:</b> you know this personal-like? ; )<br>
(01:46:05 PM) <b>bradass87:</b> it was all female<br>
(01:46:10 PM) <b>info@adrianlamo.com:</b> ah<br>
(01:46:46 PM) <b>bradass87:</b> i got sick of these dykes and their drama... it was worse than “The L Word”...<br>
(01:47:12 PM) <b>bradass87:</b> i even created a “chart”<br>
(01:47:42 PM) <b>info@adrianlamo.com:</b> physical or virtual?<br>
(01:48:07 PM) <b>bradass87:</b> we never got a replacement CI expert<br>
(01:48:39 PM) <b>bradass87:</b> virtual... on SIPR =P<br>
(01:49:20 PM) <b>info@adrianlamo.com:</b> shouldn’t be a challenge for you to exfiltrate a copy ;&gt;<br>
(01:51:07 PM) <b>bradass87:</b> that was probably a primary facilitator... CI officer was an open position, taken up by a lesbian interrogator who was more worried about the drama than the exfiltration of classified information<br>
(01:51:25 PM) <b>bradass87:</b> dual tasked... plus she was only an E-5<br>
</ins>(01:52:30 PM) <b>bradass87:</b> funny thing is... we transffered so much data on unmarked CDs...<br>
(01:52:42 PM) <b>bradass87:</b> everyone did... videos... movies... music<br>
(01:53:05 PM) <b>bradass87:</b> all out in the open<br>
(01:53:53 PM) <b>bradass87:</b> bringing CDs too and from the networks was/is a common phenomeon<br>
(01:54:14 PM) <b>info@adrianlamo.com:</b> is that how you got the cables out?<br>
(01:54:28 PM) <b>bradass87:</b> perhaps<br>
(01:54:42 PM) <b>bradass87:</b> i would come in with music on a CD-RW<br>
(01:55:21 PM) <b>bradass87:</b> labelled with something like “Lady Gaga”... erase the music... then write a compressed split file<br>
(01:55:46 PM) <b>bradass87:</b> no-one suspected a thing<br>
(01:55:48 PM) <b>bradass87:</b> =L kind of sad<br>
(01:56:04 PM) <b>info@adrianlamo.com:</b> and odds are, they never will<br>
(01:56:07 PM) <b>bradass87:</b> i didnt even have to hide anything<br>
(01:56:36 PM) <b>info@adrianlamo.com:</b> from a professional perspective, i’m curious how the server they were on was insecure<br>
(01:57:19 PM) <b>bradass87:</b> you had people working 14 hours a day... every single day... no weekends... no recreation...<br>
(01:57:27 PM) <b>bradass87:</b> people stopped caring after 3 weeks<br>
(01:57:44 PM) <b>info@adrianlamo.com:</b> i mean, technically speaking<br>
(01:57:51 PM) <b>info@adrianlamo.com:</b> or was it physical<br>
(01:57:52 PM) <b>bradass87:</b> &gt;nod&lt;<br>
(01:58:16 PM) <b>bradass87:</b> there was no physical security<br>
(01:58:18 PM) <b>info@adrianlamo.com:</b> it was physical access, wasn’t it<br>
(01:58:20 PM) <b>info@adrianlamo.com:</b> hah<br>
(01:58:33 PM) <b>bradass87:</b> it was there, but not really<br>
(01:58:51 PM) <b>bradass87:</b> 5 digit cipher lock... but you could knock and the door...<br>
(01:58:55 PM) <b>bradass87:</b> *on<br>
(01:59:15 PM) <b>bradass87:</b> weapons, but everyone has weapons<br>
(02:00:12 PM) <b>bradass87:</b> everyone just sat at their workstations... watching music videos / car chases / buildings exploding... and writing more stuff to CD/DVD... the culture fed opportunities<br>
(02:01:44 PM) <b>bradass87:</b> hardest part is arguably internet access... uploading any sensitive data over the open internet is a bad idea... since networks are monitored for any insurgent/terrorist/militia/criminal types<br>
(02:01:52 PM) <b>info@adrianlamo.com:</b> tor?<br>
(02:02:13 PM) <b>bradass87:</b> tor + ssl + sftp<br>
(02:02:33 PM) <b>info@adrianlamo.com:</b> *nod*<br>
(02:03:05 PM) <b>info@adrianlamo.com:</b> not quite how i might do it, but good<br>
(02:03:22 PM) <b>bradass87:</b> i even asked the NSA guy if he could find any suspicious activity coming out of local networks... he shrugged and said... “its not a priority”<br>
(02:03:53 PM) <b>bradass87:</b> went back to watching “Eagle’s Eye”<br>
<ins>(02:03:55 PM) <b>info@adrianlamo.com:</b> oh, those NSA guys.<br>
(02:04:05 PM) <b>info@adrianlamo.com:</b> pffft<br>
(02:04:15 PM) <b>info@adrianlamo.com:</b> probably thought it was plausible<br>
(02:04:40 PM) <b>bradass87:</b> he had a lot of girl scout cookies<br>
(02:05:03 PM) <b>info@adrianlamo.com:</b> not a Threat Level fan.<br>
(02:05:20 PM) <b>bradass87:</b> don’t judge, he actually kept up with that stuff<br>
(02:05:33 PM) <b>info@adrianlamo.com:</b> clearly not enough<br>
(02:05:39 PM) <b>bradass87:</b> and we were in a SCIF, so he would talk... and talk.... and talk<br>
(02:06:58 PM) <b>bradass87:</b> NSA capabilities... how FISA operates... i even asked a hypothetical question of my situation... and he was like... “if that did happen... doubtful anyone would figure it all out... resources are strained... plus the FISA mess”<br>
(02:07:20 PM) <b>bradass87:</b> we tracked two american citizens “off-the-record”<br>
(02:07:30 PM) <b>info@adrianlamo.com:</b> who, and why?<br>
(02:07:59 PM) <b>bradass87:</b> two naturalized american citizens...<br>
(02:08:22 PM) <b>bradass87:</b> one lived in texas for 17 years before moving back to Iraq... and then started constructed EFPs<br>
(02:08:41 PM) <b>bradass87:</b> only part of the name i remember is “Nai’m Mazan”<br>
(02:08:58 PM) <b>bradass87:</b> he was definitely crooked<br>
(02:09:10 PM) <b>bradass87:</b> neither were high profile<br>
(02:11:16 PM) <b>bradass87:</b> that product did thrown around a lot... saw our report regurgitated by NCIS<br>
(02:11:33 PM) <b>bradass87:</b> CID doesn’t make fancy CI products<br>
</ins>(02:12:23 PM) <b>bradass87:</b> so... it was a massive data spillage... facilitated by numerous factors... both physically, technically, and culturally<br>
(02:13:02 PM) <b>bradass87:</b> perfect example of how not to do INFOSEC<br>
(02:14:21 PM) <b>bradass87:</b> listened and lip-synced to Lady Gaga’s Telephone while exfiltratrating possibly the largest data spillage in american history<br>
(02:15:03 PM) <b>bradass87:</b> pretty simple, and unglamorous<br>
(02:16:37 PM) <b>bradass87:</b> *exfiltrating<br>
(02:17:56 PM) <b>bradass87:</b> weak servers, weak logging, weak physical security, weak counter-intelligence, inattentive signal analysis... a perfect storm<br>
(02:19:03 PM) <b>bradass87:</b> &gt;sigh&lt;<br>
(02:19:19 PM) <b>bradass87:</b> sounds pretty bad huh?<br>
(02:20:06 PM) <b>info@adrianlamo.com:</b> kinda :x<br>
(02:20:25 PM) <b>bradass87:</b> :L<br>
(02:20:52 PM) <b>info@adrianlamo.com:</b> i mean, for the .mil<br>
(02:21:08 PM) <b>bradass87:</b> well, it SHOULD be better<br>
(02:21:32 PM) <b>bradass87:</b> its sad<br>
(02:22:47 PM) <b>bradass87:</b> i mean what if i were someone more malicious<br>
(02:23:25 PM) <b>bradass87:</b> i could’ve sold to russia or china, and made bank?<br>
(02:23:36 PM) <b>info@adrianlamo.com:</b> why didn’t you?<br>
(02:23:58 PM) <b>bradass87:</b> because it’s public data<br>
(02:24:15 PM) <b>info@adrianlamo.com:</b> i mean, the cables<br>
(02:24:46 PM) <b>bradass87:</b> it belongs in the public domain<br>
(02:25:15 PM) <b>bradass87:</b> information should be free<br>
(02:25:39 PM) <b>bradass87:</b> it belongs in the public domain<br>
(02:26:18 PM) <b>bradass87:</b> because another state would just take advantage of the information... try and get some edge<br>
(02:26:55 PM) <b>bradass87:</b> if its out in the open... it should be a public good<br>
(02:27:04 PM) <b>bradass87:</b> *do the<br>
(02:27:23 PM) <b>bradass87:</b> rather than some slimy intel collector<br>
(02:29:18 PM) <b>bradass87:</b> im crazy like that<br>
<ins>(02:29:18 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(02:29:31 PM) <b>info@adrianlamo.com:</b> sorry, phone call<br>
(02:30:09 PM) <b>bradass87:</b> n/p<br>
(02:35:42 PM) <b>bradass87:</b> “Net-Centric Diplomacy”<br>
(02:38:29 PM) <b>bradass87:</b> http://www.flickr.com/photos/22683890@N00/ photos by the guy who runs “Net-Centric Diplomacy”<br>
(02:41:23 PM) <b>bradass87:</b> AKA “NCD” http://www.google.com/search?q=%22net+centric+diplomacy%22<br>
(02:41:23 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(02:44:06 PM) <b>bradass87:</b> http://www.sixpica.com/blog/2009/04/05/preparing-your-eer-forms-and-tips/<br>
(02:44:07 PM) <b>bradass87:</b> paragraph 2.<br>
(02:46:25 PM) <b>info@adrianlamo.com:</b> ok, back<br>
(02:46:42 PM) <b>info@adrianlamo.com:</b> two back-to-back calls<br>
(02:47:06 PM) <b>bradass87:</b> im armed... ;) so im ready for whoever you called<br>
(02:47:56 PM) <b>info@adrianlamo.com:</b> haha<br>
(02:48:32 PM) <b>info@adrianlamo.com:</b> or was that serious paranoia? :PP<br>
(02:48:54 PM) <b>bradass87:</b> would i be communicating with you if i were that paranoid?<br>
(02:49:36 PM) <b>info@adrianlamo.com:</b> hey, people are strange<br>
(02:49:54 PM) <b>bradass87:</b> re: sent links, basically all published cables that aren’t NODIS, or EXDIS<br>
(02:50:44 PM) <b>bradass87:</b> (17) SIPDIS--”formessagesintendedforautomaticWebpublishingtothe originating post’s or office’s Web site. (see 5 FAM 770 for policies regarding information on Federal Web site and 5 FAH-2 H-443.1, When and How to Use SIPDIS);<br>
(02:51:58 PM) <b>bradass87:</b> http://www.state.gov/documents/organization/89284.pdf<br>
(02:52:03 PM) <b>bradass87:</b> [reference]<br>
(02:52:47 PM) <b>bradass87:</b> state dept fucked itself... placed volumes and volumes of information in a single spot, with no security<br>
(02:53:28 PM) <b>info@adrianlamo.com:</b> only the people you trust can fuck you – infowise ;&gt;<br>
(02:54:03 PM) <b>bradass87:</b> so anything published, and classified up to SECRET//NOFORN<br>
(02:54:44 PM) <b>info@adrianlamo.com:</b> in all seriousness, would you shoot if MP’s showed up? ;&gt;<br>
(02:55:04 PM) <b>bradass87:</b> why would i need to?<br>
(02:55:18 PM) <b>info@adrianlamo.com:</b> suicide by MP.<br>
(02:55:34 PM) <b>bradass87:</b> :L<br>
(02:55:39 PM) <b>bradass87:</b> do i seem unhinged?<br>
(02:56:04 PM) <b>info@adrianlamo.com:</b> i mean, showed up – for you – if Julian were to slip up.<br>
(02:56:46 PM) <b>bradass87:</b> he knows very little about me<br>
(02:56:54 PM) <b>bradass87:</b> he takes source protection uber-seriously<br>
(02:57:01 PM) <b>bradass87:</b> “lie to me” he says<br>
(02:57:06 PM) <b>info@adrianlamo.com:</b> Really. Interesting.<br>
(02:57:34 PM) <b>bradass87:</b> he wont work with you if you reveal too much about yourself<br>
(02:58:13 PM) <b>info@adrianlamo.com:</b> why talk to me?<br>
(02:58:47 PM) <b>bradass87:</b> because </ins><ins class="wiredquote-0610">im isolated as fuck... my life is falling apart, and i dont have anyone to talk to</ins><ins><br>
(02:59:02 PM) <b>info@adrianlamo.com:</b> I’m flattered ;)<br>
(02:59:09 PM) <b>info@adrianlamo.com:</b> How is it falling apart?<br>
(02:59:41 PM) <b>bradass87:</b> GID... discharge... family issuess... and possibility of transition in near future<br>
(03:00:21 PM) <b>bradass87:</b> its all happening so quick for me... its overwhelming :’(<br>
(03:00:35 PM) <b>info@adrianlamo.com:</b> but you make a cute boy! ;&gt;<br>
(03:00:53 PM) <b>bradass87:</b> im not comfortable with myself<br>
(03:01:06 PM) <b>bradass87:</b> im in an awkward state<br>
(03:01:23 PM) <b>info@adrianlamo.com:</b> i don’t understand, but i understand the idea, if that makes sense.<br>
(03:01:39 PM) <b>bradass87:</b> and the weird part is... i love my job... i was very good at it... i wish this didnt have to happen like this<br>
(03:01:48 PM) <b>info@adrianlamo.com:</b> one of my ex’s is living as a girl in .au<br>
(03:02:05 PM) <b>bradass87:</b> i dont understand it either<br>
(03:04:05 PM) <b>bradass87:</b> its clearly an issue... i mean, i dont think its normal for people to spend this much time worrying about whether they’re behaving masculine enough, whether what they’re going to say is going to be perceived as “gay”... not to mention how i feel about the situation... for whatever reason, im not comfortable with myself... i mean, i behave and look like a male, but its not “me” =L<br>
(03:04:34 PM) <b>bradass87:</b> its... odd<br>
(03:04:40 PM) <b>bradass87:</b> or at least painful<br>
(03:05:31 PM) <b>bradass87:</b> 8 months ago, if you’d have asked me whether i wanted i would identify as female, i’d say you were crazy<br>
(03:06:11 PM) <b>bradass87:</b> that started to slip very quickly, as the stresses continued and piled up<br>
(03:06:48 PM) <b>bradass87:</b> </ins><ins class="wiredquote-0610">i had about three breakdowns</ins><ins>... </ins><ins class="wiredquote-0610">successively worse, each one revealing more and more of my uncertainty and emotional insecurity</ins><ins><br>
(03:07:57 PM) <b>bradass87:</b> now... i spend a lot of time thinking of transitioning... im now very familiar with the process... and have a rough plan of how to get portions of it to work<br>
(03:10:34 PM) <b>info@adrianlamo.com:</b> *nod*<br>
(03:10:39 PM) <b>info@adrianlamo.com:</b> *makes the bed*<br>
(03:11:15 PM) <b>bradass87:</b> have you heard similar?<br>
(03:11:22 PM) <b>info@adrianlamo.com:</b> yes<br>
(03:12:25 PM) <b>bradass87:</b> what did your ex say? if you dont mind me asking?<br>
(03:14:15 PM) <b>info@adrianlamo.com:</b> they felt uncomfortable in their own body, they hated their genitals, they didn’t like looking manly<br>
(03:14:49 PM) <b>bradass87:</b> im uncomfortable with my role in society in particular...<br>
(03:15:30 PM) <b>bradass87:</b> im not so uncomfortable with my genitalia, i mean, it works for me... but i dont like the masculine features in my appearance<br>
(03:17:04 PM) <b>bradass87:</b> i went on leave in late january / early february... and... i cross-dressed, full on... wig, breastforms, dress, the works... i had crossdressed before... but i was public... for a few days<br>
(03:17:33 PM) <b>bradass87:</b> i blended in....<br>
(03:17:34 PM) <b>bradass87:</b> no-one knew<br>
(03:18:06 PM) <b>bradass87:</b> the first thing i learned was that chivalry isn’t dead... men would walk out of their way and open doors for me... it was so weird<br>
(03:18:19 PM) <b>info@adrianlamo.com:</b> awww.<br>
(03:18:51 PM) <b>bradass87:</b> i was referred to as “Ma’am” or “Miss” at places like Starbucks and McDonalds (hey, im not a fancy eater)<br>
(03:19:35 PM) <b>bradass87:</b> i even took the Acela from DC to Boston... whatever compelled me to do that... idk... but i wanted to see my then-still-boyfriend<br>
(03:20:01 PM) <b>bradass87:</b> i rode the train, dressed in a casual business outfit<br>
(03:20:36 PM) <b>bradass87:</b> i really enjoyed the trip... minus the conductor<br>
(03:21:06 PM) <b>bradass87:</b> as he asked for my ID, and clipped my ticket... he made a fuss<br>
(03:21:24 PM) <b>info@adrianlamo.com:</b> that sucks =z<br>
(03:21:26 PM) <b>bradass87:</b> “Thank you, MISTER Manning...”<br>
(03:21:31 PM) <b>info@adrianlamo.com:</b> asshole<br>
(03:21:35 PM) <b>info@adrianlamo.com:</b> him, not you<br>
(03:21:41 PM) <b>bradass87:</b> i know<br>
(03:21:53 PM) <b>bradass87:</b> it was... an experience i wont forget...<br>
(03:22:36 PM) <b>bradass87:</b> i mean... 99.9% of people coming from iraq and afghanistan want to come home, see their families, get drunk, get laid...<br>
(03:22:56 PM) <b>bradass87:</b> i... wanted to try living as a woman, for whatever reason<br>
(03:23:14 PM) <b>bradass87:</b> obviously, its important to me... since there were plenty of other things i could’ve done<br>
(03:23:23 PM) <b>info@adrianlamo.com:</b> Overall, how did you feel about your sojourn?<br>
(03:25:50 PM) <b>bradass87:</b> idk, i just kind of blended in... i didn’t have to make an effort to do so, it just came naturally... instead of thinking all the time about how im perceived, being self conscious, i just let myself go... ...well, i was still self-concious, but in a different way... i was worried about whether i looked pretty, whether my makeup was running, whether i spilled coffee on my (expensive) outfit... and to some extent whether i was passing...<br>
(03:28:12 PM) <b>bradass87:</b> but i went to get gas... and bought cigarettes (i know, need to quit)... and the man asked to see my ID... so i did... and he about had a heart attack... he couldn’t hold himself back, he looked up and down twice... and gave me this look like... WTF, it is the same... handed it back to me... and tried to keep himself composed... so i wasn’t worried about whether i was passing as much, because he had no idea whatsoever<br>
(03:28:55 PM) <b>info@adrianlamo.com:</b> i smoze zero to five a day myself.<br>
(03:29:44 PM) <b>bradass87:</b> but the point was, i guess my face is androgynous enough that i can pass with ease<br>
(03:30:11 PM) <b>bradass87:</b> my prominent adams apple is the only issue i was concerned about<br>
(03:30:26 PM) <b>bradass87:</b> so i wore a turtleneck, and had collar up with my coat<br>
(03:30:29 PM) <b>info@adrianlamo.com:</b> yeah, i’d say that re. the former.<br>
(03:30:38 PM) <b>info@adrianlamo.com:</b> which i find cute.<br>
(03:32:29 PM) <b>bradass87:</b> i dont think i’d need much work done for FFS, if i seeked for it<br>
(03:32:58 PM) <b>bradass87:</b> *sought it<br>
(03:33:07 PM) <b>bradass87:</b> (my english is BAD today)<br>
(03:34:25 PM) <b>info@adrianlamo.com:</b> hey, can you torrent from there<br>
(03:34:45 PM) <b>bradass87:</b> i’ve tried... it eats too much bandwidth<br>
(03:34:54 PM) <b>info@adrianlamo.com:</b> limit it<br>
(03:35:00 PM) <b>info@adrianlamo.com:</b> with utorrent<br>
(03:35:14 PM) <b>bradass87:</b> tried... its just not working<br>
(03:35:20 PM) <b>info@adrianlamo.com:</b> shame<br>
(03:35:23 PM) <b>bradass87:</b> satellite cant handle<br>
(03:36:05 PM) <b>bradass87:</b> one of the reasons its taking so long to see “Hackers Wanted”... still downloading portions<br>
(03:36:14 PM) <b>info@adrianlamo.com:</b> *nod*<br>
</ins>(03:38:07 PM) <b>bradass87:</b> its not much of a pic, but here’s harry ponting http://farm4.static.flickr.com/3161/2814062024_c39d25f27d.jpg the man who’s mission it is to sell the benefits of NCD throughout the State Department, Military, and IC<br>
(03:38:18 PM) <b>bradass87:</b> i feel terribly, terribly sorry for the guy :(<br>
(03:39:17 PM) <b>bradass87:</b> im not a bad person, i keep track of everything<br>
(03:39:30 PM) <b>bradass87:</b> i watch the whole thing unfold... from a distance<br>
(03:40:07 PM) <b>bradass87:</b> i read what everyone says... look at pictures... keep tabs... and feel for them<br>
(03:40:18 PM) <b>bradass87:</b> since im basically playing a vital role in their life<br>
(03:40:29 PM) <b>bradass87:</b> without ever meeting them<br>
(03:40:53 PM) <b>bradass87:</b> i was like that as an intelligence analyst as well<br>
(03:41:09 PM) <b>info@adrianlamo.com:</b> i know the feeling, in a way.<br>
(03:41:44 PM) <b>bradass87:</b> most didnt care... but i knew, i was playing a role in the lives of hundreds of people, without them knowing them... but i cared, and kept track of some of the details, make sure everybody was okay<br>
(03:42:07 PM) <b>bradass87:</b> them knowing me<br>
(03:43:27 PM) <b>bradass87:</b> i dont think of myself as playing “god” or anything, because im not... im just playing my role for the moment... i dont control the way they react<br>
(03:44:15 PM) <b>bradass87:</b> there are far more people who do what i do, in state interest, on daily basis, and dont give a fuck<br>
(03:45:01 PM) <b>bradass87:</b> thats how i try to separate myself<br>
(03:45:13 PM) <b>bradass87:</b> from my (former) colleagues<del> Lamo asked what additional material Manning gave to Julian Assange at Wikileaks.</del><br>
<ins>(03:45:31 PM) <b>info@adrianlamo.com:</b> odds are, people feel the same way about you.<br>
(03:46:16 PM) <b>bradass87:</b> how do you mean?<br>
(03:49:25 PM) <b>info@adrianlamo.com:</b> at higher or different levels, making decisions that affect you.<br>
(03:50:32 PM) <b>bradass87:</b> in Ethan McCord’s case... for instance... i watched the guy earlier this year, after i decided to release, carrying the girl and boy out of the van... and imagining his/her reaction to seeing themselves on television, again and again... then he came out publicly and said so on Australian television<br>
(03:51:08 PM) <b>bradass87:</b> how he saw himself on television that is<br>
(03:51:36 PM) <b>bradass87:</b> coming home from dropping kids off school at<br>
(03:51:48 PM) <b>bradass87:</b> or picking them up... cant remember... more likely picking up<br>
(03:51:56 PM) <b>bradass87:</b> [afternoon / evening]<br>
(03:52:10 PM) <b>bradass87:</b> yes, but im often aware of who’s making decisions that affect me<br>
(03:52:13 PM) <b>bradass87:</b> most aren’t<br>
(03:52:28 PM) <b>info@adrianlamo.com:</b> who is?<br>
(03:52:49 PM) <b>info@adrianlamo.com:</b> making them. apart from immediate superiors.<br>
(03:53:00 PM) <b>bradass87:</b> Commanders, Politicians, Journalists, the works... i try to keep track<br>
(03:53:26 PM) <b>bradass87:</b> i have sources in the White House re: DADT and the disaster that keeps going on with that<br>
(03:53:49 PM) <b>info@adrianlamo.com:</b> anyone i should know? i’m in DC a lot.<br>
(03:53:52 PM) <b>bradass87:</b> not to mention HRC<br>
(03:53:58 PM) <b>info@adrianlamo.com:</b> raised there.<br>
(03:53:59 PM) <b>bradass87:</b> Shin Inouye<br>
(03:54:32 PM) <b>info@adrianlamo.com:</b> from grades 2-5<br>
(03:54:51 PM) <b>bradass87:</b> also, some Joint Staff people... a (bisexual) LTC at the Pentagon<br>
(03:55:42 PM) <b>bradass87:</b> only agency i cant get information out of at the highest levels is the FBI... i’ve never needed a source there<br>
(03:56:16 PM) <b>info@adrianlamo.com:</b> anyone I should talk to if you disappear one day?<br>
(03:56:29 PM) <b>bradass87:</b> good question<br>
(03:57:10 PM) <b>bradass87:</b> i gave ex-bf a list... some use he is now<br>
(03:57:29 PM) <b>info@adrianlamo.com:</b> I have more cred with the press :x<br>
(03:57:37 PM) <b>bradass87:</b> indeed...<br>
(03:58:05 PM) <b>bradass87:</b> I’m a source for Chris Johnson of Washington Blade... i feed with my sub-sources<br>
(03:59:03 PM) <b>bradass87:</b> not to mention objective personal experience of DADT... and how its actually working out “on the ground”<br>
(03:59:11 PM) <b>info@adrianlamo.com:</b> what about the sub-sources themselves? just out in the cold?<br>
(03:59:38 PM) <b>bradass87:</b> yes, they’re politically tied<br>
(04:00:50 PM) <b>bradass87:</b> so, they wouldn’t be in the cold, per se<br>
(04:00:57 PM) <b>bradass87:</b> but i would disavow them<br>
(04:00:58 PM) <b>info@adrianlamo.com:</b> ... everything else, but you don’t trust me with that? heh.<br>
(04:01:19 PM) <b>bradass87:</b> these are good people, who just happen to be gay<br>
(04:01:29 PM) <b>bradass87:</b> it would be wrong of me to confirm / deny<br>
(04:01:46 PM) <b>bradass87:</b> check queerty.com (mostly accurate)<br>
(04:01:50 PM) <b>bradass87:</b> :P<br>
(04:01:52 PM) <b>info@adrianlamo.com:</b> fair enough<br>
(04:02:16 PM) <b>bradass87:</b> ask them, not me... i say<br>
(04:02:46 PM) <b>bradass87:</b> (i keep my promises to my friends, believe it or not)<br>
(04:03:15 PM) <b>info@adrianlamo.com:</b> I can respect that.<br>
(04:03:21 PM) <b>info@adrianlamo.com:</b> And do.<br>
(04:04:10 PM) <b>bradass87:</b> Just hang around the right bars at the right times in Dupont Circle... and you can meet them yourself, you wouldn’t need me =P<br>
(04:04:26 PM) <b>info@adrianlamo.com:</b> I have. Hung out there :P<br>
(04:04:42 PM) <b>info@adrianlamo.com:</b> Any bars in particular?<br>
(04:04:52 PM) <b>bradass87:</b> they keep freakin’ changing<br>
(04:05:14 PM) <b>info@adrianlamo.com:</b> heh<br>
(04:05:16 PM) <b>bradass87:</b> changing names and locations... its been a different scene every time i go back to DC...<br>
(04:05:38 PM) <b>bradass87:</b> and im only gone 4-6 months each time =[<br>
(04:06:22 PM) <b>bradass87:</b> i usually give [redacted] a call if i need to know whats hot in town<br>
(04:07:47 PM) <b>bradass87:</b> here’s some public advice: http://twitter.com/[redacted]/status/[redacted] =P<br>
(04:08:08 PM) <b>bradass87:</b> [Tweet redacted]<br>
(04:09:11 PM) <b>bradass87:</b> i was [redacted]’s first boyfriend after [redacted]<br>
(04:09:28 PM) <b>bradass87:</b> i encouraged him to seek out relationships again”<br>
(04:09:31 PM) <b>bradass87:</b> ”<br>
(04:10:04 PM) <b>bradass87:</b> now he’s engaged to his fiancee [redacted]<br>
(04:10:32 PM) <b>bradass87:</b> (im a pretty connected guy for a ghost, i guess)<br>
(04:12:01 PM) <b>info@adrianlamo.com:</b> :)<br>
(04:13:27 PM) <b>bradass87:</b> i guess in a way, im just getting started<br>
(04:13:43 PM) <b>bradass87:</b> i mean... im not even 23 ye<br>
(04:13:48 PM) <b>bradass87:</b> *yet<br>
(04:19:02 PM) <b>info@adrianlamo.com:</b> this is true<br>
(04:22:03 PM) <b>bradass87:</b> i keep my DADT trail semi-secure<br>
(04:22:11 PM) <b>info@adrianlamo.com:</b> howso?<br>
(04:22:17 PM) <b>bradass87:</b> i figure its plausible deniability<br>
(04:22:43 PM) <b>bradass87:</b> for the more extreme stuff<br>
(04:22:56 PM) <b>info@adrianlamo.com:</b> .... howso?<br>
(04:23:13 PM) <b>bradass87:</b> well, if investigated, it provides a huge number of red herrings<br>
(04:23:57 PM) <b>bradass87:</b> politically sensitive... it would be a small domestic scandal<br>
(04:25:33 PM) <b>bradass87:</b> one of my contacts is the Special Forces officer who was involved in the (awful) interrogation of John Walker Lindh<br>
(04:26:07 PM) <b>bradass87:</b> he witnessed the death of his CIA colleagues<br>
(04:26:23 PM) <b>bradass87:</b> he’s a hero... and he’s gay<br>
(04:27:34 PM) <b>bradass87:</b> *capture and interrogation of<br>
(04:28:13 PM) <b>bradass87:</b> i know, its all very complicated and difficult to believe, which is good for me<br>
(04:28:56 PM) <b>bradass87:</b> but, i hope i can live a less ambiguous life soon... as i transition<br>
(04:29:30 PM) <b>info@adrianlamo.com:</b> I wish you a less ambiguous life as well.<br>
(04:29:41 PM) <b>bradass87:</b> thank you<br>
(04:29:57 PM) <b>bradass87:</b> i sincerely believe i deserve one :(<br>
(04:31:26 PM) <b>bradass87:</b> http://en.wikipedia.org/wiki/Battle_of_Qala-i-Jangi<br>
</ins>(04:32:05 PM) <b>bradass87:</b> oh, the JTF GTMO papers... Assange has those too<br>
(04:32:16 PM) <b>info@adrianlamo.com:</b> Read it.<br>
(04:33:21 PM) <b>info@adrianlamo.com:</b> Anything else interesting on his table, as a former collector of interesting .com info?<br>
(04:33:44 PM) <b>bradass87:</b> idk... i only know what i provide him xD<br>
(04:34:14 PM) <b>info@adrianlamo.com:</b> what do you consider the highlights?<br>
(04:35:31 PM) <b>bradass87:</b> The Gharani airstrike videos and full report, Iraq war event log, the “Gitmo Papers”, and State Department cable database<br>
(04:35:50 PM) <b>info@adrianlamo.com:</b> Not too shabby.<br>
(04:36:03 PM) <b>bradass87:</b> thats just me....<ins> :$</ins><br>
(04:36:26 PM) <b>bradass87:</b> idk about the rest... he *hopefully* has more<br>
<ins>(04:36:38 PM) <b>info@adrianlamo.com:</b> he does.<br>
(04:36:52 PM) <b>info@adrianlamo.com:</b> i tested him once.<br>
(04:37:03 PM) <b>info@adrianlamo.com:</b> i donated once upon a time<br>
(04:37:17 PM) <b>info@adrianlamo.com:</b> the donor e-mail solicitation was CC’d<br>
(04:37:19 PM) <b>bradass87:</b> and leaked the list of donars<br>
(04:37:23 PM) <b>info@adrianlamo.com:</b> not BCC’d<br>
(04:37:28 PM) <b>info@adrianlamo.com:</b> yeah.<br>
(04:37:31 PM) <b>bradass87:</b> *donor<br>
(04:37:44 PM) <b>info@adrianlamo.com:</b> he ran it anyway.<br>
(04:37:51 PM) <b>bradass87:</b> &gt;nod&lt;<br>
(04:37:51 PM) <b>info@adrianlamo.com:</b> that’s integrity.<br>
(04:38:14 PM) <b>bradass87:</b> well, afaik, he made an attempt to contact as many of those on the list as possible<br>
(04:38:20 PM) <b>bradass87:</b> i dont know if thats true<br>
(04:38:30 PM) <b>info@adrianlamo.com:</b> didn’t contact me ;&gt;<br>
(04:39:29 PM) <b>bradass87:</b> icelandic reporters from RUV travelled to baghdad and found the two kids, and the reuters staff family<br>
(04:39:38 PM) <b>bradass87:</b> as a WL “away team”<br>
(04:40:25 PM) <b>bradass87:</b> btw... i just finished downloading HW<br>
</ins>(04:42:16 PM) <b>bradass87:</b> im not sure whether i’d be considered a type of “hacker”, “cracker”, “hacktivist”, “leaker” or what...<br>
(04:42:26 PM) <b>bradass87:</b> im just me... really<br>
(04:44:21 PM) <b>bradass87:</b> starts off like every physics / astro class intro... ever<br>
(04:44:21 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(04:44:45 PM) <b>bradass87:</b> albeit without the algebraic proofs<br>
(04:45:20 PM) <b>info@adrianlamo.com:</b> or a spy :)<br>
(04:45:48 PM) <b>bradass87:</b> i couldn’t be a spy...<br>
(04:45:59 PM) <b>bradass87:</b> spies dont post things up for the world to see<br>
(04:46:14 PM) <b>info@adrianlamo.com:</b> Why? Wikileaks would be the perfect cover<br>
(04:46:23 PM) <b>info@adrianlamo.com:</b> They post what’s not useful<br>
(04:46:29 PM) <b>info@adrianlamo.com:</b> And keep the rest<br>
<ins>(04:46:36 PM) <b>info@adrianlamo.com:</b> *devil’s advocate*<br>
(04:46:55 PM) <b>bradass87:</b> too much Wayne Madsen for you... =P<br>
(04:47:42 PM) <b>info@adrianlamo.com:</b> : P<br>
(04:48:10 PM) <b>info@adrianlamo.com:</b> i didn’t know who he was until just now<br>
(04:55:35 PM) <b>bradass87:</b> im “pink hat”<br>
(05:13:21 PM) <b>bradass87:</b> oh, btw... china has a massive botnet<br>
(05:13:21 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(05:13:31 PM) <b>bradass87:</b> 45+ million, grows 100,000 every two weeks<br>
(05:14:44 PM) <b>bradass87:</b> it pings eucom and pacom servers every two weeks at the same time... spread out slightly to prevent the bandwidth from being detected (it was identified at 20 million in late 2008)<br>
(05:14:54 PM) <b>bradass87:</b> *2008 )<br>
(05:15:53 PM) <b>bradass87:</b> 45+ million ip addresses... i figure they must have a pre-installed system on consumer electronics<br>
(05:20:00 PM) <b>bradass87:</b> are you familiar with the Byzantine problem sets?<br>
(05:22:15 PM) <b>info@adrianlamo.com:</b> nope<br>
(05:23:10 PM) <b>bradass87:</b> Byzantine is the code word for all the chinese infiltration problem sets... the ones that get .mil info... as well as penetrate google (like what became public earlier this year)<br>
(05:23:16 PM) <b>bradass87:</b> yahoo, etc<br>
(05:23:23 PM) <b>bradass87:</b> mostly .gov and .mil<br>
(05:23:46 PM) <b>bradass87:</b> there are several sub-problem sets...<br>
(05:24:15 PM) <b>bradass87:</b> Byzantine Candor, for instance<br>
(05:24:51 PM) <b>bradass87:</b> its what 95% of information warfare people work on in DoD<br>
(05:25:15 PM) <b>bradass87:</b> china can knock out any network in the world with a DDos<br>
(05:25:20 PM) <b>bradass87:</b> *DDoS<br>
(05:36:07 PM) <b>bradass87:</b> their gateways throughout the world are clearly identified, and are being tracked carefully<br>
(05:36:07 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(05:46:21 PM) <b>info@adrianlamo.com:</b> interesting<br>
(05:47:21 PM) <b>info@adrianlamo.com:</b> yet i can compromise foreign networks because they speak machine and use English-friendly products.<br>
(05:47:47 PM) <b>bradass87:</b> yeah, china uses a lot of scripts... poor spear fishing<br>
(05:48:37 PM) <b>bradass87:</b> they dont get much, since they cant penetrate the airgap...<br>
(05:48:59 PM) <b>info@adrianlamo.com:</b> Do you know of any ops in Colombia other than anti-narco ones?<br>
(05:50:11 PM) <b>bradass87:</b> not really... i know of state department initiatives to improve relations with columbians... mostly because of our poor history there... and because we’re still tracking FARC<br>
(05:50:30 PM) <b>info@adrianlamo.com:</b> Venezuela?<br>
(05:50:45 PM) <b>bradass87:</b> borders watched closely<br>
(05:51:12 PM) <b>info@adrianlamo.com:</b> But nothing specific?<br>
(05:51:24 PM) <b>bradass87:</b> smuggling, trafficking... for some reason a lot of DC politicos don’t like Chavez<br>
(05:51:41 PM) <b>info@adrianlamo.com:</b> Imagine that.<br>
(05:51:53 PM) <b>bradass87:</b> i dont give specifics unless i have them in front of me, sorry<br>
(05:52:09 PM) <b>info@adrianlamo.com:</b> why?<br>
(05:52:24 PM) <b>bradass87:</b> because my memory sucks sometimes<br>
(05:52:52 PM) <b>info@adrianlamo.com:</b> You’re a leftist, I take it. Not a bad thing. My dad has a book signed by Philip Agee.<br>
(05:53:09 PM) <b>bradass87:</b> i dont have a doctrine<br>
(05:53:40 PM) <b>bradass87:</b> socialism / capitalism are the same thing in practice<br>
(05:53:57 PM) <b>info@adrianlamo.com:</b> Everyone does. Our beliefs place us somewhere, even if it’s “centrist”<br>
(05:54:15 PM) <b>bradass87:</b> i know i do, but i havent quite defined it<br>
(05:54:17 PM) <b>info@adrianlamo.com:</b> except apathetic<br>
(05:54:42 PM) <b>bradass87:</b> apathy is its own 3rd dimension... i have special graph for that... =P<br>
(05:54:56 PM) <b>info@adrianlamo.com:</b> I’m a fan of of realpolitik myself.<br>
(05:55:10 PM) <b>bradass87:</b> i dont quite know<br>
(05:55:34 PM) <b>bradass87:</b> seen too much reality to be “polar”<br>
(05:56:02 PM) <b>bradass87:</b> i dont like dogma, thats one thing i can say without doubt...<br>
(05:56:13 PM) <b>info@adrianlamo.com:</b> Reality ... how you say, is what you can get away with.<br>
(06:00:36 PM) <b>bradass87:</b> ive seen detailed imagery of columbia<br>
(06:01:00 PM) <b>bradass87:</b> as well as tehran streets... haiti’s reconstruction<br>
(06:01:24 PM) <b>bradass87:</b> even the reykjavik embassy ;)<br>
(06:01:24 PM) info@adrianlamo.com &lt;AUTO-REPLY&gt;: I’m not here right now<br>
(06:01:51 PM) <b>info@adrianlamo.com:</b> Colombia with an o. Pet peeve.<br>
(06:02:08 PM) <b>bradass87:</b> my bad<br>
(06:02:15 PM) <b>bradass87:</b> im a DC guy, it slipped<br>
(06:02:27 PM) <b>info@adrianlamo.com:</b> They have McDonald’s in Tehran yet?<br>
(06:02:41 PM) <b>bradass87:</b> no, but i was awestruck<br>
(06:03:09 PM) <b>info@adrianlamo.com:</b> not familiar<br>
(06:03:26 PM) <b>bradass87:</b> public transit systems, highways systems, its a very advanced city... way far ahead of baghdad... its like 1980s japan<br>
(06:04:17 PM) <b>bradass87:</b> still behind that curve, but remarkably advanced...<br>
(06:04:47 PM) <b>bradass87:</b> definitely a comparasion to japan, with the mountains and the buildings placed on top of buildings to save room<br>
(06:05:05 PM) <b>bradass87:</b> its no joke of a city<br>
(06:08:53 PM) <b>info@adrianlamo.com:</b> What’s your greatest fear?<br>
(06:09:24 PM) <b>bradass87:</b> dying without ever truly living<br>
(06:10:16 PM) <b>bradass87:</b> cliche, but honest<br>
(06:10:33 PM) <b>info@adrianlamo.com:</b> i keep forgetting you’re 22<br>
(06:11:50 PM) <b>info@adrianlamo.com:</b> i had my first /really/ ltr (more’n six months) at 22<br>
(06:12:13 PM) <b>info@adrianlamo.com:</b> They went on the run from the FBI /w me<br>
(06:12:30 PM) <b>info@adrianlamo.com:</b> that’s love/<br>
(06:12:46 PM) <b>info@adrianlamo.com:</b> Crazy as a shithouse rat, tho.<br>
(06:16:09 PM) <b>bradass87:</b> lol<br>
(06:16:21 PM) <b>bradass87:</b> i dont know if i can meet people who love me<br>
(06:16:37 PM) <b>bradass87:</b> no-one ever sticks around long enough to know me<br>
(06:16:45 PM) <b>bradass87:</b> those who do, become good friends...<br>
(06:16:51 PM) <b>bradass87:</b> but thats not the same<br>
(06:17:18 PM) <b>bradass87:</b> i just ended my first ltr<br>
(06:17:30 PM) <b>bradass87:</b> so im probably still depressed<br>
(06:17:45 PM) <b>bradass87:</b> (i dont know my own emotions that well)<br>
(06:17:58 PM) <b>bradass87:</b> [repression is a bitch]<br>
(06:19:08 PM) <b>bradass87:</b> i often get to know people intimately well<br>
(06:19:14 PM) <b>bradass87:</b> but it doesn’t reflect<br>
(06:24:29 PM) <b>bradass87:</b> ive seen far more than a 22 y/o should<br>
(06:25:00 PM) <b>info@adrianlamo.com:</b> so had I =z
</ins>
</div>
</body>
</html><?php
// -----
db_close_compressed_cache();
}
