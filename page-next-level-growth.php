<?php
/**
 * Template Name: Next Level Growth
 */
get_header(); ?>

	<div id="main">


	<div class="page-content">


		<!-- --- -->

		<div id="news-box">
			<div class="row2boxheader"></div>
			<div id="news-box-content">

				<!-- -->
				<div class="attorney-page-pic">
					<?php
					$wp_query = new WP_Query();
					$wp_query->query( array(
						'post_type'      => 'testimonials',
						'posts_per_page' => '1',
						'order'          => 'ASC',
						'orderby'        => 'rand'
					) );
					if ( $wp_query->have_posts() ) : ?>
						<?php while ( $wp_query->have_posts() ) : ?>

							<?php $wp_query->the_post(); ?>

							<?php the_content(); ?>


						<?php endwhile; endif;
					wp_reset_postdata();  // close loop and reset the query ?>

				</div><!-- attorney page pic -->

				<!-- -->

			</div>
		</div>

		<!-- --- -->


		<?php $recent = new WP_Query( "page_id=8" );
		while ( $recent->have_posts() ) : $recent->the_post(); ?>

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>
		<?php endwhile;
		wp_reset_postdata(); // end of the loop. ?>


	</div><!-- / page content -->


<?php //get_sidebar(); ?>
<?php get_footer(); ?>