<?php /*
*   Template Name: Products & Services
*/
global $terms_ids;
global $search_link_id;
global $cat;
$cat='product_cat';
get_header(); ?>
    <div id="main">
        <div class="product-content">
            <?php get_template_part("content","shop");?>
        </div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer(); ?>