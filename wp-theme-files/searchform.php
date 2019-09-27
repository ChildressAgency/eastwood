<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-form">
  <div class="form-group">
    <input type="hidden" name="post_type" value="product" />
    <label for="search" class="sr-only">Search</label>
    <input type="text" id="search" name="s" class="form-control" placeholder="<?php echo esc_html__('Search', 'eastwood'); ?>" aria-label="<?php echo esc_html__('Search', 'eastwood'); ?>" />
  </div>
  <div class="form-group">
    <input type="submit" class="btn-main" class="Submit" />
  </div>
</form>
