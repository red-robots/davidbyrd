<?php global $terms_ids;?>
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
            <header>
                <h2>Category</h2>
            </header>
            <div class="wrapper">
                <ul>
                    <?php foreach($terms as $term):
                        $terms_ids[] = $term->term_id;?>
                        <li>
                            <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name;?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div><!--.wrapper-->
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
            <header>
                <h2>Top Sellers</h2>
            </header>
            <div class="wrapper">
                <div class="wrapper">
                    <?php while($most_pop_query->have_posts()):$most_pop_query->the_post();?>
                        <div class="most-pop-box">
                            <a href="<?php echo get_the_permalink();?>">
                                <?php woocommerce_template_loop_product_thumbnail();
                                woocommerce_template_loop_product_title();?>
                            </a>
                        </div><!--.most-pop-box-->
                    <?php endwhile;?>
                </div><!--.wrapper-->
                <a href="<?php echo get_the_permalink(551);?>">View All</a>
            </div><!--.wrapper-->
        </div><!--.row-2-->
        <?php wp_reset_postdata();
    endif;?>
    <form class="bella-search" action="<?php the_permalink(551);?>" method="POST">
        <h2>Search</h2>
        <input type="text" name="search" placeholder="" <?php if(isset($_POST['search'])) echo 'value="'.$_POST['search'].'"';?>>
        <button type="submit"><i class="fa fa-arrow-circle-o-right"></i></button>
    </form>
</aside><!--.col-1-->