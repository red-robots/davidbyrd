<?php /*
*   Template Name: Nerium
*/
global $terms_ids;
global $search_link_id;
global $cat;
$cat = 'nerium';
get_header(); ?>
    <div id="main">
        <div class="product-content">
            <?php get_template_part("content","shop");?>
        </div><!-- .product-content -->
    </div><!--#main-->
<?php get_footer(); ?>