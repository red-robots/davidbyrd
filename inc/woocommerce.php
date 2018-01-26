<?php
if(!function_exists('woocommerce_support')){ 
	add_action( 'after_setup_theme', 'woocommerce_support' );
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
}
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

if(!function_exists('bella_related_product_args')){
	add_filter( 'woocommerce_output_related_products_args', 'bella_related_products_args' );
	function bella_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 4 related products
		$args['columns'] = 3; // arranged in 2 columns
		return $args;
	}
}
if(!function_exists('bella_woocommerce_clear_cart_url')) {
	add_action('init', 'bella_woocommerce_clear_cart_url');
	function bella_woocommerce_clear_cart_url() {
		global $woocommerce;
		if( isset($_REQUEST['clear-cart']) ) {
			$woocommerce->cart->empty_cart();
		}
	}
}
if(!function_exists('bella_clear_cart')){
	add_action( 'bella_woocommerce_after_cart_table', 'bella_clear_cart',10);
	function bella_clear_cart() {
		echo '<form action="" method="post">';
		echo '<input type="submit" class="button" name="clear-cart" value="';
		echo _e("Clear Cart","woocommerce");
		echo '">';
		echo '</form>';
	}
}

if(!function_exists('bella_remove_hooks')){
    add_action('init','bella_remove_hooks',10);
    function bella_remove_hooks(){
		global $woothemes_sensei;
		remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
		remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
		remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);
		remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
		remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display',15);
		remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs',10);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',25);
add_action('woocommerce_after_single_product','woocommerce_upsell_display',20);

/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 * Thanks https://nicola.blog/2015/07/20/change-the-return-to-shop-button-url-in-the-cart-page/
 * @return string
function wc_empty_cart_redirect_url() {
	return get_the_permalink(551);
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );
*/

/**
 * Each tab is an array containing title, callback and priority.
 * */
if(!function_exists('bella_add_tabs')&&!function_exists('bella_whats_tab')){
    add_filter('woocommerce_product_tabs','bella_add_tabs');
    function bella_add_tabs($array){
		if(!isset($array['bella_whats'])):
			$array['bella_whats'] = array(
				'title'=>'What\'s In The Box?',
				'priority'=>15,
				'callback'=>'bella_whats_tab'
			);
		endif;
		return $array;
	}
	function bella_whats_tab(){
		$whats = get_field('whats_');
		if($whats):
			echo $whats;
		endif;
	}
}


if(!function_exists('bella_loop_shop_per_page')){
	add_filter( 'loop_shop_per_page', 'bella_loop_shop_per_page', 20 );
	function bella_loop_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = 12;
	return $cols;
	}
}

add_action( 'wp_ajax_bella_add_cart', 'bella_ajax_add_cart' );
add_action( 'wp_ajax_nopriv_bella_add_cart', 'bella_ajax_add_cart' );
function bella_ajax_add_cart() {
	if ( isset( $_POST['id'] ) && isset( $_POST['qty'] ) ) {
		$id  = intval( $_POST['id'] );
		$qty = intval( $_POST['qty'] );
		if ( WC()->cart->add_to_cart( $id, $qty ) !== false ) {
			$status = 1;
		} else {
			$status = 0;
		}
	} else {
		$status = 0;
	}
	$response    = array(
		'what'   => 'cart',
		'action' => 'add_cart',
		'id'     => $status,
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

add_action( 'wp_ajax_bella_get_cart_count', 'bella_ajax_get_cart_count' );
add_action( 'wp_ajax_nopriv_bella_get_cart_count', 'bella_ajax_get_cart_count' );
function bella_ajax_get_cart_count() {
	$response    = array(
		'what'   => 'cart',
		'action' => 'get_cart_count',
		'data'   => WC()->cart->get_cart_contents_count(),
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}
add_action( 'wp_ajax_bella_get_cart_price', 'bella_ajax_get_cart_price' );
add_action( 'wp_ajax_nopriv_bella_get_cart_price', 'bella_ajax_get_cart_price' );
function bella_ajax_get_cart_price() {
	$response    = array(
		'what'   => 'cart',
		'action' => 'get_cart_price',
		'data'   => WC()->cart->get_cart_total(),
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

add_action( 'wp_ajax_bella_get_cart', 'bella_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_bella_get_cart', 'bella_ajax_get_cart' );
function bella_ajax_get_cart() {
	$return = do_action( 'woocommerce_before_cart_contents' );
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$return .= '<div class="product-box">';
			$return .= '<div class="product-info"><div class="product-name">';
			if ( ! $_product->is_visible() ) {
				$return .= apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
			} else {
				$return .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
			}
			$return .= '</div><!--.product-name--><div class="product-quantity">';
			$return .= "X " . $cart_item['quantity'] . '</div><!--.product-quantity-->';
			$return .= '</div><!--.product-info--></div><!--.product-box-->';
		}
	}
	$return .= do_action( 'woocommerce_after_cart_contents' );
	$return .= '<div class="totals-checkout"><div class="subtotal">Subtotal: ' . WC()->cart->get_cart_total() . '</div><!--.subtotal-->';
	$return .= '<div class="checkout button"><a href="' . WC()->cart->get_checkout_url() . '">Checkout</a></div><!--.checkout .button-->';
	$return .= '<div class="cart button"><a href="'.wc_get_cart_url().'">View Cart</a></div><!--.cart-button--></div><!--.totals-checkout-->';
	$response    = array(
		'what'   => 'cart',
		'action' => 'get_cart',
		'id'     => '1',
		'data'   => $return
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

if(!function_exists('bella_custom_search')){
	add_action( 'woocommerce_product_query', 'bella_custom_search', 10 );
	function bella_custom_search($q){
		global $wpdb;
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
			$q->set('post__in', $in);
		endif;
	}
}

if(!function_exists('bella_woocommerce_product_add_to_cart_text')){
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'bella_woocommerce_product_add_to_cart_text' );
	add_filter( 'woocommerce_product_add_to_cart_text' , 'bella_woocommerce_product_add_to_cart_text' );
	function bella_woocommerce_product_add_to_cart_text($default) {
		global $product;

		if( $product->is_type('bundle') || $product->is_type('subscription')) {
			return __( 'Add to cart', 'woocommerce' );
		} else {
			return $default;
		}
	}
}
?>