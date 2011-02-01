// from: http://www.cablegatesearch.net
// Stuff for search.php only
// Depends on:
//   Mootools More Element.Forms / http://mootools.net/docs/more/Element/Element.Forms

var CablegateObject;
if (!CablegateObject) {
	CablegateObject = {};
	}

(function(){
	var co = CablegateObject;
	co.suggestionKeyupTimer = null;
	co.suggestionCache = {};

	var suggestionsRequestHandler = function(response) {
		if (response.suggestions && response.suggestions.length) {
			co.suggestionCache[response.startwith] = response.suggestions;
			}
		syncSuggestions();
		};

	// Returns the content of the input field as a
	// list of words/sequences of spaces, and which
	// word is touching the caret.
	var getInputFieldDetails = function() {
		var q = $('q');

		// Get list of words in input field
		var matches = q.value.match(/[a-zA-Z0-9]+|[^a-zA-Z0-9]+/g);
		if (!matches) {
			return {
				which: -1,
				words: []
				};
			}

		// Find which word is at caret position
		var caret = q.getCaretPosition(),
			i, n = matches.length,
			beg, end = 0,
			word, startwith;

		for (i=0; i<n; i++) {
			beg = end;
			if (caret < beg) {break;}
			word = matches[i];
			end = beg + word.length;
			if (caret < end || (/[a-zA-Z0-9]/.test(word) && caret == end)) {break;}
			}
		return {
			which: i < n ? i : -1,
			sOffset: beg,
			eOffset: end,
			words: matches
			};
		};

	// Return list of suggestions at caret position.
	// Can be asynchronous if the list of suggestions is
	// not readily available.
	var getSuggestions = function() {
		var startwith;
		var details = getInputFieldDetails();
		var which = details.which,
			words = details.words;
		if (which >= 0 && /[a-zA-Z0-9]/.test(words[which])) {
			startwith = words[which].replace(/^=/,'').toLowerCase();
			}

		// No word at caret position
		if (!startwith) {return [];}

		// Maybe list is in cache?
		if (co.suggestionCache[startwith] !== undefined) {
			return co.suggestionCache[startwith];
			}

		// Nope, will have to get it from server
		var options = {
			url:'cablegate-do.php',
			onSuccess: suggestionsRequestHandler,
			};
		var parms = {
			command: 'get_keyword_suggestions',
			startwith: startwith,
			limit: 10,
			};
		var dummy = new Request.JSON(options).get(parms);

		return [];
		};

	var suggestionsClickHandler = function() {
		var details = getInputFieldDetails();
		var which = details.which,
			words = details.words;
		if (which >= 0 && /[a-zA-Z0-9]/.test(words[which])) {
			var q = $('q');
			words[which] = this.innerHTML.replace(/\s+\S+$/,'');
			if (which === words.length-1) {
				words.push(' ');
				}
			q.value = words.join('');
			q.focus();
			q.setCaretPosition(details.sOffset + words[which].length + words[which+1].length);
			syncSuggestions(); // caret moved, resync
			}

		// cancel event, to avoid input field from losing focus
		return false;
		};

	var syncSuggestions = function(show) {
		// Suggestions are shown if:
		//   The input field has focus
		//   There is at least one suggestion matching word at caret position
		//   'show' is not false
		var q = $('q');
		var suggestions = [];

		// Does the input have focus?
		if (q.retrieve('hasFocus',false)) {
			suggestions = getSuggestions();
			}

		// Something to show?
		var ss = $('search-suggestions');
		ss.empty();
		if (suggestions.length) {
			var prefix = $('q').value.search(/^=/) >= 0 ? '=' : '';
			for (var i=0; i < suggestions.length; i++) {
				var suggestion = suggestions[i];
				ss.grab(new Element('div', {
					html: prefix + suggestion,
					events: {mousedown: suggestionsClickHandler},
					}));
				}
			}

		// Something to show?
		ss.setStyle('display', show !== false && suggestions.length ? '' : 'none');
		};

	var keyupTimerHandler = function() {
		co.suggestionKeyupTimer = null;
		syncSuggestions();
		};

	var keyupHandler = function() {
		if (co.suggestionKeyupTimer) {
			window.clearTimeout(co.suggestionKeyupTimer);
			}
		// this timer is to avoid firing up
		// requests for every single key up
		// event
		co.suggestionKeyupTimer = window.setTimeout(keyupTimerHandler,250);
		};

	var clickHandler = function() {
		syncSuggestions();
		};

	var focusHandler = function() {
		this.store('hasFocus', true);
		syncSuggestions();
		};

	var blurHandler = function() {
		this.store('hasFocus', false);
		syncSuggestions();
		};

	var init = function(){
		var q = $('q');
		q.setAttribute("autocomplete","off");
		q.addEvents({
			click: clickHandler,
			keyup: keyupHandler,
			change: keyupHandler,
			focus: focusHandler,
			blur: blurHandler,
			});
		};

	window.addEvent('domready', function(){init();});
}());
