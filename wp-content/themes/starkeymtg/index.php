<?php get_header(); ?>

<div class="push"></div>

	<div class="row">
    	<div class="column">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
	<h2 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
							
		<div class="content">
			<?php the_excerpt( 'Read More...' ); ?>
								
			<?php wp_link_pages(); ?>
		</div>

	<?php endwhile; ?>
					
		<div class="pagination">
			<div class="past-page"><?php previous_posts_link( 'newer' ); ?></div>
			<div class="next-page"><?php next_posts_link( 'older' ); ?></div>
		</div>

<?php endif; ?>
		</div>
	</div>
				
<?php get_footer(); ?>