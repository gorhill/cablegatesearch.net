// from: http://www.cablegatesearch.net
var CablegateObject;
if (!CablegateObject) {
	CablegateObject = {};
	}

(function(){

	var co = CablegateObject;

	if (co.cables) {
		return;
		}
	co.cables = {};

	co.isCableExpanded = function(id){
		var div=$('cableid-'+String(id)).getElement('.cable-preview');
		return div && div.getStyle('display')!=='none';
		};

	co.showCableHeader = function(e){
		e.getParent('div').getElement('p:first-child').setStyle('display','');
		e.set('text','Hide header');
		};

	co.hideCableHeader = function(e){
		e.getParent('div').getElement('p:first-child').setStyle('display','none');
		e.set('text','Show header');
		};

	co.toggleCableHeader = function(ev){
		var pheader=this.getParent('div').getElement('p:first-child');
		if (pheader.getStyle('display')!=='none'){
			co.hideCableHeader(this);
			co.hideHeaders=true;
			}
		else {
			co.showCableHeader(this);
			co.hideHeaders=false;
			}
		Cookie.write('cablegateHideHeaders',co.hideHeaders,{duration:365});
		};

	co.highlightNavHandler = function(ev){
		if (this.src.search(/next/i)>=0){
			co.gotoNextHilight(this);
			}
		else if (this.src.search(/previous/i)>=0){
			co.gotoPrevHilight(this);
			}
		};

	co.gotoHilight = function(e,delta){
		var cableContainer=e.getParent('.cable-preview').getElement('div:first-child + div');
		var highlites=cableContainer.retrieve('highlites');
		if (!highlites) {
			highlites=cableContainer.getElements('.hilite');
			cableContainer.store('highlites',highlites);
			}
		if (!highlites.length) {return;}
		var oldindex=cableContainer.retrieve('highliteIndex');
		var newindex=(oldindex!==null?oldindex:0)+delta;
		if (newindex>=highlites.length){
			newindex=0;
			}
		else if (newindex<0){
			newindex=highlites.length-1;
			}
		if (newindex!==oldindex){
			if (oldindex!==null){
				highlites[oldindex].addClass('hilite');
				highlites[oldindex].removeClass('hilite-with-focus');
				}
			highlites[newindex].addClass('hilite-with-focus');
			highlites[newindex].removeClass('hilite');
			cableContainer.store('highliteIndex',newindex);
			}
		var scroll=new Fx.Scroll(cableContainer,{offset:{'x':0,'y':-30}});
		scroll.toElement(highlites[newindex]);
		};

	co.gotoNextHilight = function(e){
		this.gotoHilight(e,1);
		};

	co.gotoPrevHilight = function(e){
		this.gotoHilight(e,-1);
		};

	// Author: Raymond Hill
	// Version: 2011-01-17
	// Title: HTML text hilighter
	// Permalink: http://www.raymondhill.net/blog/?p=272
	// Purpose: Hilight portions of text inside a specified element, according to a search expression.
	// Key feature: Can safely hilight text across HTML tags.
	// Notes: Minified using YUI Compressor (http://refresh-sf.com/yui/),
	co.doHighlight = function(A,c,z,s){
		var G=document;if(typeof A==="string"){A=G.getElementById(A)}if(typeof z==="string"){z=new RegExp(z,"ig")}s=s||0;var j=[],u=[],B=0,o=A.childNodes.length,v,w=0,l=[],k,d,h;for(;;){while(B<o){k=A.childNodes[B++];if(k.nodeType===3){j.push({i:w,n:k});v=k.nodeValue;u.push(v);w+=v.length}else{if(k.nodeType===1){if(k.tagName.search(/^(script|style)$/i)>=0){continue}if(k.tagName.search(/^(a|b|basefont|bdo|big|em|font|i|s|small|span|strike|strong|su[bp]|tt|u)$/i)<0){u.push(" ");w++}d=k.childNodes.length;if(d){l.push({n:A,l:o,i:B});A=k;o=d;B=0}}}}if(!l.length){break}h=l.pop();A=h.n;o=h.l;B=h.i}if(!j.length){return}u=u.join("");j.push({i:u.length});var p,r,E,y,D,g,F,f,b,m,e,a,t,q,C,n,x;for(;;){r=z.exec(u);if(!r||r.length<=s||!r[s].length){break}E=r.index;for(p=1;p<s;p++){E+=r[p].length}y=E+r[s].length;g=0;F=j.length;while(g<F){D=g+F>>1;if(E<j[D].i){F=D}else{if(E>=j[D+1].i){g=D+1}else{g=F=D}}}f=g;while(f<j.length){b=j[f];A=b.n;v=A.nodeValue;m=A.parentNode;e=A.nextSibling;t=E-b.i;q=Math.min(y,j[f+1].i)-b.i;C=null;if(t>0){C=v.substring(0,t)}n=v.substring(t,q);x=null;if(q<v.length){x=v.substr(q)}if(C){A.nodeValue=C}else{m.removeChild(A)}a=G.createElement("span");a.appendChild(G.createTextNode(n));a.className=c;m.insertBefore(a,e);if(x){a=G.createTextNode(x);m.insertBefore(a,e);j[f]={n:a,i:y}}f++;if(y<=j[f].i){break}}}
		};

	co.highlight = function(e,expressions){
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
			this.doHighlight(e,'hilite',new RegExp(expression,'ig'),2);
			}
		};

	co.cableRequestHandler = function(response){
		if (response.id===undefined || response.content===undefined) {return;}
		var header = response.header,
			content = response.content,
			origin = response.origin,
			cabletime = response.cableTime || '',
			classification = response.classification;
		// assemble html of cable preview
		var expressions = co.qTerms ? co.qTerms.split(' ') : [],
			info=[];
		info.push('<b>Reference id:</b>&nbsp;', response.canonicalId, '<br><b>Origin:</b>&nbsp;', origin, '<br><b>Time:</b>&nbsp;', cabletime, '<br><b>Classification:</b>&nbsp;', classification);
		if (expressions.length){
			info.push('<br><b>Highlight:</b>&nbsp;','<','img',' src="go-previous.png" alt="Previous"','>&ensp;<','img',' src="go-next.png" alt="Next"','>');
			}
		var infoContainer = new Element('div',{'html':info.join('')}),
			pheader = new Element('p',{'html':header,styles:{display:co.hideHeaders?'none':''}}),
			pbody = new Element('p',{'html':content,'class':'cable-content'});
		pbody.getElements('a[href^="cable.php"').each(function(atag){atag.target='_blank';});
		pbody.adopt(new Element('span',{
			'class': 'toggleHeader',
			text: co.hideHeaders ? 'Show header' : 'Hide header',
			events: {
				'click':co.toggleCableHeader
				}
			}));
		var cableContainer = new Element('div');
		cableContainer.adopt(pheader,pbody);
		var div=$('cableid-'+response.id).getElement('.cable-preview');
		div.empty();
		div.adopt(infoContainer,cableContainer);
		co.highlight(div,expressions);
		co.cables[response.id]=true;
		// auto scroll to first hilighted word
		co.gotoHilight(cableContainer,0);
		// assign auto scroll handlers
		infoContainer.getElements('img').each(function(img){img.addEvent('click',co.highlightNavHandler);});
		};

	co.cableExpand = function(id){
		var tr=$('cableid-'+String(id));
		var td=tr.getElement('td:nth-of-type(3)');
		var div=td.getElement('.cable-preview');
		if (!div){
			div=new Element('div',{'class':'cable-preview'});
			td.grab(div);
			}
		if (this.cables[id]===undefined) {
			div.set('html','<span style="padding:1em 0.5em;font-style:italic;color:gray">[Loading cable content...]</span>');
			var options={
				url:'cablegate-do.php',
				onSuccess:co.cableRequestHandler,
				onFailure:function(){div.set('html','<span style="color:gray">[Error loading cable content. Try again later.]</span>');}
				};
			var jsonRequest=new Request.JSON(options).get({'command':'get_cable_content','id':id});
			}
		div.setStyle('display','');
		td.removeClass('expandable');
		td.addClass('collapsible');
		};

	co.cableCollapse = function(id){
		var tr=$('cableid-'+String(id));
		tr.getElement('.cable-preview').setStyle('display','none');
		var td=tr.getElement('td:nth-of-type(3)');
		td.addClass('expandable');
		td.removeClass('collapsible');
		};

	co.cablePreviewToggle = function(ev){
		var tr=this.getParent('tr[id^="cableid-"]');
		if (!tr) {return;}
		var id=tr.id.substr(8);
		if (co.isCableExpanded(id)){
			co.cableCollapse(id);
			}
		else {
			co.cableExpand(id);
			}
		//ev.preventDefault();
		};

	co.cablesGetNextRequestHandler = function(response){
		var cables=response.cables;
		var n=cables.length;
		if (n===0) {return;}
		CablegateGetNextInfo.offset+=n;
		CablegateGetNextInfo.num_after-=n;
		// convert cable entries into rows and populate table
		var getnextcablesrow=$('get-next-cables');
		var i, cable,tr;
		for (i=0;i<n;i++){
			cable=cables[i];
			tr=new Element('tr',{id:'cableid-'+cable.id,html:cable.html});
			co.initCableRow(tr);
			tr.inject(getnextcablesrow,'before');
			}
		if (CablegateGetNextInfo.num_after>0){
			$('get-next-cables-num_after').set('text',String(CablegateGetNextInfo.num_after));
			var button=$('get-next-cables-button');
			button.set('text',String(Math.min(100,CablegateGetNextInfo.num_after)));
			button.setProperty('disabled',false);
			button=$('get-next500-cables-button');
			button.set('text',String(Math.min(500,CablegateGetNextInfo.num_after)));
			button.setProperty('disabled',false);
			button.setStyle('display',CablegateGetNextInfo.num_after>100?'':'none');
			}
		else {
			getnextcablesrow.dispose();
			}
		co.updateFilterStats();
		CablegateGetNextInfo.busy=false;
		};

	co.cablesGetNextOnclickHandler = function(){
		if (CablegateGetNextInfo===undefined || CablegateGetNextInfo.button || CablegateGetNextInfo.num_after<=0) {return;}
		CablegateGetNextInfo.busy=true;
		var qty=parseInt(this.innerHTML.match(/\d+/)[0],10);
		CablegateGetNextInfo.limit=qty;
		this.set('text','Retrieving...');
		this.setProperty('disabled',true);
		var options={
			url:'cablegate-do.php',
			onSuccess:co.cablesGetNextRequestHandler
			};
		var jsonRequest=new Request.JSON(options).get(CablegateGetNextInfo);
		};

	co.filterToAnchor = function() {
		var iclassification = $('classification-filters').selectedIndex,
			iorigin = $('origin-filters').selectedIndex;
		var newHash = '';
		if (iclassification || iorigin) {
			newHash = '#';
			if (iclassification) {
				newHash += 'c' + String(iclassification);
				}
			if (iclassification && iorigin) {
				newHash += '-';
				}
			if (iorigin) {
				newHash += 'o' + String(iorigin);
				}
			}
		if (newHash != location.hash) {
			location.hash = newHash;
			}
		};

	co.filterCableRow = function(tr) {
		var visible = true;
		// classification
		var e = tr.getElement('td:first-child');
		//   bit 0 = 1: unclassified
		//   bit 1 = 2: confidential
		//   bit 2 = 4: secret
		var classificationFilter = co.classificationFilter || 0xFF;
		visible = classificationFilter & {'clu':1,'clc':2,'cls':4}[/\bcl[csu]\b/.exec(e.className)];
		// origin
		if (visible) {
			e = tr.getElement('td:nth-of-type(3) > a + a');
			var originFilter = co.originFilter || '';
			visible = originFilter == '' || e.innerHTML == originFilter;
			}
		if (visible) {
			tr.removeClass('dimmed');
			}
		else {
			tr.addClass('dimmed');
			}
		};

	co.filterCableRows = function() {
		$$('#cable-list tr[id^="cableid-"]').each(function(tr){
			co.filterCableRow(tr);
			});
		};

	co.updateFilterStats = function() {
		// collect stats
		var classifications = {cls:0, clc:0, clu:0};
		var origins = {};
		var nCables = 0;
		var e, origin, sel, opt, i, n;
		$$('#cable-list tr[id^="cableid-"]').each(function(tr){
			e = tr.getElement('td:first-child');
			classifications[e.className]++;
			e = tr.getElement('td:nth-of-type(3) > a + a');
			origin = e.innerHTML;
			if (origins[origin] === undefined) {
				origins[origin] = 1;
				}
			else {
				origins[origin]++;
				}
			nCables++;
			});
		// classification selector
		sel = $('classification-filters');
		if (sel) {
			var ns = classifications.cls,
				nc = classifications.clc,
				nu = classifications.clu,
				stats = [0, nCables, ns, ns+nc, nc, nc+nu, nu];
			for (i=1, n=stats.length; i<n; i++) {
				opt = sel.getElement('option:nth-of-type('+String(i)+')');
				opt.set('text',opt.get('text').replace(/^(.*?)(\s[\S]+\d+.*)?$/,'$1 ('+String(stats[i])+')'))
				opt.disabled = !stats[i] ? 'disabled' : '';
				}
			}
		// origin selector
		sel = $('origin-filters');
		if (sel) {
			// remember current selection
			var filter = sel.options[sel.selectedIndex].value;
			// empty current list
			while (sel.length > 1) {sel.remove(1);}
			// refresh number of cables
			opt = sel.options[0];
			opt.set('text',opt.get('text').replace(/^(.*?)(\s[\S]+\d+.*)?$/,'$1 ('+String(nCables)+')'))
			// fill with new choices
			var options = [''];
			for (origin in origins) {
				options.push(origin);
				}
			options.sort();
			for (i=1, n=options.length; i<n; i++) {
				origin = options[i];
				opt = document.createElement('option');
				opt.text = origin + ' ('+String(origins[origin])+')';
				opt.value = origin;
				sel.add(opt, null);
				if (opt.value == filter) {
					sel.selectedIndex = i;
					}
				}
			}
		};

	co.toElapsedTime = function(e){
		var elapsed='';
		var fl=Math.floor;
		var now=new Date();
		// get('text') very slow on Chromium 8.0 Ubuntu... TODO: Investigate
		// var then=Date.parse(e.get('text'));
		var then=Date.parse(e.innerHTML);
		var hours=fl((now.getTime()-then)/3600000);
		if (hours<1){
			elapsed='< 1 hour';
			}
		else if (hours===1){
			elapsed='1 hour';
			}
		else if (hours<48){
			elapsed=String(hours)+' hours';
			}
		else {
			var days=fl(hours/24);
			if (days<30){
				elapsed=String(days)+' days';
				}
			else {
				var weeks=fl(days/7);
				if (weeks<8) {
					elapsed=String(weeks)+' weeks';
					}
				else {
					var months=fl(days/(365/12));
					if (months<24){
						elapsed=String(months)+' months';
						}
					else {
						var years=fl(months/12);
						elapsed=String(years)+' years';
						}
					}
				}
			}
		if (elapsed.length){
			e.set('text',elapsed);
			}
		};

	co.initCableRow = function(tr){
		var id=tr.id.substr(8);
		// add cable preview container
		var td2=tr.getElement('td:nth-of-type(3)');
		if (td2){
			td2.addClass('expandable');
			var td2el=td2.getElement('a');
			if (this.qTermsEncoded) {
				td2el.href+='&q='+this.qTermsEncoded;
				}
			td2el.target='_blank';
			td2.grab(new Element('div',{'class':(co.cartContainsItem(id)?'cartToggler inCart':'cartToggler'),events:{click:co.cartAddRemoveOnclickHandler}}),'top');
			// passthrough click events for expanded/collapsed icon
			td2el=td2.getElement('span:nth-of-type(1)');
			if (td2el) {
				td2el.addEvent('click',co.cablePreviewToggle);
				}
			}
		// convert class "since" items from absolute to relative time
		tr.getElements('.since').each(function(e){co.toElapsedTime(e);});
		// hide/show cable according to classification filter
		co.filterCableRow(tr);
		};

	var init = function(){
		var e;
		// order is important
		// convert absolute time to relative time
		$$('#intro .since').each(function(e){co.toElapsedTime(e);});
		// to pass on cable page for highlighting
		e=$('qexpressions');
		if (e && e.innerHTML !== ''){
			co.qTerms=e.innerHTML;
			co.qTermsEncoded=encodeURIComponent(e.innerHTML);
			}
		// read cookies stuff
		co.hideHeaders=(Cookie.read('cablegateHideHeaders')!=='false');
		// initialize cable rows
		var cablerows=$$('#cable-list tr[id^="cableid-"]');
		cablerows.each(function(tr){co.initCableRow(tr);});
		// external links in new tab to preserve search results
		$$('a[href^="http"]').each(function(a){a.target='_blank';});
		// auto-expand first cable if only one cable or if keyword(s)
		if (cablerows.length>0 && co.qTerms){
			co.cableExpand(cablerows[0].id.substr(8));
			}
		// assign click handler for requesting more results
		e=$$('#get-next-cables button').each(function(e){
			e.addEvent('click',co.cablesGetNextOnclickHandler);
			});
		// initialize filter selectors
		co.updateFilterStats();
		var iclassification = 0,
			iorigin = 0,
			ss;
		// handle click on classification selector
		e = $('classification-filters');
		if (e) {
			e.addEvent('change', function(){
				co.classificationFilter = parseInt(this.value,10);
				co.filterCableRows();
				co.filterToAnchor();
				});
			// initialize filter as per anchor
			ss = location.hash.match(/c(\d+)/);
			if (ss && ss[1]) {
				iclassification = parseInt(ss[1],10);
				e.selectedIndex = iclassification;
				co.classificationFilter = parseInt(e.options[iclassification].value,10);
				}
			}
		// handle click on origin selector
		e = $('origin-filters');
		if (e) {
			e.addEvent('change', function(){
				co.originFilter = this.value;
				co.filterCableRows();
				co.filterToAnchor();
				});
			// initialize filter as per anchor
			ss = location.hash.match(/o(\d+)/);
			if (ss && ss[1]) {
				iorigin = parseInt(ss[1],10);
				e.selectedIndex = iorigin;
				co.originFilter = e.options[iorigin].value;
				}
			}
		if (iclassification || iorigin) {
			co.filterCableRows();
			}
		};

	window.addEvent('domready',function() {init();});
}());
