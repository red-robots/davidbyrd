<?php
/**
 * Template Name: Blog
 */

get_header(); ?>

<div id="main">	

<div class="page-content">

<h1>BLOG</h1>

<div id="subscribe">
<h2>Sign up to be notified of new blog entries</h2>
<?php the_field("subscribe"); ?>
</div>

<?php query_posts('posts_per_page=-1'); // "-1" = all posts. or, set to number of posts you want to show ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="blogentry">





  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
 <?php  echo get_excerpt(370); ?>....
<p><a href="<?php the_permalink(); ?>">read more ></a>
  
</div><!-- blogentry -->
<?php endwhile; endif; ?>
 
</div>  

<?php get_footer(); ?>