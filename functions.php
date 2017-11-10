<?php 

require get_template_directory() . '/inc/pagination.php';
require get_template_directory() . '/inc/woocommerce.php';
/*-------------------------------------
	Adds Options page for ACF.
---------------------------------------*/
if( function_exists('acf_add_options_page') ) {acf_add_options_page();}

// Enqueueing all the java script in a no conflict mode
 function ineedmyjava() {
	if (!is_admin()) {
 
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', false, '1.8.3', true);
		wp_enqueue_script('jquery');
		
		// other scripts...
		/*wp_register_script(
			'thumbslider',
			get_bloginfo('template_directory') . '/js/jquery.easing.1.3.js',
			array('jquery') );
		wp_enqueue_script('thumbslider');
		*/
		wp_register_script(
			'font-awesome',
			'https://use.fontawesome.com/8f931eabc1.js' );
		wp_enqueue_script('font-awesome');
		
		// Custom Theme scripts...
		wp_register_script(
			'custom',
			get_bloginfo('template_directory') . '/js/custom.js',
			array('jquery') );
		wp_enqueue_script('custom');
		wp_localize_script( 'custom', 'bellaajaxurl', array(
			'url' => admin_url( 'admin-ajax.php' )
		));
			
		// Lightbox/Colorbox scripts...
		wp_register_script(
			'colorbox',
			get_bloginfo('template_directory') . '/js/jquery.colorbox-min.js',
			array('jquery') );
		wp_enqueue_script('colorbox');
		
	}
}
 
add_action('wp_enqueue_scripts', 'ineedmyjava');
?>
<?php
// Add Thumbnail Image Supoort
// Must have to do featured images.
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'portsmall', 200, 9999 );
?>
<?php
function blog_favicon() {
echo '<link rel="apple-touch-icon" sizes="76x76" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/manifest.json">
<link rel="mask-icon" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/bw/wp-content/themes/david-byrd-consulting/images/favicons/favicon.ico">
<meta name="msapplication-config" content="/bw/wp-content/themes/david-byrd-consulting/images/favicons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">';
}
add_action('wp_head', 'blog_favicon');
?>
<?php
// if you need to deregister styles in plugins
/*add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'soliloquy-style' );
}*/
?>
<?php
// Changing WordPress admin Menu Names
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Blog';
    $submenu['edit.php'][10][0] = 'Add a Blog Post';
   // $submenu['edit.php'][15][0] = 'Status'; // Change name for categories
    //$submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Blog';
        $labels->singular_name = 'Blog';
        $labels->add_new = 'Add a Blog Post';
        $labels->add_new_item = 'Add a Blog Post';
        $labels->edit_item = 'Edit Blog';
        $labels->new_item = 'Blog';
        $labels->view_item = 'View Blog';
        $labels->search_items = 'Search Blog';
        $labels->not_found = 'No Blog found';
        $labels->not_found_in_trash = 'No Blog found in Trash';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );
?>
<?php 
// --------------  Register Widget Menus -------------- 
function baker_register_sidebars(){
	register_sidebar( array (
		'name' => 'Page Sidebar',
		'id' => 'page-sidebar',
		'description' => __( 'The sidebar on basic pages'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => "Homepage Widget",
		'id' => 'home-widget',
		'description' => __( 'widget for the homepage'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => "Homepage Footer",
		'id' => 'home-footer',
		'description' => __( 'homepage footer.'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// add more above this line
}
add_action( 'widgets_init', 'baker_register_sidebars' );
?>
<?php
/*
Plugin Name: Page Excerpt

Description: Adds support for page excerpts - uses WordPress code

*/
add_action( 'edit_page_form', 'pe_add_box');
add_action('init', 'pe_init');
function pe_init() {
	if(function_exists("add_post_type_support")) //support 3.1 and greater
	{add_post_type_support( 'page', 'excerpt' );}
}
function pe_page_excerpt_meta_box($post) {
?>
<label class="hidden" for="excerpt"><?php _e('Excerpt hey') ?></label><textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt"><?php echo $post->post_excerpt ?></textarea>
<p><?php _e('Excerpt go here..........'); ?></p>
<?php
}
function pe_add_box()
{
	if(!function_exists("add_post_type_support")) //legacy
	{		add_meta_box('postexcerpt', __('Page Excerpt'), 'pe_page_excerpt_meta_box', 'page', 'advanced', 'core');}
}

?>
<?php  // Limit the excerpt without truncating the last word.
// use like this > echo get_excerpt(100);
function get_excerpt($count){
	global $post;
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = $excerpt.'<div class="read-more"><a href="'.$permalink.'">READ MORE</a></div>';
	return $excerpt;
}
?>
<?php
	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'menu1' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'menu2' ) );
?>
<?php
 add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
 // add your extension to the array
 $existing_mimes['vcf'] = 'text/x-vcard';
 return $existing_mimes;
}
?>
<?php
/* Custom Post Types */
add_action('init', 'js_custom_init');
function js_custom_init()
{
	$labels = array(
		'name' => _x('Testimonials', 'post type general name'),
		'singular_name' => _x('Testimonials', 'post type singular name'),
		'add_new' => _x('Add New', 'Testimonials'),
		'add_new_item' => __('Add New Testimonials'),
		'edit_item' => __('Edit Testimonials'),
		'new_item' => __('New Testimonials'),
		'view_item' => __('View Testimonials'),
		'search_items' => __('Search Testimonials'),
		'not_found' =>  __('No Testimonials found'),
		'not_found_in_trash' => __('No Testimonials found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Testimonials'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor','custom-fields','thumbnail')
	);
	register_post_type('testimonials',$args);

	$labels = array(
		'name' => _x('Audio File', 'post type general name'),
		'singular_name' => _x('Audio File', 'post type singular name'),
		'add_new' => _x('Add New', 'Audio File'),
		'add_new_item' => __('Add New Audio File'),
		'edit_item' => __('Edit Audio file'),
		'new_item' => __('New Audio File'),
		'view_item' => __('View Audio Files'),
		'search_items' => __('Search Audio Files'),
		'not_found' =>  __('No Audio Files found'),
		'not_found_in_trash' => __('No Audio Files found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Monthly Audio'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor','custom-fields','thumbnail')
	);
	register_post_type('monthly_audio',$args);
}

/*##############################################
Custom Taxonomies     */
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
// custom tax
	register_taxonomy( 'audio_cat', 'monthly_audio',
		array(
			'hierarchical' => true, // true = acts like categories false = acts like tags
			'label' => 'Audio Category',
			'query_var' => true,
			'show_admin_column' => true,
			'public' => true,
			'rewrite' => array( 'slug' => 'audio-category' ),
			'_builtin' => true
		) );
	register_taxonomy( 'nerium', 'product',
		array(
			'hierarchical' => true, // true = acts like categories false = acts like tags
			'label' => 'Nerium',
			'query_var' => true,
			'show_admin_column' => true,
			'public' => true,
			'rewrite' => array( 'slug' => 'nerium' ),
			'_builtin' => true
		) );
} // End build taxonomies

/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
add_action('wp', 'custom_maybe_activate_user', 9);
function custom_maybe_activate_user() {

    $template_path = STYLESHEETPATH . '/activate.php';
    $is_activate_page = isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation';
    
    if( ! file_exists( $template_path ) || ! $is_activate_page  )
        return;
    
    require_once( $template_path );
    
    exit();
}

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		$digital_vault = get_the_permalink(484);
		$golden_key = get_the_permalink(263);
		if ( in_array( 'winning_the_head_game', $user->roles ) && $digital_vault && strcmp($request,$digital_vault)===0 ) {
			$link = get_the_permalink( 486 );//get winning the headgame page
			if ( $link ) {
				return $link;
			} else {
				return $redirect_to;
			}
		}
		elseif ( in_array( 'goldenkey', $user->roles ) && $golden_key && strcmp($request,$golden_key)===0 ) {
			$link = get_the_permalink( 249 );//get golden key earner page
			if ( $link ) {
				return $link;
			} else {
				return $redirect_to;
			}
		} elseif(in_array( 'administrator', $user->roles )){
			return $redirect_to;
		} elseif (in_array( 'winning_the_head_game', $user->roles )) {
		    return get_the_permalink( 486 );
		} elseif (in_array( 'goldenkey', $user->roles )) {
		    return get_the_permalink(249);
		} else {
			return $redirect_to;
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


add_action( 'init', 'bella_user_register' );
function bella_user_register() {
	if ( bella_check_one_time_code_program() && isset( $_POST['bella_registration_nonce'] ) && wp_verify_nonce( $_POST['bella_registration_nonce'], 'page-registration.php' ) ) {
	    if (isset($_POST['user_email']) && !empty($_POST['user_email'])
            && isset($_POST['user_login']) && !empty($_POST['user_login'])
            && isset($_POST['user_password']) && !empty($_POST['user_password'])) {
		    $user = get_user_by('email',$_POST['user_email']);
		    $user_id = null;
		    $created_flag = 0;
		    if($user){
		        $user_id = $user->ID;
            } else {
			    $user_id = wp_create_user( $_POST['user_login'], $_POST['user_password'], $_POST['user_email'] );
			    $created_flag = 1;
		    }
			if(!is_wp_error($user_id)) {
				$role = get_post_meta( 294, $_POST['one_time_code'], true );
				delete_post_meta( 294, 'bella_one_time_code', $_POST['one_time_code'] );
				delete_post_meta( 294, $_POST['one_time_code'], $role );
				//potentially add email if not deleted to admin
				$user = new WP_User( $user_id );
				if(!in_array($role,$user->roles)) {
					$user->add_role( $role );
				}
				if(in_array('subscriber',$user->roles) && $created_flag){
				    $user->remove_role('subscriber');
                }
				$creds = array();
				$creds['user_login'] = $_POST['user_login'];
				$creds['user_password'] = $_POST['user_password'];
				$creds['remember'] = false;
				$user = wp_signon( $creds, false );
				if(is_wp_error($user)){
				    wp_redirect(get_the_permalink(484));
				    exit;
                }
				elseif(strcmp($role,'winning_the_head_game')===0) {
					wp_redirect( get_the_permalink(486) );
					exit;
				}
			} else {
			    $_POST['bella_errors'] = "couldn't create user";
            }
		} else {
	        $_POST['bella_errors'] = "not all fields supplied";
        }
    }
}
function bella_check_one_time_code_program(){

	if(isset($_POST['one_time_code'])){
		$codes = get_post_meta(294,'bella_one_time_code',false);
		if(in_array($_POST['one_time_code'],$codes)){
			return true;
		}
	}
	return false;
}
function bella_check_one_time_code(){
	if ( ((isset( $_POST['bella_check_one_time_code_nonce'] ) && wp_verify_nonce( $_POST['bella_check_one_time_code_nonce'], 'page-registration.php' ) ) ||
         (isset( $_POST['bella_registration_nonce'] ) && wp_verify_nonce( $_POST['bella_registration_nonce'], 'page-registration.php') )) && isset( $_POST['one_time_code'] )) {
        $codes = get_post_meta( 294, 'bella_one_time_code', false );
        if ( in_array( $_POST['one_time_code'], $codes ) ) {
            return true;
        }
		$_POST['bella_errors_one_time_code'] = 'that code is not valid';
	}
	return false;
}
function bella_get_one_time_codes(){

	$codes = get_post_meta(294,'bella_one_time_code',false);?>
    <table>
        <tr><th>Codes</th><th>Role</th></tr>
        <?php foreach($codes as $code):
            $role = get_post_meta(294,$code,true);?>
            <tr>
                <td>
		            <?php echo $code;?>
                </td>
                <td>
		            <?php echo $role;?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php }
function bella_process_one_time_codes(){
    if ( !isset( $_POST['bella_nonce'] ) || !wp_verify_nonce( $_POST['bella_nonce'], basename( __FILE__) ) ||!isset($_POST['bella_num']) || empty($_POST['bella_num']) ){
        return;
    }
    $num = intval($_POST['bella_num'])>0?intval($_POST['bella_num']):1;?>
    <table>
        <tr><th>Codes</th><th>Role</th></tr>
        <?php for ( $i = 0; $i < $num; $i ++ ) {
            $strong = false;
	        $meta_id_code = false;
	        $meta_id_role = false;
            $bytes  = bin2hex( openssl_random_pseudo_bytes( 10, $strong ) );
            $role = 'winning_the_head_game';
            if ( $strong ) {
	            $meta_id_code = add_post_meta( 294, 'bella_one_time_code', $bytes );
	            $meta_id_role = add_post_meta( 294, $bytes, $role );
            }
            if ( $meta_id_code !== false && $meta_id_role !== false ) {?>
                <tr>
                    <td class="one-time-code">
                        <?php echo $bytes;?>
                    </td>
                    <td class="role">
		                <?php echo $role;?>
                    </td>
                </tr>
            <?php }
        }?>
    </table>
<?php }
function bella_one_time_codes(){?>
    <div>
        <?php if(isset($_POST['hidden'])&&strcmp($_POST['hidden'],'process')===0){
            bella_process_one_time_codes();
        }?>
	    <?php if(isset($_POST['hidden'])&&strcmp($_POST['hidden'],'get')===0){
	        bella_get_one_time_codes();
	    }?>
        <form action="" method="post">
		    <?php wp_nonce_field( basename(__FILE__ ), 'bella_nonce' );?>
            <input type="hidden" name="hidden" value="process">
            <input type="number" step="1" value="1" min="1" max="500" name="bella_num">
            <input type="submit" value="Get New One Time Codes"/>
        </form>
        <form action="" method="post">
		    <?php wp_nonce_field( basename(__FILE__ ), 'bella_nonce' );?>
            <input type="hidden" name="hidden" value="get">
            <input type="submit" value="Get All Remaining One Time Codes"/>
        </form>
    </div>
<?php }

function bella_options_page(){
	add_options_page( 'One Time Codes', 'One Time Codes', 'manage_options', 'one-time-codes', 'bella_one_time_codes');
}
add_action('admin_menu','bella_options_page');

if(!function_exists('return_100')){
	function return_100(){
		return 100;
	}
}
add_filter( 'jpeg_quality', 'return_100' );
?>