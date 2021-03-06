<?php
/*
 Template Name: Category
 *
*/


?>

<?php get_header(); ?>

			<div id="content" class="page-index">

				<div id="inner-content">

						<main id="main" class="" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php
								$post = get_the_ID();

								include('small-catalog.php');
							 ?>

								<section class="category-lead container">
									<div class="row">
										<div class="col-xs-3 category-lead__icon">
											<?php
												$current_thumb = ltrim(wp_make_link_relative(wp_get_attachment_url( get_post_thumbnail_id($post) )), '/');
												include($current_thumb);
											?>
										</div>
										<div class="col-xs-9">
											<h1 class="category-lead__title page-title"><?php the_title(); ?></h1>
											<div class="category-lead__content">
												<?php the_content(); ?>
											</div>
										</div>
									</div>
								</section>
								<section class="products container">
									<div class="row">
										<?php
										$cat = get_categories( array('type' => 'catalog') );
										$current_cat = get_query_var('name');
										$items = get_posts(
									    array(
								        'posts_per_page' => -1,
								        'post_type' => 'catalog',
												'tax_query' => array(array(
									        'taxonomy' => 'catalog',
									        'field' => 'slug',
									        'terms' => array($current_cat)
										    ))
									    )
										);
										foreach ($items as $item) {
										$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'medium' );
										 ?>

											<a
												class="<?php if(is_big($post)){?> col-xs-3 products__product--big <?php } else {?> col-xs-3 <?php  } ?> products__product"
												href="/catalog/<?php echo $current_cat; ?>/<?php echo $item->post_name ?>">
												<div class="products__thumb-wrap">
													<img src="<?php echo $thumb[0] ?>" alt="" class="products__thumb">
												</div>
												<div class="products__title"><?php echo $item->post_title ?></div>
											</a>
									<?php } ?>
									</div>
								</section>
							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
