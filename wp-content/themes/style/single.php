<?php get_header(); ?>

			<div id="content" class="container">

					<main id="main" class="row" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php $mods = get_post_meta( get_the_ID(), '_style_group_demo'); ?>
							<?php include('small-catalog.php'); ?>
								<div class="container product">
									<div class="product__nav">
										<?php
											$next_link = '
												<div class="product__nav__next">
													<span>Следущая<br>модель</span>
													<i>
														<svg width="14" height="32" viewBox="0 0 14 32">
															<path d="M1.147 1.37L13 16.322 2.145 30.863"/>
														</svg>
													</i>
												</div>
											';

											$prev_link = '
												<div class="product__nav__prev">
													<i>
														<svg width="14" height="32" viewBox="0 0 14 32">
															<path d="M1.147 1.37L13 16.322 2.145 30.863"/>
														</svg>
													</i>
													<span>Предыдущая<br>модель</span>
												</div>
											';
										$cat = get_categories( array('type' => 'catalog') );
										$post_id = get_the_ID();
										$current_cat = get_the_terms( $post_id, 'catalog' );
										$items = get_posts(
									    array(
								        'posts_per_page' => -1,
								        'post_type' => 'catalog',
												'tax_query' => array(array(
									        'taxonomy' => 'catalog',
									        'field' => 'slug',
									        'terms' => array($current_cat[0]->slug)
										    ))
									    )
										);
										$last_item = end($items);
										$first_item = array_values($items)[0];
										if(($post_id === $first_item->ID)) { ?>
											  <a href="/catalog/<?php echo $current_cat[0]->slug?>/<?php echo $last_item->post_name ?>">
													<div class="product__nav__prev">
													<i>
														<svg width="14" height="32" viewBox="0 0 14 32">
															<path d="M1.147 1.37L13 16.322 2.145 30.863"/>
														</svg>
													</i>
													<span>Предыдущая<br>модель</span>
												</div>
											 </a>
										<?php
										} else {
											next_post_link('%link', $prev_link);
										}
										if ($post_id === $last_item->ID){ ?>
											 <a href="/catalog/<?php echo $current_cat[0]->slug?>/<?php echo $first_item->post_name ?>">
													<div class="product__nav__next">
													<span>Следущая<br>модель</span>
													<i>
														<svg width="14" height="32" viewBox="0 0 14 32">
															<path d="M1.147 1.37L13 16.322 2.145 30.863"/>
														</svg>
													</i>
												</div>
											 </a>
											<?php
										} else {
											previous_post_link('%link', $next_link);
										}

										?>
									</div>
									<h2 class="product__title"><?php the_title(); ?></h2>

								 	<section class="product__lead">
									 	<div class="row">
										<?php if($mods[0] > 0) { ?>
											<div class="product-slider col-xs-12">
												<div class="product-slider__inner">
													<div id="product-slider-content" class="product-slider__content">
									        <?php foreach ($mods[0] as $mod) {
									        	$thumb = wp_get_attachment_image_src( $mod[image_id], 'large');
									        	?>
									        	<div class="product-slider__slide row">
									        		<div class="col-xs product__image"><img class="fancybox" src="<?php echo $thumb[0] ?>" alt=""></div>
									        		<div class="col-xs-5 product__mod-info">
								        				<h3 class="product__mod-info__title">В данной комплектации:</h3>
								        				<?php
									        				$parsed_descr = str_replace("\n","<br>",trim($mod[description],"\n"));
									        				echo $parsed_descr;
									        		  ?>
									        		</div>
								        		</div>
													<?php } ?>
						        			</div>
										      <button id="prev-btn" class="product-slider__prev-btn hidden">
										        <svg width="48" height="115" viewBox="0 0 48 115">
										            <path d="M1 1l46 57.29L4.872 114" stroke="#FA7800" stroke-width="1.5" fill="none" fill-rule="evenodd"/>
										        </svg>
										      </button>
										      <button id="next-btn" class="product-slider__next-btn hidden">
										        <svg width="48" height="115" viewBox="0 0 48 115">
										            <path d="M1 1l46 57.29L4.872 114" stroke="#FA7800" stroke-width="1.5" fill="none" fill-rule="evenodd"/>
										        </svg>
										      </button>
						        		</div>
											</div>
										<?php } else { ?>
					        			<div class="col-xs product__image">
					        				<img class="fancybox" src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) ?>" alt="">
					        			</div>
										<?php } ?>
										</div>
							 		</section>
								</div>
								<section class="product__info-tabs">
								<?php
									$connected_accessories_raw = get_posts( array(
									  'connected_type' => 'posts_to_pages',
									  'connected_items' => get_queried_object(),
									  'nopaging' => true,
									  'suppress_filters' => false
									) );
									$accessories = get_accessories_connections($connected_accessories_raw);
									$materials_raws = get_post_meta( get_the_ID(), '_style_demo_materials');
									$materials_raws = get_materials_connections($materials_raws[0]);
									$info_tabs = array();
									if($post->post_content != "") { $info_tabs[] = array('product__description','Описание');}
									if(count($accessories) > 0) { $info_tabs[] =  array('product__accessories','Комплектующие');}
									if(count($materials_raws) > 0) { $info_tabs[] =  array('product__materials','Отделочные материалы');}
								?>
								<ul role="tablist" class="row">
								<?php
									$i = 0;
									foreach($info_tabs as $info_tab) {
								?>
									<li
										class="
											product__info-tab
											col-xs <?php if($i == 0) { ?>active <?php } ?>
											<?php if(count($info_tabs) == 1) { ?>single<?php } ?>
											" role="presentation" >
									<a
										href="#<?php echo $info_tab[0] ?>"
										data-tab="<?php echo $info_tab[0] ?>"
										data-toggle="tab">
										<?php echo $info_tab[1] ?>
									</a>
								<?php $i++; } ?>
								</ul>
								</section>
								<?php if($post->post_content != "") { ?>
								<section
									id="product__description"
									class="product__description <?php if($info_tabs[0][0] == 'product__description') { ?>active<?php } ?> "
									data-pane="product__description"
								>
									<div class="product__description__content">
										<?php the_content(); ?>
									</div>
								</section>
								<?php } ?>
								<?php
									if(count($accessories) > 0) {
									// print "<pre>"; print_r($accessories); print "</pre>";
									?>
									<section
										id="product__accessories"
										class="hardware <?php if($info_tabs[0][0] == 'product__accessories') { ?>active<?php } ?>"
										data-pane="product__accessories"
									>
										<?php
											$i = 0;
											foreach ($accessories as $accessory) {
											 ?>
											<div class="hardware__top-cat">
												<h3 class="hardware__top-cat__name">
													<a href="cat-<?php echo $accessory[cat_info][cat_id] ?>" data-parent="#product__accessories">
														<i><?php include($img_dir . 'common/accordion-arrow.svg'); ?> </i>
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
											<?php
													$i++;
												}
											?>
									</section>
								<?php } ?>
								<?php
									if(count($materials_raws) > 0) {
  						  ?>
								<section
										id="product__materials"
										class="hardware <?php if($info_tabs[0][0] == 'product__materials') { ?>active<?php } ?>"
										data-pane="product__materials"
								>
									<div class="product__materials__alert">
										Цвет материалов и дерева зависит от настроек Вашего монитора и может отличаться от оригинала.<br/>
										При необходимости более точного подбора цвета - рекомендуем Вам ознакомиться с оригиналами образцов.
									</div>
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
																<img data-image="<?php echo $item[thumb] ?>" alt="" class="hardware__item__thumb">
																<div class="hardware__item__title"><?php echo $item[name] ?></div>
															</div>
														<?php } ?>
													</div>
												<?php $i++;} ?>
										</div>
									</div>
									</div>
									<?php $j++; } ?>
								</section>
								<?php } ?>
						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</main>



			</div>

<?php get_footer(); ?>
