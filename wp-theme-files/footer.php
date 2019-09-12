<?php get_template_part('partials/footer', 'locations'); ?>

<?php get_template_part('partials/footer', 'testimonials'); ?>

  <footer id="footer">
    <div class="row no-gutters">
      <div class="col-md-9 footer-main">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-white.png" class="img-fluid d-block mx-auto" alt="<?php echo esc_html__('Eastwood Furniture Logo', 'eastwood'); ?>" />
        <div class="row">
          <div class="col-md-4">
            <h3><?php echo esc_html__('Quick Links', 'eastwood'); ?></h3>
            <?php
              $quick_links_menu_args = array(
                'theme_location' => 'footer-quick-links-menu',
                'menu' => '',
                'container' => '',
                'container_id' => '',
                'container_class' => '',
                'menu_id' => '',
                'menu_class' => 'list-unstyled',
                'echo' => true,
                'fallback_cb' => '',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 1
              );
              wp_nav_menu($quick_links_menu_args);
            ?>
          </div>
          <div class="col-md-4">
            <h3><?php echo esc_html__('Furniture', 'eastwood'); ?></h3>
            <?php
              $furniture_menu_args = array(
                'theme_location' => 'footer-furniture-menu', 
                'menu' => '',
                'container' => '',
                'container_id' => '',
                'container_class' => '',
                'menu_id' => '',
                'menu_class' => 'list-unstyled',
                'echo' => true,
                'fallback_cb' => '',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 1
              );
              wp_nav_menu($furniture_menu_args);
            ?>
          </div>
          <div class="col-md-4">
            <h3><?php echo esc_html__('Hours & Info', 'eastwood'); ?></h3>
            <?php
              $contact_page = get_page_by_path('contact');
              $contact_page_id = $contact_page->ID;
              $locations = get_field('locations', $contact_page_id);
              if($locations): 
                foreach($locations as $location): ?>
                  <div class="location">
                    <h4><?php echo esc_html($location['location_name']); ?></h4>
                    <?php echo esc_html('location_hours'); ?>
                    <p><?php echo esc_html('location_phone'); ?> | <?php echo esc_html('location_email'); ?></p>
                  </div>
            <?php endforeach; endif; ?>
          </div>
        </div>
        <div class="copyright">
          <p>&copy; <?php echo esc_html(bloginfo('name')); ?></p>
          <p>website created by <a href="https://childressagency.com" target="_blank">Childress Agency</a></p>
        </div>
      </div>
      <div class="col-md-3 footer-social d-flex justify-content-center align-items-center">
        <?php
          $facebook = get_field('facebook', 'option');
          $twitter = get_field('twitter', 'option');
          $instagram = get_field('instagram', 'option');
        ?>
        <div class="social">
          <h3><?php echo esc_html__('Find Us', 'eastwood'); ?></h3>
          <?php if($facebook): ?>
            <a href="<?php echo esc_url($facebook); ?>" class="facebook" title="Facebook" target="_blank"><i class="fab fa-facebook"></i><span class="sr-only">Facebook</span></a>
          <?php endif; if($twitter): ?>
            <a href="<?php echo esc_url($twitter); ?>" class="twitter" title="Twitter" target="_blank"><i class="fab fa-twitter"></i><span class="sr-only">Twitter</span></a>
          <?php endif; if($instagram): ?>
            <a href="<?php echo esc_url($instagram); ?>" class="instagram" title="Instagram" target="_blank"><i class="fab fa-instagram"></i><span class="sr-only">Instagram</span></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>