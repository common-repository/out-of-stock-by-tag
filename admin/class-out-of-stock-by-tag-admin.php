<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       devwell.de
 * @since      1.0.0
 *
 * @package    Out_Of_Stock_By_Tag
 * @subpackage Out_Of_Stock_By_Tag/admin
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
class Out_Of_Stock_By_Tag_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Out_Of_Stock_By_Tag_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Out_Of_Stock_By_Tag_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/out-of-stock-by-tag-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Out_Of_Stock_By_Tag_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Out_Of_Stock_By_Tag_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/out-of-stock-by-tag-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
		Add submenu to woocommerce
	**/
	public function out_of_stock_by_tag_add_admin_submenu(){

		add_submenu_page( 'woocommerce', 'Out of stock - Settings', 'Out of Stock', 'manage_options', 'out-of-stock-by-tag-settings', [$this, 'out_of_stock_by_tag_add_admin_callback'] );

	}

	/**
		Add submenu to woocommerce callback
	**/
	public function out_of_stock_by_tag_add_admin_callback() {

		include (OUT_OF_STOCK_BY_TAG_PARTIALS) . 'out-of-stock-by-tag-admin-display.php';

	}

	/**
		Register settings
	**/
	public function out_of_stock_by_tag_add_admin_register_settings() {

		register_setting( 'out-of-stock-by-tag-options', 'out-of-stock-by-tag_tags' );
		register_setting( 'out-of-stock-by-tag-options', 'newoptions' );

	}

}
