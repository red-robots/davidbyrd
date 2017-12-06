<?php 
if(!function_exists('bella_sensei_add_audio_pdf')){
    add_action('sensei_single_lesson_content_inside_after','bella_sensei_add_audio_pdf',10,1);
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