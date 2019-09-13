<header class="article-header">
  <?php
    $header = get_field('article_header');
    if($header){
      if($header['image']){
        printf(
          '<img src="%s" class="img-fluid d-block mb-4" alt="%s" />',
          esc_url($header['image']['url']),
          esc_attr($header['image']['alt'])
        );
      }

      printf('<h1>%s</h1>', esc_html($header['title']));

      if($header['article_header_subtitle']){
        printf('<p class="subtitle">%s</p>', esc_html($header['subtitle']));
      }
    }
  ?>
</header>