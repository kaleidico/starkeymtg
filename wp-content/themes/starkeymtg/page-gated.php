<?php
/*
Template Name: Gated Page
*/
?>
<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">

    <h1><?php the_title(); ?></h1>
    		</div>
	</div>

    <?php if(!is_user_logged_in()) { ?>

	<div class="row">
		<div class="col-xs-12 col-md-9">
	Sorry to interrupt the process, but things are about to get real.

	We need to collect more sensitive data, which means we need to add a little security. Take a quick moment to login (or register, if you haven't been here before) and we can get you finished up.

		</div>
		<div class="col-xs-12 col-md-3">
			<img src="<?php bloginfo('siteurl'); ?>/wp-content/uploads/avatar-purchase.png" alt="Purchase" width="404" height="472" class="aligncenter size-full wp-image-12881" />
		</div>
	</div>

	<hr>

    	<div class="row">
        	<div class="col-xs-12 col-md-6">
				<h2 class="no-top-margin">Login</h2>
				<div class="upme-description">If you've been here before, just login</div>
                <?php echo do_shortcode('[upme_login redirect_to=" ' . get_permalink() . '"]'); ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <h2 class="no-top-margin">Register</h2>
				<div class="upme-description">If you're new, go ahead and register</div>
    			<?php echo do_shortcode('[upme_registration redirect_to=" ' . get_permalink() . '"]'); ?>
            </div>
        </div>
	<?php } else { ?>
    	<?php the_content(); ?>
    <?php }; ?>
    		</div>
   	</div>
</div>

<?php get_footer(); ?>
