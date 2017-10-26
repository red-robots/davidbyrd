<?php 
if(!function_exists('bella_add_view_now')){
    add_action('woocommerce_after_shop_loop_item','bella_add_view_now',20);
    function bella_add_view_now(){
        echo '<a class="view-now button" href="'.get_the_permalink().'">View</a>';
    }
}




?>