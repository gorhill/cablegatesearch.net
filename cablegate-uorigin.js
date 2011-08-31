// from: http://www.cablegatesearch.net
// Stuff for uorigin.php only

var CablegateObject;
if (!CablegateObject) {
	CablegateObject = {};
	}

(function(){
	var co = CablegateObject;
	co.filterTimer = null;

	var applyFilter = function() {
		var keywords = $('filter').value.split(/\s+/),
			nKeywords = keywords.length, keyword,
			regexes = [], nRegexes, excludes = [];
		while (nKeywords--) {
			keyword = keywords[nKeywords];
			regexes.push(new RegExp(keyword.replace(/[^a-zA-Z0-9]+/g,''),'i'));
			excludes.push(/^-/.test(keyword));
			}
		var table = $('cables'),
			rows = table.rows,
			nRows = rows.length, row,
			text, show,
			nHidden = 0, nShown = 0;
		while (nRows-- > 1) {
			row = rows[nRows];
			text = row.cells[1].innerHTML;
			nRegexes = regexes.length;
			show = true;
			while (nRegexes-- && show) {
				show = (excludes[nRegexes] !== regexes[nRegexes].test(text));
				}
			if (show) {
				row.style.display = '';
				nShown++;
				}
			else {
				row.style.display = 'none';
				nHidden++;
				}
			}
		// update number of cables not shown
		$('num-filtered-out').innerHTML = nHidden
			? ' '+nShown+' match'+(nShown>1?'es':'')+' ('+nHidden+' cable'+(nHidden>1?'s':'')+' filtered out.)'
			: '';
		};

	var filterTimerHandler = function() {
		co.filterTimer = null;
		applyFilter();
		};

	var changeHandler = function(event) {
		// This timer is to avoid firing up requests
		// for every single key up event
		if (co.filterTimer) {
			window.clearTimeout(co.filterTimer);
			}
		co.filterTimer = window.setTimeout(filterTimerHandler,500);
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

	var init = function(){
		var e = $('filter');
		e.setAttribute('autocomplete','off');
		e.addEvents({
			keyup: keyupHandler,
			change: changeHandler
			});
		};

	window.addEvent('domready', function(){init();});
}());
