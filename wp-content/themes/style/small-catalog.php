<section class="small-catalog">
  <div class="container">
    <div class="row">
    <?php
      $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'menu_order',
        'post_type' => 'page',
        'include' => '5,19,21,23,26,28,30,32,34,36,38,40',
        'post_status' => 'publish'
      );
      $categories = get_pages($args);
      foreach ( $categories as $category ) {
        $thumb_url = wp_make_link_relative(wp_get_attachment_url( get_post_thumbnail_id($category->ID) ));
        $thumb = ltrim($thumb_url, '/');
        if( is_big($category->ID) ){
          $icon_class = 'small-catalog__icon--big';
        } else {
          $icon_class = 'small-catalog__icon--small';
        }
    ?>
    <a class="small-catalog__item <?php if ($post === $category->ID) echo "current" ?>" href="<?php echo get_permalink( $category->ID ) ?>">
      <div class="small-catalog__inner">
        <div class="small-catalog__icon <?php echo $icon_class ?>">
          <?php include($thumb); ?>
        </div>
      </div>
      <h3 class="small-catalog__title"><?php echo $category->post_title ?></h3>
    </a>
    <?php } ?>
    </div>
  </div>
</section>