<?php if(!is_user_logged_in()) { ?>
	<a href="<?php bloginfo('url');?>/profile" class="upme-login" data-id="login">Login</a>
<?php }?>

<?php if(is_user_logged_in()) { ?>
<a href="<?php bloginfo('url');?>/profile">
	<?php
	
		if(get_field('profile_pic','user_'.$current_user->ID)){
		$img_obj = wp_get_attachment_image( get_field('profile_pic','user_'.$current_user->ID, false), array(32,32));
		print_r($img_obj);
	} else
	echo get_avatar( $current_user->ID, 32 );
	echo "Hello" . $current_user->user_firstname . " " . $current_user->user_lastname; ?>
</a>
<?php }; ?>