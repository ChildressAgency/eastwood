
<section id="hp-locations">
  <div class="container">
    <article class="text-center">
      <header class="article-header">
        <h2 class="icon-header icon-two-hand-saw"><?php echo esc_html(get_field('locations_section_title', 'option')); ?></h2>
        <p class="subtitle"><?php echo esc_html(get_field('locations_section_subtitle', 'option'); ?></p>
      </header>
      <?php echo wp_kses_post(get_field('locations_section_content', 'option')); ?>
    </article>
    <?php
      $contact_page = get_page_by_path('contact');
      $contact_page_id = $contact_page->ID;
      if(have_rows('locations', $contact_page_id)): ?>
        <div class="row">
          <?php $i = 0; while(have_rows('locations', $contact_page_id)): the_row(); ?>
            <?php if($i % 3 == 0){ echo '<div class="clearfix"></div>'; } ?>
            <div class="col-md-4">
              <?php $location_image = get_sub_field('location_image'); ?>
              <div class="location-bg-img" style="background-image:url(<?php echo esc_url($location_image['url']); ?>);">
                <a href="<?php echo esc_url(home_url('contact')); ?>"><?php echo esc_html(get_sub_field('location_name')); ?>, <?php echo esc_html(get_sub_field('location_state')); ?></a>
                <div class="overlay light-overlay"></div>
              </div>
            </div>
          <?php $i++; endwhile; ?>
        </div>
    <?php endif; ?>
  </div>
</section>