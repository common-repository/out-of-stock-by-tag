<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       devwell.de
 * @since      1.0.0
 *
 * @package    Out_Of_Stock_By_Tag
 * @subpackage Out_Of_Stock_By_Tag/includes
 */

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Out of stock by tag
 * Plugin URI:        https://devwell.de/out-of-stock-by-tag/
 * Description:       Out of stock by Tag, will allow you to bulk set products as out of stock by either Tag or Categories.
 * Version:           1.0.0
 * Author:            Antochas <antonis@devwell.de>
 * Author URI:        https://devwell.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       out-of-stock-by-tag
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Out_Of_Stock_By_Tag_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'out-of-stock-by-tag',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
