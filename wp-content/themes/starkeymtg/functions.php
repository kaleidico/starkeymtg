<?php
/* ------------------ DO NOT EDIT BELOW THIS LINE ------------------ */
define( 'WP_TEMPLATE_VERSION', 2.0 );

add_theme_support( 'automatic-feed-links' );

function wp_template_scripts()  {
	wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'wp_template_scripts' );

add_theme_support( 'post-thumbnails' );

add_filter('default_hidden_meta_boxes', 'be_hidden_meta_boxes', 10, 2);
function be_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// removed 'postcustom',
	return $hidden;
}
/* ------------------ DO NOT EDIT ABOVE THIS LINE ------------------ */


include (TEMPLATEPATH . '/inc/bootstrap-nav.php');
include (TEMPLATEPATH . '/inc/bootstrap-gf.php');


/* REGISTER NAV MENUS */
register_nav_menus(
	array(
		'Header Navigation'	=>	__( 'Header Navigation', 'wp_template' ), // Register the Primary menu
		'Footer Navigation'	=>	__( 'Footer Navigation', 'wp_template' ), // Register the Primary menu
		// Copy and paste the line above right here if you want to make another menu,
		// just change the 'primary' to another name
	)
);


/* REGISTER SIDEBARS */
function wp_template_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'The sidebar', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
	 ));
	 register_sidebar(array(				// Start a series of sidebars to
		'id' => 'mortgage-calculators-sidebar', 					// Make an ID
		'name' => 'Mortgage Calculators Sidebar',				// Name it
		'description' => 'The sidebar for Mortgage Calculator single posts.', // Dumb description for the admin side
		'before_widget' => '<div class="mortgage-calculators-sidebar">',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}
add_action( 'widgets_init', 'wp_template_register_sidebars' );


/* ADD MORE IMAGE SIZES */
	// add_image_size( 'image-size-name-here', 640, 480, true );
// Copy and paste the line above and add more to add more image sizes.


/* HEADER SCRIPTS */
function wp_template_header_scripts() { ?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css" media="print">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/flickity.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/gravityforms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/responsivetables.css">




<?php $domain = $_SERVER['SERVER_NAME']; if ($domain != "lenderfulpreview.com") { ?>
	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','//connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1619651084965778');
	fbq('track', "PageView");</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1619651084965778&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->

	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-70221901-1', 'auto');
		  ga('send', 'pageview');
	</script>

	<script type="text/javascript">
		setTimeout(function(){var a=document.createElement("script");
		var b=document.getElementsByTagName("script")[0];
		a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0018/2112.js?"+Math.floor(new Date().getTime()/3600000);
		a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>
<?php }; ?>

<?php } add_action('wp_head','wp_template_header_scripts');




/* FOOTER SCRIPTS */
function wp_template_footer_scripts() { ?>

 <script src="<?php echo get_template_directory_uri(); ?>/js/fluidvids.js"></script>
 <script>
    fluidvids.init({
  selector: ['iframe', 'object'], // runs querySelectorAll()
  players: ['www.youtube.com', 'player.vimeo.com'] // players to support
});
</script>

<script>
$('#datatable').DataTable( {
	ordering:  false
} );
</script>

<script>
	$(".gf_page_steps").replaceWith($(".gf_page_steps").replace(' ',''));
</script>

<script>
function format(input)
{
    var nStr = input.value + '';
    nStr = nStr.replace( /\,/g, "");
    var x = nStr.split( '.' );
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while ( rgx.test(x1) ) {
        x1 = x1.replace( rgx, '$1' + ',' + '$2' );
    }
    input.value = x1 + x2;
}
</script>


<!-- Show/Hide Loan Details -->
<?php if(is_page(array(2,16,12923,12969))) { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){

$('.hide-button').hide();
$('.tg-more-details').hide();
$('.flickity-viewport').height(370);
$('.show-button').click(function(){
	$(".tg-more-details").slideToggle( "slow" );
	$( ".show-button" ).hide();
	$(".hide-button").show();
	$('.flickity-viewport').height(480);
});
$('.hide-button').click(function(){
	$(".tg-more-details").slideToggle( "slow" );
	$( ".hide-button" ).hide();
	$(".show-button").show();
	$('.flickity-viewport').height(370);
});
});
</script>
<?php } else { }; ?>


<?php $domain = $_SERVER['SERVER_NAME']; if ($domain != "lenderfulpreview.com") { ?>
<!-- Google Code for Remarketing Tag -->
<!--
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
-->
<div class="hidden-xs hidden-sm hidden-md hidden-lg">
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 958243180;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:none;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/958243180/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</div>
<?php }; ?>

<script>
(function() {
  /**
   * Video element
   * @type {HTMLElement}
   */
  var video = document.getElementById("lenderful-hero-video");

  /**
   * Check if video can play, and play it
   */
  video.addEventListener( "canplay", function() {
    video.play();
  });
})();
</script>


	<!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
		$.src="//v2.zopim.com/?3iFjZi3kLmIhGerx4G962P0UWLOYMdKo";z.t=+new Date;$.
		type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
		</script>
	<!--End of Zopim Live Chat Script-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/flickity.min.js"></script>

<?php } add_action('wp_footer','wp_template_footer_scripts');

// Add custom styles to Visual Editor
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

    $style_formats = array(
array(
    'title' => 'Blue Button',
    'selector' => 'a',
    'classes' => 'button blue'
    )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

add_action( 'admin_init', 'add_my_editor_style' );

function add_my_editor_style() {
add_editor_style();
}

add_action("gform_post_submission_8", "lenderful_send_confirm_email", 10, 2);

function lenderful_send_confirm_email($entry) {

$body=$entry["1"];
$username=$entry["2"];
$subject=$entry["3"];


$un=$username;
$su=$subject;



$api_endpoint="http://ec2-52-23-201-115.compute-1.amazonaws.com:9090/api/users/confirm/";
$api_endpoint.=$un;
$api_endpoint.="?subject=";
$api_endpoint.=$su;

echo "<br/>";
echo "api end:<br/>";
echo $api_endpoint;
echo "<br/>";
echo "<br/>";
echo "<br/>";


$gtoken='02323e21-ece5-40a8-92f4-c566a4630f6f';

$token_string="Authorization: Bearer ".$gtoken;




$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $api_endpoint, //URL to the API
    CURLOPT_POST => true,
    CURLOPT_HEADER => true, // Instead of the "-i" flag
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain','Accept: application/json',$token_string) //Your New Relic API key

));


curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);



$resp = curl_exec($curl);

$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


curl_close($curl);


// put in second variable
$gman_resp=$resp;


// extract array string from response

$pos = strpos($gman_resp, "{");

$gresp2=substr($gman_resp,$pos);


// decode into array
$gresp3=json_decode($gresp2, true);

?>

<?php

$gresp4=json_decode($gman_resp, true);

echo $gresp4;

print_r($gresp3);
echo "<br/>";
echo "<br/>";
echo "Response code is: ".$code."<br/>";
echo "<br/>";



echo "<br/>";
echo "Just seeing if this function will trigger and echo this when we submit the form";
echo "<br/>";
echo "username: ".$username."<br/>";
echo "<br/>";
echo "subject: ".$subject."<br/>";
echo "<br/>";
echo "body: ".$body."<br/>";
echo "<br/>";
echo "<br/>";

}

/*

function lenderful_test1($entry) {

$body=$entry["1"];
$username=$entry["2"];
$email=$entry["3"];
echo "<br/>";
echo "Just seeing if this function will trigger and echo this when we submit the form";
echo "<br/>";
echo "username: ".$username."<br/>";
echo "<br/>";
echo "email: ".$email."<br/>";
echo "<br/>";
echo "body: ".$body."<br/>";
echo "<br/>";
echo "<br/>";

}
*/

add_action("gform_post_submission_9", "lenderful_create_api_user", 10, 2);

function lenderful_create_api_user($entry) {

$username=$entry["2"];
$password=$entry["3"];



$data = array(
    'username' => $username,
    'password' => $password,
);



$data = http_build_query($data); // convert array to urlencoded string


$gtoken='02323e21-ece5-40a8-92f4-c566a4630f6f';

$token_string="Authorization: Bearer ".$gtoken;


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://ec2-52-23-201-115.compute-1.amazonaws.com:9090/api/users', //URL to the API
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HEADER => true, // Instead of the "-i" flag
    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded','Accept: application/json',$token_string) //Your New Relic API key

));


curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);



$resp = curl_exec($curl);

$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


curl_close($curl);






// put in second variable
$gman_resp=$resp;






// extract array string from response

$pos = strpos($gman_resp, "{");

/*
echo "<br/>".$pos;
*/
$gresp2=substr($gman_resp,$pos);




// decode into array
$gresp3=json_decode($gresp2, true);

?>

<?php

$gresp4=json_decode($gman_resp, true);

echo $gresp4;

print_r($gresp3);
echo "<br/>";
echo "<br/>";
echo "Response code is: ".$code."<br/>";
echo "<br/>";


echo "Password is: ".$password."<br/>";
echo "<br/>";
echo "Username is: ".$username."<br/>";
echo "<br/>";

}



//**********************************************************************
//**********************************************************************
//**********************************************************************
//**********************************************************************
//**********************************************************************



add_action("gform_post_submission_2", "lenderful_short_form", 10, 2);

function lenderful_short_form($entry) {



$buy_refi=$entry["2"];



$to_borrow=$entry["58"];
$home_worth=$entry["57"];
$down_payment=$entry["62"];
$purchase_price=$entry["54"];
$credit=$entry["15"];

/*
echo "I am ...".$buy_refi."<br/>";
echo "to_borrow ...".$to_borrow."<br/>";
echo "home worth ...".$home_worth."<br/>";
echo "down payment ...".$down_payment."<br/>";
echo "purch price ...".$purchase_price."<br/>";
echo "credit ...".$credit."<br/>";
*/
$form_input1[buy_refi]=$buy_refi;
$form_input1[to_borrow]=$to_borrow;
$form_input1[home_worth]=$home_worth;
$form_input1[down_payment]=$down_payment;
$form_input1[purchase_price]=$purchase_price;
$form_input1[credit]=$credit;






$implode_entries=implode("|",$form_input1);

/*
echo "<br/>";
echo "<br/>";
echo $implode_entries;
echo "<br/>";
echo "<br/>";
*/
//$implode_options=implode("|",$option_array);

//$options_array=explode('|',$options_string,99);

//echo do_shortcode( "[playoff-input quote='Asteroids dont concerne me admiral!' author='David Prowse']" );

/*
echo do_shortcode( "[playoff-input quote='<?php echo $att_quote; ?>' author='<?php echo $att_author; ?>']" );
*/


echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');

}

add_action( 'gform_after_submission', 'load_intosessionvar_and_redirect', 10, 2 );
function load_intosessionvar_and_redirect( $entry, $form ) {

	session_start();

	$entry_id=rgar( $entry, 'id' );
	$form_id=rgar( $entry, 'form_id' );

	$_SESSION['entry_id']=$entry_id;



	if ($form_id==26) {


printf("<script>location.href='/purchase-options/'</script>");

	}

	if ($form_id==25) {


printf("<script>location.href='/refinance-options/'</script>");

	}


    /*
    $post_url = 'http://www.lenderful.dev/agtest1';
    $body = array(
        'form_id1' => rgar( $entry, 'form_id' ),
        'purchase_price' => rgar( $entry, '54' ),
        );

    $request = new WP_Http();
    $response = $request->post( $post_url, array( 'body' => $body ) );
    */
}

add_filter( 'gform_currencies', 'update_currency' );
function update_currency( $currencies ) {
$currencies['USD'] = array(
'name' => __( 'U.S. Dollar', 'gravityforms' ),
'symbol_left' => '$',
'symbol_right' => '',
'symbol_padding' => ' ',
'thousand_separator' => ',',
'decimal_separator' => '.',
'decimals' => 0
);

return $currencies;
}