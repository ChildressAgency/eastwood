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

      printf('<h2>%s</h2>', esc_html($header['article_header']['title']));

      if($header['article_header']['subtitle']){
        printf('<p class="subtitle">%s</p>', esc_html($header['article_header']['subtitle']));
      }
    }
  ?>
</header>