/*!
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

(function(window,undefined){
  '$:nomunge'; // Used by YUI compressor.
  
  // Since jQuery really isn't required for this plugin, use `jQuery` as the
  // namespace only if it already exists, otherwise use the `Cowboy` namespace,
  // creating it if necessary.
  var $ = window.jQuery || window.Cowboy || ( window.Cowboy = {} ),
    
    // Internal method reference.
    jq_throttle;
  
  $.throttle = jq_throttle = function( delay, no_trailing, callback, debounce_mode ) {
    // After wrapper has stopped being called, this timeout ensures that
    // `callback` is executed at the proper times in `throttle` and `end`
    // debounce modes.
    var timeout_id,
      
      // Keep track of the last time `callback` was executed.
      last_exec = 0;
    
    // `no_trailing` defaults to falsy.
    if ( typeof no_trailing !== 'boolean' ) {
      debounce_mode = callback;
      callback = no_trailing;
      no_trailing = undefined;
    }
    
    // The `wrapper` function encapsulates all of the throttling / debouncing
    // functionality and when executed will limit the rate at which `callback`
    // is executed.
    function wrapper() {
      var that = this,
        elapsed = +new Date() - last_exec,
        args = arguments;
      
      // Execute `callback` and update the `last_exec` timestamp.
      function exec() {
        last_exec = +new Date();
        callback.apply( that, args );
      };
      
      // If `debounce_mode` is true (at_begin) this is used to clear the flag
      // to allow future `callback` executions.
      function clear() {
        timeout_id = undefined;
      };
      
      if ( debounce_mode && !timeout_id ) {
        // Since `wrapper` is being called for the first time and
        // `debounce_mode` is true (at_begin), execute `callback`.
        exec();
      }
      
      // Clear any existing timeout.
      timeout_id && clearTimeout( timeout_id );
      
      if ( debounce_mode === undefined && elapsed > delay ) {
        // In throttle mode, if `delay` time has been exceeded, execute
        // `callback`.
        exec();
        
      } else if ( no_trailing !== true ) {
        // In trailing throttle mode, since `delay` time has not been
        // exceeded, schedule `callback` to execute `delay` ms after most
        // recent execution.
        // 
        // If `debounce_mode` is true (at_begin), schedule `clear` to execute
        // after `delay` ms.
        // 
        // If `debounce_mode` is false (at end), schedule `callback` to
        // execute after `delay` ms.
        timeout_id = setTimeout( debounce_mode ? clear : exec, debounce_mode === undefined ? delay - elapsed : delay );
      }
    };
    
    // Set the guid of `wrapper` function to the same of original callback, so
    // it can be removed in jQuery 1.4+ .unbind or .die by using the original
    // callback as a reference.
    if ( $.guid ) {
      wrapper.guid = callback.guid = callback.guid || $.guid++;
    }
    
    // Return the wrapper function.
    return wrapper;
  };

  $.debounce = function( delay, at_begin, callback ) {
    return callback === undefined
      ? jq_throttle( delay, at_begin, false )
      : jq_throttle( delay, callback, at_begin !== false );
  };
  
})(this);  


/*
 * Add scrolling ability and floating sidebar functions to table
 * WooCommerce Product Compare since v1.2
 * Bolder Elements (http://bolderelements.net/)
 */
jQuery(document).ready(function($) {
	$('table#be_compare_features_table').each(function() {
		if($(this).find('thead').length > 0 && $(this).find('th').length > 0) {
			// Clone <thead>
			var $w	   = $(window),
				$t	   = $(this),
				$b     = $(this).find('tbody'),
				$thead = $t.find('thead').clone(),
				$col   = $t.find('thead, tbody, tfoot').clone();
				$colr  = $col.find('.subcategory').each( function() { jQuery(this).append('<td></td>') });

			// Add class, remove margins, reset width and wrap table
			$t
			.addClass('sticky-enabled')
			.css({
				margin: 0,
				width: '100%'
			}).wrap('<div class="sticky-wrap" />');

			// If <tbody> contains <th>, then we create sticky column and intersect (advanced)
			if($t.find('tbody th').length > 0) {
				$t.after('<table class="sticky-col be_compare_features_table" />');
			}

			// Create shorthand for things
			var	$stickyCol   = $(this).siblings('.sticky-col'),
				$stickyInsct = $(this).siblings('.sticky-intersect'),
				$stickyWrap  = $(this).parent('.sticky-wrap');

			$stickyCol
			.append($col)
				.find('thead th:gt(0)').remove()
				.end()
				.find('tbody td').remove()
				.end()
				.find('tfoot th:gt(0)').remove();

			$stickyCol.find('.subcategory').each( function() { this.innerHTML = '<td>&nbsp;</td>'; });

			// Set widths
			var setWidths = function () {
					$t
					.find('tr').each(function (i) {
						$stickyCol.find('tr').eq(i).height($(this).height());
					});

					// Set width of sticky table col
					$stickyCol.find('th').add($stickyInsct.find('th')).width($t.find('thead th').width());

					// Set width of sticky intersect
					$stickyInsct.width($t.find('thead th').outerWidth());
				},
				repositionStickyCol = function () {
					if($stickyWrap.scrollLeft() > 0) {
						// When left of wrapping parent is out of view
						$stickyCol.add($stickyInsct).css({
							opacity: 1,
							left: $stickyWrap.scrollLeft()
						});
					} else {
						// When left of wrapping parent is in view
						$stickyCol
						.css({ opacity: 0 })
						.add($stickyInsct).css({ left: 0 });
					}
				},
				calcAllowance = function () {
					var a = 0;
					// Calculate allowance
					$t.find('tbody tr:lt(3)').each(function () {
						a += $(this).height();
					});
					
					// Set fail safe limit (last three row might be too tall)
					// Set arbitrary limit at 0.25 of viewport height, or you can use an arbitrary pixel value
					if(a > $w.height()*0.25) {
						a = $w.height()*0.25;
					}
					
					// Add the height of sticky header
					a += $stickyHead.height();
					return a;
				};

			setWidths();

			$t.parent('.sticky-wrap').scroll($.throttle(250, function() {
				//repositionStickyHead();
				repositionStickyCol();
			}));

			$w
			.load(function() {
				setWidths();
				repositionStickyCol();
			})
			.resize($.debounce(250, function () {
				setWidths();
				repositionStickyCol();
			}));
		}
	});
});