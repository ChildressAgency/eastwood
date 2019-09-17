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
  return 'Call for price';
}