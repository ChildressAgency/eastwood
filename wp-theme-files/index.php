<?php get_header(); ?>
<main id="main">
  <div class="container">
    <?php
      if(have_posts()){
        while(have_posts()){
          the_post();

          if(is_singular()){
            echo '<article>';
              the_content();
            echo '</article>';
          }
          else{
            echo '<h2>' . esc_html(get_the_title()) . '</h2>';
            the_excerpt();
            echo '<a href="' . esc_url(get_the_permalink()) . '">' . esc_html__('Read More', 'eastwood') . '</a>';
          }
        }
      }
      else{
        echo '<p>' . esc_html__('Sorry, we could note find what you were looking for.', 'eastwood') . '</p>';
      }
      wp_pagenavi();
    ?>
  </div>
</main>
<?php get_footer();