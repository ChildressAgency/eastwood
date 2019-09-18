<?php
if(!defined('ABSPATH')){ exit; }

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action('woocommerce_before_main_content', 'eastwood_wrapper_start', 10);
function eastwood_wrapper_start(){
  echo '<main id="main">
          <div class="container">';
}

add_action('woocommerce_after_main_content', 'eastwood_wrapper_end', 10);
function eastwood_wrapper_end(){
  echo '</div></main>';
}

add_action('woocommerce_before_shop_loop', 'eastwood_shop_loop_wrapper_open', 15);
function eastwood_shop_loop_wrapper_open(){
  echo '<div class="row eastwood-product-loop">
          <div class="col-md-8 col-lg-9 order-md-12">';
}

add_action('woocommerce_after_shop_loop', 'eastwood_shop_loop_wrapper_close', 15);
function eastwood_shop_loop_wrapper_close(){
  echo '</div>'; //close col-md-8
  echo '<div class="col-md-4 col-lg-3 order-md-1">';
    get_sidebar('shop');
  echo '</div>';
  echo '</div>'; //close row
}

/**
 * Call for Price
 */
add_filter('woocommerce_empty_price_html', 'eastwood_empty_price_html');
add_filter('woocommerce_variable_empty_price_html', 'eastwood_empty_price_html');
add_filter('woocommerce_variation_empty_price_html', 'eastwood_empty_price_html');
function eastwood_empty_price_html(){
  //return 'Call for price';
  $contact_for_price = '<a href="#" class="btn-main">Contact About Price</a>';

  return $contact_for_price;
}

/**
 * product category thumbnail
 * @see content-product_cat.php
 */
remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

add_action('woocommerce_before_subcategory', 'eastwood_template_loop_category_link_open', 10);
function eastwood_template_loop_category_link_open($category){
  $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
  $image_url = wp_get_attachment_url($thumbnail_id);

  echo '<div class="img-link" style="background-image:url(' . esc_url($image_url) . ');">';
}

add_action('woocommerce_shop_loop_subcategory_title', 'eastwood_template_loop_category_title', 10);
function eastwood_template_loop_category_title($category){
  echo '<a href="' . esc_url(get_term_link($category, 'product_cat')) . '">';
    echo '<span>' . $category->name . '</span>';
  echo '</a>';
}

add_action('woocommerce_after_subcategory', 'eastwood_template_loop_category_link_close', 10);
function eastwood_template_loop_category_link_close($category){
  echo '</div>';
}

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

add_action('woocommerce_before_main_content', 'eastwood_get_shop_header', 50);
function eastwood_get_shop_header(){
  echo '<article class="shop-intro">';

  if(is_shop()){
    eastwood_show_main_shop_header();
  }
  else{
    if(is_product_taxonomy() & absint(get_query_var('paged') == 0)){
      $term = get_queried_object();

      if($term){
        $category_header = eastwood_get_category_header('product_cat_' . $term->term_id);
        if(empty($category_header) || is_null($category_header['title'])){ //no header set for this category

          if($term->parent > 0){
            $category_header = eastwood_get_category_header('product_cat_' . $term->parent);
            if(empty($category_header) || is_null($category_header['title'])){ //no header set for this category parent
              eastwood_show_main_shop_header();
            }
            else{
              eastwood_show_category_header($category_header);
            }
          }
          else{ //this is a parent category so use main shop header
            eastwood_show_main_shop_header();
          }

        }
        else{
          eastwood_show_category_header($category_header);
        }

      }
    }
  }

  echo '</article>';
}

function eastwood_show_main_shop_header(){
  echo '<header class="woocommerce-products-header article-header">';
    echo '<h2>' . esc_html(get_field('main_shop_page_header_article_header_title', 'option')) . '</h2>';
    echo '<p class="subtitle">' . esc_html(get_field('main_shop_page_header_article_header_subtitle', 'option')) . '</p>';
  echo '</header>';
  echo wp_kses_post(get_field('main_shop_page_description', 'option'));
}

function eastwood_show_category_header($category_header){
  echo '<header class="woocommerce-products-header article-header">';
    echo '<h2>' . esc_html($category_header['title']) . '</h2>';
    echo '<p class="subtitle">' . esc_html($category_header['subtitle']) . '</p>';
  echo '</header>';
  echo wp_kses_post($category_header['description']);
}

function eastwood_get_category_header($header_id){
  $category_header = array();

  $category_header['title'] = get_field('category_page_header_article_header_title', $header_id);
  $category_header['subtitle'] = get_field('category_page_header_article_header_subtitle', $header_id);
  $category_header['description'] = get_field('category_page_description', $header_id);

  return $category_header;
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 80);