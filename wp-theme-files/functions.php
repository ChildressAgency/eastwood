<?php
add_action('wp_footer', 'show_template');
function show_template() {
	global $template;
	print_r($template);
}

add_action('wp_enqueue_scripts', 'jquery_cdn');
function jquery_cdn(){
  if(!is_admin()){
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, null, true);
    wp_enqueue_script('jquery');
  }
}

add_action('wp_enqueue_scripts', 'eastwood_scripts');
function eastwood_scripts(){
  wp_register_script(
    'bootstrap-popper',
    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js',
    array('jquery'),
    '',
    true
  );

  wp_register_script(
    'bootstrap-scripts',
    'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js',
    array('jquery', 'bootstrap-popper'),
    '',
    true
  );

  wp_register_script(
    'eastwood-scripts',
    get_stylesheet_directory_uri() . '/js/custom-scripts.min.js',
    array('jquery', 'bootstrap-scripts'),
    '',
    true
  );

  wp_enqueue_script('bootstrap-popper');
  wp_enqueue_script('bootstrap-scripts');
  wp_enqueue_script('eastwood-scripts');
}

add_filter('script_loader_tag', 'eastwood_add_script_meta', 10, 2);
function eastwood_add_script_meta($tag, $handle){
  switch($handle){
    case 'jquery':
      $tag = str_replace('></script>', ' integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>', $tag);
      break;

    case 'bootstrap-popper':
      $tag = str_replace('></script>', ' integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>', $tag);
      break;

    case 'bootstrap-scripts':
      $tag = str_replace('></script>', ' integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>', $tag);
      break;
  }

  return $tag;
}

add_action('wp_enqueue_scripts', 'eastwood_styles');
function eastwood_styles(){
  wp_register_style(
    'google-fonts',
    'https://fonts.googleapis.com/css?family=Raleway:400,500,700,700i,900&display=swap'
  );

  wp_register_style(
    'fontawesome',
    'https://use.fontawesome.com/releases/v5.6.3/css/all.css'
  );

  wp_register_style(
    'eastwood-css',
    get_stylesheet_directory_uri() . '/style.css'
  );

  wp_enqueue_style('google-fonts');
  wp_enqueue_style('fontawesome');
  wp_enqueue_style('eastwood-css');
}

add_filter('style_loader_tag', 'eastwood_add_css_meta', 10, 2);
function eastwood_add_css_meta($link, $handle){
  switch($handle){
    case 'fontawesome':
      $link = str_replace('/>', ' integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">', $link);
      break;
  }

  return $link;
}

add_action('after_setup_theme', 'eastwood_setup');
function eastwood_setup(){
  add_theme_support('post-thumbnails');
  //set_post_thumbnail_size(320, 320);

  add_theme_support(
    'html5',
    array(
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    )
  );

  add_theme_support('editor-styles');
  add_theme_support('wp-block-styles');
  add_theme_support('responsive-embeds');

  register_nav_menus(array(
    'footer-quick-links-menu' => 'Footer Quick Links Menu',
    'footer-furniture-menu' => 'Footer Furniture Menu',
  ));

  load_theme_textdomain('eastwood', get_stylesheet_directory_uri() . '/languages');

  //woocommerce support
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
}

//require_once dirname(__FILE__) . '/includes/class-wp-bootstrap-navwalker.php';
require_once dirname(__FILE__) . '/includes/woo-functions.php';

add_action('widgets_init', 'eastwood_register_sidebars');
function eastwood_register_sidebars(){
  register_sidebar(array(
    'name' => esc_html__('Shop Sidebar', 'eastwood'),
    'id' => 'sidebar-shop',
    'description' => esc_html__('Add widgets here to appear in your sidebar on the shop pages.', 'eastwood'),
    'before_widget' => '<div class="sidebar-section">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

add_filter('block_categories', 'eastwood_custom_block_category', 10, 2);
function eastwood_custom_block_category($categories, $post){
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'custom-blocks',
        'title' => esc_html__('Custom Blocks', 'eastwood'),
        'icon' => 'wordpress'
      )
    )
  );
}

add_action('acf/init', 'eastwood_register_blocks');
function eastwood_register_blocks(){
  if(function_exists('acf_register_block_type')){
    acf_register_block_type(array(
      'name' => 'article_header',
      'title' => esc_html__('Article Header', 'eastwood'),
      'description' => esc_html__('Add a pre-styled article header.', 'eastwood'),
      'category' => 'custom-blocks',
      'mode' => 'auto',
      'align' => 'full',
      'render_template' => get_stylesheet_directory() . '/partials/article_header.php',
      'enqueue_style' => get_stylesheet_directory_uri() . '/partials/article_header.css'
    ));

    acf_register_block_type(array(
      'name' => 'content_styled_image',
      'title' => esc_html__('Content with Styled Image', 'eastwood'),
      'description' => esc_html__('Display content with article header and a stylized image.', 'eastwood'),
      'category' => 'custom-blocks',
      'mode' => 'auto',
      'align' => 'full',
      'render_template' => get_stylesheet_directory() . '/partials/content_styled_image.php',
      'enqueue_style' => get_stylesheet_directory_uri() . '/partials/content_styled_image.css'
    ));
  }
}