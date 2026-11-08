/**
 * Front-end behaviour that markup alone cannot express:
 * a sticky-header shadow, the back-to-top button and scroll reveals.
 */
( function () {
	'use strict';

	document.documentElement.className += ' js';

	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* Scroll reveal */
	( function () {
		var els = document.querySelectorAll( '.fdp-rev' );
		var i;

		if ( ! els.length ) {
			return;
		}

		if ( ! ( 'IntersectionObserver' in window ) || reduce ) {
			for ( i = 0; i < els.length; i++ ) {
				els[ i ].classList.add( 'is-in' );
			}
			return;
		}

		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-in' );
					io.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 } );

		for ( i = 0; i < els.length; i++ ) {
			io.observe( els[ i ] );
		}
	}() );

	/* Sticky header state + back to top */
	( function () {
		var hdr = document.querySelector( '.fdp-hdr' );
		var top = document.querySelector( '.fdp-totop' );
		var ticking = false;

		if ( ! hdr && ! top ) {
			return;
		}

		function update() {
			var y = window.pageYOffset || document.documentElement.scrollTop;

			if ( hdr ) {
				hdr.classList.toggle( 'is-stuck', y > 12 );
			}

			if ( top ) {
				top.classList.toggle( 'is-on', y > 700 );
			}

			ticking = false;
		}

		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				window.requestAnimationFrame( update );
				ticking = true;
			}
		}, { passive: true } );

		update();
	}() );
}() );
