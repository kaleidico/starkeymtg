<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
	    	<?php if ( function_exists('yoast_breadcrumb') ) {
	  yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	} ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
    	    		<h1><?php single_cat_title( '', true ); ?></h1>

			<div class="cat-description content">
				<?php echo category_description(); ?>
			</div>
    		</div>
	</div>

	<div class="row center more-bottom-margin">
		<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<a href="<?php the_permalink(); ?>">
	        		<div class="content loop-item" data-equalizer-watch>
	            			<div class="loop-thumbnail">
	                			<?php $cat_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );  echo $cat_thumbnail; ?>
					</div>
	            		</div>
	            		<div class="loop-title">
	                		<h2><?php the_title(); ?></h2>
	            		</div>
		     		<div class="loop-cat-description calc-desc">
					<h3><?php $postid = $wp_query->post->ID; echo get_post_meta($postid, 'Calculator Description', true); ?></h3>
		     		</div>
	        	</a>
		</div>

<?php
	} // end while
} // end if
?>
	</div>
</div>

<?php get_footer(); ?>
