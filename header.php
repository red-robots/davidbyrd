<!DOCTYPE html>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name="viewport" content="width=device-width" />

<?php 


if( isset($_GET['page']) && $_GET['page'] === 'gf_activation' ) { ?>
<title>Activation</title>
<?php } else { ?>
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />



<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/colorbox.css" />





<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>















<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,700' rel='stylesheet' type='text/css'>



<link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>



<?php wp_head(); ?>





<!-- nav -->



<script type="text/javascript" language="JavaScript"><!--

function HideContent(d) {

document.getElementById(d).style.display = "none";

}

function ShowContent(d) {

document.getElementById(d).style.display = "block";

}

function ReverseDisplay(d) {

if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }

else { document.getElementById(d).style.display = "none"; }

}

//--></script>



<!-- nav -->



<?php the_field('google_analytics', 'option'); ?>



</head>



<body <?php body_class(); ?>>









<div id="main-header">



<div id="header">



    

    

    <div id="header-content">

    

   

 <div id="header-content1-wrapper">   

<div id="header-content1">





<div class="social-icon"><a href="https://www.youtube.com/user/davidbyrdconsulting/" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/youtube.jpg" alt="" border="0"></a></div>

<div class="social-icon"><a href="https://www.linkedin.com/company/david-byrd-consulting" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/linkedin.jpg" alt="" border="0"></a></div>

<div class="social-icon"><a href="https://www.facebook.com/DavidByrdConsulting" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/facebook.jpg" alt="" border="0"></a></div>

<div class="social-icon"><a href="https://twitter.com/davidbyrdtweets" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/twitter.jpg" alt="" border="0"></a></div>

<div class="social-icon" style="margin-right: 3px;"><a href="http://davidbyrdconsulting.com/golden-key-earner-log-in"><img src="<?php bloginfo('template_url'); ?>/images/golden-key-icon.png" alt="" border="0"></a></div>

<?php $button_link = get_field("header_button_link","option");
$button_text = get_field("header_button_text","option");
if($button_link&&$button_text):?>
    <div class="social-icon digital-vault" style="margin-right: 3px;"><a href="<?php echo $button_link;?>"><?php echo $button_text;?></a></div>
<?php endif;?>
<?php 
$button_link = get_field("header_button_link_2","option");
$button_text = get_field("header_button_text_2","option");
$button_text_logout = get_field("header_button_text_logout_2","option");
if($button_link):?>
    <div class="social-icon digital-vault" style="margin-right: 3px;"><a href="<?php if(!is_user_logged_in()): echo $button_link; else: echo wp_logout_url($button_link); endif;?>"><?php if($button_text&&!is_user_logged_in()): echo $button_text; elseif($button_text_logout&&is_user_logged_in()): echo $button_text_logout; endif;?></a></div>
<?php endif;?>
</div>

</div> 



    </div><!-- #logo -->    

 

 

 

<div id="header1">



<div id="logo">

    <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/david-byrd-consulting.png" alt="" border="0"></a> 

    </div><!-- #logo -->

    

<div id="navigation">



      <nav id="access" role="navigation">

				<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

			</nav>

    </div><!-- / navigation -->

    

</div><!-- / header1 -->

 

    

    

    </div>

    

   <!-- #navigation -->

    

    

    

    



    

    

    

    

<div id="mobile-navigation">



<a href="javascript:ReverseDisplay('uniquename')"> 

Menu &nbsp;&nbsp;&nbsp; <img src="<?php bloginfo('template_url'); ?>/images/down-arrow.png" alt="" border="0">

</a>



<div id="uniquename" style="display:none;">

<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>       

</div>



      

    </div><!-- #navigation -->    

    

    

<div class="clear"></div>

    

    </div>

    

    

    

    

  