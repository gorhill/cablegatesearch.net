// from: http://www.cablegatesearch.net
var CablegateObject;
if (!CablegateObject) {
	CablegateObject = {};
	}

(function() {

	var co = CablegateObject;

	if (co.cart) {
		return;
		}
	co.cart = {};

	// encode 18-bit integer into 3 base-64 characters
	co.cartBase64Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";

	co.cartItemIdToBase64 = function(id) {
		id = Number(id);
		var s = this.cartBase64Str;
		return String(s[id>>12&0x3F]) + String(s[id>>6&0x3F]) + String(s[id&0x3F]);
		};

	co.cartBase64ToItemId = function(base64) {
		var s = this.cartBase64Str;
		return (s.indexOf(base64.substr(0,1))<<12) + (s.indexOf(base64.substr(1,1))<<6) + (s.indexOf(base64.substr(2,1)));
		};

	co.cartSave = function(key) {
		Cookie.write('cablegateCart',key !== undefined ? key : this.cartEncode(this.cart), {duration:365});
		};

	co.cartLoad = function() {
		var key = Cookie.read('cablegateCart');
		this.cart = this.cartDecode(key);
		this.cartUpdatePermalink(key);
		};

	co.cartSynchronizeItems = function() {
		$$('.cartToggler').each(function(e){
			var id = co.cartItemIdFromElement(e);
			if (co.cartContainsItem(id)) {
				e.addClass('inCart');
				}
			else {
				e.removeClass('inCart');
				}
			});
		};

	co.cartAddItem = function(id) {
		var base64 = this.cartItemIdToBase64(id),
			key;
		if (!this.cart[base64]){
			this.cart[base64] = true;
			key = this.cartEncode(this.cart);
			this.cartSave(key);
			this.cartUpdatePermalink(key);
			}
		};

	co.cartRemoveItem = function(id) {
		var base64 = this.cartItemIdToBase64(id),
			key;
		if (this.cart[base64]){
			delete this.cart[base64];
			key = this.cartEncode(this.cart);
			this.cartSave(key);
			this.cartUpdatePermalink(key);
			}
		};

	co.cartRemoveAll = function() {
		this.cart = {};
		this.cartSynchronizeItems();
		this.cartSave();
		this.cartUpdatePermalink();
		};

	co.cartContainsItem = function(id) {
		return this.cart[this.cartItemIdToBase64(id)] !== undefined;
		};

	co.cartEncode = function(cart) {
		var key = [],
		    id;
		for (id in cart){
			if (cart.hasOwnProperty(id)){
				key.push(id);
				}
			}
		return key.join('');
		};

	co.cartDecode = function(key) {
		if (!key) {return {};}
		var cart = {},
		    entries = key.match(/([-\w]{3})/g),
		    i,
		    n = entries.length;
		for (i = 0;i<n;i++){
			cart[entries[i]] = true;
			}
		return cart;
		};

	co.cartAddRemoveOnclickHandler = function(ev) {
		var id = co.cartItemIdFromElement(this);
		if (co.cartContainsItem(id)){
			co.cartRemoveItem(id);
			this.removeClass('inCart');
			}
		else {
			co.cartAddItem(id);
			this.addClass('inCart');
			}
		co.cartSave();
		return false;
		};

	co.cartUpdatePermalink = function(key) {
		key = key || this.cartEncode(this.cart);
		var matches = window.location.href.match(/^.+\//),
			e,
			permalink;
		if (!matches || !matches.length) {return;}
		e = $('cart-permalink');
		if (e){
			if (key !== ''){
				e.href = matches[0] + 'cart.php?cart=' + key;
				e.innerHTML = 'cart.php?cart=' + (key.length > 15 ? key.replace(/^(.{5}).*(.{5})$/,'$1...$2') : key);
				}
			else {
				e.href = '#';
				e.innerHTML = '[empty]';
				}
			}
		};

	co.cartItemIdFromElement = function(e) {
		var ancestor = e.getParent('[id^="cableid-"]');
		if (!ancestor) {return 0;}
		return ancestor.id.substr(8);
		};

	co.cartLoad();

	window.addEvent('domready',function() {
		co.cartUpdatePermalink();
		$$('.cartToggler').each(function(e){
			e.addEvent('click', co.cartAddRemoveOnclickHandler);
			});
		co.cartSynchronizeItems();
		// to auto-select whole field when clicked
		var e = $('cart-permalink');
		if (e){
			e.addEvent('click',function(){this.focus();this.select();});
			}
		e = $('cart-remove-all');
		if (e){
			e.addEvent('click',function(){
				if (confirm('Remove all cables from your private cart?')) {co.cartRemoveAll();}
				});
			}
		});
}());
