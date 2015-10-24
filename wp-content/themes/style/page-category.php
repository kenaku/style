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
								$big_icons = array(32, 28, 34, 30, 36);
							 ?>
								<div class="small-catalog">
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
												if( in_array( $category->ID , $big_icons ) ){
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
										</a>
										<h3 class="small-catalog__title"><?php echo $category->post_title ?></h3>
										<?php } ?>
										</div>
									</div>
								</div>
								<div class="category-lead container">
									<div class="row">


									<h1 class="page-title"><?php the_title(); ?></h1>
									<?php the_content(); ?>
								</section>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
