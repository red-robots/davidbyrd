<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div id="slideshow-wrapper">
		<div id="slideshow"><?php if ( function_exists( 'soliloquy_slider' ) ) {
				soliloquy_slider( '24' );
			} ?></div>
	</div>

	<div id="main">

	<div id="row2">

		<div class="row2box1">
			<div class="row2boxheader"></div>

			<?php
			$image = get_field( 'box1_image' );
			if ( ! empty( $image ) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
			<?php endif; ?>

			<div class="row2box-text"><?php the_field( "box1_text" ); ?></div>

			<div class="row2button"><a href="<?php bloginfo( 'url' ); ?>"><img
						src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg" alt="" border="0"></a>
				<div class="row2buttontext"><a
						href="<?php the_field( "box1_link" ); ?>"><?php the_field( "box_1_link_text" ); ?></a></div>
			</div>

		</div>

		<div class="row2box1">
			<div class="row2boxheader"></div>

			<?php
			$image = get_field( 'box2_image' );
			if ( ! empty( $image ) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
			<?php endif; ?>

			<div class="row2box-text"><?php the_field( "box2_text" ); ?></div>

			<div class="row2button"><a href="<?php the_field( "box_2_link" ); ?>"><img
						src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg" alt="" border="0"></a>
				<div class="row2buttontext"><a
						href="<?php the_field( "box_2_link" ); ?>"><?php the_field( "box_2_link_text" ); ?></a></div>
			</div>

		</div>

		<div class="row2box2">
			<div class="row2boxheader"></div>

			<?php
			$image = get_field( 'box3_image' );
			if ( ! empty( $image ) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
			<?php endif; ?>

			<div class="row2box-text"><?php the_field( "box3_text" ); ?></div>

			<div class="row2button"><a href="<?php the_field( "box_3_link" ); ?>"><img
						src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg" alt="" border="0"></a>
				<div class="row2buttontext"><a
						href="<?php the_field( "box_3_link" ); ?>"><?php the_field( "box_3_link_text" ); ?></a></div>
			</div>

		</div>

		<div class="row2box3">
			<div class="row2boxheader"></div>

			<?php
			$image = get_field( 'box4_image' );
			if ( ! empty( $image ) ): ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
			<?php endif; ?>

			<div class="row2box-text"><?php the_field( "box4_text" ); ?></div>

			<div class="row2button"><a href="<?php the_field( "box_4_link" ); ?>"><img
						src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg" alt="" border="0"></a>
				<div class="row2buttontext"><a
						href="<?php the_field( "box_4_link" ); ?>"><?php the_field( "box_4_link_text" ); ?></a></div>
			</div>

		</div>

	</div>


<?php endwhile; endif; ?>


<?php get_footer(); ?>