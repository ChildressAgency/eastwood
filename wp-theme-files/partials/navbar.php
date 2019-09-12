<?php
/** Main Header Navigation */

if(!defined('ABSPATH')){ exit; }
?>


<div id="navbar" class="collapse navbar-collapse">
  <ul class="navbar-nav ml-auto">

    <?php if(have_rows('menu_items', 'option')): while(have_rows('menu_items', 'option')): the_row();
      $menu_style = get_row_layout();

      switch($meu_style){
        case 'mega-menu': ?>
          <li class="nav-item dropdown mega-dropdown">
            <a href="#" class="nav-link dropdown-toggle text-nowrap" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo esc_html(get_sub_field('mega_menu_title')); ?></a>
            <div class="dropdown-menu mega-menu">
              <div class="row">
                <div class="col-sm-4">

                  <?php $mega_menu_items = get_sub_field('mega_menu_items'); ?>
                  <div id="" class="nav flex-column nav-pills mega-top-nav" role="tablist" aria-orientation="vertical">
                    <?php 
                      $t = 0; 
                      foreach($menu_items as $menu_item){

                        $menu_item_title = $menu_item['mega_menu_item_title'];
                        $menu_item_slug = sanitize_title($menu_item_title);

                        $active = ($t == 0) ? ' active' : '';
                        $aria_selected = ($t == 0) ? 'true' : 'false';

                        printf(
                          '<a href="#%s" id="tab-%s" class="nav-link%s" data-toggle="pill" role="tab" aria-controls="%s" aria-selected="%s">%s</a>',
                          esc_attr($menu_item_slug),
                          esc_attr($menu_item_slug),
                          $active,
                          esc_attr($menu_item_slug),
                          $aria_selected,
                          esc_html($menu_item_title)
                        );

                        $t++; 
                      }
                      reset($menu_items); ?>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div id="furniture-content" class="tab-content">
                    <?php $c = 0; foreach($menu_items as $menu_item): ?>
                      <?php 
                        $menu_item_title = $menu_item['mega_menu_item_title'];
                        $menu_item_slug = sanitize_title($menu_item_title);
                        $first_image = array();
                      ?>
                      <div id="<?php echo esc_attr($menu_item_slug); ?>" class="tab-pane fade<?php if($c == 0){ echo ' show active'; } ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr($menu_item_slug); ?>">
                        <div class="row">
                          <div class="col-sm-6">
                            <div id="" class="nav flex-column nav-pills mega-sub-nav" role="tablist">
                              <?php 
                                $menu_sub_items = $menu_item['mega_menu_item_links'];
                                $i = 0; 
                                foreach($menu_sub_items as $menu_sub_item){
                                  //set first image
                                  if($i == 0){
                                    $first_image = $menu_sub_item['menu_item_image'];
                                  }

                                  $sub_item = $menu_sub_item['product_category'];
                                  $sub_item_title = $sub_item->name;
                                  $sub_item_slug = $sub_item->slug;
                                  $sub_item_url = get_term_link($sub_item);
                                  $sub_item_image = $menu_sub_item['menu_item_image']; 

                                  printf(
                                    '<a href="%s" id="tab-%s-%s" class="nav-link" data-menu_img_target="menu-img-%s" data-menu_img="%s" data-menu_img_alt="%s">%s</a>',
                                    esc_url($sub_item_url),
                                    esc_attr($menu_item_slug),
                                    esc_attr($sub_item_slug),
                                    esc_attr($menu_item_slug),
                                    esc_url($sub_item_image['url']),
                                    esc_attr($sub_item_image['alt']),
                                    esc_html($sub_item_title)
                                  );

                                  $i++;  
                                }
                              ?>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div id="" class="tab-content furniture-sub-content">
                              <img src="<?php echo esc_url($first_image['url']); ?>" id="menu-img-bedroom" class="img-fluid d-block mx-auto" alt="<?php echo esc_attr($first_image['alt']); ?>" />
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php $c++; endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </li>
        <?php break;

        case 'dropdown-menu': ?>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle text-nowrap" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo esc_html(get_sub_field('menu_title')); ?></a>
            <div class="dropdown-menu">
              <?php
                if(have_rows('dropdown_menu_links')){
                  while(have_rows('dropdown_menu_links')){
                    the_row();
                    $dropdown_menu_link = get_sub_field('dropdown_menu_link');

                    printf(
                      '<a href="%s" class="dropdown-item">%s</a>',
                      esc_url($dropdown_menu_link['url']),
                      esc_html($dropdown_menu_link['title'])
                    )
                  }
                }
              ?>
            </div>
          </li>
        <?php break;

        default: ?>
          <li class="nav-item">
            <?php $menu_link = get_sub_field('menu_link'); ?>
            <a href="<?php echo esc_url($menu_link['url']); ?>" class="nav-link"><?php echo esc_html($menu_link['title']); ?></a>
          </li>

      <?php } ?>
    <?php endwhile; endif; ?>
 
    <li class="dropdown-divider d-block d-lg-none"></li>
    <?php 
      $contact_page = get_page_by_path('contact');
      $contact_page_id = $contact_page->ID;
      if(have_rows('locations', $contact_page_id)): ?>
        <li class="phone-numbers d-block d-lg-none">
          <?php while(have_rows('locations', $contact_page_id)): the_row(); ?>
            <?php 
              $location_phone = get_sub_field('location_phone'); 
            
              printf(
                '<span>%s: <a href="tel:%s">%s</a></span>',
                esc_html(get_sub_field('location_name')),
                esc_attr($location_phone),
                esc_html($location_phone)
              );
            ?>
          <?php endwhile; ?>
        </li>
    <?php endif; ?>

  </ul>
</div>
