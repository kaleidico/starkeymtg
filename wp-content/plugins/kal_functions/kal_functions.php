<?php
/*
Plugin Name: Kaleidico Functions Plugin
Plugin URI: http://kaleidico.com
Description: Moves most functions away from functions.php (in theme file)
Author: Gerard Donnelly
Version: 1.0
Author URI: http://kaleidico.com
License: GPL2
*/



// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************



//tell wordpress to register the demolistposts shortcode
add_shortcode("api-errors-test", "api_errors_handler");



function api_errors_handler() {
  //run function that actually does the work of the plugin
  $demolph_output = api_errors_function();
  //send back text to replace shortcode in post
  return $demolph_output;
}


function api_errors_function() {

ob_start(); // begin output buffering

//include 'wp-content/plugins/kal_functions/zfp_output.php';

 global $wpdb;

        $error_timestamp=time();
        $line_number=287;
        $error_msg='Lenderful Alert: API call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));



$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
    return $output;


}










// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************






// function to registration Shortcode

function gman_registration_shortcode( $atts ) {

    global $wpdb, $user_ID; 

  $firstname='';

  $lastname='';

  $username='';

  $email='';

  

  



  if(sanitize_text_field( $_POST['com_submit']) != ''){



    //$firstname=sanitize_text_field( $_REQUEST['com_firstname'] );

    //$lastname=sanitize_text_field( $_REQUEST['com_lastname']);

    $username = sanitize_text_field(  $_REQUEST['com_username'] );

    $email = sanitize_text_field(  $_REQUEST['com_email']  );

    $password = $wpdb->escape( sanitize_text_field( $_REQUEST['com_password']));

    $status = wp_create_user($username,$password,$email);

      $succress ='';

    $error_msg='';

     

    if (is_wp_error($status))  {

         $error_msg = __('Username or Email already registered, please try another one.',''); 

    } 

    else{

      $user_id=$status;

      //update_user_meta( $user_id,'first_name', $firstname);

      //update_user_meta( $user_id,'last_name', $lastname);

      

      $succress= __('You are registered successfully.',''); 

      

    }  

  }

?>

  

    <?php if($error_msg!='') { ?><div class="error"><?php echo $error_msg; ?></div><?php }  ?>

    <?php if($succress!='') { ?><div class="success"><?php echo $succress; ?></div><?php }  ?>

    

    <form  name="form" id="registration"  method="post">

     

      <div class="ftxt more-bottom-margin">

       <label><?php _e("Username :",'');?></label><br>

       <input id="com_username" name="com_username" type="text" class="input form-control" required value=<?php echo $username; ?> >

      </div>

      <div class="ftxt more-bottom-margin">

      <label><?php _e("E-mail :",'');?></label><br>

       <input id="com_email" name="com_email" type="email" class="input form-control" required value=<?php echo $email; ?> >

      </div>

      <div class="ftxt more-bottom-margin">

      <label><?php _e("Password :",'');?></label><br>

       <input id="password1" name="com_password" class="form-control" type="password" required class="input" />

      </div>

      <div class="ftxt more-bottom-margin">

      <label><?php _e("Confirm Password : ",'');?></label><br>

       <input id="password2" name="c_password" class="form-control" type="password" class="input" />

      </div>

      <div class="fbtn more-bottom-margin"><input type="submit" name='com_submit' class="button btn btn-primary"  value="Register"/> </div>

    </form>

  
<?php 

}



//add registration shortcoode

add_shortcode( 'gman-registration-form', 'gman_registration_shortcode' );




// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************



function log_me_in_please( $user_id ) {
    

    wp_set_current_user( $user_id );

    wp_set_auth_cookie( $user_id );
    
    wp_redirect( get_permalink() );

    

    


    exit(); 
}
add_action( 'user_register', 'log_me_in_please' );



// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************


function gman_login_redirect() {
    //wp_redirect( get_permalink() );

    printf("<script>location.href='/property-results-refi/'</script>");

}

add_action('wp_login', 'gman_login_redirect');


// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************
// *****************  new function ********************



add_filter( 'gform_save_field_value_43_1', 'gd_encrypt1', 10, 5 );

function gd_encrypt1( $value, $lead, $field, $form ) {
    return base64_encode( $value );
}


add_filter( 'gform_save_field_value_43_3', 'gd_encrypt2', 10, 5 );

function gd_encrypt2( $value, $lead, $field, $form ) {
    return base64_encode( $value );
}


add_filter( 'gform_get_input_value_43_3', 'gd_decrypt1', 10, 4 );

function gd_decrypt1( $value, $entry, $field, $input_id ) {
    return base64_decode( $value );
}



// this code will run for form 420 only; change 420 to your form ID
add_filter('gform_validation_7', 'verify_minimum_age');
function verify_minimum_age($validation_result){

    // retrieve the $form
    $form = $validation_result['form'];

        // date of birth is submitted in field 5 in the format YYYY-MM-DD
        // change the 5 here to your field ID
        $dob = rgpost('input_7');

        // this the minimum age requirement we are validating
        $minimum_age = 18;

        // calculate age in years like a human, not a computer, based on the same birth date every year
$age = date('Y') - substr($dob, 6, 4);
if (strtotime(date('Y-m-d')) - strtotime(date('Y') . '-' . substr($dob, 0, 2) . '-' . substr($dob, 3, 2)) < 0) {

        //$age = date('Y') - substr($dob, 0, 4);
        //if (strtotime(date('Y-m-d')) - strtotime(date('Y') . substr($dob, 4, 6)) < 0){
            $age--;
        }
 
    // is $age less than the $minimum_age?
    if( $age < $minimum_age ){
 
        // set the form validation to false if age is less than the minimum age
        $validation_result['is_valid'] = false;
 
        // find field with ID of 5 and mark it as failed validation
        foreach($form['fields'] as &$field){
 
            // NOTE: replace 5 with the field you would like to mark invalid
            if($field['id'] == '7'){
                $field['failed_validation'] = true;
                $field['validation_message'] = "Sorry, you must be at least $minimum_age years of age to apply for a mortgage.";
                break;
            }
 
        }
 
    }
    // assign modified $form object back to the validation result
    $validation_result['form'] = $form;
    return $validation_result;
}

//Fire this on form 7

// this code will run for form 420 only; change 420 to your form ID
add_filter('gform_validation_5', 'verify_minimum_age2');
function verify_minimum_age2($validation_result){

    // retrieve the $form
    $form = $validation_result['form'];

        // date of birth is submitted in field 5 in the format YYYY-MM-DD
        // change the 5 here to your field ID
        $dob = rgpost('input_48');

        // this the minimum age requirement we are validating
        $minimum_age = 18;

        // calculate age in years like a human, not a computer, based on the same birth date every year
$age = date('Y') - substr($dob, 6, 4);
if (strtotime(date('Y-m-d')) - strtotime(date('Y') . '-' . substr($dob, 0, 2) . '-' . substr($dob, 3, 2)) < 0) {

        //$age = date('Y') - substr($dob, 0, 4);
        //if (strtotime(date('Y-m-d')) - strtotime(date('Y') . substr($dob, 4, 6)) < 0){
            $age--;
        }
 
    // is $age less than the $minimum_age?
    if( $age < $minimum_age ){
 
        // set the form validation to false if age is less than the minimum age
        $validation_result['is_valid'] = false;
 
        // find field with ID of 5 and mark it as failed validation
        foreach($form['fields'] as &$field){
 
            // NOTE: replace 5 with the field you would like to mark invalid
            if($field['id'] == '48'){
                $field['failed_validation'] = true;
                $field['validation_message'] = "Sorry, you must be at least $minimum_age years of age to apply for a mortgage.";
                break;
            }
 
        }
 
    }
    // assign modified $form object back to the validation result
    $validation_result['form'] = $form;
    return $validation_result;
}




//tell wordpress to register the demolistposts shortcode
add_shortcode("prepopulate-landing", "prepopulate_handler");



function prepopulate_handler() {
  //run function that actually does the work of the plugin
  $demolph_output = prepopulate_function();
  //send back text to replace shortcode in post
  return $demolph_output;
}


function prepopulate_function() {
include 'wp-content/plugins/kal_functions/longform_populate.php';
}






//tell wordpress to register the demolistposts shortcode
add_shortcode("zillow-form-page", "zfp_handler");



function zfp_handler() {
  //run function that actually does the work of the plugin
  $demolph_output = zfp_function();
  //send back text to replace shortcode in post
  return $demolph_output;
}


function zfp_function() {

ob_start(); // begin output buffering

include 'wp-content/plugins/kal_functions/zfp_output.php';

$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
    return $output;


}




//tell wordpress to register the demolistposts shortcode
add_shortcode("mdm-form-landing", "mdm_landing_handler");



function mdm_landing_handler() {
  //run function that actually does the work of the plugin
  $demolph_output = mdm_landing_function();
  //send back text to replace shortcode in post
  return $demolph_output;
}


function mdm_landing_function() {

ob_start(); // begin output buffering

include 'wp-content/plugins/kal_functions/mdm_form_landing.php';

$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
    return $output;


}



















//****************start function
//****************start function
//****************start function
//****************start function
//****************start function








//****************start function
//****************start function
//****************start function
//****************start function
//****************start function
//*********************** MAIN HOOK FOR FORMS
//*********************** MAIN HOOK FOR FORMS
//*********************** MAIN HOOK FOR FORMS
//*********************** MAIN HOOK FOR FORMS


add_action( 'gform_after_submission', 'load_intosessionvar_and_redirect2', 10, 2 );
function load_intosessionvar_and_redirect2( $entry, $form ) {

	session_start();

	if(!function_exists('pre')){
    function pre($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}

$entry_id=rgar( $entry, 'id' );
$form_id=rgar( $entry, 'form_id' );
$_SESSION['entry_id']=$entry_id;






if ($form_id==43) {

echo "just ran the encryption test form...";
echo "<br/>";

$input1=rgar( $entry, '1' );

$input2=rgar( $entry, '2' );

echo "input 1: ".$input1."<br/>";
echo "input 2: ".$input2."<br/>";
echo "*******************************";
echo "<br/>";

$input1a=base64_decode( $input1 );

echo "decoded: ".$input1a;
}






if ($form_id==26 || $form_id==25 || $form_id==7 || $form_id==5) {

$purchase_form=26;
$refi_form=25;


// 7
$pre_form=7;
$long_form=5;

$apiLink = 'http://ec2-54-209-66-20.compute-1.amazonaws.com:9090/api/Leads/lead';

$email=rgar( $entry, '66' );
$phone=rgar( $entry, '48' );
$first_name=rgar( $entry, '1.3' );
$last_name=rgar( $entry, '1.6' );

$appraised_value=rgar( $entry, '57' );

$loan_amount=rgar( $entry, '58' );
$purchase_price=rgar( $entry, '54' );
$down_payment=rgar( $entry, '62' );







$fico_string=rgar( $entry, '15' );



if ($fico_string=='721-759') {
	$fico='759';
}

if ($fico_string=='760+') {
	$fico='760';
}
if ($fico_string=='681-720') {
	$fico='720';
}
if ($fico_string=='641-680') {
	$fico='680';
}

if ($fico_string=='580-640') {
	$fico='640';
}







if ($form_id==$long_form) {
$loan_string=rgar( $entry, '60' );

if ($loan_string=='Purchase a new home') {
$loan_type="Purchase";
}

if ($loan_string=='Refinance my current mortgage') {
	$loan_type="Refinance";
}


$zip_code=rgar( $entry, '59.5' );

$email=rgar( $entry, '119' );
$phone=rgar( $entry, '114' );
$first_name=rgar( $entry, '53.3' );
$last_name=rgar( $entry, '53.6' );

$appraised_value=rgar( $entry, '186' );

$loan_amount=rgar( $entry, '1' );
$purchase_price=rgar( $entry, '331' );
$down_payment=rgar( $entry, '62' );

$fico="";


}


if ($form_id==$pre_form) {



$loan_type="Purchase";



	
$fico="";


$zip_code=rgar( $entry, '9.5' );

$email=rgar( $entry, '11' );
$phone=rgar( $entry, '10' );
$first_name=rgar( $entry, '8.3' );
$last_name=rgar( $entry, '8.6' );

//$appraised_value=rgar( $entry, '186' );

//$loan_amount=rgar( $entry, '1' );
$purchase_price=rgar( $entry, '178' );
$down_payment=rgar( $entry, '2' );

$loan_amount=$purchase_price-$down_payment;



}



if ($form_id==$purchase_form) {
$loan_type="Purchase";

$zip_code=rgar( $entry, '77.5' );



$email=rgar( $entry, '66' );
$phone=rgar( $entry, '48' );
$first_name=rgar( $entry, '1.3' );
$last_name=rgar( $entry, '1.6' );

$appraised_value=rgar( $entry, '57' );

//$loan_amount=rgar( $entry, '58' );
$purchase_price=rgar( $entry, '54' );
$down_payment=rgar( $entry, '62' );
$loan_amount=$purchase_price-$down_payment;

}

if ($form_id==$refi_form) {
$loan_type="Refinance";

$zip_code=rgar( $entry, '76.5' );

$email=rgar( $entry, '66' );
$phone=rgar( $entry, '48' );
$first_name=rgar( $entry, '1.3' );
$last_name=rgar( $entry, '1.6' );

$appraised_value=rgar( $entry, '57' );

$loan_amount=rgar( $entry, '58' );
$purchase_price=rgar( $entry, '54' );
$down_payment=rgar( $entry, '62' );
}




/*
$script1="<script>location.href='/purchase-options/?eid=".$entry_id."'</script>";
//printf("<script>location.href='/property-results-refi/'</script>");
printf($script1);
*/



//echo "email: ".$email."<br/>";
//echo "phone: ".$phone."<br/>";
//echo "first_name: ".$first_name."<br/>";
//echo "last_name: ".$last_name."<br/>";
//echo "appraised_value: ".$appraised_value."<br/>";
//echo "zip_code: ".$zip_code."<br/>";
//echo "loan_type: ".$loan_type."<br/>";
//echo "ficoScore: ".$fico."<br/>";
//echo "loan_amount: ".$loan_amount."<br/>";
//echo "purchase_price: ".$purchase_price."<br/>";
//echo "down_payment: ".$down_payment."<br/>";

$crm_json_array[email]=$email;
$crm_json_array[phone]=$phone;
$crm_json_array[firstName]=$first_name;
$crm_json_array[lastName]=$last_name;
$crm_json_array[ficoScore]=$fico;
$crm_json_array[propertyValue]=$appraised_value;
$crm_json_array[propertyZipCode]=$zip_code;
$crm_json_array[loanType]=$loan_type;
$crm_json_array[loanAmount]=$loan_amount;
$crm_json_array[downPayment]=$down_payment;

//echo "<br/>";
//print_r($crm_json_array);

$crm_json=json_encode($crm_json_array);

//echo "<br/>";
//echo "<br/>echo";
//echo "<br/>";
//echo $crm_json;

$data=$crm_json;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $apiLink, //URL to the API
    CURLOPT_POST => true,
    //CURLOPT_POSTFIELDS => $json,
    CURLOPT_HEADER => false, // Instead of the "-i" flag
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Accept: application/json','Content-Length: ' . strlen($data)) //Your New Relic API key
   
));


curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);



$resp = curl_exec($curl);

$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


curl_close($curl); 

//echo "<br/>";
//echo "<br/>array resp code: ";
//echo "<br/>";
//echo $code;
//echo "<br/>";
//echo "<br/>";

// put in second variable
//$gman_resp=$resp;


//print_r($resp);

//echo "<br/>";

//echo $gman_resp;

/*

add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));


$message2 ="<br/>CRM Response:<br/><br/>
Code:&nbsp;" .$code . "<br/><br/>
Json Data:<br/><br/>".$crm_json."<br/><br/>
Other response items will be added soon.
"
;


$email1="gmanbooks@gmail.com";
    $email2=$email;
    $users= $email1. "," .$email2;

$headers = 'From: MDM <gmanbooks@gmail.com>' . "\r\n";
wp_mail($users, 'MDM CRM Response', $message2 , $headers);

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );


if(!function_exists('set_html_content_type')){

function set_html_content_type()
{
	return 'text/html';
}
}


*/





if ($form_id==25) {

$script1="<script>location.href='/refinance-options/?eid=".$entry_id."'</script>";
//printf("<script>location.href='/property-results-refi/'</script>");
printf($script1);

}


if ($form_id==26) {

$script1="<script>location.href='/purchase-options/?eid=".$entry_id."'</script>";
//printf("<script>location.href='/property-results-refi/'</script>");
printf($script1);

}




}





	if ($form_id==30) {

		//$street_address=rgar( $entry, '1.1' );
//$city=rgar( $entry, '1.3' );
//$state=rgar( $entry, '1.4' );
//$zip_code=rgar( $entry, '1.5' );

		/*
		$f_name=rgar( $entry, '1.3' );
		$l_name=rgar( $entry, '1.6' );

		$email=rgar( $entry, '66' );
		$zip_code=rgar( $entry, '77.5' );
*/


		$financing_type=rgar( $entry, '2' );


//		$home_worth=rgar( $entry, '3' );
//		$amount2borrow=rgar( $entry, '4' );
//		$financing_type=rgar( $entry, '5' );
//		$down_payment=rgar( $entry, '6' );
//		$credit=rgar( $entry, '7' );
		



		

		//echo $entry_id;
		//echo "<br/>";

		//echo $financing_type;

if ($financing_type=='Refinance This Home') {
$script1="<script>location.href='/property-results-refi/?eid=".$entry_id."'</script>";


	//printf("<script>location.href='/property-results-refi/'</script>");
printf($script1);

}

if ($financing_type=='Purchase This Home') {

$script1="<script>location.href='/property-results-purchase/?eid=".$entry_id."'</script>";

printf($script1);
}
	
//	$_SESSION['financing_type']=$financing_type;
//	$_SESSION['city']=$city;
//	$_SESSION['state']=$state;
//	$_SESSION['zip_code']=$zip_code;
	
/*

		if ($form_id==30) {


	printf("<script>location.href='/purchase-options/'</script>");
		}

		if ($form_id==25) {
	printf("<script>location.href='/refinance-options/'</script>");
		}

	}
*/
    
} //close if form id =30




} // end function