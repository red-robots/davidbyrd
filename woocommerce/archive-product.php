<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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
				<div class="row-1">
					<header class="woocommerce-products-header">

						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

							<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

						<?php endif; ?>

						<?php
							/**
							 * woocommerce_archive_description hook.
							 *
							 * @hooked woocommerce_taxonomy_archive_description - 10
							 * @hooked woocommerce_product_archive_description - 10
							 */
							do_action( 'woocommerce_archive_description' );
						?>

					</header>
				</div><!--.row-1-->
				<div class="row-2">
                    <aside class="col-1">
                        <?php $args = array(
                            'taxonomy'   => "product_cat",
                            'order'      => 'ASC',
                            'orderby'    => 'term_order',
                            'hide_empty' => 0
                        );
                        $terms_ids= array();
                        $terms      = get_terms( $args );
                        if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ):?>
                            <div class="row-1 cat-box">
                                <ul>
                                    <?php foreach($terms as $term):
                                        $terms_ids[] = $term->term_id;?>
                                        <li>
                                            <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name;?></a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div><!--.row-1-->
                        <?php endif;
                        $args = array(
                            'post_type'             => 'product',
                            'post_status'           => 'publish',
                            'posts_per_page'        => 3,            
                            'meta_key'              => 'total_sales',
                            'orderby'               => 'meta_value_num',
                            'tax_query' => array(               
                                'relation'=>'AND',
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => $terms_ids,
                                    'operator'=>'IN'
                                ),
                                array(
                                    'taxonomy'=>'product_visibility',
                                    'field'=>'slug',
                                    'terms'=>array('exclude-from-catalog','exclude-from-search'),
                                    'operator'=>'NOT IN'
                                )
                            )
                        );
                        $most_pop_query = new WP_Query($args);
                        if($most_pop_query->have_posts()):?>
                            <div class="row-2 popular-box">
                                <?php while($most_pop_query->have_posts()):$most_pop_query->the_post();?>
                                    <div class="most-pop-box">
                                        <a href="<?php echo get_the_permalink();?>">
                                            <?php woocommerce_template_loop_product_thumbnail();
                                            woocommerce_template_loop_product_title();?>
                                        </a>
                                    </div><!--.most-pop-box-->
                                <?php endwhile;?>
                            </div><!--.row-2-->
                            <?php wp_reset_postdata();
                        endif;?>
                    </aside><!--.col-1-->
                    <section class="col-2">
			

			

						<?php if ( have_posts() ) : ?>

							<?php
								/**
								 * woocommerce_before_shop_loop hook.
								 *
								 * @hooked wc_print_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								//do_action( 'woocommerce_before_shop_loop' );
							?>
							<?php
								add_filter( 'loop_shop_columns', 'return_3' );
								function return_3() {
									return 3;
								}
							?>
							<?php woocommerce_product_loop_start(); ?>

								<?php woocommerce_product_subcategories(); ?>

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
								do_action( 'woocommerce_after_shop_loop' );
							?>

						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

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
				</div><!--.row-2-->

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
