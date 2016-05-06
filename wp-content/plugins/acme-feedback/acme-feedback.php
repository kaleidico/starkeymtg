<?php 
/*
	Plugin Name: ACME Feedback
	Plugin URI:  http://www.acmefeedback.com
	Description: ACME Feedback is a survey tool which helps you gather feedback from your visitors.  You can also use the plugin to display widgets on popup as well as optin forms and video.
	Version:     1.92
	Author:      WPUnite
	Author URI:  mailto:support@wpunite.com
	Copyright:   Code and text Copyright (c) 2015 WPUnite. All Rights Reserved.
*/ 
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://acmefeedback.com/dlafb/info.json',
    __FILE__
);
error_reporting(E_ERROR);
define('ACMEAFF_MAX_QUESTIONS', 5);
define('EMAIL_TEMPLATE', "Here is some feedback from your website:<br><br>Who: {WHO}<br>When: {WHEN}<br><br> {QUESTIONAREA}<br><br>Thanks for using ACME Feedback<br>Visit http://acmefeedback.com/products for more of our products.");
define('AF_LOGIN_URL', 'http://acmefeedback.com/?loginacmefeedback=1');
add_action('admin_menu', 'acmefeedback_menu');
register_activation_hook(__FILE__ , 'acmefeedback_install');
register_uninstall_hook( __FILE__, 'acmefeedback_uninstall');
add_filter("plugin_action_links_acme-feedback/acme-feedback.php","acmefeedback_addsets");
add_action('wp_footer', 'acmefeedback_popup',9999);
add_action('template_redirect', 'acmefeedback_jquery');
add_action('init', 'acmefeedback_ajax');
add_action('admin_init', 'acmefeedback_previewp');
function acmefeedback_previewp(){
	if ($_GET['page'] == 'acmefeedbackp'){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_style('wp-jquery-ui-dialog');
		//wp_enqueue_style('jquery-style', get_bloginfo('url').'/wp-content/plugins/acme-feedback/jquery-ui.css');
		echo "<html><head>";
		wp_head();
		echo "
		<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".get_bloginfo( 'stylesheet_url' )."\" />
		<script type='text/javascript' src='".get_bloginfo('url')."/wp-content/plugins/acme-feedback/js/jquery.ui.core.min.js'></script>
		<script type='text/javascript' src='".get_bloginfo('url')."/wp-content/plugins/acme-feedback/js/jquery.ui.widget.min.js'></script>
		<script type='text/javascript' src='".get_bloginfo('url')."/wp-content/plugins/acme-feedback/js/jquery.ui.dialog.min.js'></script>
		</head></body><h1>Popup CAN appear differently in preview mode than on live site.  Use as a reference only.";
		acmefeedback_p();
		echo "</body></html>";
		exit;
	}
}
add_action( 'widgets_init', 'acme_sidebars_load');
function acme_sidebars_load(){
register_sidebar(array(
  'name' => 'Acme Feedback Popup',
  'id' => 'acme-feedback-popup',
  'description' => 'Widgets will be displayed in Feedback Popup.',
  'before_title' => '',
  'after_title' => ''
));
}
add_action( 'admin_init', 'acme_feedback_css' );
function acme_feedback_css() {
	wp_register_style( 'acme_feedback_style', plugins_url('style.css',__FILE__) );
   
}
function acme_feedback_css_style() {
        /* Link our already registered script to a page */
        wp_enqueue_style( 'acme_feedback_style' );
    }
function acmefeedback_ajax(){
	if ($_GET['acmefeedbackpopupjs'] == 1){
		$opts = get_option('acmefeedback_options');	
		if ($opts['tab'] == 'c'){
			$location = $opts['urlt'];
		} else {
			$location = get_bloginfo('url')."/wp-content/plugins/acme-feedback/tabs/$opts[tab]";
		}
		$pos = 1;
		$ordr = 0;
		global $wpdb;
		$qs = $wpdb->get_results("select * from  ".$wpdb->prefix . "acmefb_questions  where active=1 order by ordr asc");
		$questions = "var qtitles = new Array();\r\nvar qbodies = new Array();\r\nvar qflds = new Array();\r\nvar qtypes = new Array();\r\n";
		foreach($qs as $q){
			$qt = str_replace("\r\n"," ",$q->title);
			++$ordr;
			if ($q->qtp == 't'){
				$qb = str_replace("\r\n"," ",addslashes($q->body));
				$qfj = "qflds[$ordr] = \"<br><textarea style=width:400px; rows=7 id=answer name=answer class='qansf'></textarea>\";\r\n";
			} else {
				$qb = addslashes($q->body);
				$list = preg_split("/\n/",$qb);
				if (count($list) < 2){
					$qb = str_replace("\n","",$qb);
					$list = preg_split("/\r/",$qb);
				} else {
					$qb = str_replace("\r","",$qb);
				}
				$qb  = '' ;
				$lst = '<br>';
				foreach($list as $li){
					$li = trim($li);
					$lst .= "<input type=radio name=answer value=\\\"".urlencode($li)."\\\"> $li <br>";
				}
				$qfj = "qflds[$ordr] = \"<br>$lst\";\r\n";
			}
			++$totq;
			$questions .= "qtitles[$ordr] = \"$qt\";\r\nqbodies[$ordr] = \"$qb\";\r\nqtypes[$ordr] = '$q->qtp';\r\n$qfj";
		}
		$affurl = '';
		if ($opts['affurl'])
			$affurl = '<div id=affurl style=\";width:100%;text-align:center\"><a href=\"'.$opts[affurl].'\">Powered By ACME Feedback Plugin</a></div>';
		global $user_ID;
		$showw = 0;	
	if ($opts['exit'] == 'd'){
		$showw = 0;		
	} else if ($opts['exit'] == 'o'){
		$ips = get_transient('acme_feedback_ips');
		if (!$ips[getenv('REMOTE_ADDR')]){
			$showw =1;
			$ips[getenv('REMOTE_ADDR')] = 1;
			delete_transient('acme_feedback_ips');
			set_transient('acme_feedback_ips',$ips,60 * 60 * 24 * 31);
		}	
	} else {
		$showw =1;
	}
	
	if ($opts['skipq']){
		$skipq = ",
						'Skip': function() {
							if (qtypes[acme_qno] == 't'){
								vl = document.getElementById('answer').value;
							} else {
								vl = jQuery('input:radio[name=answer]:checked').val();
							}
							jQuery('#ansr').val(jQuery('#ansr').val()+';;;'+qtitles[acme_qno]+':::<b>Skipped</b>:::'+jQuery('#dadded').val());
							clearTimeout(acme_timeout);
							jQuery('#dadded').val(1);
							acme_seconds = 1;
							acme_timeout = setTimeout('incSeconds();',1000);
							if (acme_qcnt == acme_qno){
								var form_values =jQuery(\".qansf\").serialize( );
								jQuery('#question_container').fadeOut(0);
								jQuery('#question_container').html('Please Wait');
								jQuery('#question_container').fadeIn(100);
								jQuery.post( '".get_option('siteurl')."/index.php', form_values, function(response) {
								if (response.resp != '111'){
									jQuery('#question_container').html('Error during saving.');
								} else {
									var dhtml = jQuery('#thanksdiv').html();
									dhtml = dhtml.replace(/<script/gi,'<scrpt');
									dhtml = dhtml.replace(/<\/script/gi,'<\/scrpt');
									jQuery('#question_container').html(dhtml);
								}
								jQuery( '#acmeuidialog' ).dialog( 'option', 'buttons',  [
								{
									text: 'Close',
									click: function() { jQuery(this).dialog('close');wsc = 0;opened = 0; }
								}
								]);}, 'json');
								return false;
							}
							jQuery('#question_container').fadeOut(0);
							++acme_qno;
							jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
							if (qbodies[acme_qno] != '')
								jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
							if (qflds[acme_qno] != '')
								jQuery('#question_answers_area').html(qflds[acme_qno]);	
							jQuery('#question_container').fadeIn(300);
							jQuery('#answer').focus();
						}
				";
	}
		header ('Content-Type: application/javascript');

		echo "
			document.writeln(\"<input type=hidden name=step value='$pos' class='qansf'>\");
			document.writeln(\"<input type=hidden name=ansr value='' class='qansf' id=ansr>\");
			document.writeln(\"<input type=hidden name=acmesurvey value='1' class='qansf'>\");
			document.writeln(\"".addslashes(str_replace('<input ', "<input class='qansf' ", wp_nonce_field('survey_save', '_wpnonce', true, false)))."\");			
			document.writeln(\"<input type=hidden name=ip value='".getenv(REMOTE_ADDR)."' class='qansf'>\");
			document.writeln(\"<input type=hidden name=start value='".time()."' class='qansf'>\");
			document.writeln(\"<input type=hidden name=uid value='".$user_ID."' class='qansf'>\");
			document.writeln(\"<input type=hidden name=dadded value='' class='qansf' id=dadded>\");
			var acme_tab_pos = '$opts[position]';
			var acme_tab_exit = '$opts[exit]';
			var acme_header_image = '$opts[urlh]';
			var acme_hcolor = '$opts[hcolor]';
			var acme_bcolor = '$opts[bcolor]';
			var acme_bsize = '$opts[bsize]';
			var thankyoujs = '$opts[thankyoujs]';
			var skipq = '$opts[skipq]';
			var affurl = '$affurl';
			var acme_qno = 1;
			var acme_qcnt = $totq;
			var acme_seconds = 0;
			var acme_timeout;
			var bu_color = '$opts[bucolor]';
			var bu_bcolor = '$opts[bubcolor]';
			var showw = $showw;
			$questions
			var counter = 0;
			var mouseIsIn = true;
			function incSeconds(){
				++acme_seconds;
				jQuery('#dadded').val(acme_seconds);
				acme_timeout = setTimeout('incSeconds();',1000);
			}
		
			var wsc = -1;var opened = 0;
			
			function toggleAcmePopup(){
				
				if (opened) return;
				opened = 1;
				acme_qno = 1;
				acme_timeout = setTimeout('incSeconds();',1000);
				if (document.getElementById('ansr'))
					document.getElementById('ansr').value = '';
				jQuery(window).scroll(function() {
					if (wsc >= 0){
							
						jQuery(window).scrollTop(wsc);
					}
				});												var dhtml2 = jQuery('#widget_content').html();				dhtml2 = dhtml2.replace(/<script/gi,'<scrpt');				dhtml2 = dhtml2.replace(/<\/script/gi,'<\/scrpt');				jQuery('#widgets_container').html(dhtml2);	
				document.getElementById('acmeuidialog').style.display = '';
				
				jQuery('#affurl').remove();
	
				if (acme_header_image != ''){
					
					jQuery('#acme_hdr_img').remove();
					jQuery('.ui-widget-header').append('<img id=acme_hdr_img src=\"'+acme_header_image+'\" align=center style=\"margin:0 auto\">');
					jQuery('.ui-widget-header').css('height',jQuery('#acme_hdr_img').attr('height'));
				}
				if (acme_hcolor == '') acme_hcolor = 'white';
				jQuery('.ui-widget-header').css('background',acme_hcolor);
				if ((parseInt(acme_bsize) > 0) && (acme_bcolor != '')){
					jQuery('.ui-dialog').css('border', acme_bsize+'px solid '+acme_bcolor);
				}
				jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
				if (qbodies[acme_qno] != '')
					jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
				if (qflds[acme_qno] != '')
					jQuery('#question_answers_area').html(qflds[acme_qno]);						
				
				jQuery( '#acmeuidialog' ).dialog( 'open' );
				jQuery('#acmeuidialog').parent().css('z-index','900000');	
				jQuery('.ui-button').css('background',bu_bcolor);
				jQuery('.ui-button').css('color',bu_color);
				jQuery('.ui-dialog-buttonpane').parent().append(affurl);
				wsc = jQuery(window).scrollTop();
				return false;
			}
			
		
			var popit = true;
			var showw = $showw;
			
			function putAcmeTab(){
				if (acmetabloaded != 0) return;
				if (jQuery('#acmepopuptab').attr('src') != undefined){
					return;
				}
				
				acmetabloaded = 1;
				
				jQuery('body').bind('mouseleave', function(e) {											
					if (showw && e.clientY <= 1) {
						toggleAcmePopup();
						showw = 0;
					}
				}); 
				
				jQuery(window).resize(function() {
					tp = parseInt(jQuery(window).height() / 2 - jQuery('#acmepopuptab').height() /2);
					jQuery('#acmepopuptab').css('top', tp + 'px') ;
				});
				var tops = '100px';		
				if (acme_tab_pos == 'l'){ pos = 'left'; } else if (acme_tab_pos == 'br') { pos = 'right: 0; bottom'; tops = 'auto'; } else { pos = 'right'; }
	
				if (acme_tab_pos != 'd'){
					jQuery('div:first').append(\"<a href=# id=acme-feedback-btn onclick='javascript:return toggleAcmePopup();'><img  src='$location' id=acmepopuptab style='z-index:5500;position:fixed;top:\"+tops+\";\"+pos+\":0px;' border=0></a>\");
					if (acme_tab_pos != 'br') {
					tp = parseInt(jQuery(window).height() / 2 - jQuery('#acmepopuptab').height() /2);
					document.getElementById('acmepopuptab').style.top = tp + 'px' ;
					}
				}
				if (jQuery('acmeuidialog').is(':data(dialog)')){
     jQuery( '#acmeuidialog' ).dialog('destroy');
    }
	
				jQuery( '#acmeuidialog' ).dialog({
					autoOpen: false,
					height: $opts[ph],
					width: $opts[pw],
					modal: true,
					resizable: false,
					draggable: false,
					buttons: {
						'$opts[butext]': function() {
							if (qtypes[acme_qno] == 't'){
								vl = document.getElementById('answer').value;
							} else {
								vl = jQuery('input:radio[name=answer]:checked').val();
							}
							
							if (vl == '' || vl == undefined) return;
							
							
								jQuery('#ansr').val(jQuery('#ansr').val()+';;;'+qtitles[acme_qno]+':::'+vl+':::'+jQuery('#dadded').val());
								clearTimeout(acme_timeout);
								jQuery('#dadded').val(1);
								acme_seconds = 1;
								acme_timeout = setTimeout('incSeconds();',1000);
								
								if (acme_qcnt == acme_qno){
									var form_values =jQuery('.qansf').serialize( );
									jQuery('#question_container').fadeOut(0);
									jQuery('#question_container').html('Please Wait');
									jQuery('#question_container').fadeIn(100);
									jQuery.post( '".get_option('siteurl')."/index.php', form_values, function(response) {
										if (response.resp != '111'){
												jQuery('#question_container').html('Error during saving.');
										} else {
												var dhtml = jQuery('#thanksdiv').html();
												dhtml = dhtml.replace(/<script/gi,'<scrpt');
												dhtml = dhtml.replace(/<\/script/gi,'<\/scrpt');
												jQuery('#question_container').html(dhtml);
										}
							
										jQuery( '#acmeuidialog' ).dialog( 'option', 'buttons',  [
    {
        text: 'Close',
        click: function() { jQuery(this).dialog('close');wsc = 0;opened = 0; }
    }
									]);}, 'json');
									return false;
								}
								
								jQuery('#question_container').fadeOut(0);
								++acme_qno;
								jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
								if (qbodies[acme_qno] != '')
									jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
								if (qflds[acme_qno] != '')
									jQuery('#question_answers_area').html(qflds[acme_qno]);	
								
								
								jQuery('#question_container').fadeIn(300);
								jQuery('#answer').focus();
						}
						 $skipq
					},
			close: function() {
				wsc = 0;
				clearTimeout(acme_timeout);
				
				jQuery(window).unbind();
				acme_seconds = 0;
				opened = 0;
			}});
			}
			
			var acmetabloaded = 0;
			document.onload =  putAcmeTab();
		";exit;
	}
	if ($_POST['acmesurvey']){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'survey_save' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}	
		$opts = get_option('acmefeedback_options');
		global $wpdb, $user_ID;
		$ansr = serialize(strip_tags($_POST['ansr']));
		$ip = addslashes($_POST['ip']);
		$start = addslashes($_POST['start']);
		$uid = $_POST['uid']?$user_ID:0;
		
		$dadded = $_POST['dadded']?(int) $_POST['dadded']:time();
		$wpdb->query("insert into ".$wpdb->prefix."acmefb_answers set ansr='$ansr', ip='$ip', start='$start', uid = '$uid', dadded='".$dadded."'");
		if ($opts['sendcopy'] and $opts['email']){
			
			$answers = '';
			if ($uid){	
				$usr = get_userdata( $uid);
				$who = $usr->user_login." (IP: ".$ip.")";
			} else {
				$who = "anonymous (IP: ".$ip.")";
			}
		
			
			
			$tpl = EMAIL_TEMPLATE;
			$as = preg_split("/;;;/",unserialize($ansr));
			$qatpl = "<p style=padding-bottom:20px><b>Q:</b> {QUESTION}<br><b>A:</b> {ANSWER}<br><b>T:</b> <i>{TIMEDIFF} seconds</i></p>";	
			foreach($as as $a){
				if (strlen($a) > 3){
					++$cntas;
					$spls = preg_split("/:::/", $a);
					$qatplp = str_replace("{QUESTION}", urldecode($spls[0]),  $qatpl);
					$qatplp = str_replace("{ANSWER}", urldecode($spls[1]),  $qatplp);
					$qatplp = str_replace("{TIMEDIFF}", $spls[2],  $qatplp);
				}
				$qatpls .= $qatplp;
			}
			$tpl = str_replace("{WHEN}", date("Y-m-d H:i:s",$start), $tpl);
			$tpl = str_replace("{QUESTIONAREA}", $qatpls, $tpl);
			$tpl = str_replace("{WHO}", $who, $tpl);
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			add_filter( 'wp_mail_from_name', create_function('', 'return "'.$opts['sender'].'";'));
			$rss = wp_mail($opts['email'], $opts['subj'], $tpl);
		}
		echo json_encode(array('resp' => '111'));
		exit;
	}
}
function acmefeedback_menu(){
	//here we define some global variables containing data of admin menu, registeered hooks and admin pages
	global $menu, $admin_page_hooks, $_registered_pages;
	if ($_GET['page'] == 'acmefeedbackc'){
		wp_enqueue_script('cpick_js',get_bloginfo('url')."/wp-content/plugins/acme-feedback/colorpicker/colorpicker.js");		
		wp_enqueue_style('cpick_css', get_bloginfo('url')."/wp-content/plugins/acme-feedback/colorpicker/colorpicker.css");
	} else 	if ($_GET['page'] == 'acmefeedbackp'){
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('wp-jquery-ui-dialog');
		
		
		//wp_enqueue_style('jquery-style', get_bloginfo('url').'/wp-content/plugins/acme-feedback/jquery-ui.css');
	}
	//The name of the plugin link in dashboard navigation panel
	$menu_title 	= "ACME Feedback";
	//The value of TITLE head tag of plugin page
	$page_title 	= "ACME Feedback";
	//What kind of users can access dashboard. In our case  - starting from subscriber
	$access_level 	= 0;
	//The name of plugin file - used to define hook
	$file     	= 'acmefeedback';
	//What function will be called for menu link
	$function 	= 'acmefeedback';
	//What position it will appear in Dashboard. The more number is the lower it will appear
	$position 	= 1000;
	//add new hook for this plugin to global admin page hooks array
	$admin_page_hooks[$file] = sanitize_title( $menu_title );
	//add new action to link the page hookname and target function
	$hookname = get_plugin_page_hookname( $file, '' );
	
	add_action( $hookname, $function );
	//Next we should found first free positions in menus' array we can use for our menu - in case our set position is used by another page
	do {
		$position++;
	} while ( !empty( $menu[$position] ) );
	
	// In case we want some icon to be showed
	$icon_url  = get_bloginfo('url')."/wp-admin/images/media-button-image.gif";
	//And Update the menu array with new enry containing  all the data we have defined above
	//$menu[$position] = array ( $menu_title, $access_level, $file, $page_title, 'menu-top ' . $hookname, $hookname, $icon_url );
	add_menu_page( $menu_title, $page_title, 'manage_options', 'acmefeedback', 'acmefeedback_s', $icon_url, 100 );
	$_registered_pages[$hookname] = true;
			
	//Adds Settings submenu 			
	$t0 = add_submenu_page( 'acmefeedback','Settings', 'Settings', 'manage_options', 'acmefeedback', 'acmefeedback_s' );
	$t1 = add_submenu_page( 'acmefeedback','Customization', 'Customization', 'manage_options', 'acmefeedbackc', 'acmefeedback_c' );
	$t2 = add_submenu_page( 'acmefeedback','Questions', 'Questions', 'manage_options', 'acmefeedbackq', 'acmefeedback_q' );
	$t3 = add_submenu_page( 'acmefeedback','Results', 'Results', 'manage_options', 'acmefeedbackr', 'acmefeedback_r' );	
	$t4 = add_submenu_page( 'acmefeedback','Preview Form', 'Preview Form', 'manage_options', 'acmefeedbackp', 'acmefeedback_p' );
	add_action('admin_print_scripts-' . $t0, 'acme_feedback_css_style');
	add_action('admin_print_scripts-' . $t1, 'acme_feedback_css_style');
	add_action('admin_print_scripts-' . $t2, 'acme_feedback_css_style');
	add_action('admin_print_scripts-' . $t3, 'acme_feedback_css_style');
	add_action('admin_print_scripts-' . $t4, 'acme_feedback_css_style');
}
function acmefeedback_post_content ($url,$postdata) {
  $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
  $ch = curl_init( $url );
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);
  curl_setopt($ch, CURLOPT_FAILONERROR, 1);
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );
  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  return $header['content'];
}
add_action('init', 'acmefeedback_chkinit');
function acmefeedback_chkinit(){
	$POST = $_POST;	
	$POST['actor'] = get_bloginfo('url');	
	if ($_GET['act'] == 'gologin'){		
	$jsonout =  acmefeedback_post_content(AF_LOGIN_URL,$POST);
	echo $jsonout;		
	exit;	
	}
}
//This function displays navigation tabs of the plugin
function acmefeedback(){ }
function acmefeedback_header($label, $text){
	$active = array();	
	
	/*$current = get_site_transient( 'update_plugins' );
	foreach ($current->response as $k => $resp){
		if (eregi("acme\-feedback",$k)){	
			if ($resp->new_version != AF_VERSION)
				echo "<div id='setting-error-settings_updated' class='updated settings-error'><p style='color:green'><strong>Version $resp->new_version is available! Go to <a href='plugins.php'>Plugin Upgrades</a> page and upgrade ACME Feedback!</strong></p></div>";
			break;
		}
	}	*/
	$active[$label] = 'nav-tab-active';
		echo '<div class="wrap">
			<table><tr><Td><div id="icon-options-general" class="icon32"></div></td><td><h1  style=padding-top:5px>ACME Feedback - '.$text.'</h1></td></tr></table>
			<p>If you need assistance with setting up the plugin visit <a target=blank href=http://acmefeedback.com/setup/>our support page</a></p>
			<div id="nav">
			<h2 class="themes-php">
			<a class="nav-tab '.$active['settings'].'" style="font-size:15px" href="admin.php?page=acmefeedback">Settings</a>
			<a class="nav-tab '.$active['customization'].'" style="font-size:15px" href="admin.php?page=acmefeedbackc">Customization</a>
			<a class="nav-tab '.$active['questions'].'" style="font-size:15px" href="admin.php?page=acmefeedbackq">Questions</a>			
			<a class="nav-tab '.$active['results'].'" style="font-size:15px" href="admin.php?page=acmefeedbackr">Results</a>			
			<a class="nav-tab '.$active['previewform'].'" style="font-size:15px" href="admin.php?page=acmefeedbackp" target=_blank>Preview Form</a>			
			</h2>
			</div> 
		  </div><div class=wrap style="border:1px solid silver;padding:5px;margin-top:-4px;padding-left:15px !important;min-height:400px">
			';
}
function acmefeedback_addsets($plg){
	$plg['setts'] = "<a href='admin.php?page=acmefeedback'>Settings</a>";
	return $plg;
}
function 	acmefeedback_jquery(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_style('wp-jquery-ui-dialog');
	//wp_enqueue_style('jquery-style', get_bloginfo('url').'/wp-content/plugins/acme-feedback/jquery-ui.css');
}
	
//Simply the footer of plugin with only closing div element
function acmefeedback_footer(){
	echo "<br><div style=text-align:center;color:#91848A;font-size:12px>Copyright 2012-2015 - WPUnite ";
	echo '</div>';
}
function acmefeedback_s(){
	global $user_ID, $wpdb;
	
	acmefeedback_header('settings', 'General Settings');
	$opts = get_option('acmefeedback_options');
	
	
	if ($_POST['update']){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}		
		delete_transient('acme_feedback_ips');
		$em = $_POST['email'];
		$err = array();
		$arr = array();
		$ema = explode(',', $em);
		if(!empty($ema)){
			
			for ($i=0; $i < count($ema); $i++) {
					if(!filter_var($ema[$i], FILTER_VALIDATE_EMAIL) and strlen($ema[$i]))
					{
						array_push($err, $ema[$i]);
					} else {
						array_push($arr, $ema[$i]);
					}
				}
		}
		if(!empty($err)){
			
				$message = "<h3 align=center style='border:1px solid #B00404;background:#FF7869;width:250px;padding:5px;float:right;margin-right:5px;margin-top:5px'><font color=#F21313>Invalid Format - Check for extra spaces : ".implode(',', $err)."</font></h3>";
				$errm = "border:1px solid red";
		} else if (!filter_var($_POST['affurl'], FILTER_VALIDATE_URL) and strlen($_POST['affurl'])){
			$erru = " style='border:1px solid red' ";		
			$message = "<h3 align=center style='border:1px solid #B00404;background:#FF7869;width:200px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=#F21313>Invalid URL Format</font></h3>";
		} else {
		
			$opts['affurl'] = $_POST['affurl'];
			$opts['sendcopy'] = $_POST['sendcopy']?1:0;
			$opts['email'] = implode(',', $arr);
			$opts['skipq'] = $_POST['skipq'];
			$opts['exclude'] = $_POST['exclude'];
			
			$opts['include'] = $_POST['include'];			
			$opts['thankyoujs'] = $_POST['thankyoujs'];
			$opts['sender'] = $_POST['sender'];
			$opts['subj'] = $_POST['subj'];
			$opts['position'] = $_POST['position']?$_POST['position']:"d";
			$opts['disable_form'] = $_POST['disable_feedback_form'];
			$opts['disable_tablet'] = $_POST['disable_tablet'];
			$opts['disable_mobile'] = $_POST['disable_mobile'];
			$opts['homepage_only'] = $_POST['homepage_only'];
			$opts['exit'] = $_POST['exit']?$_POST['exit']:"d";
			$opts['thankyou'] = str_replace("&gt;", ">",str_replace("&lt;", "<",$_POST['thankyou']));
			$maxq = get_option('acmefeedback_maxq');
			for($j = 1; $j<= $maxq; $j++){
				$v = 0;
				$qlist  = is_array($_POST['questions'])?$_POST['questions']:array();
				if (in_array($j, $qlist))	
					$v =1;
				$wpdb->query("update ".$wpdb->prefix . "acmefb_questions set active=$v where ordr=$j");	
			}
			update_option('acmefeedback_options', $opts);
			$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=green>Settings Updated</font></h3>";
		}
	}
	
	$chk1 = $opts['sendcopy']?" checked":"";
	$email = $opts['email'];
	$affurl = $opts['affurl'];
	$exclude  = $opts['exclude'];
	
	$include =  $opts['include'];
	$sender = $opts['sender'];
	$subj = $opts['subj'];
	$thankyou = str_replace("<", "&lt;",stripslashes($opts['thankyou']));
	$thankyou = str_replace(">", "&gt;",$thankyou);
	$thankyoujs = $opts['thankyoujs'];
	
	$qs = $wpdb->get_results("select * from ".$wpdb->prefix . "acmefb_questions order by ordr");
	foreach($qs as $q){
		$chk = $q->active?" checked":"";
		if ($q->title)
			$questions .= "<tr><td><input type=checkbox name=questions[] value='".$q->ordr."' $chk> ". $q->title."</td></tr>";
	}
	if (!$questions) $questions = "<Tr><TD align=center><i>N/A</i></td></tr>";
	
	if ($opts['position'] == 'r'){
		$chkre = " checked";
	} else if ($opts['position'] == 'l'){
		$chkle = " checked";
	} else if ($opts['position'] == 'br'){
		$chkle = " checked";
	} else {
		$chkd = " checked";
	}
	if ($opts['disable_form'] == 'yes'){
		$disable_form = " checked";
	}
	if ($opts['disable_mobile'] == 'yes'){
		$chkphone = " checked";
	}
	if ($opts['disable_tablet'] == 'yes'){
		$chktab = " checked";
	}
	if ($opts['homepage_only'] == 'yes'){
		$hpotab = " checked";
	}
	
	if ($opts['exit'] == 'o'){
		$chkeo = " checked";
	} else if ($opts['exit'] == 'e'){
		$chkee = " checked";
	} else {
		$chked = " checked";
	}
	if ($opts['skipq'] == '1'){
		$skipq = " checked";
	} else {
		$skipq = " ";	
	}
	echo "$message<form method=post><input type=hidden name=update value=1>";
	
	wp_nonce_field( 'acme_feedback' );
	echo "<table>";
	
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>ACME Feedback Settings</h2>\r\n";
	echo "We have a variety of settings and options to help you customize and optimize ACME Feedback.<br>\r\n";
		echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Choose Questions to Display</h2>\r\n";
	echo "At first you'll see our default sample questions. You'll need to setup your own questions on the <a href=admin.php?page=acmefeedbackq>Questions Tab</a>. <br>You can then pick and choose which questions you wish to display on your feedback form here. <br>This is designed so you can configure a large number of questions, then pick and choose which ones to use here.<br>\r\n";
	echo "<br>When a user submits the first question they will be shown the next question until the rotation is complete.<br> When no more questions are available a thank you message will be displayed.<br>\r\n";
	echo "<h3 style=padding-top:15px;padding-bottom:15px>Your Questions</h3>\r\n";
	echo "<table width=100%>$questions</table>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Email</h2>\r\n";
	echo "<input type=checkbox name=sendcopy value=1 $chk1> Receive submissions via email?<br><br>\r\n";
	echo "Email From Name: <br> <input type=text size=40 name=sender value=\"$sender\" style='margin-bottom:15px;$errm'><br>\r\n";		
	echo "Email Addresses - Separate multiple with comma and no spaces<br/><input type=text size=60 name=email value=\"$email\" style='margin-bottom:15px;$errm'><br>\r\n";
	echo "Email Subject:<br><input type=text size=40 name=subj value=\"$subj\" style='margin-bottom:15px;$errm'>\r\n";		
	echo "<hr><h2 style=padding-top:15px;padding-bottom:10px>Feedback Tab Location</h2>\r\n";
	echo "The default button is right edge orange, change your button graphic on the customization tab.<br><br>\r\n";
	echo "<input type=radio name=position value=r $chkre> Right Edge<br>\r\n";
	echo "<input type=radio name=position value=l $chkle> Left Edge<br>\r\n";
	echo "<input type=radio name=position value=br $chkle> Bottom Right<br>\r\n";
	echo "<input type=radio name=position value=d $chkd> Disabled<br><br>\r\n";
		echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Mobile</h2>\r\n";
	echo "<input type=checkbox name=disable_tablet value=yes $chktab>Disable on ipad/tablets<br>\r\n";
	echo "<input type=checkbox name=disable_mobile value=yes $chkphone>Disable on Phones<br><br>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Exit Feedback Settings</h2> \r\n";
	echo "<input type=radio name=exit value=o $chkeo> On Exit - Once Per Visitor<br>\r\n";
	echo "<input type=radio name=exit value=e $chkee> On Exit - Every Visit<br>\r\n";
	echo "<input type=radio name=exit value=d $chked> Disabled<br><br>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Disable Widget</h2>\r\n";
	echo "<input type=checkbox value=yes name=disable_feedback_form $disable_form>Disable Feedback form and show widget only<br>\r\n";
	echo "<br><h2 style=margin-bottom:4px>Thank You Message</h2>Enter in text or html to appear after  user completes feedback form, or optin form code to get people added to your list<br>\r\n";
	echo "<br><textarea name=thankyou cols=80 rows=7 style=width:700px>$thankyou</textarea>\r\n";

	echo "<br><hr><h2 style=padding-top:15px;padding-bottom:15px>Affiliate Link</h2>Will be displayed below popup if entered. <a target=blank href=http://acmefeedback.com/affiliates>Affiliate Info</a><br>\r\n";
	echo "<br><input type=text name=affurl size=80 value=\"$affurl\" $erru></td></tr>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Enable on Homepage</h2>\r\n";
	echo "<input type=checkbox name=homepage_only value=yes $hpotab>This will enable the tab and popup to work on just the homepage or any page ID included below.<br>\r\n";
	echo "<br><h2 style=padding-top:15px;padding-bottom:15px>Exclude Page/Posts</h2>Comma separated list of page/post IDs where you want to disable popup<br>\r\n";
	
	echo "<br><input type=text name=exclude size=80 value=\"$exclude\"><br>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Include Page/Posts</h2>Comma separated list of page/post IDs where popup will be showed.<br>\r\n";		
	
	echo "<br><input type=text name=include size=80 value=\"$include\"><br>\r\n";
	echo "<hr><h2 style=padding-top:15px;padding-bottom:15px>Allow Skipping</h2><input type=checkbox name=skipq value=1 $skipq>&nbsp;&nbsp;&nbsp;  Add \"Skip Question\" button to popup window<br><br>\r\n";
	
	echo "<hr><input type=submit value='Save Settings' class=button-primary><br>\r\n";
	echo "</form>\r\n";
	
	acmefeedback_footer();
}
function acmefeedback_r(){
	global $user_ID, $wpdb;
	
	acmefeedback_header('results', 'Completed Surveys');
	$opts = get_option('acmefeedback_options');
	
	$sortby = $_POST[sortby];
	if (!$sortby) {	$sortby = $_GET[sortby]; }
	if (!$sortby) { $sortby = 't'; }
	$dir = $_POST[dir];
	if (!$dir) { $dir = $_GET[dir]; }
	if (!$dir) { $dir = 'a';}
	$pp = (int) $_POST[pp];
	if(!$pp)  { $pp =  (int) $_GET[pp]; }
	if(!$pp)  { $pp = 50; }
	if ($sortby == 'i'){
		$check2 = "checked";
		$order = "ip";
	} else {
		$check1 = " checked";
		$order = "start";
	}
	if ($dir == 'a'){
		$sel1 = " selected";
		$order2 = "asc";
	} else {
		$sel2 = " selected";
		$order2 = "desc";
	}
	if ($_POST[submit] == 'Delete All'){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback2' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}	
		$wpdb->query("delete from ".$wpdb->prefix."acmefb_answers");
		$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:-50px'><font color=red>History Removed</font></h3>";
	}
	if ($_GET[del]){
		
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback2' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}	
		$wpdb->query("delete from ".$wpdb->prefix."acmefb_answers where id = $_GET[del]");
		$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:-50px'><font color=red>Survey Deleted</font></h3>";
	}
	if ($_POST[submit] == 'Delete Selected' and $_POST[todel]){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback2' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}	
		$wpdb->query("delete from ".$wpdb->prefix."acmefb_answers where id in (".join(",",$_POST[todel]).")");
		$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:-50px'><font color=red>".count($_POST[todel])." Surveys Deleted</font></h3>";
	}
	if ($_GET[pg]){
		$page = $_GET[pg];
	} else {
		$page = 1;
	}
	$tot = $wpdb->get_var($wpdb->prepare("SELECT count(*) as c FROM ".$wpdb->prefix."acmefb_answers"));		
	$pages = (int)($tot/$pp);
	if ($tot/$pp > $pages){ ++$pages; }
	if ($pages > 1){
		$params = "&sortby=$sortby&dir=$dir&pp=$pp";
		for($j = 1; $j <=  $pages; $j++){
			if ($j == $page){
				$pgs .= "<b>$j</b> ";
			} else {
				$pgs .= "<a href=admin.php?page=acmefeedbackr&pg=$j$params>$j</a> ";
			}
		}
		$Pages = "Pages: $pgs";
	}
	
	$limit1 = ($page-1)*$pp;	
	$limit2 = $pp;
	$res = $wpdb->get_results("select * from ".$wpdb->prefix."acmefb_answers order by $order $order2 limit $limit1, $limit2");
	$to_csv = array();
	foreach($res as $rec){
		if ($color == "white"){
			$color = "#DADBD9";
		} else {
			$color = "white";
		}
		if ($rec->uid){	
			$usr = get_userdata( $rec->uid);
			$who = "<a href=user-edit.php?user_id=".$rec->uid.">".$usr->user_login."</a> (IP: ".$rec->ip.")";
			$who_csv = $usr->user_login .' (IP: '.$rec->ip.')';
		} else {
			$who = "anonymous (IP: ".$rec->ip.")";
			$who_csv = $who;
		}
		
		$when = date("Y-m-d H:i:s",$rec->start);
		$as = preg_split("/;;;/",unserialize($rec->ansr));
		$answers = '';
		$answers_csv = array();
		foreach($as as $a){
			if (strlen($a) > 3){
				$spls = preg_split("/:::/", $a);
				$diff = $spls[2];
				$answers .= "<p style=padding-bottom:20px><b>Q:</b> $spls[0]<br><b>A:</b> ".urldecode($spls[1])."<br><b>T:</b> <i>$diff seconds</i></p>";
				array_push($answers_csv,'Q: '.$spls[0].' | A: '.$spls[1]);
			}
		}
		
		$delurl = wp_nonce_url(admin_url('admin.php?page=acmefeedbackr&del='.$rec->id), 'acme_feedback2');
		$recs .= "<TR style=background:$color><Td><input type=checkbox name=todel[] value=$rec->id><TD><B>$rec->id</b></td><TD>$who</td><td>$when</td><TD><a href=# onclick='return showDets($rec->id);'>Details&nbsp;&nbsp;&nbsp;<A href='$delurl' style=color:red onclick=\"return(confirm('Are you sure you want to delete this entry?'));\"><span style=color:red;>Delete</span></a></td></tr>";
		$recs .= "<tr style=background:$color;display:none id=tr".$rec->id."><td colspan=5>$answers</td></tr>";
		++$found;
		$arr = array($who_csv, $when);
		$arr = array_merge($arr, $answers_csv);
		array_push($to_csv, $arr);
	}
	echo '<script>
	jQuery(document).ready(function(){
	jQuery("#exportcsv").click(function(e){
	var csv_data = '.json_encode($to_csv).';
	console.log("clicked");
	e.preventDefault();
	
		jQuery.post(
	    ajaxurl, 
	    	{
	        "action": "download_csv",
	        "data": csv_data
    		},
    	function(msg){
    		window.location.href = "'.plugin_dir_url( __FILE__ ).'exports/export.csv";
    	}); 
		})
	})
</script>';
	if (!$found) $recs = "<TR><TD colspan=5 align=center><i>No Data</i></td></tr>";
	echo "
	<script language=javascript>
		function showDets(d){
			if (document.getElementById('tr'+d).style.display == 'none'){
				document.getElementById('tr'+d).style.display = '';
			} else {
				document.getElementById('tr'+d).style.display = 'none';
			}
			return false;
		}
	</script>
		<h2 align=left>Results Manager </h2><p>Note: To export all your data change your record count and then export.  Your questions will get exported on each line as well.</p><span align=right style=width:100%><a href=admin.php?page=acmefeedbackr&download_csv=yes id='exportcsv' class=button-primary>Export to CSV</a></span><div class=inside><BR>$message
	<form method=post action=admin.php?page=acmefeedbackr><p align=right><B>Sort By:</b>&nbsp;&nbsp;<input type=radio name=sortby value=t $check1> Date&nbsp;&nbsp;&nbsp;  <input type=radio name=sortby value=i $check2> IP &nbsp;&nbsp;&nbsp;&nbsp; <select name=dir><option value=a $sel1>Ascending</option><option value=d $sel2>Descending</option>&nbsp;&nbsp; <input type=text name=pp size=5 value='$pp'> records on page <input type=submit value=Go class=button></form></p>";
	
	
	echo "<table class='widefat'><thead><tr><th width=2%>&nbsp;</th><th width=5%>ID</th><th width='35%'>Who</th><th width='30%'>When</th><th width='30%'>Action</th></tr></thead><tbody><form method=post action=admin.php?page=acmefeedbackr><input type=hidden name=update value=1>";
	echo wp_nonce_field( 'acme_feedback2' );
	echo $recs;
	echo "<TR style=height:70px;border:0><TD colspan=2><BR><input type=submit value='Delete Selected' name=submit class=button-primary  onclick=\"return(confirm('Are you sure you want to delete selected entries?'));\"></td><td colspan=2 align=left><br><input type=submit value='Delete All' name=submit  class=button-primary  onclick=\"return(confirm('Are you sure you want to delete all entries?'));\"></form></td><Td><BR><span style=font-size:16px>$Pages</span></td></tr></table></div>";
	
	acmefeedback_footer();
}
add_action( 'wp_ajax_download_csv', 'download_csv' );
add_action( 'wp_ajax_nopriv_download_csv', 'download_csv' );
function download_csv() {
		/*
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=file.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies */
    	$data = $_POST['data'];
    	//var_dump($data);
	    $output = fopen(plugin_dir_path( __FILE__ )."exports/export.csv", "w");
	    for($i=0;$i<count($data);$i++){
	        fputcsv($output, $data[$i]); // here you can change delimiter/enclosure
	    }
	    fclose($output);
	    //echo 1;
	    die();
}
function acmefeedback_c(){
	global $user_ID, $wpdb;
	
	acmefeedback_header('customization', 'Customization');
	$opts = get_option('acmefeedback_options');
	
	
	if ($_POST['update']){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}		
	
		$err  = 0;
		if (!filter_var($_POST['urlh'], FILTER_VALIDATE_URL) and strlen($_POST['urlh'])){
			$erru1 = " style='border:1px solid red' ";		
			$err = 1;
		} 
		if (!filter_var($_POST['urlc'], FILTER_VALIDATE_URL) and strlen($_POST['urlc'])){
			$erru2 = " style='border:1px solid red' ";		
			$err = 1;
		} 
		if (!filter_var($_POST['urlt'], FILTER_VALIDATE_URL) and strlen($_POST['urlt'])){
			$erru3 = " style='border:1px solid red' ";		
			$err = 1;
		} 
		if ($err) { 
			$message = "<h3 align=center style='border:1px solid #B00404;background:#FF7869;width:200px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=#F21313>Invalid URL Format</font></h3>";
		} else {
			$opts['urlh'] = $_POST['urlh'];
			$opts['urlc'] = $_POST['urlc'];
			$opts['urlt'] = $_POST['urlt'];
			$opts['title'] = $_POST['title'];
			$opts['hcolor'] = $_POST['hcolor'];
			$opts['tab'] = $_POST['tab'];
			$opts['bcolor'] = $_POST['bcolor'];
	
			$opts['bucolor'] = $_POST['bucolor'];
			$opts['bubcolor'] = $_POST['bubcolor'];
			$opts['butext'] = $_POST['butext'];
			$opts['bsize'] = (int) $_POST['bsize'];
			$opts['pw'] = (int) $_POST['pw'];
			$opts['ph'] = (int) $_POST['ph'];
			$opts['ptpl'] = $_POST['ptpl'];
		
			$opts['etpl'] = $_POST['etpl'];
			$opts['widget'] = $_POST['widget'];
			update_option('acmefeedback_options', $opts);
			$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=green>Settings Updated</font></h3>";
		}
	}
	$title  =  stripslashes($opts['title']);
	$hcolor = $opts['hcolor'];
	$urlh = $opts['urlh'];
	$urlc = $opts['urlc'];
	$tab = $opts['tab'];
	$pw = $opts['pw'];
	$ph = $opts['ph'];
	if (!$tab) $tab = 'or';
	$dir = opendir(dirname(__FILE__)."/tabs");
	while($file = readdir($dir)){
		if (file_is_displayable_image(dirname(__FILE__)."/tabs"."/".$file)){
			$tabs[] = $file;
		}
	}
	closedir($dir);
	
	sort($tabs);
	
	foreach($tabs as $tb){
		$spls = preg_split("/\./",$tb);
		$titl = ucfirst(str_replace("_", " ",$spls[0]));
		if ($tb == $tab){
			$sopts .= "<option value='$tb' selected>$titl</option>";
		} else {
			$sopts .= "<option value='$tb'>$titl</option>";
		}
	}
	
	if ($tab != 'c'){
		$displ = " style=display:none";
		$sopts .= "<option value=c>Custom URL</option>";
	} else {
		$urlt = $opts['urlt'];
		$sopts .= "<option value=c selected>Custom URL</option>";
	}
	
	$bcolor = $opts['bcolor'];
	$bucolor = $opts['bucolor'];
	$bubcolor = $opts['bubcolor'];
	$butext = $opts['butext'];
	$bsize = $opts['bsize'];
	$ptpl = stripslashes($opts['ptpl']);
	$etpl = stripslashes($opts['etpl']);
	
	echo "$message<form method=post><input type=hidden name=update value=1>";
	wp_nonce_field( 'acme_feedback' );	
	
	
	echo "<h2 style=padding-top:15px;padding-bottom:15px>Customize Popup and CSS Design</h2>\r\n";
	echo "Popup Title Bar Text (leave blank is using custom header graphic)<br>\r\n";
	echo "<input type=text size=90 name=title value=\"$title\" style=margin-top:10px><br>\r\n";
	echo "<br>Title Bar Header Color <br><input type=text size=8 value='$hcolor' id=hcolor style='color:$hcolor' name=hcolor>";
	echo "<br><br>Enter URL of  header graphic to brand your title bar<br>\r\n";
	echo "<input type=text size=90 name=urlh value=\"$urlh\"  style=margin-top:0px>\r\n";
	echo "<br><br>Select Feedback Tab - <a target=blank href=http://acmefeedback.com/images/feedback-tabs.png>See Examples</a><br><select name=tab onchange=checkTbs(this.value); >$sopts</select>";
	//echo "<tr $displ id=cftr><td colspan=2 style=padding-top:10px>Enter URL of Custom Feedback tab design<br>\r\n";
	echo "<br><br>Enter URL of Custom Feedback tab design<br>\r\n";
	echo "<input type=text size=90 name=urlt value=\"$urlt\">\r\n";
	echo "<br><br>Submit Button Text Color<br><input type=text size=8 value='$bucolor' name=bucolor id=bucolor style='color:$bucolor'>";	
	echo "<br><br>Submit Button Background Color<br><input type=text size=8 value='$bubcolor' name=bubcolor id=bubcolor style='color:$bubcolor'>";		
	echo "<br><br>Submit Button Text<br><input type=text size=20 value='$butext' name=butext id=butext>";		
	echo "<br><br>Popup Border Color<br><input type=text size=8 value='$bcolor' name=bcolor id=bcolor style='color:$bcolor'>";	
	echo "<br><br>Choose Border Size<br><input type=text size=8 value='$bsize' name=bsize >";		
	echo "<br><br>Popup Width<br><input type=text size=8 value='$pw' name=pw >";		
	echo "<br><br>Popup Height<br><input type=text size=8 value='$ph' name=ph >";		
	echo "<br><br>Popup Content Template<br><textarea name=ptpl style=width:650px rows=5>$ptpl</textarea>";		
	echo "<br><br>Popup Widget Content can be configured by placing required widget inside <b>Acme Feedback Popup</b> <a href=widgets.php>here</a>";
	echo "<br><hr><input type=submit value='Save Settings' class=button-primary><br>\r\n";
	echo "</form>\r\n";
	echo "<script langauge=javascript>
						 jQuery('#hcolor' ).ColorPicker({
						 	color: '$hcolor',
							eventname: 'click',
							livePreview: true,
						 	onChange: function (hsb, hex, rgb) {
									jQuery('#hcolor').val('#' + hex);
									jQuery('#hcolor').css('color', '#' + hex);
							}}
						 );	
						 jQuery('#bcolor' ).ColorPicker({
						 	color: '$bcolor',
							eventname: 'click',
							livePreview: true,
						 	onChange: function (hsb, hex, rgb) {
									jQuery('#bcolor').val('#' + hex);
									jQuery('#bcolor').css('color', '#' + hex);
							}}
						 );			
			 
						 jQuery('#bucolor' ).ColorPicker({
						 	color: '$bucolor',
							eventname: 'click',
							livePreview: true,
						 	onChange: function (hsb, hex, rgb) {
									jQuery('#bucolor').val('#' + hex);
									jQuery('#bucolor').css('color', '#' + hex);
							}}
						 );	
						 						 jQuery('#bubcolor' ).ColorPicker({
						 	color: '$bubcolor',
							eventname: 'click',
							livePreview: true,
						 	onChange: function (hsb, hex, rgb) {
									jQuery('#bubcolor').val('#' + hex);
									jQuery('#bubcolor').css('color', '#' + hex);
							}}
						 );	
						 function checkTbs(v){
							if (v == 'c'){
								document.getElementById('cftr').style.display = '';
							} else {
								document.getElementById('cftr').style.display = 'none';
							}
						 }
	</script>";
	acmefeedback_footer();
}
function acmefeedback_q(){
	global $user_ID, $wpdb;
	
	acmefeedback_header('questions', 'Questions');
	
	$maxq = get_option('acmefeedback_maxq');
	
	
	if ($_POST['update']){
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback' ) ) {
		  echo "Suspicious intention, operation aborted.";exit; 
		}		
		delete_transient('acme_feedback_ips');
		for($j = 1; $j<= $maxq; $j++){
			$title = $_POST['title'.$j];
			if ($title == 'Enter question title here...') $title = '';
			$body = $_POST['body'.$j];
			$qtp = $_POST['qtp'.$j];
			if ($body == "Enter answers here...") $body = '';
			$wpdb->query("update ".$wpdb->prefix . "acmefb_questions set title='$title', body='$body', qtp='$qtp' where ordr=$j");	
		}
		$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=green>Questions Updated</font></h3>";
	} else {
		if ($_GET['dec'] and $maxq > 1 and  wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback' )){
			$wpdb->query("delete from ".$wpdb->prefix . "acmefb_questions where ordr=$maxq");
			--$maxq;
			update_option('acmefeedback_maxq',$maxq);
			$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=red>Question Removed</font></h3>";
		} else if ($_GET['inc'] and  wp_verify_nonce( $_REQUEST['_wpnonce'], 'acme_feedback' )){
			++$maxq;
			update_option('acmefeedback_maxq',$maxq);
			$wpdb->query("insert into " . $wpdb->prefix . "acmefb_questions  set ordr=$maxq, active=0, dadded='".time()."', title='', body=''");
			$message = "<h3 align=center  style='border:1px solid #3AA82C;background:#BFEDB9;width:150px;padding:10px;float:right;margin-right:5px;margin-top:5px'><font color=green>Question Added</font></h3>";
		}
	}
	
	
	$qs = $wpdb->get_results("select * from ".$wpdb->prefix . "acmefb_questions order by ordr");
	foreach($qs as $q){
		++$qfv;
		if (!$q->title and !$q->body){
			$q->body = "Enter answers here...";
			$st2 = "color:#B5B5B5;text-decoration:italic;padding-left:15px";
			$onf2 = " onfocus=\"clearStv(this, 'b".$q->ordr."');\" ";
		} else {
			$st2 = "";
			$onf2 = "";
		}
		if (!$q->title){
			$q->title = "Enter question title here...";
			$stl = " style='color:#B5B5B5;text-decoration:italic;padding-left:15px' ";
			$onf1 = " onfocus=\"clearStv(this, 't".$q->ordr."');\" ";
		} else {
			$stl = "";
			$onf1 = "";
		}
		if ($q->qtp == 'l'){
			$qtp2 = " checked";
			$qtp1 = "";
		 
			$st3 = "";
		} else {
			$qtp2 = "";
			$qtp1 = " checked";
		
			$st3 = "display:none";
		}
		if ($q->ordr == $maxq){
			$incurl = wp_nonce_url(admin_url('admin.php?page=acmefeedbackq&inc=1'), 'acme_feedback');
			$decurl = wp_nonce_url(admin_url('admin.php?page=acmefeedbackq&dec=1'), 'acme_feedback');
			$addn = "<br><BR><BR><center><input type=button class=button value='+' style=font-size:25px;color:green title='Increase questions count' onclick=\"document.location='$incurl';\">&nbsp;".($maxq>1?"<input type=button class=button value='-' style=font-size:25px;color:red title='Decrease questions count' onclick=\"if (confirm('Are you sure you want to remove question $maxq?')) document.location='$decurl';\">":"")."</center>";
		}
		$questions .= "<tr><td valign=top width=20%><b>Question #".$q->ordr."</b>$addn</td><td valign=top><input type=text size=65 name=title".$q->ordr." value=\"".$q->title."\" $stl $onf1>&nbsp;&nbsp;&nbsp;<input type=radio name=qtp".$q->ordr." value=t $qtp1 onchange=swFld($qfv,'none');> Text Answer <input type=radio name=qtp".$q->ordr." value=l $qtp2 onchange=swFld($qfv,'');> Select from List<br><textarea style='width:570px;$st2;$st3' rows=2 name=body".$q->ordr." $onf2  id=tar$qfv>". $q->body."</textarea></td></tr>\r\n";
	}
	
	echo "<script language=javascript>
		var t = new Array();
		function clearStv(ob, tp){
			if (t[tp] == 1) return;
			t[tp] = 1;
			ob.value = '';
			ob.text = '';
			ob.style.color = 'black';
			ob.style.textDecoration = '';
			ob.style.paddingLeft  = '3px';
		}
	
		function swFld(qfv,stl){
			if (document.getElementById('tar'+qfv).style.display == 'none'){
				document.getElementById('tar'+qfv).style.display = '';
			} else {
				document.getElementById('tar'+qfv).style.display = 'none';
			}
		}
		</script>";
		
	echo "$message<form method=post><input type=hidden name=update value=1>\r\n";
	wp_nonce_field( 'acme_feedback' );
		
	echo "<table width=100%>\r\n";
	echo "<tr><td colspan=2 align=left><h2>What Questions  Would You Like To Ask?</h2><br>\"Text Answer\" questions collect user typed text. In \"Select from List\" questions user can choose one answer from existing list. List of answers is configured inside question textarea - each answer option on its own line</b><br><br>\r\n";
	echo $questions;
	echo "<tr><td>&nbsp;</td><td><br>Once you save here the questions will be displayed on the settings page and you can select which ones or all you wish to rotate.<br></td></tr>\r\n";
	echo "<tr style=height:60px><td colspan=2 align=center valign=middle><input type=submit value='Save Settings' class=button-primary></td></tr>\r\n";
	echo "</table></form>\r\n";
	
	acmefeedback_footer();
}
function acmefeedback_popup(){
	global $post;
	$opts = get_option('acmefeedback_options');
	$exs = $opts['exclude'];
	$exs = preg_split("/,/", $exs);
	$incs = $opts['include'];
	$incs = preg_split("/,/", $incs);
	foreach($exs as $ex){
		$exarr[] = trim($ex);
	}
	
	$inarr = array();
	foreach($incs as $in){
		if (trim($in))
			$inarr[] = trim($in);
	}

	if ($opts['homepage_only'] == 'yes' && !is_front_page() && !is_home() && count($inarr) == 0)
		return;

	if (count($inarr) > 0){
		if (($post->ID and !in_array($post->ID,$inarr)))
			if ($opts['homepage_only'] == 'yes' && is_home()) {

			} else {
				return;
			}
	}

	if (in_array($post->ID,$exarr) and $post->ID)
		return;
	if ($opts['position'] == 'd' and $opts['exit'] == 'd') return;
	if (!$opts['tab']) return;
	if ($opts['tab'] == 'c' and !$opts['urlt']) return;

	
	
	$ptpl = str_replace("{TITLE}", $opts['title'], str_replace(array("\r","\n")," ",stripslashes($opts['ptpl'])))	;
	ob_start();		
	dynamic_sidebar('Acme Feedback Popup');		
	$widget_content = ob_get_contents();		
	ob_end_clean();		
	$widget_content = str_replace(array("\n","\r")," ", $widget_content);
	echo '<style>';
	if ($opts['disable_tablet']=='yes') {
		echo '@media only screen and (min-width: 768px) and ( max-width: 959px  ){ #acme-feedback-btn { display: none; } }';
	}
	if ($opts['disable_mobile']=='yes') {
		echo '@media only screen and ( max-width: 767px ){ #acme-feedback-btn { display: none; } }';
	}
	echo '</style>';
	$opts['thankyou'] = stripslashes($opts['thankyou']);
	echo "<div id=thanksdiv style=display:none>".str_replace(array("\n","\r")," ",$opts['thankyou'])."</div>";echo "<div id=widget_content style=display:none>$widget_content</div>";
	echo "
	$ptpl
	<script src=\"".get_bloginfo('url')."?acmefeedbackpopupjs=1\"></script>";
	if ($opts['disable_form']=='yes') {
		echo '<script>jQuery("#acmefeedback").remove();';
		echo 'jQuery("#acmewidget").width("100%");';
		echo 'jQuery(".ui-dialog-buttonset .ui-button").remove();</script>';
	}
}
function acmefeedback_p(){
	$opts = get_option('acmefeedback_options');
	
	$pos = 1;
	$ordr = 0;
	global $wpdb;
	$qs = $wpdb->get_results("select * from  ".$wpdb->prefix . "acmefb_questions  where active=1 order by ordr asc");
	$questions = "var qtitles = new Array();\r\nvar qbodies = new Array();\r\nvar qflds = new Array();\r\nvar qtypes = new Array();\r\n";
	
	foreach($qs as $q){
		$qt = str_replace(array("\r","\n")," ",$q->title);
		++$ordr;
		if ($q->qtp == 't'){
			$qb = str_replace(array("\r","\n")," ",addslashes($q->body));
			$qfj = "qflds[$ordr] = \"<textarea style=width:400px; rows=9 id=answer name=answer class='qansf'></textarea>\";\r\n";
		} else {
			$qb = addslashes($q->body);
			$list = preg_split("/\n/",$qb);
			if (count($list) < 2){
				$qb = str_replace("\n","",$qb);
				$list = split("/\r/",$qb);
			} else {
				$qb = str_replace("\r","",$qb);
			}
	
			$qb  = '' ;
			$lst = '<br>';
			foreach($list as $li){
				$li = trim($li);
				$lst .= "<input type=radio name=answer value=\\\"".urlencode($li)."\\\"> $li <br>";
			}
			$qfj = "qflds[$ordr] = \"<br>$lst\";\r\n";
			
		}
		++$totq;
		$questions .= "qtitles[$ordr] = \"$qt\";\r\nqbodies[$ordr] = \"$qb\";\r\nqtypes[$ordr] = '$q->qtp';\r\n$qfj";
	}
	ob_start();
	dynamic_sidebar('Acme Feedback Popup');
	$widget_content = ob_get_contents();
	ob_end_clean();
	$ptpl = str_replace("{TITLE}", $opts['title'], str_replace(array("\r","\n")," ",stripslashes($opts['ptpl'])))	;
	
	$widget_content = str_replace(array("\n","\r")," ", $widget_content);
	
	$affurl = '';
	if ($opts['affurl'])
		$affurl = '<div id=affurl style=\";width:100%;text-align:center\"><a href=\"'.$opts[affurl].'\">Powered By ACME Feedback Plugin</a></div>';
	
	global $user_ID;
	if ($opts['skipq']){
		$skipq = ",
						'Skip': function() {
							if (qtypes[acme_qno] == 't'){
								vl = document.getElementById('answer').value;
							} else {
								vl = jQuery('input:radio[name=answer]:checked').val();
							}
							jQuery('#ansr').val(jQuery('#ansr').val()+';;;'+qtitles[acme_qno]+':::<b>Skipped</b>:::'+jQuery('#dadded').val());
							jQuery('#dadded').val(1);
							acme_seconds = 1;
							if (acme_qcnt == acme_qno){
								var form_values =jQuery('.qansf').serialize( );
								jQuery('#question_container').fadeOut(0);
								jQuery('#question_container').html('Please Wait');
								jQuery('#question_container').fadeIn(100);
								jQuery.post( '".get_option('siteurl')."/index.php', form_values, function(response) {
									if (response.resp != '111'){
										jQuery('#question_container').html('Error during saving.');
									} else {
										var dhtml = jQuery('#thanksdiv').html();
										dhtml = dhtml.replace(/<script/gi,'<scrpt');
										dhtml = dhtml.replace(/<\/script/gi,'<\/scrpt');
										jQuery('#question_container').html(dhtml);
									}
								
								}, 'json');
								return false;
							}
							jQuery('#question_container').fadeOut(0);
							++acme_qno;
							jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
							if (qbodies[acme_qno] != '')
								jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
							if (qflds[acme_qno] != '')
								jQuery('#question_answers_area').html(qflds[acme_qno]);	
							jQuery('#question_container').fadeIn(300);
							jQuery('#answer').focus();
						}
				";
	}
	ob_start();		
	dynamic_sidebar('Acme Feedback Popup');		
	$widget_content = ob_get_contents();	
	ob_end_clean();		
	$widget_content = str_replace(array("\n","\r")," ", $widget_content);
	echo "<div id=widget_content style=display:none>$widget_content</div>";
	echo "<div id=thanksdiv style=display:none>".stripslashes($opts['thankyou'])."</div><h3>Loading Popup...</h3><input type=hidden name=step value=$pos class='qansf'>
		<input type=hidden name=ansr value='' class='qansf' id=ansr>
		<input type=hidden name=acmesurvey value='1' class='qansf'>
		<input type=hidden name=ip value='".getenv(REMOTE_ADDR)."' class='qansf'>
		<input type=hidden name=start value='".time()."' class='qansf'>
		<input type=hidden name=uid value='".$user_ID."' class='qansf'>
		
		$ptpl
		<script language=javascript>
			
			var acme_tab_pos = 'r';
			var acme_tab_exit = 'd';
			var acme_header_image = '$opts[urlh]';
			var acme_hcolor = '$opts[hcolor]';
			var acme_bcolor = '$opts[bcolor]';
			var acme_bsize = '$opts[bsize]';
			var acme_qno = 1;
			var acme_qcnt = $totq;
			$questions
			
			var bu_color = '$opts[bucolor]';
			var bu_bcolor = '$opts[bubcolor]';
			
	
			var affurl = '$affurl';
	
			function checkLength( o, min, max ) {
				if ( o.length > max || o.length < min ) {
					jQuery( '#answer' ).addClass( 'ui-state-error' );
					return false;
				} else {
					return true;
				}
			}
			var wsc = 0;var opened = 0;
			function putAcmeTab(){
				if (jQuery('#acmeuidialog').is(':data(dialog)')){
     jQuery( '#acmeuidialog' ).dialog('destroy');
    }
				document.getElementById('acmeuidialog').style.display = '';
				jQuery( '#acmeuidialog' ).dialog({
					autoOpen: false,
					height: $opts[ph],
					width: $opts[pw],
					modal: true,
					resizable: false,
					draggable: false,
					buttons: {
						'$opts[butext]': function() {
							if (qtypes[acme_qno] == 't'){
								vl = document.getElementById('answer').value;
							} else {
								vl = jQuery('input:radio[name=answer]:checked').val();
							}
							
							if (vl == '') return;
							
								jQuery('#ansr').val(jQuery('#ansr').val()+';;;'+qtitles[acme_qno]+':::'+vl+':::'+new Date().getTime());
								if (acme_qcnt == acme_qno){
									var form_values =jQuery('.qansf').serialize( );
									jQuery('#question_container').fadeOut(0);
									jQuery('#question_container').html('Please Wait');
									jQuery('#question_container').fadeIn(100);
									var dhtml = jQuery('#thanksdiv').html();			
									dhtml = dhtml.replace(/<script/gi,'<scrpt');
									dhtml = dhtml.replace(/<\/script/gi,'<\/scrpt');
									jQuery('#question_container').html(dhtml);																		
									jQuery( '#acmeuidialog' ).dialog( 'option', 'buttons',  [
    {
        text: 'Close',
        click: function() { jQuery(this).dialog('close');wsc = 0;opened = 0; }
    }
									]);
									return false;
								}
								
								jQuery('#question_container').fadeOut(0);
								++acme_qno;
								jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
								if (qbodies[acme_qno] != '')
									jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
								if (qflds[acme_qno] != '')
									jQuery('#question_answers_area').html(qflds[acme_qno]);	
								jQuery('#question_container').fadeIn(300);
								jQuery('#answer').focus();
						} $skipq 
					}  ,
			close: function() {
				wsc = 0;
				opened = 0;
			}});
			
			acme_qno = 1;
			document.getElementById('ansr').value = '';
			
			if (acme_header_image != ''){
				jQuery('#acme_hdr_img').remove();
				jQuery('.ui-widget-header').append('<img id=acme_hdr_img src=\"'+acme_header_image+'\" align=center style=\"margin:0 auto\">');
				jQuery('.ui-widget-header').css('height',jQuery('#acme_hdr_img').attr('height'));
			}
			if (acme_hcolor == '') acme_hcolor = 'white';
			jQuery('.ui-widget-header').css('background',acme_hcolor);
			if ((parseInt(acme_bsize) > 0) && (acme_bcolor != '')){
				jQuery('.ui-dialog').css('border', acme_bsize+'px solid '+acme_bcolor);
			}
			
				//jQuery('.ui-icon-closethick').remove();
				jQuery('#question_title_area').html('<b>' + qtitles[acme_qno]+'</b><br>');
				if (qbodies[acme_qno] != '')
					jQuery('#question_body_area').html('<br>'+qbodies[acme_qno]);	
				if (qflds[acme_qno] != '')
					jQuery('#question_answers_area').html(qflds[acme_qno]);						
				jQuery('#affurl').remove();
				if (affurl != '')
					jQuery('.ui-dialog-buttonpane').parent().append(affurl);
								var dhtml2 = jQuery('#widget_content').html();				dhtml2 = dhtml2.replace(/<script/gi,'<scrpt');				dhtml2 = dhtml2.replace(/<\/script/gi,'<\/scrpt');				jQuery('#widgets_container').html(dhtml2);	
				jQuery( '#acmeuidialog' ).dialog( 'open' );
				jQuery(':button').css('background',bu_bcolor);
				jQuery(':button').css('color',bu_color);
	
			}
			
			document.onload =  setTimeout(\"putAcmeTab();\",1000);
			</script>
			";
	echo '<style>';
	if ($opts['disable_tablet']=='yes') {
		echo '@media only screen and (min-width: 768px) and ( max-width: 959px  ){ #acme-feedback-btn { display: none; } }';
	}
	if ($opts['disable_mobile']=='yes') {
		echo '@media only screen and ( max-width: 767px ){ #acme-feedback-btn { display: none; } }';
	}
	echo '</style>';
	if ($opts['disable_form']=='yes') {
		echo '<script>jQuery("#acmefeedback").remove();';
		echo 'jQuery("#acmewidget").width("100%");';
		echo 'jQuery(".ui-dialog-buttonset button").remove();</script>';
	}
			
	acmefeedback_footer();
}
function acmefeedback_install(){
	global $wpdb;
	error_reporting(E_ERROR);
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  	$sql = "CREATE TABLE " . $wpdb->prefix . "acmefb_questions (
	  id int(4) NOT NULL AUTO_INCREMENT primary key,
	  title varchar(255),
	  body text,
	  qtp char(1),
	  ordr int(3),
	  active int(1),
	  dadded int(13)
	)";
	dbDelta($sql);
	$sql = "CREATE TABLE " . $wpdb->prefix . "acmefb_answers (
	  id int(4) NOT NULL AUTO_INCREMENT primary key,
	  ansr text,
	  ip varchar(255),
	  start int(15),
	  uid int(10),
	  dadded varchar(20)
	)";
	dbDelta($sql);
	if (!get_option('acmefeedback_maxq'))
		update_option('acmefeedback_maxq', ACMEAFF_MAX_QUESTIONS);
	$opts = get_option('acmefeedback_options');
	if (!$opts['activated']){
		$opts['thankyou'] = "<h2 align=center>Thanks For Answering!</h2>";
		$opts['position'] = 'd';
		$opts['exit'] = 'd';
		$opts['email'] = get_bloginfo('admin_email');
		$opts['sendcopy'] = 1;
		$opts['activated'] = 1;
		$opts['title'] = "Can You Give Us Some Feedback?";
		$opts['hcolor'] = '#e8e8e8';
		$opts['bcolor'] = '#d57000';
		$opts['bsize'] = 10;
		$opts['tab'] = 'orange_right.png'; 
		$opts['pw'] = 850; 
		$opts['ph'] = 400;
		$opts['bucolor'] = '#000';
		$opts['bubcolor'] = '#f3f3f3';
		$opts['butext'] = 'Submit';
		$opts['sender'] = "ACME Feedback";
		$opts['subj'] =  "New ACME Feedback Submission";
		$opts['ptpl'] = " <style type=\"text/css\"> .ui-widget {font-family: inherit;}.ui-dialog .ui-dialog-title {font-size:18px;}.ui-widget-content h2 {color: #666;font-size: 18px;font-weight: normal;}.ui-widget-content ul {color: #333;}.ui-widget-content li {color: #444; padding: 2px 0 2px 0;margin:3px 0 0 0px;list-style-type:none;} #affurl {font-size: 12px;} #acmeuidialog {width:98%; height:90%; padding:20px;} #acmewidget {float: left; width:50%;} #acmefeedback {width:50%; float:right; font-size:16px;}</style><div id='acmeuidialog' title=\"{TITLE}\">
<div id='acmewidget'><span id=widgets_container></span></div><div id='acmefeedback'><span id=question_container><span id=question_title_area></span>
<span id=question_body_area></span><span id=question_answers_area></span></span></div></div>";
		$opts['etpl'] = EMAIL_TEMPLATE;
			
		update_option('acmefeedback_options', $opts);
		for ($j = 1; $j < ACMEAFF_MAX_QUESTIONS-1;$j++){
			$wpdb->query("insert into " . $wpdb->prefix . "acmefb_questions  set ordr=$j, active=1, dadded='".time()."', title='Sample Question $j', body='', qtp='t'");
		}
		$wpdb->query("insert into " . $wpdb->prefix . "acmefb_questions  set ordr=".( ACMEAFF_MAX_QUESTIONS - 1 ).", active=1, dadded='".time()."', title='Sample Question $j', body='First Answer\nSecond Answer\nThird Answer\nLast Answer', qtp='l'");
		$wpdb->query("insert into " . $wpdb->prefix . "acmefb_questions  set ordr=".ACMEAFF_MAX_QUESTIONS.", active=0, dadded='".time()."', title='', body=''");
	}
}
function acmefeedback_uninstall(){
	global $wpdb;
	delete_option('acmefeedback_options');
	delete_option('acmefeedback_maxq');
	$wpdb->query("drop table " . $wpdb->prefix . "acmefb_questions");
}
?>