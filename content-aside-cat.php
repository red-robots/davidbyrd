<?php global $terms_ids, $cat, $search_link_id;?>
<aside class="col-1">
    <?php $args = array(
        'taxonomy'   => $cat,
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
    <?php endif;?>
    <div class="row-2">
        <header>
            <h2>Sort</h2>
        </header>
        <form class="woocommerce-ordering" action="<?php echo get_the_permalink($search_link_id);?>" method="get">
            <select name="orderby" class="orderby">
                <option value="menu_order" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='menu_order')||!isset($_GET['orderby'])) echo 'selected="selected"';?>>Default sorting</option>
                <option value="popularity" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='popularity')) echo 'selected="selected"';?>>Sort by popularity</option>
                <option value="rating" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='rating')) echo 'selected="selected"';?>>Sort by average rating</option>
                <option value="date" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='date')) echo 'selected="selected"';?>>Sort by newness</option>
                <option value="price" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='price')) echo 'selected="selected"';?>>Sort by price: low to high</option>
                <option value="price-desc" <?php if((isset($_GET['orderby'])&&$_GET['orderby']==='price-desc')) echo 'selected="selected"';?>>Sort by price: high to low</option>
            </select>
	        <?php wc_query_string_form_fields( null, array( 'orderby', 'submit' ) ); ?>
        </form>
    </div><!--.row-2-->
    <?php $args = array(
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'posts_per_page'        => 3,
        'order'=>'ASC',
        'orderby'=>'rand',
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
    $most_pop_query = new WP_Query($args);
    if($most_pop_query->have_posts()):?>
        <div class="row-3 popular-box">
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
                <a href="<?php 
                if(strcmp($cat,"nerium")===0):
                    echo get_the_permalink(1500);
                else: 
                    echo get_the_permalink(1451);
                endif;?>">View All</a>
            </div><!--.wrapper-->
        </div><!--.row-2-->
        <?php wp_reset_postdata();
    endif;?>
</aside><!--.col-1-->