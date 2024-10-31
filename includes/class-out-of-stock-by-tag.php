<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
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
class Out_Of_Stock_By_Tag {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Out_Of_Stock_By_Tag_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'OUT_OF_STOCK_BY_TAG_VERSION' ) ) {
			$this->version = OUT_OF_STOCK_BY_TAG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'out-of-stock-by-tag';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Out_Of_Stock_By_Tag_Loader. Orchestrates the hooks of the plugin.
	 * - Out_Of_Stock_By_Tag_i18n. Defines internationalization functionality.
	 * - Out_Of_Stock_By_Tag_Admin. Defines all hooks for the admin area.
	 * - Out_Of_Stock_By_Tag_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-out-of-stock-by-tag-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-out-of-stock-by-tag-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-out-of-stock-by-tag-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-out-of-stock-by-tag-public.php';

		$this->loader = new Out_Of_Stock_By_Tag_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Out_Of_Stock_By_Tag_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Out_Of_Stock_By_Tag_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Out_Of_Stock_By_Tag_Admin( $this->get_plugin_name(), $this->get_version() );

		//Menu page
		$this->loader->add_action('admin_menu', $plugin_admin, 'out_of_stock_by_tag_add_admin_submenu');
		$this->loader->add_action('admin_menu', $plugin_admin, 'out_of_stock_by_tag_add_admin_register_settings');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Out_Of_Stock_By_Tag_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_filter( 'woocommerce_product_is_in_stock', $plugin_public, 'maybe_show_out_of_stock', 2, 99 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Out_Of_Stock_By_Tag_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
