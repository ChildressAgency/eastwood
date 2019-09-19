<div class="row">
  <div class="col-md-5">
    <article>
      <header class="article-header">
        <?php 
          $header = get_field('article_header');
          if($header){
            if($header['article_header']['image']){
              printf(
                '<img src="%s" class="img-fluid d-block mb-4" alt="%s" />',
                esc_url($header['article_header']['image']['url']),
                esc_attr($header['article_header']['image']['alt'])
              );
            }

            echo '<h2>' . esc_html($header['article_header']['title']) . '</h2>';
            
            if($header['article_header']['subtitle']){
              echo '<p class="subtitle">' . esc_html($header['article_header']['subtitle']) . '</p>';
            }
          }
        ?>
      </header>

      <?php echo wp_kses_post(get_field('article_content')); ?>

      <?php 
        $link = get_field('article_link');
        if($link){
          echo '<a href="' . esc_url($link['url']) . '" class="btn-main">' . esc_html($link['title']) . '</a>';
        }
      ?>
    </article>
  </div>
  <div class="col-md-7">
    <?php 
      $image = get_field('article_image');
      if($image): ?>
        <div class="img-stylized-background">
          <img src="<?php echo esc_url($image['url']); ?>" class="img-fluid d-block mx-auto" alt="<?php echo esc_attr($image['alt']); ?>" />
          <div class="border-square"></div>
          <div class="filled-square"></div>
        </div>
    <?php endif; ?>
  </div>
</div>
