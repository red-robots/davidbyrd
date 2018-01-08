<?php global $terms_ids;
global $search_link_id;
global $cat;
if(have_posts()):the_post();
    $search_link_id = get_the_ID();?>
    <?php get_template_part("content-aside-cart");?>
    <div class="row-3">                
        <?php get_template_part("content-aside-cat");?>
        <section class="col-2">
            <?php get_template_part("content-aside-woo-banner");?>
            <?php $bella_args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'posts_per_page' => 12,
                'tax_query' => array(
                    'relation'=>'AND',       
                    array(
                        'taxonomy'=>'product_visibility',
                        'field'=>'slug',
                        'terms'=>array('exclude-from-catalog','exclude-from-search'),
                        'operator'=>'NOT IN'
                    ),
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    ),
                    array(
                        'taxonomy' => $cat,
                        'field' => 'term_id',
                        'terms' => $terms_ids,
                        'operator'=>'IN'
                    ),
                )
            );
            if(isset($_POST['search'])):
                $prepare_args = array();
                $prepare_string = "SELECT ID, post_title FROM $wpdb->posts WHERE post_title LIKE '%%%s%%' AND post_type=%s";
                array_unshift($prepare_args,'product');
                array_unshift($prepare_args,$_POST['search']);
                array_unshift($prepare_args,$prepare_string);
                $results = $wpdb->get_results(  call_user_func_array(array($wpdb, "prepare"),$prepare_args));
                $in = array(-1);
                if($results):     
                    foreach($results as $result):
                        $in[] = $result->ID;
                    endforeach;
                endif;
                $bella_args['post__in'] = $in;
            endif;
            if(isset($_GET['orderby'])):
                switch($_GET['orderby']):
                    case 'price':
                        $bella_args['orderby'] = 'meta_value_num';
                        $bella_args['order'] = 'ASC';
                        $bella_args['meta_key'] = '_price';
                        break;
                    case 'price-desc':
                        $bella_args['orderby'] = 'meta_value_num';
                        $bella_args['order'] = 'DESC';
                        $bella_args['meta_key'] = '_price';
                        break;
                    case 'date':
                        $bella_args['orderby'] = 'date';
                        $bella_args['order'] = 'ASC';
                        break;
                    case 'popularity':
                        $bella_args['orderby'] = 'meta_value_num';
                        $bella_args['order'] = 'ASC';
                        $bella_args['meta_key']='total_sales';
                        break;
                    case 'rating':
                        $bella_args['orderby'] = 'meta_value_num';
                        $bella_args['order']='ASC';
                        $bella_args['meta_key']='_wc_average_rating';
                        break;
                endswitch;
            endif;
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
    </div><!--.row-3-->
<?php endif;?>