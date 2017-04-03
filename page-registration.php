<?php /*
*   Template Name: Register Page
*/?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="main">
    <div class="page-content">
        <h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
        <?php $code_valid = bella_check_one_time_code();
        if($code_valid):?>
            <form name="registerform" id="registerform" action="" method="post">
                <?php if(isset($_POST['bella_errors'])):?>
                    <p>
                        <?php echo $_POST['bella_errors'];?>
                    </p>
                <?php endif;?>
                <p>
                    <label for="user_login"><?php _e('Username') ?><br />
                        <input type="text" name="user_login" id="user_login" class="input" value="" size="20" /></label>
                </p>
                <p>
                    <label for="user_email"><?php _e('Email') ?><br />
                        <input type="email" name="user_email" id="user_email" class="input" value="" size="25" /></label>
                </p>
                <p>
                    <label for="user_password"><?php _e('Password') ?><br />
                        <input type="password" name="user_password" id="user_password" class="input" value="" size="25" /></label>
                </p>
                <?php if(isset($_POST['one_time_code'])):?>
                    <input type="hidden" name="one_time_code" value="<?php echo $_POST['one_time_code'];?>">
	            <?php endif;
                wp_nonce_field( 'page-registration.php', 'bella_registration_nonce' ); ?>
                <br class="clear" />
                <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Register'); ?>" /></p>
            </form>
        <?php else:?>
            <form action="" method="post">
                <input type="text" name="one_time_code" value=""/>
                <?php wp_nonce_field( 'page-registration.php', 'bella_check_one_time_code_nonce' );?>
                <input type="submit" value="Submit"/>
            </form>
        <?php endif;?>
    </div><!-- / page content -->
<?php endwhile; endif; ?>
<?php get_footer(); ?>