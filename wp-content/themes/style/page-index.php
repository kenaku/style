<?php
/*
 Template Name: Index
 *
*/
?>

<?php get_header(); ?>

			<div id="content" class="page-index">

				<div id="inner-content">

						<main id="main" class="" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php include('slider.php'); ?>
									<div class="container">
									<div class="index-catalog">


										<div class="row">
											<h1 class="page-title"><?php the_title(); ?></h1>
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
												?>
												<a class="col-xs-4 index-category" href="<?php echo get_permalink( $category->ID ) ?>">
													<div class="index-category__inner">
														<div class="index-category__icon"><?php include($thumb); ?></div>
														<h3 class="index-category__title"><?php echo $category->post_title ?></h3>
													</div>
												</a>
												<?php } ?>
										</div>
										<a href="#" class="big-btn center">скачать каталог</a>
										<div class="index-catalog__description">
										  <?php the_content(); ?>
										</div>

										</div>
									</div>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
