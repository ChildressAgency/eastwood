<?php get_header(); ?>
<main id="main">

  <section id="hp-main-section" class="my-5">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <article>

            <header class="article-header">
              <?php
                $first_section_header = get_field('first_section_header');
                if($first_section_header['image']){
                  echo '<img src="' . esc_url($first_section_header['image']['url']) . '" class="img-fluid d-block mb-4" alt="' . esc_attr($first_section_header['image']['alt']) . '" />';
                }

                echo '<h1>' . esc_html($first_section_header['title']) . '</h1>';

                if($first_section_header['subtitle']){
                  echo '<p class="subtitle">' . esc_html($first_section_header['subtitle']);
                }
              ?>
            </header>

            <?php echo wp_kses_post(get_field('first_section_content')); ?>
            <?php
              $first_section_link = get_field('first_section_link');
              if($first_section_link): ?>
                <a href="<?php echo esc_url($first_section_link['url']); ?>" class="btn-main"><?php echo esc_html($first_section_link['title']); ?></a>
            <?php endif; ?>
          </article>
        </div>
        <div class="col-md-7">
          <div class="img-stylized-background">
            <?php $first_section_image = get_field('first_section_image'); ?>
            <img src="<?php echo esc_url($first_section_image['url']); ?>" class="img-fluid d-block mx-auto" alt="<?php echo esc_url($first_section_image['alt']); ?>" />
            <div class="border-square"></div>
            <div class="filled-square"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="overflow-wrapper">
    <div id="planer-animation">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/planer.png" class="" alt="" />
    </div>
  </div>

  <section id="hp-why" class="my-5">
    <div class="container">
      <article>
        <header class="article-header">
          <?php
            $second_section_header = get_field('second_section_header');
            if($second_section_header['image']){
              echo '<img src="' . esc_url($second_section_header['image']['url']) . '" class="img-fluid d-block mb-auto" alt="' . esc_attr($second_section_header['image']['alt']) . '" />';
            }

            echo '<h2>' . esc_html($second_section_header['title']) . '</h2>';

            if($second_section_header['subtitle']){
              echo '<p class="subtitle">' . esc_html($second_section_header['subtitle']) . '</p>';
            }
          ?>
        </header>

        <div class="two-column-content">
          <?php echo wp_kses_post(get_field('second_section_content')); ?>
        </div>
      </article>
    </div>
  </section>

  <section id="hp-explore">
    <div class="row no-gutters">
      <div class="col-md-6 text-side d-flex flex-column align-items-end">
        <article>
          <header class="article-header">
            <?php
              $explore_section_header = get_field('explore_section_header');
              if($explore_section_header['image']){
                echo '<img src="' . esc_url($explore_section_header['image']['url']) . '" class="img-fluid d-block mb-4" alt="' . esc_attr($explore_section_header['image']['alt']) . '" />';
              }

              echo '<h2>' . esc_html($explore_section_header['title']) . '</h2>';

              if($explore_section_header['subtitle']){
                echo '<p class="subtitle">' . esc_html($explore_section_header['subtitle']) . '</p>';
              }
            ?>
          </header>

          <?php echo wp_kses_post(get_field('explore_section_content')); ?>
        </article>

        <?php
          $shop_cats = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => 0
          ));
          $first_image = '';

          if($shop_cats): ?>
            <div class="cat-list-container">
              <div id="cat-list">
                <ul class="nav nav-pills">
                  <?php $c = 0; foreach($shop_cats as $shop_cat):
                    $shop_cat_name = $shop_cat->name;
                    $shop_cat_slug = $shop_cat->slug;
                    $shop_cat_image_id = get_term_meta($shop_cat->term_id, 'thumbnail_id', true);
                    $shop_cat_image_url = wp_get_attachment_url($shop_cat_image_id);

                    $active_cat = ($c == 0) ? ' active' : '';
                    $aria_selected = ($c == 0) ? 'true' : 'false';

                    if($c == 0){ $first_image = $shop_cat_image_url; }
                  ?>
                    <li class="nav-item">
                      <?php 
                        printf(
                          '<a href="#explore-%s" id="tab-explore-%s" class="nav-link%s" data-toggle="pill" role="tab" aria-controls="explore-%s" aria-selected="%s" data-bg_image="$s">%s</a>',
                          esc_attr($shop_cat_slug),
                          esc_attr($shop_cat_slug),
                          $active_cat,
                          esc_attr($shop_cat_slug),
                          $aria_selected,
                          esc_url($shop_cat_image_url),
                          esc_html($shop_cat_name)
                        );
                      ?>
                    </li>
                  <?php $c++; endforeach; reset($shop_cats); ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
      </div>
      <div class="col-md-6 image-side" style="background-image: url(<?php echo esc_url($first_image); ?>);">
        <?php if($shop_cats): ?>
          <div id="cat-links-container">
            <div id="cat-links" class="tab-content">
              <?php $sc = 0; foreach($shop_cats as $shop_cat):
                $shop_cat_name = $shop_cat->name;
                $shop_cat_slug = $shop_cat->slug;
                $shop_cat_description = $shop_cat->description;
                $shop_cat_link = get_category_link($shop_cap->term_id);
              ?>

                <div id="explore-<?php echo esc_attr($shop_cat_slug); ?>" class="tab-pane fade<?php if($sc = 0){ echo ' show active'; } ?>" role="tabpanel" aria-labelledby="tab-explore-<?php echo esc_attr($shop_cat_slug); ?>">
                  <div class="cat-tab-pane-inner">
                    <div class="cat-description">
                      <?php echo wp_kses_post($shop_cat_description); ?>
                    </div>
                    <div class="cat-shop-now">
                      <a href="<?php echo esc_url($shop_cat_link); ?>">Shop<br />Now</a>
                    </div>
                  </div>
                </div>

              <?php $sc++; endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section id="customization">
    <div class="row no-gutters">
      <div class="col-md-6">
        <?php 
          $custom_options_page = get_page_by_path('custom-options');
          $custom_options_page_id = $custom_options_page->ID;
          $wood_species = get_field('wood_species', $custom_options_page_id);
          if($wood_species): ?>

            <div class="wood-species d-flex flex-wrap">
              <?php foreach($wood_species as $wood):
                $wood_image = $wood['wood_species_image']; ?>
                <img src="<?php echo esc_url($wood_image['url']); ?>" class="img-fluid" alt="<?php echo esc_attr($wood_image['alt']); ?>" />
              <?php endforeach; ?>
            </div>
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <article>
          <header class="article-header">
            <?php
              $options_section_header = get_field('custom_options_section_header');
              if($options_section_header['image']){
                echo '<img src="' . esc_url($options_section_header['image']['url']) . '" class="img-fluid d-block mb-4" alt="' . esc_attr($options_section_header['image']['alt']) . '" />';
              }

              echo '<h2>' . esc_html($options_section_header['title']) . '</h2>';

              if($options_section_header['subtitle']){
                echo '<p class="subtitle">' . esc_html($options_section_header['subtitle']) . '</p>';
              }
            ?>
          </header>

          <?php echo wp_kses_post(get_field('custom_options_section_content')); ?>
          <?php
            $custom_options_section_link = get_field('custom_options_section_link');
            if($custom_options_section_link): ?>
              <a href="<?php echo esc_url($custom_options_section_link['url']); ?>" class="btn-main"><?php echo esc_url($custom_options_section_link['title']); ?></a>
          <?php endif; ?>
        </article>
      </div>
    </div>
  </section>
</main>
<?php get_footer();