<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       devwell.de
 * @since      1.0.0
 *
 * @package    Out_Of_Stock_By_Tag
 * @subpackage Out_Of_Stock_By_Tag/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php

  $all_tags_terms = get_terms(
    [
      'hide_empty' => false, // only if you want to hide false
      'taxonomy'   => 'product_tag',
      'limit'      => 0
    ]
  );

  $all_tags_slugs = [];
  foreach($all_tags_terms as $terms_object){
    $all_tags_slugs[$terms_object->name] = $terms_object->slug;
  }

  $product_categories_terms = get_terms( 'product_cat',
    [
      'orderby'    => 'name',
      'order'      => 'asc',
      'hide_empty' => false
    ]
  );

  $all_categories_slugs = [];
  foreach($product_categories_terms as $category_object){
    $all_categories_slugs[$category_object->name] = $category_object->slug;
  }

  $wpnonce = true;
  if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce($_POST['nonce'], 'oosbt-nonce')) {
    $wpnonce = false;
  }

  if(isset($_POST['out-of-stock-by-tag_submit'])){

      // Nonce security check
    if($wpnonce){
      
      $sanitized_tags = [];
      foreach($_POST['out-of-stock-by-tag_tags'] as $tag){
        
        // Sanitisazation 
        $sanitized_tag = sanitize_text_field( $tag );
        
        // Validation, only actuall product_tag slugs are allowed
        if(in_array($sanitized_tag, $all_tags_slugs)){
        
          $sanitized_tags[] = $sanitized_tag;
        
        }
        
      }
  
      $tags = implode(';', $sanitized_tags);
      
      // update_option is already escaping the input, no need to additional escaping, thanks wp :)
      update_option( 'out-of-stock-by-tag_tags', $tags);
  
      $sanitized_cats = [];
      foreach($_POST['out-of-stock-by-tag_categories'] as $cat){
        
        // Sanitisazation 
        $sanitized_cat = sanitize_text_field( $cat );
        
        // Validation, only actuall product_tag slugs are allowed
        if(in_array($sanitized_cat, $all_categories_slugs)){
        
          $sanitized_cats[] = $sanitized_cat;
        
        }
      
      }
      
      $cats = implode(';', $sanitized_cats);
      
      // update_option is already escaping the input, no need to additional escaping, thanks wp :)
      update_option( 'out-of-stock-by-tag_categories', $cats);
    
      echo '<div class="notice notice-success is-dismissible">
        <p>Updated successfully</p>
      </div>';

    }else{
        
      echo '<div class="error is-dismissible">
        <p>Error with nonce!</p>
      </div>';

    }

  }


?>

<div class="wrap">
	<h1>Out of Stock by Tag (and categories) - settings</h1>
	<form method="post" style="margin-top: 50px">

    <table>
      <tr valign="top" style="text-align: left">
        <th scope="row"><label for="out-of-stock-by-tag_tags">Tags: </label></th>
        <td>
          <?php $tags = explode(';', get_option('out-of-stock-by-tag_tags'));?>
          <select style="width:250px" name="out-of-stock-by-tag_tags[]" id="out-of-stock-by-tag_tags" multiple>
            <?php
              foreach ($all_tags_slugs as $tag_name => $tag_slug) {
                echo '<option value="' . $tag_slug . '"' . ' ' . (in_array($tag_slug, $tags)?'selected':'') . '>' . $tag_name . '</option>';
              }
             ?>
          </select>
        </td>
      </tr>

      <tr valign="top" style="text-align: left">
        <th scope="row"><label for="out-of-stock-by-tag_tags">Categories: </label></th>
        <td>
          <?php $cats = explode(';', get_option('out-of-stock-by-tag_categories'));
          
          ?>
          <select style="width:250px" name="out-of-stock-by-tag_categories[]" id="out-of-stock-by-tag_tags" multiple>
            <?php
              foreach ($all_categories_slugs as $category_name => $category_slug) {
                echo '<option value="' . $category_slug . '"' . ' ' . (in_array($category_slug, $cats)?'selected':'') . '>' . $category_name . '</option>';
              }
             ?>
          </select>
        </td>
      </tr>

    </table>
    
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('oosbt-nonce') ?>">
    <input type="hidden" name="out-of-stock-by-tag_submit" value="1">
		<?php
    		submit_button();
    ?>

</form></div>
