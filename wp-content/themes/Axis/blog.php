<?php
/*
	Template Name: Blog
*/
?>
<?php get_header(); ?>

<div id="content">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('paged='.$paged);
?>
<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>	

<div class="post clearfix" id="post-<?php the_ID(); ?>">
<div class="comm"><?php comments_popup_link('0', '1', '%'); ?></div>
<div class="title">
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
</div>
<div class="postmeta">
	<span class="author">Posted by <?php the_author_link(); ?>  </span> - <span class="clock">  <?php the_time('M - j - Y'); ?></span>
</div>

<div class="entry">
<a href="<?php the_permalink() ?>"><img class="postimg" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&amp;h=250&amp;w=620&amp;zc=1" alt=""/></a>
<?php wpe_excerpt('wpe_excerptlength_index', ''); ?>
<div class="clear"></div>
</div>
<div class="singleinfo">
<span class="categori">Categories: <?php the_category(', '); ?> </span>
</div>
</div>

<?php endwhile; ?>

<div class="clear"></div>

<?php getpagenavi(); ?>

<?php $wp_query = null; $wp_query = $temp;?>
     
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>