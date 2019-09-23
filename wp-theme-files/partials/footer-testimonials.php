<?php 
  $testimonials = get_field('testimonials', 'option');
  if($testimonials): ?>
    <section id="testimonials">
      <span id="quotes"></span>
      <div id="testimonial-carousel" class="carousel slide carousel-heights" data-ride="carousel">
        <?php if(count($testimonials) > 1): ?>
          <ol class="carousel-indicators">
            <?php $i = 0; foreach($testimonials as $testimonial): ?>

              <li data-target="#testimonial-carousel" data-slide-to="<?php echo $i; ?>"<?php if($i == 0){ echo ' class="active"'; } ?>></li>

            <?php $i++; endforeach; reset($testimonials); ?>
          </ol>
        <?php endif; ?>

        <div class="carousel-inner">
          <?php $s = 0; foreach($testimonials as $testimonial): ?>

            <div class="carousel-item<?php if($s == 0){ echo ' active'; } ?>">
              <div class="testimonial">
                <?php echo wp_kses_post($testimonial['testimonial']); ?>
                <cite><?php echo esc_html($testimonial['testimonial_author']); ?></cite>
              </div>
            </div>
          
          <?php $s++; endforeach; ?>
        </div>
      </div>
    </section>
<?php endif; ?>