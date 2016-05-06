<?php
/*
Template Name: Products Page
*/
?>
<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>Our Products</h2>

			<p>We don’t want to sound like a broken record, but these aren’t products so much as mortgage options. We call them products because, well, you buy them… eventually. These are the most popular among current Starkey Mortgage users. They’ll change when you fill out our short form to get started.</p>

			<p>Browse our most popular mortgages to get a better sense of the marketplace, and when you’re ready, finding the path to your perfect mortgage starts with only a few questions.</p>

			<p class="center more-bottom-margin"><a class="btn btn-lg btn-primary" href="<?php bloginfo('siteurl'); ?>/pre-approval">Get Pre-Approved</a></p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php echo do_shortcode('[ldf_products]'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 more-bottom-margin">
			<?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
