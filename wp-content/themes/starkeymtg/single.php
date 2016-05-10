<?php
/**
 * The template for displaying any single post.
 *
 */
get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
		    	<?php if ( function_exists('yoast_breadcrumb') ) {
		  yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		} ?>
		<h1><?php the_title(); ?></h1>
    		</div>
	</div>

	<div class="row more-bottom-margin">
			<div class="col-xs-12">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
			</div>

<?php endwhile; endif; ?>
	</div>
</div>

<?php get_footer(); ?>
