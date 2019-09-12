<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta http-equiv="cache-control" content="public">
  <meta http-equiv="cache-control" content="private">

  <title><?php echo esc_html(bloginfo('name')); ?></title>

  <?php wp_head(); ?>
</head>

<body>
  <header id="header">
    <section id="masthead">
      <div class="container d-flex align-items-stretch">
        <div class="masthead-contact">
          <a href="<?php echo esc_url(home_url('contact')); ?>" class="call-today d-none d-lg-inline"><?php echo esc_html__('Call Today!', 'eastwood'); ?></a>
          <?php
            $contact_page = get_page_by_path('contact');
            $contact_page_id = $contact_page->ID;
            if(have_rows('locations', $contact_page_id)): ?>
              <ul class="list-unstyled locations d-none d-lg-inline">
                <?php while(have_rows('locations', $contact_page_id)): the_row(); ?>
                  <?php $location_phone = get_sub_field('location_phone'); ?>
                  <li><?php the_sub_field('location_name'); ?>: <a href="tel:<?php echo esc_attr($location_phone); ?>"><?php echo esc_html($location_phone); ?></a></li>
                <?php endwhile; ?>
              </ul>
          <?php endif; ?>
        </div>
        <a href="<?php echo esc_url(home_url('search')); ?>" class="search-link" title="<?php echo esc_attr__('Search', 'eastwood'); ?>"><span class="sr-only"><?php echo esc_html__('Search', 'eastwood'); ?></span></a>
      </div>
    </section>

    <nav id="header-nav" class="navbar navbar-expand-lg">
      <div class="container">
        <a href="<?php echo esc_url(home_url()); ?>" class="navbar-brand">
          <img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.png" class="img-fluid" alt="Eastwood Furniture Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle Navigation">
          <i class="fas fa-bars"></i>
        </button>
        <?php get_template_part('partials/navbar'); ?>
      </div>
    </nav>
  </header>

  <?php get_template_part('partials/hero');