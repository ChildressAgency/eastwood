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
  global $product;
  $product_name = $product->get_name();
  $product_sku = $product->get_sku();

  $contact_for_price = '<a href="#product-inquiry-modal" class="btn-main" data-toggle="modal">Contact About Price</a>';

  $contact_for_price = sprintf(
    '<a href="#product-inquiry-modal" class="btn-main" data-toggle="modal" data-product_name="%s" data-product_sku="%s">%s</a>',
    esc_attr($product_name),
    esc_attr($product_sku),
    esc_html__('Contact About Price', 'eastwood')
  );

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

/**
 * product loop thumbnail
 */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

add_action('woocommerce_before_shop_loop_item', 'eastwood_template_loop_product_link_open', 10);
function eastwood_template_loop_product_link_open(){
  echo '<div class="img-link" style="background-image:url(' . get_the_post_thumbnail_url() . ');">';
}

add_action('woocommerce_shop_loop_item_title', 'eastwood_shop_loop_item_title', 10);
function eastwood_shop_loop_item_title(){
   //echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>';
  global $product;

  $product_link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
  echo '<a href="' . esc_url($product_link) . '">';
    echo '<span>' . esc_html(get_the_title()) . '</span>';
  echo '</a>';
}

add_action('woocommerce_after_shop_loop_item', 'eastwood_template_loop_product_link_close', 5);
function eastwood_template_loop_product_link_close(){
  echo '</div>';
}

/**
 * display loop header
 */
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

/**
 * rearrange single product meta section
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 80);

/**
 * Product inquiry modal content
 */
add_action('woocommerce_after_main_content', 'eastwood_product_inquiry_modal', 20);
function eastwood_product_inquiry_modal(){
  $product_inquiry_form = get_field('product_inquiry_form_shortcode', 'option'); ?>

  <div class="modal fade" id="product-inquiry-modal" tabindex="-1" role="dialog" aria-labelledby="product-inquiry-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="product-inquiry-modal-label"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <?php echo do_shortcode($product_inquiry_form); ?>
        </div>
      </div>
    </div>
  </div>
<?php }