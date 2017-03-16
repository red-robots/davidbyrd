<?php
/**
 * Template Name: Monthly Audio
 */
get_header(); ?>

    <div id="main">
<?php if ( have_posts() ) : the_post(); ?>
	<?php $audio_category = get_field( "audio_category" ); ?>
    <div class="page-content">
        <h1><?php the_title(); ?></h1>
		<?php if ( $audio_category ):
			$user = wp_get_current_user();
			$audio_cats = explode( "-", $audio_category->slug );
			if ( $audio_cats ):
				$role = implode( "_", $audio_cats );
				if ( ! ( in_array( $role, (array) $user->roles, true ) ||
				         in_array( 'administrator', (array) $user->roles, true ) )
				) : ?>
                    <p>Welcome to the David Byrd Consulting Digital Vault. This site is accessible to Winning The Head
                        Game
                        users only.</p>
				<?php else :
					$args = array(
						'post_type'      => 'monthly_audio',
						'posts_per_page' => - 1,
						'orderby'        => 'date',
						'order'          => 'ASC',
						'tax_query'      => array(
							array(
								'taxonomy' => 'audio_cat',
								'field'    => 'term_id',
								'terms'    => array( $audio_category->term_id ),
							),
						),
					);
					$query = new WP_Query( $args );
					if ( $query->have_posts() ):?>
                        <div class="monthly-audio-wrapper">
							<?php $count = 0;
							while ( $query->have_posts() ):$query->the_post(); ?>
                                <div class="audio-box js-blocks count-<?php echo $count % 4; ?>">
                                    <div class="audio-box-header">
										<?php the_title(); ?>
                                    </div><!--.audio-box-header-->
                                    <div class="audio-box-wrapper">
                                        <div class="audio-box-text">
                                            <?php the_content(); ?>
                                        </div><!--.audio-box-text-->
										<?php $audio_file = get_field( "audio_file" );
										$audio_file_2 = get_field( "audio_file_2" );
										$file             = get_field( "file" );
										$link_text        = get_field( "monthly_audio_link_text", 484 );
										$file_text        = get_field( "monthly_audio_file_text", 484 );
										if ( ( $audio_file && $link_text ) || ( $file && $file_text ) ):?>
                                            <div class="audio-box-button-wrapper">
	                                            <?php if ( $audio_file && $link_text ): ?>
                                                    <div class="audio-box-button">
                                                        <a class="audio-popup"
                                                           href="<?php echo '#audio-file-' . $audio_file['id']; ?>">
                                                            <img src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg"
                                                                 alt="" border="0">
                                                            <div class="audio-box-button-text">
					                                            <?php echo $link_text; ?>
                                                            </div><!--.audio-box-button-text-->
                                                        </a>
                                                        <div class="audio-hidden">
                                                            <div class="audio-file"
                                                                 id="<?php echo 'audio-file-' . $audio_file['id']; ?>">
                                                                <audio controls class="audio-player">
                                                                    <source src="<?php echo $audio_file['url']; ?>"
                                                                            type="audio/ogg">
                                                                    <source src="<?php echo $audio_file['url']; ?>"
                                                                            type="audio/mpeg">
                                                                    Your browser doesn't support html5 audio! Please
                                                                    upgrade your browser.
                                                                </audio>
                                                            </div><!--#audio-file-# .audio-file-->
                                                        </div><!--.audio-hidden-->
                                                    </div><!--.audio-box-button-->
	                                            <?php endif;//endif for link and link text?>
	                                            <?php if ( $audio_file_2 && $link_text ): ?>
                                                    <div class="audio-box-button">
                                                        <a class="audio-popup"
                                                           href="<?php echo '#audio-file-' . $audio_file_2['id']; ?>">
                                                            <img src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg"
                                                                 alt="" border="0">
                                                            <div class="audio-box-button-text">
					                                            <?php echo $link_text; ?>
                                                            </div><!--.audio-box-button-text-->
                                                        </a>
                                                        <div class="audio-hidden">
                                                            <div class="audio-file"
                                                                 id="<?php echo 'audio-file-' . $audio_file_2['id']; ?>">
                                                                <audio controls class="audio-player">
                                                                    <source src="<?php echo $audio_file_2['url']; ?>"
                                                                            type="audio/ogg">
                                                                    <source src="<?php echo $audio_file_2['url']; ?>"
                                                                            type="audio/mpeg">
                                                                    Your browser doesn't support html5 audio! Please
                                                                    upgrade your browser.
                                                                </audio>
                                                            </div><!--#audio-file-# .audio-file-->
                                                        </div><!--.audio-hidden-->
                                                    </div><!--.audio-box-button-->
	                                            <?php endif;//endif for link and link text
												if ( $file && $file_text ):?>
                                                    <div class="audio-box-button">
                                                        <a href="<?php echo $file; ?>" target="_blank">
                                                            <img src="<?php bloginfo( 'template_url' ); ?>/images/button-arrow.jpg"
                                                                 alt="" border="0">
                                                            <div class="audio-box-button-text">
																<?php echo $file_text; ?>
                                                            </div><!--.audio-box-button-text-->
                                                        </a>
                                                    </div><!--.audio-box-button-->
												<?php endif;//endif for file and file text
												?>
                                            </div><!--.audio-box-button-wrapper-->
										<?php endif;//endif for file and file text or link and link text
										?>
                                    </div><!--.audio-box-wrapper-->
                                </div>
								<?php $count ++;
							endwhile; //while for audio files
							?>
                        </div><!--.audio-wrapper-->
						<?php wp_reset_postdata();
					endif; //if for audio files
				endif;//if for correct role
			endif;//if for audio cats explode
		endif; //if for audio category?>
    </div><!--.page-content-->

<?php endif; ?>


<?php get_footer(); ?>