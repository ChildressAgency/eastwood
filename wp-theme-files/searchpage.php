<?php
/**
 * Template Name: Search Page
 */
?>

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
    <section class="search-form">
      <?php get_search_form(); ?>
    </section>
  </div>
</main>
<?php get_footer();