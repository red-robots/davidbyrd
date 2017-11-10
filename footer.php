</div> <!-- main -->


<?php if(is_page( 'Home' ) ) { ?>

<div id="row3">
<div id="row1">

<div id="row1-left">

 <?php $the_query = new WP_Query( 'showposts=1' ); ?>

<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

<h2><?php the_title(); ?></h2>
<span class="date"><?php the_date('m.d.y'); ?></span>

<p><?php  echo get_excerpt(300); ?> 


 <?php endwhile;?>


 <?php wp_reset_postdata(); ?>
 
</div>

<div id="row1-right">


<?php $recent = new WP_Query("page_id=21"); while($recent->have_posts()) : $recent->the_post();?>

<?php the_content(); ?>
<?php endwhile; wp_reset_postdata(); // end of the loop. ?>

</div>


</div>
</div>
            <?php } else { ?>

            <?php } ?>



<div id="footer">

<div id="footer2-wrapper">

<div id="footer2">

<div id="footer2-left">
<div id="footer-content1">
<div class="social-icon"><a href="https://www.youtube.com/user/davidbyrdconsulting/" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/youtube.jpg" alt="" border="0"></a></div>
<div class="social-icon"><a href="http://www.linkedin.com/in/davidbyrdconsulting" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/linkedin.jpg" alt="" border="0"></a></div>
<div class="social-icon"><a href="https://www.facebook.com/DavidByrdConsulting" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/facebook.jpg" alt="" border="0"></a></div>
<div class="social-icon"><a href="https://twitter.com/davidbyrdtweets" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/twitter.jpg" alt="" border="0"></a></div>
</div>
</div>
<div id="footer2-right"><?php the_field('footer_info', 'option'); ?>
<div id="footer2-right-sm"><a href="<?php bloginfo('url'); ?>/contact-us">Contact</a> &nbsp; | &nbsp; <a href="<?php bloginfo('url'); ?>/sitemap">Sitemap</a> &nbsp; | &nbsp; Site by <a href="http://www.bellaworksweb.com" target="_blank">Bellaworks</a></div>
</div>

</div>
</div>
</div>
	

<?php wp_footer(); ?>
<!-- liquid web -->
</body>
</html>