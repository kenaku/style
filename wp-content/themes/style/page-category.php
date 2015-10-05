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

								<?php include('slider.php'); ?>
									<div class="container">
										<div class="row">
											<div class="col-xs-4"></div>
										</div>
									</div>
									<h1 class="page-title"><?php the_title(); ?></h1>
									<?php the_content(); ?>
								</section>

							<?php endwhile; endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
