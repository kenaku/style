<?php
/*
 Template Name: Комплектующие
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
								<section class="category-lead container category-lead--alt">
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
								<?php
									$connected_accessories_raw = get_posts( array(
										'post_type' => 'accessories',
										'posts_per_page'   => -1,
										'order'            => 'ASC',
										'orderby'          => 'menu_order',
									) );
									$accessories = get_accessories_connections($connected_accessories_raw);
									?>
									<section id="accessories" class="hardware">
										<div class="container">
											<div class="row">
												<div class="col-xs-12">
													<?php foreach ($accessories as $accessory) { ?>
														<div class="hardware__top-cat">
															<h3 class="hardware__top-cat__name">
																<a href="cat-<?php echo $accessory[cat_info][cat_id] ?>" data-parent="#accessories">
																	<?php echo $accessory[cat_info][cat_name] ?>
					        							</a>
															</h3>
															<div id="cat-<?php echo $accessory[cat_info][cat_id] ?>" class="hardware__top-cat__content row">
																<?php foreach ($accessory['items'] as $item) { ?>
																	<div class="hardware__item col-xs-2">
																		<div class="hardware__item__thumb">
																			<img src="<?php echo $item[thumb]; ?>" alt="">
																		</div>
																		<div class="hardware__item__title"><?php echo $item[name]; ?></div>
																	</div>
																<?php } ?>
															</div>
														</div>
														<?php } ?>
												</div>
											</div>
										</div>
									</section>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
