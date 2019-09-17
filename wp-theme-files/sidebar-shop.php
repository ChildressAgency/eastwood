<?php
/**
 * Sidebar for shop pages
 */

if(!is_active_sidebar('sidebar-shop')){ return; }
?>

<div id="shop-sidebar">
  <?php dynamic_sidebar('sidebar-shop'); ?>
</div>