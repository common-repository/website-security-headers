<?php
/**
 * Enqueues
 *
 * @package DAVEDOESTHINGS\WSH
 */

namespace DAVEDOESTHINGS\WSH\Enqueues;

use const DAVEDOESTHINGS\WSH\ROOT_FILE;

/**
 * Setup.
 *
 * @return void
 */
function setup() : void {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_assets', 10 );
}

/**
 * Enqueue assets for the admin area.
 *
 * @return void
 */
function enqueue_admin_assets() : void {

	$current_screen = get_current_screen();

	if ( ! $current_screen || 'settings_page__davedoesthings_wsh_settings' !== $current_screen->base ) {
		return;
	}

	wp_enqueue_script(
		'davedoesthings-wsh-js',
		plugins_url( 'assets/davedoesthings-wsh.js', ROOT_FILE ),
		[],
		filemtime( plugin_dir_path( ROOT_FILE ) . 'assets/davedoesthings-wsh.js' ),
		true
	);

	wp_enqueue_style(
		'davedoesthings-wsh-css',
		plugins_url( 'assets/davedoesthings-wsh.css', ROOT_FILE ),
		[],
		filemtime( plugin_dir_path( ROOT_FILE ) . 'assets/davedoesthings-wsh.css' )
	);
}
