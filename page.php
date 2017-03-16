<?php get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div id="main">

    <div class="page-content">


		<?php if ( is_page( 'About' ) ) { ?>

            <div id="news-box">
                <div class="row2boxheader"></div>
                <div id="news-box-content"><?php the_field( "callout_box" ); ?></div>
            </div>

		<?php } else { ?>


		<?php } ?>


		<?php if ( is_page( 'Golden Key Earner' ) ) { ?>

            <div id="news-box">
                <div class="row2boxheader"></div>
                <div id="news-box-content"><?php the_field( "callout_box" ); ?></div>
            </div>

		<?php } else { ?>


		<?php } ?>


        <h1><?php the_title(); ?></h1>


		<?php if ( is_page( 263 ) ) { // key earner login ?>


			<?php if ( post_password_required() ) : ?>
                <form method="post" action="<?php bloginfo( 'wpurl' ); ?>/wp-login.php?action=postpass">
                    <p>Welcome to David Byrd Consulting Golden Key Earners site.  This site is accessible to Golden Key
                        Earners only.</p>
                    <input type="password" style="margin:10px 0;" size="20" id="pwbox-<?php the_ID(); ?>"
                           name="post_password"/></label><br/>
                    <input type="submit" value="Submit" name="Submit"/></p>
                </form>
			<?php endif; ?>


			<?php
// password protect Members section fields
			if ( ! post_password_required() ) { ?>
				<?php wp_login_form(); ?>

                <h2>Registration</h2>

                <!-- <p>If you are a Golden Key Earner and new to this site, please register <a title="Registration" href="http://davidbyrdconsulting.com/bw/wp-login.php?action=register">here</a>.</p> -->
                <p>If you are a Golden Key Earner and new to this site, please register <a title="Registration"
                                                                                           href="http://davidbyrdconsulting.com/golden-key-earner-registration/">here</a>.
                </p>

			<?php } elseif ( is_page( 260 ) ) { // register page ?>

				<?php wp_login_form(); ?>
                <h2>Registration</h2>
                <p>If you wish to register for this site, Please click the link below.</p>
				<?php wp_register(); ?>
			<?php } // end if is password protected?>

		<?php } elseif(is_page(484)) { ?>
			<?php wp_login_form(); ?>
            <h2>Lost Password</h2>
            <form method="post" action="<?php bloginfo( 'wpurl' ); ?>/wp-login.php?action=lostpassword">
                <label>Username or E-mail: </label><input type="text" style="margin:10px 0;" size="20" name="user_login"/><br/>
                <input type="submit" value="Submit" name="Submit"/>
            </form>
        <?php } else {?>
			<?php the_content(); ?>

		<?php } ?>
    </div><!-- / page content -->


<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>