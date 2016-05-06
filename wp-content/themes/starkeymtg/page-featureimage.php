<?php
/*
Template Name: Page with Feature Image
*/
?>

<?php get_header(); ?>
<div class="feature-image-container" style="background: url('<?php $featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $featured_image ?>') no-repeat center center; height: 400px; width: 100%; background-size: cover; position: relative;">
	<div class="feature-image-content">
    	<h1><?php the_title(); ?></h1>
    </div>
</div>

<div class="row">
	<div class="column content push-down">
    	<?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
    </div>
</div>

<?php get_footer(); ?>