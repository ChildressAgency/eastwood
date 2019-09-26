<?php
/**
 * Plugin Name: eastwoodfurniture.com Core Functionality
 * Description: This contains all your site's core functionality so that it is theme independent. <strong>It should always be activated.</strong>
 * Author: Childress Agency
 * Author URI: https://childressagency.com
 * Version: 1.0
 * Text Domain: eastwood
 */
if(!defined('ABSPATH')){ exit; }

define('EASTWOOD_PLUGIN_DIR', dirname(__FILE__));
define('EASTWOOD_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Load ACF if not already loaded
 */
if(!class_exists('acf')){
  require_once EASTWOOD_PLUGIN_DIR . '/vendors/advanced-custom-fields-pro/acf.php';
  add_filter('acf/settings/path', 'eastwood_acf_settings_path');
  add_filter('acf/settings/dir', 'eastwood_acf_settings_dir');
}

function eastwood_acf_settings_path($path){
  $path = plugin_dir_path(__FILE__) . 'vendors/advanced-custom-fields-pro/';
  return $path;
}

function eastwood_acf_settings_dir($dir){
  $dir = plugin_dir_url(__FILE__) . 'vendors/advanced-custom-fields-pro/';
  return $dir;
}

add_action('plugins_loaded', 'eastwood_load_textdomain');
function eastwood_load_textdomain(){
  load_plugin_textdomain('eastwood', false, basename(EASTWOOD_PLUGIN_DIR) . '/languages');
}

add_action('acf/init', 'eastwood_acf_options_page');
function eastwood_acf_options_page(){
  acf_add_options_page(array(
    'page_title' => esc_html__('General Settings', 'eastwood'),
    'menu_title' => esc_html__('General Settings', 'eastwood'),
    'menu_slug' => 'general-settings',
    'capability' => 'edit_posts',
    'redirect' => false
  ));

  acf_add_options_sub_page(array(
    'page_title' => esc_html__('Header Menu Settings', 'eastwood'),
    'menu_title' => esc_html__('Header Menu', 'eastwood'),
    'parent_slug' => 'general-settings'
  ));

  acf_add_options_sub_page(array(
    'page_title' => esc_html__('Testimonials Settings' , 'eastwood'),
    'menu_title' => esc_html__('Testimonials', 'eastwood'),
    'parent_slug' => 'general-settings'
  ));
}

/**
 * add additional woocommerce product tabs
 */
add_filter('woocommerce_product_tabs', 'eastwood_additional_product_tabs');
function eastwood_additional_product_tabs($tabs){
  $wood_species = get_field('wood_options_product_tab');
  //var_dump($wood_species['wood_options_wood_species']);
  if(($wood_species['product_tab_intro'] !== null && $wood_species['product_tab_intro'] !== '') || $wood_species['wood_options_wood_species']){
    $tabs['wood_options_tab'] = array(
      'title' => esc_html__('Wood Options', 'eastwood'),
      'priority' => 11,
      'callback' => 'eastwood_wood_options_tab'
    );
  }

  $stains_finishes = get_field('stains_finishes_product_tab');
  if(($stains_finishes['product_tab_intro'] !== null && $stains_finishes['product_tab_intro'] !== '') || $stains_finishes['stains_finishes_stains_finishes']){
    $tabs['stains_finishes_tab'] = array(
      'title' => esc_html__('Stains & Finishes', 'eastwood'),
      'priority' => 12,
      'callback' => 'eastwood_stains_finishes_tab'
    );
  }

  return $tabs;
}

function eastwood_wood_options_tab(){
  $product_tab = get_field('wood_options_product_tab');
  echo '<div class="tab-intro">';
    echo apply_filters('the_content', wp_kses_post($product_tab['product_tab_intro']));
  echo '</div>';

  $custom_options = $product_tab['wood_options_wood_species'];
  include(locate_template('partials/loop-custom_options.php', false, false));
}

function eastwood_stains_finishes_tab(){
  $product_tab = get_field('stains_finishes_product_tab');
  echo '<div class="tab-intro">';
    echo apply_filters('the_content', wp_kses_post($product_tab['product_tab_intro']));
  echo '</div>';

  $custom_options = $product_tab['stains_finishes_stains_finishes'];
  include(locate_template('partials/loop-custom_options.php', false, false));
}