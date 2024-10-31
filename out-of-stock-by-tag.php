<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              devwell.de
 * @since             1.0.0
 * @package           Out_Of_Stock_By_Tag
 *
 * @wordpress-plugin
 * Plugin Name:       Out of stock by tag
 * Plugin URI: 		  https://devwell.de/out-of-stock-by-tag/
 * Description:       Out of stock by Tag, will allow you to bulk set products as out of stock by either Tag or Categories.
 * Version:           1.0.0
 * Author:            Antochas <antonis@devwell.de>
 * Author URI:        https://devwell.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       out-of-stock-by-tag
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'OUT_OF_STOCK_BY_TAG_VERSION', '1.0.0' );
define( 'OUT_OF_STOCK_BY_TAG_PARTIALS',  __dir__ . '/admin/partials/' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-out-of-stock-by-tag-activator.php
 */
function activate_out_of_stock_by_tag() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-out-of-stock-by-tag-activator.php';
	Out_Of_Stock_By_Tag_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-out-of-stock-by-tag-deactivator.php
 */
function deactivate_out_of_stock_by_tag() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-out-of-stock-by-tag-deactivator.php';
	Out_Of_Stock_By_Tag_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_out_of_stock_by_tag' );
register_deactivation_hook( __FILE__, 'deactivate_out_of_stock_by_tag' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-out-of-stock-by-tag.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_out_of_stock_by_tag() {

	$plugin = new Out_Of_Stock_By_Tag();
	$plugin->run();

}
run_out_of_stock_by_tag();
