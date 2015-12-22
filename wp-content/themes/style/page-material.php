<?php
/*
 Template Name: Материалы
 *
*/


?>

<?php get_header(); ?>

			<div id="content" class="page-index">

				<div id="inner-content">

						<main id="main" class="" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php
								include('small-catalog.php');
								$post = get_the_ID();
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
									$connected_materials_raw = get_categories( array(
										'taxonomy' => 'materials',
									) );
									$materials_ids = array();
									foreach ($connected_materials_raw as $material) {
										if($material->parent != 0) {
											$materials_ids[] = $material->cat_ID;
										}
									}
									$materials_raws = get_materials_connections($materials_ids);
								?>

								<div class="container">
								<section id="materials" class="hardware">
									<div class="row">
									<?php
									$j = 0;
									foreach ($materials_raws as $material_top_cat) {
										?>
									<div class="hardware__top-cat">
										<h3 class="hardware__top-cat__name">
											<a href="cat-<?php echo $material_top_cat[id] ?>" data-parent="#product__materials">
												<i><?php include($img_dir . 'common/accordion-arrow.svg'); ?> </i>
												<?php echo $material_top_cat[name] ?>
											</a>
										</h3>
										<div id="cat-<?php echo $material_top_cat[id] ?>" class="hardware__top-cat__content row">
										<div class="col-xs-3 hardware__tabs">
											<ul role="tablist">
												<?php
													$i = 0;
													foreach ($material_top_cat[sub_cat] as $sub_cat) { ?>
													<li role="presentation" <?php if($i == 0) { ?>class="active" <?php } ?> >
														<a
															href="#<?php echo $sub_cat[slug] ?>"
															class="hardware__tab" data-tab="<?php echo $sub_cat[id] ?> "
															data-toggle="tab"
														>
															<?php echo $sub_cat[name] ?>
														</a>
													</li>
												<?php  $i++; } ?>
											</ul>
										</div>

										<div class="col-xs-9 hardware__items">
												<?php
													$i = 0;
													foreach ($material_top_cat[sub_cat] as $sub_cat) {
													?>
													<div
														id="<?php echo $sub_cat[slug] ?>"
														class="hardware__pane row <?php if($i == 0) { ?>active<?php } ?>"
														data-pane="<?php echo $sub_cat[id] ?>"
													>
														<?php foreach ($sub_cat['items'] as $item) {
															?>
															<div class="col-xs-2 hardware__item">
																<img src="<?php echo $item[thumb] ?>" alt="" class="hardware__item__thumb">
																<div class="hardware__item__title"><?php echo $item[name] ?></div>
															</div>
														<?php } ?>
													</div>
												<?php $i++;} ?>
										</div>
									</div>
									</div>
									<?php $j++; } ?>
									</div>
								</section>
								</div>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
