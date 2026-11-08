/**
 * Freelancer Design Portfolio — Admin promo banner dismissal.
 */
(function ($) {
	'use strict';

	$(function () {
		$(document).on('click', '.freelancer-design-portfoliomo-banner__close', function (e) {
			e.preventDefault();

			var $banner = $(this).closest('.freelancer-design-portfoliomo-banner');
			var nonce   = $banner.data('nonce');

			$banner.addClass('is-dismissing');

			$.post(FreelancerDesignPortfolioPromo.ajaxUrl, {
				action: FreelancerDesignPortfolioPromo.action,
				nonce:  nonce
			}).always(function () {
				window.setTimeout(function () {
					$banner.remove();
				}, 250);
			});
		});
	});
})(jQuery);
