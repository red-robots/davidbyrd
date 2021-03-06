<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $search_link_id, $cat;
$search_link_id = 1308;
$cat='nerium';
get_header( 'shop' ); ?>
	<div id="main">
		<div class="product-content">
				<?php
					/**
					 * woocommerce_before_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 * @hooked WC_Structured_Data::generate_website_data() - 30
					 */
					//do_action( 'woocommerce_before_main_content' );
				?>
				<?php get_template_part("content-aside-cart-woocommerce");?>
				<div class="row-3">
                    <?php get_template_part("content-aside-cat");?>
                    <section class="col-2">
						<?php get_template_part("content-aside-woo-banner");?>
			

			

						<?php if ( have_posts() ) : ?>

							<?php
								/**
								 * woocommerce_before_shop_loop hook.
								 *
								 * @hooked wc_print_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
							<?php
								add_filter( 'loop_shop_columns', 'return_3' );
								function return_3() {
									return 3;
								}
							?>
							<?php woocommerce_product_loop_start(); ?>

								<?php while ( have_posts() ) : the_post(); ?>

									<?php
										/**
										 * woocommerce_shop_loop hook.
										 *
										 * @hooked WC_Structured_Data::generate_product_data() - 10
										 */
										do_action( 'woocommerce_shop_loop' );
									?>

									<?php wc_get_template_part( 'content', 'product' ); ?>

								<?php endwhile; // end of the loop. ?>

							<?php woocommerce_product_loop_end(); ?>

							<?php
								remove_filter( 'loop_shop_columns', 'return_3' );
								/**
								 * woocommerce_after_shop_loop hook.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								//do_action( 'woocommerce_after_shop_loop' );
								pagi_posts_nav();
							?>

						<?php else: ?>

							<?php
								/**
								 * woocommerce_no_products_found hook.
								 *
								 * @hooked wc_no_products_found - 10
								 */
								do_action( 'woocommerce_no_products_found' );
							?>

						<?php endif; ?>
					</section><!--.col-2-->
				</div><!--.row-3-->

			<?php
				/**
				 * woocommerce_after_main_content hook.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				//do_action( 'woocommerce_after_main_content' );
			?>

			<?php
				/**
				 * woocommerce_sidebar hook.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				//do_action( 'woocommerce_sidebar' );
			?>

		</div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer( 'shop' ); ?>

