/**
 * Graceful Theme Admin Scripts
 * Handles 1-click plugin installation via core wp.updates and AJAX notice dismissal.
 */
/* global ajaxurl, gracefulAdminL10n */
( function ( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	// 1. AJAX Notice Dismissal
	$( function () {
		$( document ).on( 'click', '.graceful-notice-nux .notice-dismiss', function () {
			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'graceful_dismiss_notice',
					nonce: gracefulAdminL10n.nonce
				},
				dataType: 'json'
			} );
		} );
	} );

	// 2. 1-Click Plugin Installation via wp.updates
	$( function () {
		$( document ).on( 'click', '.sf-install-now', function ( event ) {
			var $button = $( event.target );

			if ( $button.hasClass( 'activate-now' ) ) {
				return true;
			}

			event.preventDefault();

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates && wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );

				$( document ).on( 'credential-modal-cancel', function () {
					var $message = $( '.sf-install-now.updating-message' );
					$message
						.removeClass( 'updating-message' )
						.text( wp.updates.l10n ? wp.updates.l10n.installNow : 'Install Now' );
				} );
			}

			if ( wp.updates && wp.updates.installPlugin ) {
				wp.updates.installPlugin( {
					slug: $button.data( 'slug' )
				} );
			} else {
				// Fallback to normal link navigation if wp.updates is not available.
				window.location.href = $button.attr( 'href' );
			}
		} );
	} );

} )( window.wp, jQuery );
