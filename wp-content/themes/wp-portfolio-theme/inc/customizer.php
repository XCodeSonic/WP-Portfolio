<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'customize_register', function ( $wp ) {
	$wp->add_panel( 'pp_panel', array( 'title' => 'Portfolio homepage', 'priority' => 30 ) );

	$text = array(
		'pp_hero' => array( 'Hero', array(
			'pp_name'       => array( 'Big name', 'Your Name' ),
			'pp_role_first' => array( 'Role (first word)', 'Freelance' ),
			'pp_role_rest'  => array( 'Role (rest)', 'Designer & Developer' ),
			'pp_location'   => array( 'Location text (one line per row)', "Located\nin the\nPhilippines" ),
		) ),
		'pp_brand' => array( 'Top-left brand text', array(
			'pp_brand_prefix' => array( 'Text before name (e.g. "Code by", or your company)', 'Code by' ),
			'pp_brand_first'  => array( 'Name / company — shown first', 'Your' ),
			'pp_brand_last'   => array( 'Revealed on hover (e.g. last name)', 'Name' ),
		) ),
		'pp_about' => array( 'About page', array(
			'pp_about_h1_a'    => array( 'Title — line 1', 'We are a team' ),
			'pp_about_h1_b'    => array( 'Title — line 2', 'of creative people' ),
			'pp_about_p1'      => array( 'Intro paragraph', 'Tell visitors who your organization is and what you stand for.' ),
			'pp_about_p2'      => array( 'Short line under it (animated dots are added)', 'Always exploring' ),
			'pp_team_title'    => array( 'Heading above the team', 'Meet the team' ),
			'pp_offers_title'  => array( 'Offers heading (%s = first name)', 'What %%s can help you with' ),
			'pp_certs_title'   => array( 'Certifications heading', 'Certifications' ),
		) ),
		'pp_loader' => array( 'Intro loader', array(
			'pp_loading_words' => array( 'Greeting words (one per line; your name is added last)', "Hello\nBonjour\nCiao\nHola\nOlá\nHallo" ),
		) ),
		'pp_contact' => array( 'Contact page', array(
			'pp_contact_h1_a'  => array( 'Title — line 1', "Let’s start a" ),
			'pp_contact_h1_b'  => array( 'Title — line 2', 'project together' ),
			'pp_form_q'        => array( 'Form questions — one per line as "Question | placeholder" (5 lines: name, email, organization, service, message)', "What’s your name? | John Doe *\nWhat’s your email? | john@doe.com *\nWhat’s the name of your organization? | Your company\nWhat services are you looking for? | Web design, development …\nYour message | Hello, can you help me with … *" ),
			'pp_form_send'     => array( 'Send button label', 'Send it!' ),
			'pp_form_thanks'   => array( 'Message after sending', 'Thank you! Your message has been sent. We will get back to you soon.' ),
			'pp_business'      => array( 'Organization details — one per line (name, registration no., address…)', "Your Organization\nLocation: Philippines" ),
		) ),
		'pp_pages' => array( 'Work & Archive pages', array(
			'pp_work_h1_a'    => array( 'Work page title — line 1', 'Creating next level' ),
			'pp_work_h1_b'    => array( 'Work page title — line 2', 'digital products' ),
			'pp_archive_label' => array( 'Archive button label', 'Archive' ),
		) ),
		'pp_intro' => array( 'Intro', array(
			'pp_intro_heading' => array( 'Intro heading', 'Helping brands stand out online. Clean design, solid code, no nonsense.' ),
			'pp_intro_text'    => array( 'Intro paragraph', 'Write a short sentence about what makes your work unique.' ),
			'pp_about_label'   => array( 'About button label', 'About me' ),
			'pp_about_url'     => array( 'About button link', '/about/' ),
			'pp_work_title'    => array( 'Work section title', 'Recent work' ),
			'pp_more_label'    => array( 'More work button label', 'More work' ),
		) ),
		'pp_footer' => array( 'Footer / contact', array(
			'pp_cta_line1'  => array( 'Call to action line 1', 'Let’s work' ),
			'pp_cta_line2'  => array( 'Call to action line 2', 'together' ),
			'pp_cta_label'  => array( 'Button label', 'Get in touch' ),
			'pp_cta_url'    => array( 'Button link', '/contact/' ),
			'pp_email'      => array( 'Email', 'hello@example.com' ),
			'pp_phone'      => array( 'Phone', '' ),
			'pp_version'    => array( 'Version text', date( 'Y' ) . ' © Edition' ),
			'pp_timezone'   => array( 'Timezone for local time (e.g. Asia/Manila)', 'Asia/Manila' ),
		) ),
	);
	foreach ( $text as $sid => $sec ) {
		$wp->add_section( $sid, array( 'title' => $sec[0], 'panel' => 'pp_panel' ) );
		foreach ( $sec[1] as $id => $f ) {
			$wp->add_setting( $id, array( 'default' => $f[1], 'sanitize_callback' => ( in_array( $id, array( 'pp_location', 'pp_about_p1', 'pp_loading_words', 'pp_form_q', 'pp_business' ), true ) ? 'sanitize_textarea_field' : 'sanitize_text_field' ) ) );
			$wp->add_control( $id, array( 'label' => $f[0], 'section' => $sid, 'type' => ( in_array( $id, array( 'pp_intro_text', 'pp_location', 'pp_about_p1', 'pp_loading_words', 'pp_form_q', 'pp_business' ), true ) ? 'textarea' : 'text' ) ) );
		}
	}
	$wp->add_setting( 'pp_hero_zoom', array( 'default' => 100, 'sanitize_callback' => 'absint' ) );
	$wp->add_control( 'pp_hero_zoom', array( 'label' => 'Hero image size (%) — lower it if your photo looks too big', 'section' => 'pp_hero', 'type' => 'range', 'input_attrs' => array( 'min' => 40, 'max' => 120, 'step' => 5 ) ) );
	$imgs = array(
		'pp_hero_image'    => array( 'Hero image (portrait, ~1600×2000)', 'pp_hero' ),
		'pp_profile_image' => array( 'Round profile photo (footer)', 'pp_footer' ),
		'pp_about_image'   => array( 'About page image (portrait)', 'pp_about' ),
	);
	foreach ( $imgs as $id => $f ) {
		$wp->add_setting( $id, array( 'sanitize_callback' => 'absint' ) );
		$wp->add_control( new WP_Customize_Media_Control( $wp, $id, array( 'label' => $f[0], 'section' => $f[1], 'mime_type' => 'image' ) ) );
	}
} );
