<?php

/**
 * Plugin Name: PS Popup
 * Plugin URI:  https://power-source.github.io/ps-popup/
 * Description: Ermöglicht es Besuchern auf der ganzen Webseite ein ausgefallenes PopUp anzuzeigen. Eine *sehr* effektive Art, eine Mailingliste, ein Sonderangebot oder eine einfache alte Anzeige zu bewerben.
 * Version:     1.0.0
 * Author:      PSOURCE
 * Author URI:  https://github.com/Power-Source
 * Textdomain:  popover
 * Domain Path: lang
 */

/**
 * Copyright notice
 *
 * @copyright PSOURCE (https://github.com/Power-Source)
 *
 * Authors: PSOURCE
 *
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */

function inc_popup_init() {
	if ( ! defined( 'PO_VERSION' ) ) {
		define( 'PO_VERSION', 'standard' );
	}
	
	/**
	 * The current DB/build version. NOT THE SAME AS THE PLUGIN VERSION!
	 * Increase this when DB structure changes, migration code is required, etc.
	 * See IncPopupDatabase: db_is_current() and db_update()
	 */
	define( 'PO_BUILD', 6 );

	$externals = array();
	$plugin_dir = trailingslashit( dirname( __FILE__ ) );
	$plugin_dir_rel = trailingslashit( dirname( plugin_basename( __FILE__ ) ) );
	$plugin_url = plugin_dir_url( __FILE__ );

	define( 'PO_LANG_DIR', $plugin_dir_rel . 'lang/' );
	define( 'PO_DIR', $plugin_dir );
	define( 'PO_TPL_DIR', $plugin_dir . 'css/tpl/' );
	define( 'PO_INC_DIR', $plugin_dir . 'inc/' );
	define( 'PO_JS_DIR', $plugin_dir . 'js/' );
	define( 'PO_CSS_DIR', $plugin_dir . 'css/' );

	define( 'PO_TPL_URL', $plugin_url . 'css/tpl/' );
	define( 'PO_JS_URL', $plugin_url . 'js/' );
	define( 'PO_CSS_URL', $plugin_url . 'css/' );
	define( 'PO_IMG_URL', $plugin_url . 'img/' );

	// Include function library.
	$modules[] = PO_INC_DIR . 'external/wpmu-lib/core.php';
	//$modules[] = PO_INC_DIR . 'external/wdev-frash/module.php';
	$modules[] = PO_INC_DIR . 'config-defaults.php';

	if ( is_admin() ) {
		// Defines class 'IncPopup'.
		$modules[] = PO_INC_DIR . 'class-popup-admin.php';
	} else {
		// Defines class 'IncPopup'.
		$modules[] = PO_INC_DIR . 'class-popup-public.php';
	}




	// Plugin configuration.
	foreach ( $modules as $path ) {
		if ( file_exists( $path ) ) { require_once $path; }
	}

	// Initialize the plugin as soon as we have identified the current user.
	IncPopup::instance();
}


inc_popup_init();




// Translation.
function inc_popup_init_translation() {
	if ( defined( 'PO_LANG_DIR' ) ) {
		load_plugin_textdomain(
			'popover',
			false,
			PO_LANG_DIR
		);
	}
}
add_action( 'plugins_loaded', 'inc_popup_init_translation' );