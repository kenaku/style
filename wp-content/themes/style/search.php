<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="container">

					<main id="main" role="main" class="row">
          <?php include('small-catalog.php'); ?>
						<h1 class="archive-title page-title col-xs-12"><span><?php _e( 'Результаты поиска:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

            <?php
              if (have_posts()) : while (have_posts()) : the_post();
              $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
              // $current_cat = get_query_var('name');
              // $cat = get_categories( array('type' => 'catalog') );
            ?>
              <a
                class="<?php if(is_big($post)){?> col-xs-3 products__product--big <?php } else {?> col-xs-3 <?php  } ?> products__product"
                href="/catalog/<?php echo $post->post_name ?>">
                <img src="<?php echo $thumb[0] ?>" alt="" class="products__thumb">
                <div class="products__title"><?php the_title(); ?></div>
              </a>
						<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the search.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>

					</div>

			</div>

<?php get_footer(); ?>
