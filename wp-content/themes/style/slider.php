<div class="index-slider">
 	<div class="container">
		<div class="row index-slider__inner">
			<div id="index-slider-content"class="col-xs-12 index-slider__content">
      <?php
        $items = get_posts(array(
          'posts_per_page' => -1,
          'post_type' => 'slider',
          'orderby' => 'menu_order',
          'order' => 'ASC',
        )
        );
        foreach ($items as $item) {
        $thumb = wp_get_attachment_url( get_post_thumbnail_id($item->ID), '/' );
        $url = get_post_meta( $item->ID, '_slider_url', true );
         ?>
          <a href="<?php echo $url; ?>">
            <div class="index-slider__slide"><img src="<?php echo $thumb ?>"></div>
          </a>
      <?php } ?>
      </div>
      <div class="index-slider__prev-btn">
        <svg width="48" height="115" viewBox="0 0 48 115">
            <path d="M1 1l46 57.29L4.872 114" stroke="#FA7800" stroke-width="1.5" fill="none" fill-rule="evenodd"/>
        </svg>
      </div>
      <div class="index-slider__next-btn">
        <svg width="48" height="115" viewBox="0 0 48 115">
            <path d="M1 1l46 57.29L4.872 114" stroke="#FA7800" stroke-width="1.5" fill="none" fill-rule="evenodd"/>
        </svg>
      </div>
		</div>
 	</div>
</div>
