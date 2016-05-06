<?php get_header(); ?>

<div class="container more-bottom-margin">
	<div class="row">
		<div class="col-xs-12">
    			<h1><?php the_title(); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
		</div>
    	</div>
</div>

<?php get_footer(); ?>
