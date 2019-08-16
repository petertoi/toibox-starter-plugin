<?php

/**
 * Plugin Name:        Plugin_Name
 * Plugin URI:         https://petertoi.com
 * Description:        Plugin Description
 * Version:            1.0.0
 * Requires at least:  @TODO WordPress version requirement
 * Requires PHP:       @TODO PHP version requirement
 * Author:             Peter Toi
 * Author URI:         https://petertoi.com
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:        plugin-name
 * Domain Path:        /public/lang
 * Network:            @TODO can this be activated network wide?
 */

use Toi\Plugin_Name\Plugin as Plugin_Name;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! defined( 'TOI_PLUGIN_NAME_VERSION' ) ) {
    define( 'TOI_PLUGIN_NAME_VERSION', '1.0.0' );
}

require_once 'autoloader.php';

/**
 * Global function providing access to the plugin.
 *
 * @since    1.0.0
 */
function toibox_plugin_name() {
    /**
     * @var $toibox_plugin_name Plugin_Name
     */
    $toibox_plugin_name = Plugin_Name::get_instance();

    return $toibox_plugin_name;
}

// Ready, steady, GO!
toibox_plugin_name()->initialize(
    __FILE__,
    TOI_PLUGIN_NAME_VERSION
);
