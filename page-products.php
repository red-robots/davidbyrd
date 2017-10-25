<?php /*
*   Template Name: Products & Services
*/
get_header(); ?>
    <div id="main">
        <div class="product-content">
            <?php if(have_posts()):the_post();?>
                <div class="row-1">
                    <h1><?php the_title(); ?></h1>
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
                        <?php $bella_args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 12,
                            'paged'=>$paged,
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
                        $bella_query = new WP_Query( $bella_args ); ?>
                        <?php if ( $bella_query->have_posts() ) : ?>
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

                            <?php woocommerce_product_subcategories(); ?>

                            <?php while ( $bella_query->have_posts() ) : $bella_query->the_post(); ?>
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

                            <?php pagi_posts_nav($bella_query);
                            wp_reset_postdata();?>

                        <?php elseif ( ! woocommerce_product_subcategories( array('before' => woocommerce_product_loop_start( false ), 'after'  => woocommerce_product_loop_end( false )))) : ?>
                            <?php 
                            /**
                             * woocommerce_no_products_found hook.
                             *
                             * @hooked wc_no_products_found - 10
                             */
                            do_action( 'woocommerce_no_products_found' ); ?>
                        <?php endif; ?>
                    </section><!--.col-2-->
                </div><!--.row-2-->
            <?php endif;?>
        </div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer(); ?>