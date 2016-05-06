<div class="row header-row-1">
		<div class="standard-logo column small-12 large-3 small-medium-centered">
        	<a href="<?php bloginfo('siteurl'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/lenderful-logo.png" alt="<?php bloginfo('name'); ?>"></a>
        </div>
        <div class="column small-12 large-6 small-medium-centered">
        
        	<?php
				$my_postid_header_top_contact = 12888; //This is page id or post id
				$content_post = get_post($my_postid_header_top_contact);
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>

        </div>
        <div class="standard-profile column small-12 large-3 small-medium-centered large-right">
        		<div class="header-upme">
             	
                	<?php if(!is_user_logged_in()) { ?><a href="<?php bloginfo('url');?>/profile" class="upme-login" data-id="login">Login</a><?php }?>
					<?php if(is_user_logged_in()) { ?>
						<a href="<?php bloginfo('url');?>/profile">
							<?php
							if(get_field('profile_pic','user_'.$current_user->ID)){
								$img_obj = wp_get_attachment_image( get_field('profile_pic','user_'.$current_user->ID, false), array(32,32));
								print_r($img_obj);
							}
							else
							
							$current_user = wp_get_current_user();
								// echo get_avatar( $current_user->ID, 32 );
							?><span class="upme-text"><?php echo "Hello " . $current_user->user_firstname . "!"; ?> | <a href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a></span>
						</a>
                		<?php };
							?>
                </div>
        </div>     	
    </div>

<div class="row header-row-2">
	<nav class="standard-nav column small-12 small-medium-centered" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'Header Navigation' ) ); // Display the user-defined menu in Appearance > Menus ?>
	</nav>
</div> 
