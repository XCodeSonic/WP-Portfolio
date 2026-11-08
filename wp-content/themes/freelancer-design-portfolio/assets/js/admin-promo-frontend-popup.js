/**
 * Freelancer Design Portfolio — Front-end promo popup dismissal.
 */
(function () {
	'use strict';

	document.addEventListener('click', function (e) {
		var close = e.target.closest('.freelancer-design-portfolio-popup__close');

		if (!close) {
			return;
		}

		e.preventDefault();

		var popup = close.closest('.freelancer-design-portfolio-popup');
		var body  = new URLSearchParams();

		body.append('action', FreelancerDesignPortfolioPopup.action);
		body.append('nonce', popup.getAttribute('data-nonce'));

		popup.classList.add('is-dismissing');

		window.fetch(FreelancerDesignPortfolioPopup.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		}).catch(function () {});

		window.setTimeout(function () {
			popup.remove();
		}, 250);
	});
})();
