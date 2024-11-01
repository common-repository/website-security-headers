<?php
/**
 * Website Security Headers
 *
 * @package           DAVEDOESTHINGS\WSH
 *
 * Plugin Name:       Website Security Headers
 * Description:       Easily implement key security headers that can have a profound impact on the overall security of your website.
 * Version:           1.0.1
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Contributors:      davedoesthings
 * Author:            Dave Green <mr.david.thomas.green@gmail.com>
 * Author URI:        https://github.com/davedoesthings
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       davedoesthings-wsh
 * Domain Path:       /languages
 */

namespace DAVEDOESTHINGS\WSH;

if ( ! defined( 'WPINC' ) ) {
	die;
}

const ROOT_FILE   = __FILE__;
const DATA_PREFIX = '_davedoesthings_wsh';

require_once 'inc/enqueues.php';
require_once 'inc/headers.php';
require_once 'inc/settings.php';

load_plugin_textdomain( 'davedoesthings-wsh', false, plugin_dir_path( ROOT_FILE ) . 'languages' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\Enqueues\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Headers\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Settings\setup' );
