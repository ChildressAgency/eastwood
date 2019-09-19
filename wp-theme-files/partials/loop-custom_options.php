<div class="options d-flex flex-wrap">
  <?php foreach($custom_options as $option): ?>
    <a href="<?php echo esc_url($option['image']['url']); ?>" class="option" data-lightbox="<?php echo $group; ?>" title="<?php echo esc_attr($option['name']); ?>">
      <img src="<?php echo esc_url($option['image']['url']); ?>" class="img-fluid d-block" alt="<?php echo esc_attr($option['image']['alt']); ?>" />
      <div class="option-caption">
        <span class="lightbox-opener"></span>
        <span class="option-name">
          <?php echo esc_html($option['name']); ?>
          <?php 
            if(isset($option['code'])){
              echo '<br />' . esc_html($option['code']);
            }
          ?>
        </span>
      </div>
    </a>
  <?php endforeach; ?>
</div>
