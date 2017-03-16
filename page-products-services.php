<?php
/**
 * Template Name: Products & Services
 */
get_header(); ?>

    <div id="main">
<?php if ( have_posts() ) :
	the_post(); ?>
    <div class="page-content">
        <h1><?php the_title(); ?></h1>
		<?php $tiles = get_field( "tiles" );
		if ( $tiles ):?>
            <div class="product-services-box-wrapper">
				<?php $count     = 0;
				foreach ( $tiles as $tile ):
					$title = $tile['title'];
					$image       = (array)$tile['image'];
					$copy        = $tile['copy'];
					$button_text = $tile['button_text'];
					$button_link = $tile['button_link'];
					if($title ||$image||$copy||($button_text&&$button_link)):?>
                        <div class="product-services-box js-blocks count-<?php echo $count % 3; ?>">
                            <div class="product-services-header">
                                <?php echo $title; ?>
                            </div><!--.audio-box-header-->
                            <div class="product-services-wrapper">
                                <div class="product-services-text-image-wrapper">
                                    <div class="product-services-image">
                                        <img src="<?php echo $image['sizes']['large'];?>" alt="<?php echo $image['alt'];?>">
                                    </div><!--.product-services-image-->
                                    <div class="product-services-text">
                                        <?php echo $copy; ?>
                                    </div><!--.product-services-text-->
                                </div><!--.audio-box-text-->
                                <div class="product-services-button-wrapper">
                                    <?php if ( $button_text && $button_link ): ?>
                                        <div class="product-services-button">
                                            <a href="<?php echo $button_link; ?>">
                                                <img src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg"
                                                     alt="" border="0">
                                                <div class="product-services-button-text">
                                                    <?php echo $button_text; ?>
                                                </div><!--.audio-box-button-text-->
                                            </a>
                                        </div><!--.audio-box-button-->
                                    <?php endif;//if for button ?>
                                </div><!--.audio-box-button-wrapper-->
                            </div><!--.audio-box-wrapper-->
                        </div><!--.audio-box-->
                    <?php endif;//if for audio box contains content ?>
					<?php $count ++;
				endforeach; //foreach for tiles?>
            </div><!--.audio-wrapper-->
			<?php wp_reset_postdata();
		endif;//if for tiles
		?>
    </div><!--.page-content-->

<?php endif; ?>


<?php get_footer(); ?>