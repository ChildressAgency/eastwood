<?php if(is_front_page()): ?>
  <section id="hp-hero">
    <div id="hero-carousel" class="carousel slide carousel-heights" data-ride="carousel">
      <?php
        $hero_slides = get_field('hero_slides');
        if($hero_slides):
          if(count($hero_slides) > 1): ?>
            <ol class="carousel-indicators">
              <?php $i = 0; foreach($hero_slides as $slide): ?>
                <li data-target="#hero-carousel" data-slide-to="<?php echo $i; ?>"<?php if($i == 0){ echo ' class="active"'; } ?>></li>
              <?php $i++; endforeach; reset($hero_slides); ?>
            </ol>
        <?php endif; ?>

        <div class="carousel-inner">
          <?php $s = 0; foreach($hero_slides as $slide): ?>

            <?php
              $slide_image = $slide['slide_background_image'];
              $slide_image_css = $slide['slide_background_image_css'];
            ?>
            <div class="carousel-item<?php if($s == 0){ echo ' active'; } ?>" style="background-image:url(<?php echo esc_url($slide_image['url']); ?>); <?php echo esc_attr($slide_image_css); ?>">
              <div class="container">
                <div class="hero-caption">
                  <h2><?php echo esc_html($slide['slide_caption']); ?></h2>
                  <p class="hero-subtitle"><?php echo esc_html($slide['slide_sub_caption']); ?></p>
                  <?php 
                    $slide_link = $slide['slide_link'];
                    if($slide_link): ?>
                      <a href="<?php echo esc_url($slide_link['url']); ?>" class="btn-main"><?php echo esc_html($slide_link['title']); ?></a>
                  <?php endif; ?>
                </div>
              </div>
              <div class="overlay"></div>
            </div>

          <?php $s++; endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

<?php else: ?>

  <?php
    if(is_shop() || is_product_tag()){
      $shop_page = get_page_by_path('shop');
      $shop_page_id = $shop_page->ID;

      $hero_image = get_field('hero_background_image', $shop_page_id);
      $hero_image_css = get_field('hero_background_image_css', $shop_page_id);
      $hero_caption = get_field('hero_caption', $shop_page_id);
    }
    elseif(is_product_category()){
      $cat = get_queried_object();
      $cat_id = $cat->term_id;

      $hero_image = get_field('hero_background_image', 'product_cat_' . $cat_id);
      $hero_image_css = get_field('hero_background_image_css', 'product_cat_' . $cat_id);
      $hero_caption = get_field('hero_caption', 'product_cat_' . $cat_id);

      if(!$hero_image){
        //this cat didn't have hero img set so try its parent
        if($cat->parent > 0){
          $parent_id = $cat->parent;

          $hero_image = get_field('hero_background_image', 'product_cat_' . $parent_id);
          $hero_image_css = get_field('hero_background_image_css', 'product_cat_' . $parent_id);
        }
        else{
          //no parent so get shop
          $shop_page = get_page_by_path('shop');
          $shop_page_id = $shop_page->ID;

          $hero_image = get_field('hero_background_image', $shop_page_id);
          $hero_image_css = get_field('hero_background_image_css', $shop_page_id);
        }
      }

      if(!$hero_caption){
        //this cat didn't have hero caption set to try its parent
        if($cat->parent > 0){
          $parent_id = $cat->parent;

          $hero_caption = get_field('hero_caption', 'product_cat_' . $parent_id);
        }
        else{
          //no parent so get shop hero caption
          $shop_page = get_page_by_path('shop');
          $shop_page_id = $shop_page->ID;

          $hero_caption = get_field('hero_caption', $shop_page_id);
        }
      }
    }
    elseif(is_product()){
      $cats = get_the_terms(get_the_ID(), 'product_cat');
      
      foreach($cats as $cat){
        if($cat->parent > 0){
          //get the id of one of the child cats
          $cat_id = $cat->term_id;
        }
      }

      if($cat_id){
        $hero_image = get_field('hero_background_image', 'product_cat_' . $cat_id);
        $hero_image_css = get_field('hero_background_image_css', 'product_cat_' . $cat_id);

        if(!$hero_image){
          $cat = get_term($cat_id, 'product_cat');
          $cat_parent = $cat->parent;

          $hero_image = get_field('hero_background_image', 'product_cat_' . $cat_parent);
          $hero_image_css = get_field('hero_background_image_css', 'product_cat_' . $cat_parent);

          if(!$hero_image){
            $shop_page = get_page_by_path('shop');
            $shop_page_id = $shop_page->ID;

            $hero_image = get_field('hero_background_image', $shop_page_id);
            $hero_image_css = get_field('hero_background_image_css', $shop_page_id);
          }
        }

        $hero_caption = get_field('hero_caption', 'product_cat_' . $cat_id);
        if(!$hero_caption){
          $cat = get_term($cat_id, 'product_cat');
          $cat_parent = $cat->parent;

          $hero_caption = get_field('hero_caption', 'product_cat_' . $cat_parent);
          if(!$hero_caption){
            $shop_page = get_page_by_path('shop');
            $shop_page_id = $shop_page->ID;

            $hero_caption = get_field('hero_caption', $shop_page_id);
          }
        }
      }
      else{
        $cat_id = $cats[0]->term_id;

        $hero_image = get_field('hero_background_image', 'product_cat_' . $cat_id);
        $hero_image_css = get_field('hero_background_image_css', 'product_cat_' . $cat_id);

        if(!$hero_image){
          $shop_page = get_page_by_path('shop');
          $shop_page_id = $shop_page->ID;

          $hero_image = get_field('hero_background_image', $shop_page_id);
          $hero_image_css = get_field('hero_background_image_css', $shop_page_id);
        }

        $hero_caption = get_field('hero_caption', 'product_cat_' . $cat_id);
        if(!$hero_caption){
          $shop_page = get_page_by_path('shop');
          $shop_page_id = $shop_page->ID;

          $hero_caption = get_field('hero_caption', $shop_page_id);
        }
      }
    }
    else{
      //not a shop, product cat archive or product page, just a normal page
      $hero_image = get_field('hero_background_image');
      $hero_image_css = get_field('hero_background_image_css');
      $hero_caption = get_field('hero_caption');
    }

    if(!$hero_image){
      //none of the stuff above got us a hero image so fallback to default setting
      $hero_image = get_field('default_hero_background_image', 'option');
      $hero_image_css = get_field('default_hero_background_image_css', 'option');
    }
  ?>
  <section id="hero" style="background-image: url(<?php echo esc_url($hero_image['url']); ?>); <?php echo esc_attr($hero_image_css); ?>">
    <div class="container">
      <?php if($hero_caption): ?>
        <div class="hero-caption">
          <h1><?php echo esc_html($hero_caption); ?></h1>
        </div>
      <?php endif; ?>
    </div>
    <div class="overlay"></div>
  </section>

<?php endif; ?>