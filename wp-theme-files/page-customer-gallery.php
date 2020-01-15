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
    <div id="customer-gallery" class="d-flex flex-wrap justify-content-center">
      <?php
        $gallery = get_field('customer_gallery');
        if($gallery){
          foreach($gallery as $image){
            echo '<a href="' . esc_url($image['url']) . '" class="gallery-img" data-lightbox="customer-gallery" title="' . esc_attr($image['title']) . '" data-title="' . esc_attr($image['caption']) . '" style="background-image:url(' . esc_url($image['url']) . ');">';
              //echo '<img src="' . esc_url($image['url']) . '" class="img-fluid d-block" alt="' . esc_attr($image['alt']) . '" />';
              echo '<span class="gallery-img-name">' . esc_html($image['title']) . '</span>';
            echo '</a>';
          }
        }
      ?>
    </div>
  </div>
</main>
<?php get_footer();