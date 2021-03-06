<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $cat;
global $search_link_id;
get_header( 'shop' ); ?>
	<div id="main">
		<div class="single-product-content">
			<?php if ( have_posts() ) : the_post(); 
				if(has_term('','nerium')):
					$cat = 'nerium';
					$search_link_id = 1308;
				else:
					$cat='product_cat';
					$search_link_id = 10;
				endif;?>
				<?php get_template_part("content-aside-cart");?>
				<div class="row-3">                
					<?php get_template_part("content-aside-cat");?>
					<section class="col-2">
						<?php get_template_part("content-aside-woo-banner");?>
						<?php
							/**
							 * woocommerce_before_main_content hook.
							 *
							 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
							 * @hooked woocommerce_breadcrumb - 20
							 */
							do_action( 'woocommerce_before_main_content' );
						?>

							

								<?php wc_get_template_part( 'content', 'single-product' ); ?>

							

						<?php
							/**
							 * woocommerce_after_main_content hook.
							 *
							 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
							 */
							do_action( 'woocommerce_after_main_content' );
						?>

						<?php
							/**
							 * woocommerce_sidebar hook.
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							//do_action( 'woocommerce_sidebar' );
						?>
					</section><!--.col-2-->
				</div><!--.row-3-->
			<?php endif; // end of the loop. ?>
        </div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
