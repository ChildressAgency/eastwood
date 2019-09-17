<?php get_header(); ?>
<main id="main">
  <div class="container">
    <?php
      if(have_posts()){
        while(have_posts()){
          the_post();

          echo '<article>';
            the_content();
          echo '</article>';
        }
      }
      else{
        echo '<p>' . esc_html__('Sorry, we could not find what you were looking for.', 'eastwood') . '</p>';
      }
    ?>
  </div>
</main>
<?php get_footer();