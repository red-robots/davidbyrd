<?php /*
*   Template Name: Shop Featured Nerium
*/
global $search_link_id;
global $cat;
$cat='nerium';
get_header(); ?>
    <div id="main">
        <div class="product-content">
            <?php get_template_part("content","shop-featured");?>
        </div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer(); ?>