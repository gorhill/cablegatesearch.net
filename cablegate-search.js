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
	co.suggestionSelected = -1;

	// Returns the content of the input field as an
	// alternate list of word and non-word segments,
	// and which segment is in contact with the caret.
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

		// Find which word is at caret position. If the caret
		// touches both a word and non-word segment simultaneously,
		// the word has priority
		var caret = q.getCaretPosition(),
			i, n = matches.length,
			beg, end = 0,
			word;

		for (i=0; i<n; i++) {
			beg = end;
			if (caret < beg) {break;}
			word = matches[i];
			end = beg + word.length;
			if (caret < end || (/[a-zA-Z0-9]/.test(word) && caret === end)) {break;}
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
	var suggestionsRequestHandler = function(response) {
		if (response.suggestions && response.startwith.length) {
			co.suggestionCache[response.startwith] = response.suggestions;
			}
		syncSuggestions();
		};

	var suggestionsRequest = new Request.JSON({
		url:'cablegate-do.php',
		onSuccess: suggestionsRequestHandler
		});

	var getSuggestions = function() {
		var startwith,
			details = getInputFieldDetails(),
			which = details.which,
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
		suggestionsRequest.get({
			command: 'get_keyword_suggestions',
			startwith: startwith
			});

		return [];
		};

	var useSuggestion = function(suggestion) {
		var details = getInputFieldDetails();
		var which = details.which,
			words = details.words;
		if (which >= 0 && /[a-zA-Z0-9]/.test(words[which])) {
			var q = $('q');
			words[which] = suggestion.innerHTML.replace(/\s+\S+$/,'');
			if (which === words.length-1) {
				words.push(' ');
				}
			q.value = words.join('');
			q.focus();
			q.setCaretPosition(details.sOffset + words[which].length + words[which+1].length);
			syncSuggestions(); // caret moved, resync
			}
		};

	var selectSuggestion = function(index) {
		if (index === co.suggestionSelected) {return;}
		var ss = $('search-suggestions');
		ss.getElements('.selected').each(function(e){
			e.removeClass('selected');
			});
		var ee = ss.getElements('div');
		if (index < -1) {
			index = ee.length-1;
			}
		if (ee[index] !== undefined) {
			ee[index].addClass('selected');
			co.suggestionSelected = index;
			}
		else {
			co.suggestionSelected = -1;
			}
		};

	var suggestionMouseenterHandler = function() {
		selectSuggestion($$('#search-suggestions > div').indexOf(this));
		};

	var suggestionMouseleaveHandler = function() {
		if (co.suggestionSelected === $$('#search-suggestions > div').indexOf(this)) {
			selectSuggestion(-1);
			}
		};

	var suggestionClickHandler = function() {
		useSuggestion(this);
		// cancel event, to avoid input field from losing focus
		return false;
		};

	var syncSuggestions = function(show) {
		// Suggestions are shown if:
		//   'show' is not false
		//   The input field has focus
		//   There is at least one suggestion matching word at caret position
		var q = $('q'),
			suggestions = q.retrieve('hasFocus',false) ? getSuggestions() : [];

		// Something to show?
		var ss = $('search-suggestions');
		ss.empty();
		if (suggestions.length) {
			var prefix = $('q').value.search(/^=/) >= 0 ? '=' : '',
				n = suggestions.length,
				html;
			while (n-- > 0) {
				html = prefix + suggestions[n];
				ss.grab(new Element('div', {
					html: html,
					events: {
						mouseenter: suggestionMouseenterHandler,
						mouseleave: suggestionMouseleaveHandler,
						mousedown: suggestionClickHandler
						}
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

	var changeHandler = function(event) {
		// This timer is to avoid firing up requests
		// for every single key up event
		if (co.suggestionKeyupTimer) {
			window.clearTimeout(co.suggestionKeyupTimer);
			}
		co.suggestionKeyupTimer = window.setTimeout(keyupTimerHandler,250);
		};

	var keyupHandler = function(event) {
		// Handle arrow keys
		if (event.key === 'up') {
			selectSuggestion(co.suggestionSelected-1);
			return false; // event consumed
			}
		if (event.key === 'down') {
			selectSuggestion(co.suggestionSelected+1);
			return false; // event consumed
			}
		changeHandler();
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

	var submitHandler = function(event) {
		var ee = $$('#search-suggestions > div');
		if (ee[co.suggestionSelected] !== undefined) {
			useSuggestion(ee[co.suggestionSelected]);
			selectSuggestion(-1);
			return false;
			}
		};

	var init = function(){
		var q = $('q');
		q.setAttribute('autocomplete','off');
		q.addEvents({
			click: clickHandler,
			keyup: keyupHandler,
			change: changeHandler,
			focus: focusHandler,
			blur: blurHandler
			});
		q.getParent('form').addEvent('submit', submitHandler);
		};

	window.addEvent('domready', function(){init();});
}());
