<?php
if(!function_exists('declare_sensei_support')){ 
    add_action( 'after_setup_theme', 'declare_sensei_support' );
    function declare_sensei_support() {
        add_theme_support( 'sensei' );
    }
}
if(!function_exists('bella_add_column_to_my_courses')){ 
    add_action( 'sensei_my_courses_before', 'bella_add_column_to_my_courses',0 );
    function bella_add_column_to_my_courses() {
        echo '<nav class="woocommerce-account-navigation">';
	        wp_nav_menu( array( 'theme_location' => 'myaccount' ) );
        echo "</nav>";
    }
}
/*if(!function_exists('bella_text_to_my_courses')){ 
    add_action( 'sensei_my_courses_content_inside_before', 'bella_text_to_my_courses',10 );
    function bella_text_to_my_courses() {
        echo '<p>Welcome to your account dashboard. This is where you can check your order status, find your online courses and downloads, manage your subscriptions, manage your shipping and billing addresses, and edit your password and account details.</p>';
    }
}*/
if(!function_exists('bella_sensei_add_audio_pdf')){
    add_action('sensei_lesson_single_meta','bella_sensei_add_audio_pdf',10,1);
    function bella_sensei_add_audio_pdf($id){
        $audio_file = get_field( "audio_file" , $id);
        $audio_file_2 = get_field( "audio_file_2", $id );
        $file             = get_field( "file", $id );
        $link_text        = get_field( "monthly_audio_link_text", 484 );
        $audio_file_2_text = get_field("audio_file_2_text", $id);
        $file_text        = get_field( "monthly_audio_file_text", 484 );
        if ( ( $audio_file && $link_text ) || ( $file && $file_text ) ){
            echo '<div class="audio-box-button-wrapper">';
                if ( $audio_file && $link_text ){
                    echo '<div class="audio-box-button">';
                        echo '<a class="audio-popup" href="#audio-file-' . $audio_file['id'].'">';
                            echo '<img src="'. get_bloginfo( 'template_url' ) .'/images/button-arrow.jpg" alt="" border="0">';
                            echo '<div class="audio-box-button-text">';
                                echo $link_text;
                            echo '</div><!--.audio-box-button-text-->';
                        echo '</a>';
                        echo '<div class="audio-hidden">';
                            echo '<div class="audio-file" id="audio-file-' . $audio_file['id'] . '">';
                                echo '<audio controls class="audio-player">';
                                    echo '<source src="'.$audio_file['url'].'" type="audio/ogg">';
                                    echo '<source src="'.$audio_file['url'].'" type="audio/mpeg">';
                                    echo 'Your browser doesn\'t support html5 audio! Please upgrade your browser.';
                                echo '</audio>';
                            echo '</div><!--#audio-file-# .audio-file-->
                        </div><!--.audio-hidden-->
                    </div><!--.audio-box-button-->';
                }//endif for link and link text
                if ( $audio_file_2 && ($link_text || $audio_file_2_text) ){
                    echo '<div class="audio-box-button">
                        <a class="audio-popup" href="#audio-file-' . $audio_file_2['id'] . '">
                            <img src="'.get_bloginfo( 'template_url' ).'/images/button-arrow.jpg" alt="" border="0">
                            <div class="audio-box-button-text">';
                                if($audio_file_2_text){
                                    echo $audio_file_2_text;
                                } else {
                                    echo $link_text;
                                }
                            echo '</div><!--.audio-box-button-text-->
                        </a>
                        <div class="audio-hidden">
                            <div class="audio-file" id="audio-file-' . $audio_file_2['id'].'">
                                <audio controls class="audio-player">
                                    <source src="'.$audio_file_2['url'].'" type="audio/ogg">
                                    <source src="'.$audio_file_2['url'].'" type="audio/mpeg">
                                    Your browser doesn\'t support html5 audio! Please
                                    upgrade your browser.
                                </audio>
                            </div><!--#audio-file-# .audio-file-->
                        </div><!--.audio-hidden-->
                    </div><!--.audio-box-button-->';
                };//endif for link and link text
                if ( $file && $file_text ){
                    echo '<div class="audio-box-button">
                        <a href="'.$file.'" target="_blank">
                            <img src="'.get_bloginfo( 'template_url' ).'/images/button-arrow.jpg" alt="" border="0">
                            <div class="audio-box-button-text">';
                                echo $file_text;
                            echo '</div><!--.audio-box-button-text-->
                        </a>
                    </div><!--.audio-box-button-->';
                };//endif for file and file text
            echo '</div><!--.audio-box-button-wrapper-->';
        };//endif for file and file text or link and link text
    }
}
/**
 * Required: Restrict lesson videos & quiz links until the member has access to the lesson.
 * Used to ensure content dripping from Memberships is compatible with Sensei.
 *
 * This will also remove the "complete lesson" button until the lesson is available.
 
function sv_wc_memberships_sensei_restrict_lesson_details() {
    global $post;
    // sanity checks
    //exit;
    var_dump($post);
    var_dump(sensei_can_user_view_lesson());
    if ( ! function_exists( 'wc_memberships_get_user_access_start_time' )){
        echo "1";
    }
    if( ! function_exists( 'Sensei' ) ){
        echo "2";
    } 
    if('lesson' !== get_post_type( $post ) ) {
        echo "3";
    }
    echo wc_memberships_get_user_access_start_time( get_current_user_id(), 'view', array( 'lesson' => $post->ID ) )."<br>";
    echo current_time( 'timestamp' );
    // if access start time isn't set, or is after the current date, remove the video
    if ( ! wc_memberships_get_user_access_start_time( get_current_user_id(), 'view', array( 'lesson' => $post->ID ) )
        || current_time( 'timestamp' ) < wc_memberships_get_user_access_start_time( get_current_user_id(), 'view', array( 'lesson' => $post->ID ) ) ) {
       // remove_action( 'sensei_single_lesson_content_inside_after', 'bella_sensei_add_audio_pdf' );
    }
}
add_action( 'wp', 'sv_wc_memberships_sensei_restrict_lesson_details' );
*/