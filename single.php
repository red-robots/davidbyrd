<?php
/**
 * Displays a Single Post
 */

get_header(); ?>

	

<div id="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="single-post-container">
<div id="news-box">
<div class="row2boxheader"></div>
<div id="news-box-content">
<h2>Blog</h2>
 <?php $the_query = new WP_Query( 'showposts=5' ); ?>

<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

 <li><span class="date"><?php the_date('m.d.y'); ?></span>&nbsp;&nbsp;<a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

 <?php endwhile;?>



 <p><a href="<?php bloginfo('url'); ?>/blog">see all ></a></p>



 </ul>
 <?php wp_reset_postdata(); ?>
</div> </div>
<h1><?php the_title(); ?></h1>

 
  
 		<?php the_content(); ?>
</div><!-- single post container -->






<?php endwhile; endif; ?>


<?php // get_sidebar(); ?>
<?php get_footer(); ?>