<?php get_header(); ?>
<main id="main">
  <div class="container">
    <article class="entry-content">
      <?php 
        if(have_posts()){
          while(have_posts()){
            the_post();

            the_content();
          }
        }
      ?>

      <div class="row">
        <div class="col-lg-6">
          <div class="locations">
            <?php if(have_rows('locations')): while(have_rows('locations')): the_row(); ?>
              <div class="location">
                <h3><?php the_sub_field('location_title'); ?></h3>
                <p><?php the_sub_field('location_hours'); ?></p>
                <p><?php the_sub_field('location_phone'); ?></p>
                <p><?php the_sub_field('location_email'); ?></p>
                <p>
                  <span class="d-block"><?php the_sub_field('location_address'); ?></span>
                  <span class="d-block"><?php the_sub_field('location_city_state_zip'); ?></span>
                </p>
                <a href="<?php the_sub_field('location_map_view'); ?>" class="btn-main btn-small"><?php echo esc_html('See on map', 'eastwood'); ?></a>
              </div>
            <?php endwhile; endif; ?>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="embed-responsive embed-responsive-1by1 locations-map">
            <?php if(have_rows('locations')): while(have_rows('locations')): the_row(); ?>
              <?php
                $location = get_sub_field('google_map_marker_location');
                if($location): ?>

                  <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
                    <h4><?php echo esc_html(bloginfo('name')); ?><br /><?php echo esc_html(get_sub_field('location_title')); ?></h4>
                    <p class="map-address">
                      <span class="d-block"><?php echo esc_html(get_sub_field('location_address')); ?></span>
                      <span class="d-block"><?php echo esc_html(get_sub_field('location_city_state_zip')); ?></span>
                    </p>
                    <p class="map-phone">
                      <?php $map_phone = get_sub_field('location_phone'); ?>
                      <a href="tel:<?php echo esc_attr($map_phone); ?>"><?php echo esc_html($map_phone); ?></a>
                    </p>
                  </div>

              <?php endif; ?>
            <?php endwhile; endif; ?>
          </div>
        </div>
      </div>
    </article>
  </div>

  <?php 
    $contact_form_shortcode = get_field('contact_form_shortcode');
    if($contact_form_shortcode): ?>
      <section id="contact-form">
        <div class="container">
          <h2><?php the_field('contact_form_title'); ?></h2>
          <?php echo do_shortcode($contact_form_shortcode); ?>
        </div>
      </section>
  <?php endif; ?>
</main>
<?php get_footer();