/**
 * Graceful Extra Frontend Scripts
 */
(function ($) {
	'use strict';

	$(document).ready(function () {
		// Post Header Metrics (Reading Time & Views) placement.
		if (typeof gracefulExtraMetrics !== 'undefined') {
			if (gracefulExtraMetrics.single) {
				var $singleMeta = $('.single .post-header .post-meta');
				if ($singleMeta.length && !$singleMeta.find('.graceful-extra-meta-item').length) {
					$singleMeta.append(gracefulExtraMetrics.single);
				}
			}
			if (gracefulExtraMetrics.archives) {
				for (var id in gracefulExtraMetrics.archives) {
					var $archiveMeta = $('#post-' + id + ' .post-meta');
					if ($archiveMeta.length && !$archiveMeta.find('.graceful-extra-reading-time').length) {
						$archiveMeta.append(gracefulExtraMetrics.archives[id]);
					}
				}
			}
		}

		var $btt = $('#graceful-extra-btt');

		if (!$btt.length) {
			return;
		}

		var scrollThreshold = 250;
		var ticking = false;

		function updateBttVisibility() {
			if ($(window).scrollTop() > scrollThreshold) {
				$btt.addClass('is-visible');
			} else {
				$btt.removeClass('is-visible');
			}
			ticking = false;
		}

		// Initial check on page load.
		updateBttVisibility();

		// Throttled scroll listener using requestAnimationFrame.
		$(window).on('scroll', function () {
			if (!ticking) {
				window.requestAnimationFrame(updateBttVisibility);
				ticking = true;
			}
		});

		// Smooth scroll to top on click.
		$btt.on('click', function (e) {
			e.preventDefault();

			if ('scrollBehavior' in document.documentElement.style) {
				window.scrollTo({
					top: 0,
					behavior: 'smooth'
				});
			} else {
				$('html, body').stop().animate(
					{
						scrollTop: 0
					},
					450
				);
			}
		});
	});
})(jQuery);
