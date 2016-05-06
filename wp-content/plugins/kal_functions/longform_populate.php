<?php
//your code here!
session_start();
$entry_id=$_SESSION['entry_id'];



global $wpdb;

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id") as $key200 => $row200) {
       
        $form_id = $row200->form_id;
}

if ($form_id==7) {

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 9.1") as $key200 => $row200) {
       
        $street_address = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 9.2") as $key200 => $row200) {
       
        $address2 = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 9.3") as $key200 => $row200) {
       
        $city = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 9.4") as $key200 => $row200) {
       
        $state = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 9.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}



foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 8.3") as $key200 => $row200) {
       
        $first_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 8.6") as $key200 => $row200) {
       
        $last_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=10") as $key200 => $row200) {
       
        $phone = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=11") as $key200 => $row200) {
       
        $email = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=7") as $key200 => $row200) {
       
        $dob = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=178") as $key200 => $row200) {
       
        $purchase_price = $row200->value;
}




}

if ($form_id==25) {

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 76.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 1.3") as $key200 => $row200) {
       
        $first_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 1.6") as $key200 => $row200) {
       
        $last_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=48") as $key200 => $row200) {
       
        $phone = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=66") as $key200 => $row200) {
       
        $email = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=58") as $key200 => $row200) {
       
        $loan_amount = $row200->value;
}



	
}

if ($form_id==26) {

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 77.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 1.3") as $key200 => $row200) {
       
        $first_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 1.6") as $key200 => $row200) {
       
        $last_name = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=48") as $key200 => $row200) {
       
        $phone = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=66") as $key200 => $row200) {
       
        $email = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=54") as $key200 => $row200) {
       
        $purchase_price = $row200->value;
}


	
}

/*

echo $form_id;
echo "<br/>";
echo $first_name;
echo "<br/>";
echo $last_name;
echo "<br/>";
echo $zip_code;
echo "<br/>";
echo $phone;
echo "<br/>";
echo $email;

echo "<br/>";

echo $street_address;
echo "<br/>";
echo $address2;
echo "<br/>";
echo $city;
echo "<br/>";
echo $state;
echo "<br/>";
echo $zip_code;
*/

if ($form_id==7) {


$email4="zip1=".$zip_code."&First_Name=".$first_name."&Last_Name=".$last_name."&E_Mail=".$email."&7_Digits=".$phone."&address1=".$street_address."&address2=".$address2."&city=".$city."&state=".$state."&purchase_price=".$purchase_price."&dob=".$dob;

}





//$email3="the@qwe.com";
//$email4="email2=".$email3;
if ($form_id==25) {

$email4="zip1=".$zip_code."&First_Name=".$first_name."&Last_Name=".$last_name."&E_Mail=".$email."&7_Digits=".$phone."&Loan_Amount=".$loan_amount;

}

if ($form_id==26) {

$email4="zip1=".$zip_code."&First_Name=".$first_name."&Last_Name=".$last_name."&E_Mail=".$email."&7_Digits=".$phone."&purchase_price=".$purchase_price;

}
/*
//echo do_shortcode('[gravityform id="27" field_values="email2=gman1&parameter_name2=value2"]');
//echo do_shortcode("[gravityform id='27' field_values='email2='<?php echo $email3; ?>']");
//echo do_shortcode('[add_to_cart id="'.$prod_id.'" showprice="no"        ]');
*/


echo do_shortcode('[gravityform id="5" field_values="'.$email4.'"]');








/*

$form_input1[buy_refi]=$form_id;
$form_input1[to_borrow]=$loan_amount;
$form_input1[home_worth]=$appraised_amount;
$form_input1[down_payment]=$down_payment;
$form_input1[purchase_price]=$purchase_price;
$form_input1[credit]=$credit;






$implode_entries=implode("|",$form_input1);

echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');
*/


//echo do_shortcode('[ldf_products_quote_table]');
?>