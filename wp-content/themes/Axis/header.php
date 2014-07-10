<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.shutter.css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<?php 
	wp_enqueue_script('jquery');
	wp_enqueue_script('effects', get_stylesheet_directory_uri() .'/js/effects.js');
	wp_enqueue_script('superfish', get_stylesheet_directory_uri() .'/js/superfish.js'); 
	wp_enqueue_script('supersized', get_stylesheet_directory_uri() .'/js/supersized.3.2.7.js'); 	
	wp_enqueue_script('easing', get_stylesheet_directory_uri() .'/js/jquery.easing.min.js'); 	
	wp_enqueue_script('shutter', get_stylesheet_directory_uri() .'/js/supersized.shutter.js'); 		
	wp_enqueue_script('backstretch', get_stylesheet_directory_uri() .'/js/jquery.backstretch.min.js'); 	
?>

<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>


<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>

<?php if ( is_front_page() ) { ?>

<script type="text/javascript">
   jQuery(function ($) {

      $.supersized({

         // Functionality
         slideshow: 1,
         // Slideshow on/off
         autoplay: 1,
         // Slideshow starts playing automatically
         start_slide: 1,
         // Start slide (0 is random)
         stop_loop: 0,
         // Pauses slideshow on last slide
         random: 0,
         // Randomize slide order (Ignores start slide)
         slide_interval: 3000,
         // Length between transitions
         transition: <?php echo get_option('axis_effect'); ?>,
         // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
         transition_speed: <?php echo get_option('axis_speed'); ?>,
         // Speed of transition
         new_window: 1,
         // Image links open in new window/tab
         pause_hover: 0,
         // Pause slideshow on hover
         keyboard_nav: 1,
         // Keyboard navigation on/off
         performance: 1,
         // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
         image_protect: 1,
         // Disables image dragging and right click with Javascript
         // Size & Position						   
         min_width: 0,
         // Min width allowed (in pixels)
         min_height: 0,
         // Min height allowed (in pixels)
         vertical_center: 1,
         // Vertically center background
         horizontal_center: 1,
         // Horizontally center background
         fit_always: 0,
         // Image will never exceed browser width or height (Ignores min. dimensions)
         fit_portrait: 1,
         // Portrait images will not exceed browser height
         fit_landscape: 0,
         // Landscape images will not exceed browser width
         // Components							
         slide_links: 'blank',
         // Individual links for each slide (Options: false, 'num', 'name', 'blank')
         thumb_links: 1,
         // Individual thumb links for each slide
         thumbnail_navigation: 1,
         // Thumbnail navigation
         slides: [ // Slideshow Images

         <?php
         // The Query
         query_posts('post_type=slides&posts_per_page=-1');
         $i = 0;
         while (have_posts()): the_post();
         $simg = get_post_meta($post->ID, 'wtf_slide', true);
         $nimg = get_the_title();
         $cimg = get_the_content(); 
         if ($i>0): echo ','; else: echo ''; endif; //For IE sake add a coma BEFORE every image offsetting the first one.
         echo "{image : '".$simg."',title : '".$nimg."',desc : '".$cimg."'}";
         $i++;
         endwhile;
         wp_reset_query(); ?>
         ],

         // Theme Options			   
         progress_bar: 1,
         // Timer for each slide							
         mouse_scrub: 0

      });
   });
</script>

<?php } else { ?>
<script type="text/javascript">
jQuery.backstretch("<?php if ( is_singular( 'post' )  ) { 
get_image_url();
} else {
 $default = get_option('axis_default'); echo $default;
}
?> ");
</script>
<?php } ?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">  <!-- wrapper begin -->
<div id="masthead"><!-- masthead begin -->
	<div id="top"> 
		<div id="blogname">	
			<h1><a href="<?php bloginfo('siteurl');?>/" title="<?php bloginfo('name');?>"><?php bloginfo('name');?></a></h1>
		</div>
		<div id="botmenu">
		<?php wp_nav_menu( array( 'container_id' => 'submenu', 'theme_location' => 'primary','menu_class'=>'sfmenu','fallback_cb'=> 'fallbackmenu' ) ); ?>
	</div>
	</div>

</div><!--end masthead-->

<div id="casing">