<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<script src="https://cdn.optimizely.com/js/302824939.js"></script>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<script src="<?php echo get_template_directory_uri(); ?>/js/header-popout.js"></script>

<?php
//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone || $iPad || $Android || $webOS ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/mobile.css">
<?php } else { }; ?>

<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('siteurl'); ?>/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="<?php bloginfo('siteurl'); ?>/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php bloginfo('siteurl'); ?>/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="<?php bloginfo('siteurl'); ?>/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="<?php bloginfo('siteurl'); ?>/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="<?php bloginfo('siteurl'); ?>/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?php bloginfo('siteurl'); ?>/manifest.json">
<link rel="mask-icon" href="<?php bloginfo('siteurl'); ?>/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="<?php bloginfo('siteurl'); ?>/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php if(!is_page_template( 'page-landing.php')) { ?>
<header class="mobile-center">
	<div class="container">
		<div class="row header-row-1">
			<div class="col-xs-12 col-sm-3 col-md-3 more-bottom-margin xs-center md-left">
				<a href="<?php bloginfo('siteurl'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/starkey-logo.png" alt="<?php bloginfo('name'); ?>"></a>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-2 more-bottom-margin">
				<div class="header-cta center">
					<a href="tel:8665995510"><div class="fa fa-phone"></div> (866) 599-5510</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-2 more-bottom-margin">
				<div class="header-cta center">
					<a href="javascript:$zopim.livechat.window.show()"><div class="fa fa-comments"></div> Let's Chat</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-2 more-bottom-margin">
				<div class="header-cta center">
					<a href="<?php bloginfo('url');?>/mortgage-application/"><div class="fa fa-check"></div> Apply Now</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 xs-center md-right more-bottom-margin">
				<div class="header-btn">
					<a href="pre-approval/"><button class="btn btn-primary"><span class="fa fa-icon fa-file-o more-right"></span> PreQualify Online</button></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row header-row-2">
		<div class="container">
			<nav class="hidden-xs hidden-sm desktop-nav col-xs-12" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'Header Navigation' ) ); // Display the user-defined menu in Appearance > Menus ?>
			</nav>
			<div class="hidden-md hidden-lg col-xs-12">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
		                <!-- Brand and toggle get grouped for better mobile display -->
		                <div class="navbar-header">
		                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		                    <span class="sr-only">Toggle navigation</span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                  </button>
		                </div>

	                    <?php
	                        wp_nav_menu( array(
	                            'menu'              => 'Header Navigation',
	                            'theme_location'    => 'Header Navigation',
	                            'depth'             => 2,
	                            'container'         => 'div',
	                            'container_class'   => 'collapse navbar-collapse',
	                    'container_id'      => 'bs-example-navbar-collapse-1',
	                            'menu_class'        => 'nav navbar-nav',
	                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	                            'walker'            => new wp_bootstrap_navwalker())
	                        );
	                    ?>
	     		</div>
				</nav>
			</div>
		</div>
	</div>
</header>
	<?php }; ?>
