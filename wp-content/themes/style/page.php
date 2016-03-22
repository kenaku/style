<?php get_header(); ?>

			<div id="content" class="default-page container">

				<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<h1 class="page-title"><?php the_title(); ?></h1>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
				</main>

			</div>

<?php get_footer(); ?>