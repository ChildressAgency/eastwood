<?php get_header(); ?>
<main id="main">
  <div class="container">
    <article class="entry-content text-center">
      <?php
        $search_query = get_search_query();
        if($search_query && $search_query !== ''): ?>
          <h2><?php printf(esc_html__('Showing results for "%s".', 'eastwood'), $search_query); ?></h2>
      <?php endif; ?>
    </article>
    <section class="search-form">
          <?php get_search_form(); ?>
    </section>
    <div class="search-results">
      <?php
        if(have_posts()){
          while(have_posts()){
            the_post();

            echo '<div class="search-item"><h2>' . esc_html(get_the_title()) . '</h2>';
            the_excerpt();
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html__('Read More', 'eastwood') . '</a></div>';
          }
        }
        else{
          echo '<p>' . esc_html__('Sorry, we could note find what you were looking for.', 'eastwood') . '</p>';
        }
        wp_pagenavi();
      ?>
    </div>
  </div>
</main>
<?php get_footer();