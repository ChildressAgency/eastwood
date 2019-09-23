<?php get_header(); ?>
<main id="main">
  <div class="container">
    <?php
      if(have_posts()){
        while(have_posts()){
          the_post();

          echo '<article class="entry-content">';
            the_content();
          echo '</article>';
        }
      }
    ?>
  </div>
    <section id="hp-explore">
      <div class="row no-gutters">
        <div class="col-md-6 text-side d-flex flex-column align-items-end">
          <article>
            <header class="article-header">
              <?php
                $our_focus_header = get_field('our_focus_section_header');
                if(isset($our_focus_header['article_header']['image'])){
                  echo '<img src="' . esc_url($our_focus_header['article_header']['image']['url']) . '" class="img-fluid d-block mb-4" alt="' . esc_attr($our_focus_header['article_header']['image']['alt']) . '" />';
                }

                if(isset($our_focus_header['article_header']['title'])){
                  echo '<h2>' . esc_html($our_focus_header['article_header']['title']) . '</h2>';
                }

                if(isset($our_focus_header['article_header']['subtitle'])){
                  echo '<p class="subtitle">' . esc_html($our_focus_header['article_header']['subtitle']) . '</p>';
                }
              ?>
            </header>

            <?php echo wp_kses_post(get_field('our_focus_section_content')); ?>
          </article>

          <?php
            $focus_areas = get_field('focus_areas');
            $first_image = '';

            if($focus_areas): ?>
              <div class="cat-list-container">
                <div id="cat-list">
                  <ul class="nav nav-pills" style="column-count:1; text-align:right;">
                    <?php $c = 0; foreach($focus_areas as $focus_area):
                      $focus_area_name = $focus_area['focus_area_name'];
                      $focus_area_slug = sanitize_title($focus_area['focus_area_name']);
                      $focus_area_image = $focus_area['focus_area_image'];

                      $active = ($c == 0) ? ' active' : '';
                      $aria_selected = ($c == 0) ? 'true' : 'false';

                      if($c == 0){ $first_image = $focus_area_image['url']; }
                    ?>
                      <li class="nav-item">
                        <?php
                          printf(
                            '<a href="#focus-%s" id="tab-focus-%s" class="nav-link%s" data-toggle="pill" role="tab" aria-controls="focus-%s" aria-selected="%s" data-bg_image="%s">%s</a>',
                            esc_attr($focus_area_slug),
                            esc_attr($focus_area_slug),
                            $active,
                            esc_attr($focus_area_slug),
                            $aria_selected,
                            esc_url($focus_area_image['url']),
                            esc_html($focus_area_name)
                          );
                        ?>
                      </li>
                    <?php $c++; endforeach; reset($focus_areas); ?>
                  </ul>
                </div>
              </div>
          <?php endif; ?>
        </div>
        <div class="col-md-6 image-side" style="background-image:url(<?php echo esc_url($first_image); ?>);">
          <?php if($focus_areas): ?>
            <div id="cat-links-container">
              <div id="cat-links" class="tab-content">
                <?php $sc = 0; foreach($focus_areas as $focus_area):
                  $focus_area_name = $focus_area['focus_area_name'];
                  $focus_area_slug = sanitize_title($focus_area_name);
                  $focus_area_description = $focus_area['focus_area_description'];
                  $focus_area_link = $focus_area['focus_area_link'];
                ?>
                  <div id="focus-<?php echo esc_attr($focus_area_slug); ?>" class="tab-pane fade<?php if($sc == 0){ echo ' show active'; } ?>" role="tabpanel" aria-labelledby="tab-focus-<?php echo esc_attr($focus_area_slug); ?>">
                    <div class="cat-tab-pane-inner">
                      <div class="cat-description">
                        <?php echo wp_kses_post($focus_area_description); ?>
                      </div>
                      <div class="cat-shop-now">
                        <a href="<?php echo esc_url($focus_area_link['url']); ?>"><?php echo esc_html($focus_area_link['title']); ?></a>
                      </div>
                    </div>
                  </div>
                <?php $sc++; endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <section>

  <section id="dont-settle">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <article>
            <header class="article-header">
              <h2><?php the_field('dont_settle_section_title'); ?></h2>
              <p class="subtitle"><?php the_field('dont_settle_section_subtitle'); ?></p>
            </header>
            <?php the_field('dont_settle_section_content'); ?>
            <?php $dont_settle_link = get_field('dont_settle_section_link'); ?>
            <a href="<?php echo esc_url($dont_settle_link['url']); ?>" class="btn-main"><?php echo esc_html($dont_settle_link['title']); ?></a>
          </article>
        </div>
        <div class="col-md-6">
          <?php $dont_settle_section_image = get_field('dont_settle_section_image'); ?>
          <img src="<?php echo esc_url($dont_settle_section_image['url']); ?>" class="img-fluid d-block mx-auto" alt="<?php echo esc_attr($dont_settle_section_image['alt']); ?>" />
        </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer();