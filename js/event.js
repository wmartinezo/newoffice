;(function($$){
	
	// shamelessly taken from jQuery
	// https://github.com/jquery/jquery/blob/master/src/event.js

	$$.Event = function( src, props ) {
		// Allow instantiation without the 'new' keyword
		if ( !(this instanceof $$.Event) ) {
			return new $$.Event( src, props );
		}

		// Event object
		if ( src && src.type ) {
			this.originalEvent = src;
			this.type = src.type;

			// Events bubbling up the document may have been marked as prevented
			// by a handler lower down the tree; reflect the correct value.
			this.isDefaultPrevented = ( src.defaultPrevented || src.returnValue === false ||
				src.getPreventDefault && src.getPreventDefault() ) ? returnTrue : returnFalse;

		// Event type
		} else {
			this.type = src;
		}

		// Put explicitly provided properties onto the event object
		if ( props ) {
			$$.util.extend( this, props );
		}

		// Create a timestamp if incoming event doesn't have one
		this.timeStamp = src && src.timeStamp || +new Date;

		// Mark it as fixed
		//this[ jQuery.expando ] = true;
	};

	function returnFalse() {
		return false;
	}
	function returnTrue() {
		return true;
	}

	// jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
	// http://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
	$$.Event.prototype = {
		preventDefault: function() {
			this.isDefaultPrevented = returnTrue;

			var e = this.originalEvent;
			if ( !e ) {
				return;
			}

			// if preventDefault exists run it on the original event
			if ( e.preventDefault ) {
				e.preventDefault();

			// otherwise set the returnValue property of the original event to false (IE)
			} else {
				e.returnValue = false;
			}
		},
		stopPropagation: function() {
			this.isPropagationStopped = returnTrue;

			var e = this.originalEvent;
			if ( !e ) {
				return;
			}
			// if stopPropagation exists run it on the original event
			if ( e.stopPropagation ) {
				e.stopPropagation();
			}
			// otherwise set the cancelBubble property of the original event to true (IE)
			e.cancelBubble = true;
		},
		stopImmediatePropagation: function() {
			this.isImmediatePropagationStopped = returnTrue;
			this.stopPropagation();
		},
		isDefaultPrevented: returnFalse,
		isPropagationStopped: returnFalse,
		isImmediatePropagationStopped: returnFalse
	};
	
	
})( cytoscape );
