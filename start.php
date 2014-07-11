<?php

/**
 * Responsive Theme for Elgg
 *
 * @package hypeJunction
 * @subpackage ThemeX
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 */

namespace hypeJunction\ThemeX;

const PLUGIN_ID = 'hypeThemeX';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');
elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\setup_menus', 999);

/**
 * Initialize the plugin
 */
function init() {

	if (elgg_in_context('admin')) {
		return;
	}

	elgg_extend_view('css/elgg', 'css/theme/custom', 999);
	elgg_extend_view('css/elgg', 'css/theme/plugins', 999);

	elgg_extend_view('page/elements/head', 'framework/metatags/viewport');

	elgg_unextend_view('page/elements/header', 'search/header');

	// Load fonts
	elgg_register_css('fonts.font-awesome', '/mod/' . PLUGIN_ID . '/vendors/fonts/font-awesome.css');
	elgg_load_css('fonts.font-awesome');
	elgg_register_css('fonts.open-sans', '/mod/' . PLUGIN_ID . '/vendors/fonts/open-sans.css');
	elgg_load_css('fonts.open-sans');

	elgg_define_js('modernizr', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/modernizr/modernizr.js',
			//'exports' => 'window.Modernizr',
	));
	elgg_define_js('fastclick', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/fastclick/lib/fastclick.js',
			//'exports' => 'Fastclick',
	));

	elgg_define_js('foundation', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/foundation/js/foundation.min.js',
		'deps' => array('jquery', 'modernizr', 'fastclick')
	));

	elgg_require_js('theme/init');
}

/**
 * Customize the topbar menu so that it works with Foundation
 */
function setup_menus() {

	elgg_unregister_menu_item('topbar', 'elgg_logo');

	elgg_register_menu_item('topbar', array(
		'name' => 'logo',
		'href' => false,
		'text' => elgg_view('page/elements/topbar_logo'),
		'item_class' => 'name',
		'section' => 'title-area',
	));

	elgg_register_menu_item('topbar', array(
		'name' => 'toggle',
		'href' => '#',
		'text' => elgg_echo('menu'),
		'item_class' => 'toggle-topbar menu-icon',
		'priority' => 900,
		'section' => 'title-area',
	));

	if (elgg_is_admin_logged_in()) {
		$counter = '';
		$admin_notices = elgg_get_entities(array(
			'types' => 'object',
			'subtypes' => 'admin_notice',
			'count' => true
		));
		if ($admin_notices) {
			$counter = '<span class="messages-new">' . $admin_notices . '</span>';
		}
		elgg_register_menu_item('topbar', array(
			'name' => 'administration',
			'href' => 'admin',
			'text' => elgg_view_icon('dashboard') . elgg_echo('admin') . $counter,
			'priority' => 100,
			'section' => 'alt',
		));
	}
}
