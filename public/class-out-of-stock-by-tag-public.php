<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://devwell.de/out-of-stock-by-tag/
 * @since      1.0.0
 *
 * @package    Out_Of_Stock_By_Tag
 * @subpackage Out_Of_Stock_By_Tag/public
 * 
 * Plugin Name: Out Of Stock By Tag
 * Plugin URI: https://devwell.de/out-of-stock-by-tag/
 * Description: Easily sell and manage software license keys through your WooCommerce shop.
 * Version: 2.2.1
 * Author: antochas
 * Author URI: https://devwell.de/
 * Tested up to: 5.5
 * Requires PHP: 5.6
 * WC requires at least: 2.7
 * WC tested up to: 4.5
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

class Out_Of_Stock_By_Tag_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	Here is where the frontend magic happens
	**/
	public function maybe_show_out_of_stock($in_stock, $object){

		// Out of stock by categories
		$categories = get_the_terms ( $object->get_id(), 'product_cat' );
		$categories_slugs = [];

		foreach ($categories as $category) {
			$categories_slugs[] = $category->slug;
		}

		$out_of_stock_categories = explode(';', get_option('out-of-stock-by-tag_categories'));

		$category_check = !empty(array_intersect($categories_slugs, $out_of_stock_categories));

		// Block by category
		if($category_check){
			return false;
		}

		// Out of stock by tags
		$product_tags = wp_get_post_terms ( $object->get_id(), 'product_tag' );
		$product_tag_slugs = [];

		foreach ($product_tags as $product_tag) {
			$product_tag_slugs[] = $product_tag->slug;
		}

		$out_of_stock_tags = explode(';', get_option('out-of-stock-by-tag_tags'));

		$tag_check = !empty(array_intersect($product_tag_slugs, $out_of_stock_tags));

		// Block by category
		if($tag_check){
			return false;
		}

		return $in_stock;

	}

}
