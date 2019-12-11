<?php get_header(); ?>
<main id="main">
  <section id="hp-main-section" class="my-5">
    <div class="container">
      <?php
        if(have_posts()){
          while(have_posts()){
            the_post();

            the_content();
          }
        }
      ?>
    </div>
  </section>

  <section id="wood-species">
    <div class="container">
      <div class="options-section">
        <h2><?php echo esc_html__('Wood Species', 'eastwood'); ?></h2>
        <p><?php the_field('wood_species_section_intro'); ?></p>
        <?php
          $wood_species_section_note = get_field('wood_species_section_note');
          if($wood_species_section_note): ?>
            <p class="light-note"><?php echo esc_html($wood_species_section_note); ?></p>
        <?php endif; ?>

        <?php
          $custom_options = get_field('wood_species');
          $group = 'wood-species';
          if($custom_options){
            include(locate_template('partials/loop-custom_options.php', false, false));
          }
        ?>
      </div>
    </div>
  </section>

  <section id="stains-finishes">
    <div class="container">
      <div class="options-section">
        <h2><?php echo esc_html__('Stains & Finishes', 'eastwood'); ?></h2>
        <p><?php the_field('stains_finishes_section_intro'); ?></p>
        <?php 
          $stains_finishes_section_note = get_field('stains_finishes_section_note');
          if($stains_finishes_section_note): ?>
            <p class="light-note"><?php echo esc_html($stains_finishes_section_note); ?></p>
        <?php endif; ?>

        <?php 
          $custom_options = get_field('stains_finishes');
          $group = 'stains-finishes';
          if($custom_options){
            include(locate_template('partials/loop-custom_options.php', false, false));
          }
        ?>
      </div>
    </div>
  </section>

<?php
  $custom_options = get_field('hardware_options');
  $group = 'hardware';
  if(!empty($custom_options)): ?>
    <section id="hardware-options">
      <div class="container">
        <div class="options-section">
          <h2><?php echo esc_html__('Hardware Options', 'eastwood'); ?></h2>
          <p><?php the_field('hardware_options_section_intro'); ?></p>
          <?php
            $hardware_section_note = get_field('hardware_options_section_note');
            if($hardware_section_note): ?>
              <p class="light-note"><?php echo esc_html($hardware_section_note); ?></p>
          <?php endif; ?>

          <?php 
            include(locate_template('partials/loop-custom_options.php'));
          ?>
        </div>
      </div>
    </section>
<?php endif; ?>

  <section id="have-questions">
    <div class="container">
      <article>
        <header class="article-header">
          <?php
            $header = get_field('have_questions_header');
            if($header){
              if($header['article_header']['image']){
                printf(
                  '<img src="%s" class="img-fluid d-block mb-4" alt="%s" />',
                  esc_url($header['article_header']['image']['url']),
                  eac_attr($header['article_header']['image']['alt'])
                );
              }
            }

            echo '<h2>' . esc_html($header['article_header']['title']) . '</h2>';

            if($header['article_header']['subtitle']){
              echo '<p class="subtitle">' . esc_html($header['article_header']['subtitle']) . '</p>';
            }
          ?>
        </header>
        <?php the_field('have_questions_content'); ?>

        <?php 
          $have_questions_link = get_field('have_questions_link');
          if($have_questions_link){
            echo '<a href="' . esc_url($have_questions_link['url']) . '" class="btn-main">' . esc_html($have_questions_link['title']) . '</a>';
          }
        ?>
      </article>
    </div>
  </section>

</main>
<?php get_footer();