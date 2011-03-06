// from: http://www.cablegatesearch.net
(function(){
	var init = function(){
		var e, text;
		// email
		e=$('mangled-email');
		if (e){
			text='ten.hcraesetagelbac@llihr'.split('').reverse().join('');
			e.href='mailto:'+text+'?subject=Cablegate: full-text search';
			e.set('text',text);
			}
		};

	window.addEvent('domready',init);
}());
