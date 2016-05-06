<?php
/*
Template Name: About Lenderful Template
*/
?>

<?php get_header(); ?>

<!-- BEGIN ABOUT HERO SECTION -->
<div class="about-hero">
	<div class="container">
		<div class="row more-bottom-margin">
			<div class="col-xs-12">
				<h1 style="text-align: center;">Why Lenderful?</h1>
			</div>
		</div>
    		<div class="row">
			<div class="col-xs-12 col-md-5">
				<p class="larger-font">Let's be honest, buying a mortgage isn't rocket science, or at least it shouldn't be. But, traditional mortgage companies want you to think it's complicated so they can push you into the loan they want. <strong>At Lenderful, we believe it's time you were in control.</strong></p>

				<p class="center"><a href="<?php bloginfo('siteurl'); ?>/pre-approval/" class="btn btn-primary green-gradient btn-lg caps">Get Pre-Approved</a></p>
			</div>
			<div class="col-xs-12 col-md-7 more-bottom-padding">
				<iframe src="https://player.vimeo.com/video/154783492" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
<!-- END ABOUT HERO SECTION -->
<!-- BEGIN ABOUT CONTENT SECTION -->
<div class="container more-bottom-margin">
	<div class="row">
		<div class="col-xs-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
		</div>
	</div>
</div>
<!-- END ABOUT CONTENT SECTION -->
<!-- BEGIN ABOUT BLUE SECTION -->
<div class="blue-section more-bottom-margin more-bottom-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h3>Knowing who you are is key to serving you best.</h3>

				<p>At Lenderful we want you to be in control and we want your mortgage options to be tailored specifically to you. To better understand what you need, and what is unique about your financial position and personal goals, we want to get to know you so we can serve you better. Keep this in mind when it comes time to finish filling out those forms.</p>
			</div>
		</div>
	</div>
</div>
<!-- END ABOUT BLUE SECTION -->
<!-- BEGIN ABOUT CATEGORY QUERY SECTION -->
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h3>We believe education is essential.</h3>

			<p>Most mortgage companies want to steer you toward a mortgage option that is best for them. At Lenderful, we want to empower you to make decisions that help you get the mortgage you need. It is because of this that we believe education is essential. The more you understand, the better decisions you will make, and the more comfortable and in control you will feel. In our Learning Center we’ll give it to you straight, helping you understand all the variables and nuances of the mortgage process so you can become the expert. New content becomes available often so stay tuned or even ask a Lenderful expert if you have a question that’s not answered there.</p>

			<p><strong>Questions? <a href="javascript:$zopim.livechat.window.show()">Chat Live</a> with an expert.</strong></p>

			<div class="center more-bottom-margin">
				<div class="btn-group" role="group" aria-label="Basic example">
	  				<a href="<?php bloginfo('siteurl'); ?>/learning-center/" class="btn btn-primary blue-gradient">Learning Center</a>
	  				<a href="<?php bloginfo('siteurl'); ?>/pre-approval/" class="btn btn-primary green-gradient">Get Pre-Approved</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END ABOUT CATEGORY QUERY SECTION -->

<?php get_footer(); ?>
