<?php 
/*
 * Template Name: Woocommerce Default
 */?>
<?php get_header(); ?>

    <div id="main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="page-content">
                <?php get_template_part("content-aside-cart");?>		
                <?php the_content(); ?>
            </div><!-- / page content -->
        <?php endwhile; endif; ?>
<?php get_footer(); ?>