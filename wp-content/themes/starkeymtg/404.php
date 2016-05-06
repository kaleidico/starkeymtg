<?php get_header(); ?>

<div class="container more-bottom-margin">
	<div class="row">
		<div class="col-xs-12">
	<center><img src="<?php echo get_template_directory_uri(); ?>/img/404.png" alt="404 - Page Not Found" /></center>
			
	<h1>404 - Page Not Found</h1>
			
	<p>Sorry, the page you are looking for cannot be found.  Try a list of these categories below.</p>
			
	<?php
		$args = array(
			'orderby' => 'name',
			'parent' => 0
		);
		$categories = get_categories( $args );
		foreach ( $categories as $category ) {
			echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a><br/>';
		};
	?>

	<p class="more-top-margin">Still not what you're looking for?  Try searching our site instead.</p>

	<form role="search" method="get" id="searchform" class="searchform more-top-margin" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div>
			<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
			<input type="submit" id="searchsubmit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
		</div>
	</form>
		</div>
	</div>
</div>

<?php get_footer(); ?>