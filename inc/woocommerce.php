<?php 
if(!function_exists('bella_add_view_now')){
    add_action('woocommerce_after_shop_loop_item','bella_add_view_now',20);
    function bella_add_view_now(){
        echo '<a class="view_now button" href="'.get_the_permalink().'">View</a>';
    }
}

if(!function_exists('bella_add_button_group_beginning_tag')){
    add_action('woocommerce_after_shop_loop_item_title','bella_add_button_group_beginning_tag',20);
    function bella_add_button_group_beginning_tag(){
        echo '<div class="button_group">';
    }
}

if(!function_exists('bella_add_button_group_ending_tag')){
    add_action('woocommerce_after_shop_loop_item','bella_add_button_group_ending_tag',20);
    function bella_add_button_group_ending_tag(){
        echo '</div><!--.button_group-->';
    }
}

?>