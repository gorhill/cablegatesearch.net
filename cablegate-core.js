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
		// private cart tooltip
		$$('a[href="/cart.php"]').each(function(e){
			var tipElem = $('cart-tips');
			tipElem.setStyle('display','none');
			var dummy = new Tips(e,{fixed:true,offset:{x:20,y:24}});
			e.store('tip:title','');
			e.store('tip:text',tipElem.get('html'));
			});
		};

	window.addEvent('domready',init);
}());
