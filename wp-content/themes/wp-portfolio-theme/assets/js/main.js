(function () {
	'use strict';
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
	var hasGsap = typeof gsap !== 'undefined';
	if (hasGsap && typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);
	var main = $('main');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	var loco = null;
	var smooth = fine && window.innerWidth > 1024 && !reduce && typeof LocomotiveScroll !== 'undefined';

	function setVh() { document.documentElement.style.setProperty('--vh', (window.innerHeight / 100) + 'px'); }
	setVh(); window.addEventListener('resize', setVh);

	/* Burger appears early; hero arrow tilts downward while scrolling */
	var heroArrow = $('.home-header .arrow.big svg');
	function onScrollY(y) {
		main.classList.toggle('scrolled', y > window.innerHeight * 0.15);
		if (heroArrow) heroArrow.style.transform = 'rotate(' + (Math.min(1, y / (window.innerHeight * 0.8)) * 35) + 'deg)';
	}

	/* Same smooth scroll library the original uses (Locomotive Scroll) */
	if (smooth) {
		main.classList.remove('touch'); main.classList.add('no-touch');
		loco = new LocomotiveScroll({ el: $('[data-scroll-container]'), smooth: true, lerp: 0.08, multiplier: 1 });
		loco.on('scroll', function (a) { onScrollY(a.scroll.y); });
		window.addEventListener('load', function () { loco.update(); });
		if (window.ResizeObserver) new ResizeObserver(function () { loco.update(); }).observe($('[data-scroll-container]'));
		$$('a[href*="#work"]').forEach(function (a) {
			a.addEventListener('click', function (e) {
				var u = new URL(a.href, location.href);
				if (u.pathname === location.pathname && $('#work')) { e.preventDefault(); loco.scrollTo('#work'); }
			});
		});
	}

	/* Reveal helper (works with both native and Locomotive scrolling) */
	function reveal(els, vars, opts) {
		if (!hasGsap || reduce) return;
		opts = opts || {};
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (!en.isIntersecting) return;
				io.unobserve(en.target);
				var t = opts.children ? $$(opts.children, en.target) : en.target;
				gsap.fromTo(t, vars.from, Object.assign({}, vars.to, { delay: opts.delay || 0 }));
			});
		}, { threshold: 0.1 });
		els.forEach(function (el) {
			gsap.set(opts.children ? $$(opts.children, el) : el, vars.from);
			io.observe(el);
		});
	}

	/* ---------- Loader ---------- */
	function finishLoader() {
		var lc = $('.loading-container');
		if (lc) lc.style.display = 'none';
		try { sessionStorage.setItem('ppSeen', '1'); } catch (e) {}
		intro();
	}
	function loader() {
		var lc = $('.loading-container');
		if (!lc || document.documentElement.classList.contains('pp-skip-loader') || !hasGsap || reduce) { return finishLoader(); }
		var words = $$('.loading-words h2', lc), screen = $('.loading-screen', lc), wrap = $('.loading-words', lc);
		var bottom = $('.rounded-div-wrap.bottom', lc);
		document.body.style.overflow = 'hidden'; if (loco) loco.stop();
		wrap.style.opacity = 1;
		var i = 0;
		words[0].classList.add('active');
		var tick = setInterval(function () {
			words[i].classList.remove('active');
			i++;
			if (i >= words.length) { clearInterval(tick); return slideUp(); }
			words[i].classList.add('active');
		}, i === 0 ? 300 : 190);
		function slideUp() {
			var tl = gsap.timeline({ onComplete: function () { document.body.style.overflow = ''; if (loco) loco.start(); finishLoader(); } });
			tl.to(wrap, { opacity: 0, duration: .3 }, 0)
			  .to(bottom, { height: '12vh', duration: .4, ease: 'power2.in' }, 0)
			  .to(screen, { top: '-100%', duration: .9, ease: 'power3.inOut' }, .15)
			  .to(bottom, { height: '0vh', duration: .5 }, .6);
		}
	}

	/* ---------- Intro animation + scroll effects ---------- */
	function intro() {
		if (!hasGsap || reduce) return;
		gsap.from('.home-header .container, .home-header .hanger, .home-header .nav-bar', { y: 40, opacity: 0, duration: 1, stagger: .12, ease: 'power3.out' });
		gsap.from('.home-header .big-name', { y: 80, opacity: 0, duration: 1.2, ease: 'power3.out' });

		if (!smooth && typeof ScrollTrigger !== 'undefined') {
			$$('[data-pp-speed]').forEach(function (el) {
				var sp = parseFloat(el.getAttribute('data-pp-speed')) || 0;
				if (el.closest('footer')) {
					gsap.fromTo(el, { y: Math.abs(sp) * 40 }, { y: 0, ease: 'none', scrollTrigger: { trigger: '.footer-wrap', start: 'top bottom', end: 'bottom bottom', scrub: true } });
					return;
				}
				gsap.to(el, { y: sp * 40, ease: 'none', scrollTrigger: { trigger: el.closest('section, header, footer') || el, start: 'top bottom', end: 'bottom top', scrub: true } });
			});
			$$('[data-pp-speed-x]').forEach(function (el) {
				var sp = parseFloat(el.getAttribute('data-pp-speed-x')) || 0;
				gsap.to(el, { x: sp * -60, ease: 'none', scrollTrigger: { trigger: '.home-header', start: 'top top', end: 'bottom top', scrub: true } });
			});
		}
		$$('[data-pp-lines]').forEach(function (h) {
			reveal([h], { from: { yPercent: 110 }, to: { yPercent: 0, duration: .9, stagger: .035, ease: 'power3.out' } }, { children: '.span-line-inner' });
		});
		reveal($$('.fade-in'), { from: { y: 30, opacity: 0 }, to: { y: 0, opacity: 1, duration: 1, ease: 'power3.out' } });
		reveal($$('.work-items li'), { from: { y: 24, opacity: 0 }, to: { y: 0, opacity: 1, duration: .8, ease: 'power3.out' } });
		reveal($$('.work-tiles ul li'), { from: { y: 60, opacity: 0 }, to: { y: 0, opacity: 1, duration: 1, ease: 'power3.out' } });
	}

	/* ---------- Hamburger / full-screen nav ---------- */
	var burger = $('.btn-hamburger');
	function setNav(open) {
		main.classList.toggle('nav-active', open);
		document.body.classList.toggle('nav-active', open);
		if (burger) burger.classList.toggle('active', open);
	}
	if (burger) burger.addEventListener('click', function () { setNav(!main.classList.contains('nav-active')); });
	$$('.btn-menu').forEach(function (b) { b.addEventListener('click', function () { setNav(true); }); });
	var back = $('.fixed-nav-back');
	if (back) back.addEventListener('click', function () { setNav(false); });
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setNav(false); });
	$$('.fixed-nav a').forEach(function (a) { a.addEventListener('click', function () { setNav(false); }); });
	function onScroll() { onScrollY(window.scrollY); }
	if (!smooth) { window.addEventListener('scroll', onScroll, { passive: true }); onScroll(); }

	/* ---------- Button fill + magnetic ---------- */
	if (hasGsap && fine) {
		$$('.btn-click').forEach(function (btn) {
			var fill = $('.btn-fill', btn), text = $('.btn-text', btn);
			var sx = parseFloat(btn.getAttribute('data-strength')) || 0;
			var st = parseFloat(btn.getAttribute('data-strength-text')) || 0;
			var ti = $('.btn-text-inner', btn), origColor = ti ? getComputedStyle(ti).color : null;
			var side = function (e) { var r = btn.getBoundingClientRect(); return e.clientY < r.top + r.height / 2 ? -1 : 1; };
			btn.addEventListener('mouseenter', function (e) {
				if (!fill) return;
				gsap.killTweensOf(fill);
				gsap.set(fill, { yPercent: side(e) * 76 });          /* start below (or above) the button */
				gsap.to(fill, { yPercent: 0, duration: .55, ease: 'power3.out' });
				if (ti) gsap.to(ti, { color: '#fff', duration: .25, overwrite: true });
			});
			btn.addEventListener('mouseleave', function (e) {
				if (fill) {
					gsap.killTweensOf(fill);
					gsap.to(fill, { yPercent: side(e) * 76, duration: .5, ease: 'power3.inOut' });   /* leave out the side the mouse exits */
					if (ti) gsap.to(ti, { color: origColor, duration: .3, overwrite: true, onComplete: function () { ti.style.color = ''; } });
				}
				gsap.to(btn, { x: 0, y: 0, duration: .8, ease: 'elastic.out(1,.4)' });
				if (text) gsap.to(text, { x: 0, y: 0, duration: .8, ease: 'elastic.out(1,.4)' });
			});
			btn.addEventListener('mousemove', function (e) {
				var r = btn.getBoundingClientRect();
				var rx = (e.clientX - (r.left + r.width / 2)) / r.width, ry = (e.clientY - (r.top + r.height / 2)) / r.height;
				gsap.to(btn, { x: rx * sx, y: ry * sx, duration: .4, ease: 'power3.out' });
				if (text) gsap.to(text, { x: rx * st, y: ry * st, duration: .4, ease: 'power3.out' });
			});
		});
		$$('.btn-fill').forEach(function (f) { f.style.transform = 'none'; gsap.set(f, { yPercent: -76 }); });
	}

	/* ---------- Work list: floating hover image + "View" bubble ---------- */
	var float = $('.mouse-pos-list-image'), bounce = $('.mouse-pos-list-image-bounce', float || document);
	var imgWrap = $('.float-image-wrap', float || document), bubble = $('.mouse-pos-list-span'), circle = $('.mouse-pos-list-btn');
	var items = $$('.mouse-pos-list-image-wrap > li');
	if (float && fine && hasGsap && items.length && $$('.mouse-pos-list-image-inner', float).length) {
		var mx = 0, my = 0, cx = 0, cy = 0, on = false;
		window.addEventListener('mousemove', function (e) { mx = e.clientX; my = e.clientY; });
		(function loop() {
			cx += (mx - cx) * .12; cy += (my - cy) * .12;
			float.style.left = cx + 'px'; float.style.top = cy + 'px';
			if (bubble) { bubble.style.left = cx + 'px'; bubble.style.top = cy + 'px'; }
			if (circle) { circle.style.left = cx + 'px'; circle.style.top = cy + 'px'; }
			requestAnimationFrame(loop);
		})();
		items.forEach(function (li, idx) {
			li.addEventListener('mouseenter', function () {
				on = true; imgWrap.style.transform = 'translateY(' + (-(idx * 100 / Math.max(1, $$('.mouse-pos-list-image-inner', imgWrap).length))) + '%)';
				imgWrap.style.transition = 'transform .5s cubic-bezier(.65,0,.35,1)';
				float.classList.add('active'); if (bounce) bounce.classList.add('active'); if (bubble) bubble.classList.add('active'); if (circle) circle.classList.add('active');
			});
			li.addEventListener('mouseleave', function () {
				on = false; float.classList.remove('active'); if (bounce) bounce.classList.remove('active'); if (bubble) bubble.classList.remove('active'); if (circle) circle.classList.remove('active');
			});
		});
		$$('.work-items > li .stripe').forEach(function (s) { s.style.opacity = 1; });
	}

	/* ---------- Footer curve: flattens as the footer scrolls into view ---------- */
	var curveBox = $('.footer-rounded-div'), curve = curveBox && $('.rounded-div-wrap', curveBox);
	if (curve) {
		(function flatten() {
			var vh = window.innerHeight, top = curveBox.getBoundingClientRect().top;
			var base = (window.innerWidth <= 720 ? 7.5 : 10) * vh / 100;
			var p = Math.min(1, Math.max(0, (vh - top) / (vh * 0.75)));
			curve.style.height = (base * (1 - p)) + 'px';
			requestAnimationFrame(flatten);
		})();
	}

	/* ---------- Project videos: play only while visible ---------- */
	var vids = $$('.playpauze video');
	vids.forEach(function (v) { v.muted = true; });
	if (vids.length && 'IntersectionObserver' in window) {
		var vio = new IntersectionObserver(function (es) {
			es.forEach(function (e) {
				var v = e.target;
				if (e.isIntersecting) { var pr = v.play(); if (pr && pr.catch) pr.catch(function () {}); } else { v.pause(); }
			});
		}, { threshold: 0.25 });
		vids.forEach(function (v) { vio.observe(v); });
	}

	/* ---------- Certificates: full-screen lightbox ---------- */
	var lb = null, lbItems = [], lbIndex = 0;
	function lbRender() {
		var a = lbItems[lbIndex];
		$('img', lb).src = a.getAttribute('data-full');
		$('.cap strong', lb).textContent = a.getAttribute('data-title') || '';
		$('.cap span', lb).textContent = a.getAttribute('data-meta') || '';
		var link = a.getAttribute('data-link'), l = $('.cap a', lb);
		l.style.display = link ? '' : 'none'; if (link) l.href = link;
		$('.lb-prev', lb).style.display = $('.lb-next', lb).style.display = lbItems.length > 1 ? '' : 'none';
	}
	function lbClose() {
		if (!lb) return;
		if (document.fullscreenElement && document.exitFullscreen) document.exitFullscreen();
		lb.parentNode.removeChild(lb); lb = null;
		document.body.classList.remove('pp-lb-open');
		if (loco) loco.start();
		document.removeEventListener('keydown', lbKey);
	}
	function lbStep(d) { lbIndex = (lbIndex + d + lbItems.length) % lbItems.length; lbRender(); }
	function lbKey(e) { if (e.key === 'Escape') lbClose(); if (e.key === 'ArrowRight') lbStep(1); if (e.key === 'ArrowLeft') lbStep(-1); }
	function lbOpen(a) {
		var group = a.closest('.person-certs-grid');
		lbItems = $$('.pp-cert[data-full]', group || document);
		lbIndex = Math.max(0, lbItems.indexOf(a));
		lb = document.createElement('div');
		lb.className = 'pp-lightbox';
		lb.innerHTML = '<button class="lb-full" aria-label="Full screen" title="Full screen">⤢</button><button class="lb-close" aria-label="Close">✕</button><button class="lb-prev" aria-label="Previous">‹</button><button class="lb-next" aria-label="Next">›</button><img alt=""><div class="cap"><strong></strong><span></span><br><a target="_blank" rel="noopener">Open credential ↗</a></div>';
		document.body.appendChild(lb);
		document.body.classList.add('pp-lb-open');
		if (loco) loco.stop();
		$('.lb-close', lb).addEventListener('click', lbClose);
		$('.lb-prev', lb).addEventListener('click', function () { lbStep(-1); });
		$('.lb-next', lb).addEventListener('click', function () { lbStep(1); });
		$('.lb-full', lb).addEventListener('click', function () {
			if (document.fullscreenElement) document.exitFullscreen(); else if (lb.requestFullscreen) lb.requestFullscreen();
		});
		lb.addEventListener('click', function (e) { if (e.target === lb) lbClose(); });
		document.addEventListener('keydown', lbKey);
		lbRender();
	}
	$$('.pp-cert[data-full]').forEach(function (a) {
		a.addEventListener('click', function (e) { e.preventDefault(); lbOpen(a); });
	});

	/* ---------- In-page anchors (team buttons, /about/#name links) ---------- */
	function scrollToHash(h) {
		var el = h && h.length > 1 ? document.querySelector(h) : null;
		if (!el) return false;
		if (loco) loco.scrollTo(el); else el.scrollIntoView({ behavior: 'smooth' });
		return true;
	}
	$$('a.pp-anchor').forEach(function (a) {
		a.addEventListener('click', function (e) { if (scrollToHash(a.getAttribute('href'))) e.preventDefault(); });
	});
	if (location.hash) window.addEventListener('load', function () { setTimeout(function () { scrollToHash(location.hash); }, 900); });

	/* ---------- Contact form: floating label state ---------- */
	$$('.form .form-col .field').forEach(function (f) {
		var col = f.closest('.form-col');
		var upd = function () { col.classList.toggle('not-empty', f.value.trim() !== ''); };
		f.addEventListener('input', upd); upd();
	});

	/* ---------- Local time ---------- */
	var ts = $('#timeSpan');
	if (ts) {
		var tz = ts.getAttribute('data-tz') || undefined;
		var fmt = function () {
			try {
				ts.textContent = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', timeZone: tz, timeZoneName: 'short' });
			} catch (e) { ts.textContent = new Date().toLocaleTimeString(); }
		};
		fmt(); setInterval(fmt, 30000);
	}

	/* ---------- Top-left brand: measure text so the hover slide fits any wording ---------- */
	function brandVars() {
		$$('.btn-left-top').forEach(function (b) {
			var cb = $('.code-by', b), ds = $('.dennis-span', b), sn = $('.snellenberg', b);
			if (!cb || !ds || !sn) return;
			b.style.setProperty('--cbw', cb.getBoundingClientRect().width + 'px');
			b.style.setProperty('--dw', ds.getBoundingClientRect().width + 'px');
			b.style.setProperty('--snw', sn.scrollWidth + 'px');
		});
	}
	(document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve()).then(brandVars);
	window.addEventListener('load', brandVars);
	window.addEventListener('resize', brandVars);

	/* ---------- Work page: type filters + rows/columns toggle ---------- */
	function refreshScroll() { if (loco) { setTimeout(function () { loco.update(); }, 60); setTimeout(function () { loco.update(); }, 700); } }
	var fbtns = $$('.work-filters .toggle-row .btn');
	fbtns.forEach(function (b) {
		b.addEventListener('click', function () {
			var f = b.getAttribute('data-filter') || 'all';
			fbtns.forEach(function (x) { x.classList.toggle('active', x === b); });
			$$('.section-wrap-work li').forEach(function (li) {
				li.classList.toggle('visible', f === 'all' || li.classList.contains(f));
			});
			var wi = $('.work-items'); if (wi) wi.classList.toggle('all-active', f === 'all');
			refreshScroll();
		});
	});
	var rowsPart = $('.grid-rows-part'), colsPart = $('.grid-columns-part'), rowsBtn = $('.rows-btn'), colsBtn = $('.columns-btn');
	function showGrid(rows) {
		if (!rowsPart || !colsPart) return;
		var show = rows ? rowsPart : colsPart, hide = rows ? colsPart : rowsPart;
		if (rowsBtn) rowsBtn.classList.toggle('active', rows);
		if (colsBtn) colsBtn.classList.toggle('active', !rows);
		hide.classList.remove('visible'); show.classList.add('visible');
		refreshScroll();
	}
	if (rowsBtn) rowsBtn.addEventListener('click', function () { showGrid(true); });
	if (colsBtn) colsBtn.addEventListener('click', function () { showGrid(false); });

	/* ---------- Big name: endless idle marquee (scroll movement still adds on top) ---------- */
	var nameTween = null, nameTimer = null;
	function buildMarquee() {
		var h = $('.name-h1');
		if (!h || !hasGsap || reduce) return;
		if (nameTween) { nameTween.kill(); nameTween = null; }
		$$('.name-wrap[data-clone]', h).forEach(function (c) { c.parentNode.removeChild(c); });
		var base = $('.name-wrap', h);
		gsap.set($$('.name-wrap', h), { x: 0, flex: '0 0 auto' });
		var w = base.getBoundingClientRect().width;
		if (!w) return;
		var total = Math.ceil((window.innerWidth * 2) / w) + 1;
		for (var i = 1; i < total; i++) {
			var c = base.cloneNode(true); c.setAttribute('data-clone', '1'); c.setAttribute('aria-hidden', 'true');
			h.appendChild(c);
		}
		nameTween = gsap.to($$('.name-wrap', h), { x: -w, duration: w / 110, ease: 'none', repeat: -1 });
		if (loco) loco.update();
	}
	(document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve()).then(buildMarquee);
	window.addEventListener('load', buildMarquee);
	window.addEventListener('resize', function () { clearTimeout(nameTimer); nameTimer = setTimeout(buildMarquee, 250); });

	loader();
})();
