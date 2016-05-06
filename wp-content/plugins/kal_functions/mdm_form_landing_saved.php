<?php
//your code here!
session_start();
$entry_id=$_SESSION['entry_id'];

if (is_null($_SESSION['entry_id'])) {
	
$entry_id=$_GET['eid'];
	
	//echo "entry id from url is: ".$entry_id."<br/>";


	
	$_SESSION['entry_id']=$entry_id;
	
}


$post_form=$_POST['post_form'];

if (is_null($_POST['post_form'])) {
$post_form="no";
}

echo "<div class='hide'>";
echo "<br/>";
echo "post form is: ".$post_form;
echo "<br/>";
echo "</div>";

	
if (is_user_logged_in()) {
		
		
		
		
		global $current_user;
      get_currentuserinfo();
      $user_id=$current_user->ID;
}
//echo "user is ".$user_id;

global $wpdb;

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=15") as $key200 => $row200) {
       
        $credit = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id") as $key200 => $row200) {
       
        $form_id = $row200->form_id;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=54") as $key200 => $row200) {
       
        $purchase_price = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=57") as $key200 => $row200) {
       
        $appraised_amount = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=58") as $key200 => $row200) {
       
        $loan_amount = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=62") as $key200 => $row200) {
       
        $down_payment = $row200->value;
}



foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=77.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}

if ($form_id==25) {
	
	foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=76.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}
	
}

if ($post_form=="yes") {


$zip_code=$_POST['zip_code'];
$down_payment=$_POST['down_payment'];
$loan_amount=$_POST['loan_amount'];
$appraised_amount=$_POST['appraised_amount'];
$purchase_price=$_POST['purchase_price'];
$form_id=$_POST['buy_refi_form'];
$credit=$_POST['credit'];
$buy_refi_form=$_POST['buy_refi_form'];


}





$timestamp=time();

echo "<div class='hide'>";
	echo "<br/>";

	echo "credit: ".$credit."<br/>";
	echo "loan amount: ".$loan_amount."<br/>";
	echo "appraised amount: ".$appraised_amount."<br/>";
	echo "form id: ".$form_id."<br/>";

	echo "purchase price: ".$purchase_price."<br/>";
	echo "down payment: ".$down_payment."<br/>";
echo "</div>";

//echo "zip code: ".$zip_code."<br/>";

//echo "entry id: ".$entry_id."<br/>";

/*

if ($form_id==26) {
update_user_meta( $user_id, 'loan_amount', $purchase_price);

}

if ($form_id==25) {

update_user_meta( $user_id, 'loan_amount', $loan_amount);

}

*/

/*

update_user_meta( $user_id, 'entry_id', $entry_id);

update_user_meta( $user_id, 'estimated_credit', $credit);
update_user_meta( $user_id, 'entry_date', $timestamp);
update_user_meta( $user_id, 'property_appraised_amount', $appraised_amount);
*/



if ($post_form=="yes") {

$form_input1[buy_refi]=$buy_refi_form;

}

else {

$form_input1[buy_refi]=$form_id;

}


$form_input1[to_borrow]=$loan_amount;
$form_input1[home_worth]=$appraised_amount;
$form_input1[down_payment]=$down_payment;
$form_input1[purchase_price]=$purchase_price;
$form_input1[credit]=$credit;
$form_input1[zip_code]=$zip_code;
//$form_input1[buy_refi]=$buy_refi;






$implode_entries=implode("|",$form_input1);

?>

 <h2>Popular Mortgage Programs</h2>

            <p>Lenderful clients, with mortgage situations like yours, have recently selected the following products.</p>

            <p>By selecting the product that you think might best fit your needs or your preferred next step, we can start the pre-approval process and finalize your home purchase or refinance.</p>

            
            

<style>

#dropdown1{
 width:150px;   
}
</style>




            <?php

            
            if ($form_input1[buy_refi]==25) {

//echo "this is a REFI FORM...<br/>";

?>

<div class="row vertical-center-container">
	<div class="column small-12 large-3">
		<div class="blue-background lots-more-margin">
            <form method="post" class="recalculation-form" action="/refinance-options">



            	 <input type="hidden" name="buy_refi_form" value=25 />
            <input type="hidden" name="post_form" value="yes" />
            
            
            Appraised Amount<br/><input placeholder="$" type="text" name="appraised_amount" value="<?php echo $appraised_amount; ?>" onkeyup="format(this)" /><br/>
            Loan Amount<br/><input placeholder="$" type="text" name="loan_amount" value="<?php echo $loan_amount; ?>" onkeyup="format(this)" /><br/>

            <?php




}



if ($form_input1[buy_refi]==26) {

    $purchase_price_display=number_format($purchase_price);

//	echo "this is a PURCH FORM...<br/>";
	
?>

<div class="row">
	<div class="column small-12 large-3">
		<div class="blue-background lots-more-margin">
            <form method="post" class="recalculation-form" action="/purchase-options">

            <input type="hidden" name="buy_refi_form" value=26 />
            <input type="hidden" name="post_form" value="yes" />
            
            <!--
            Purchase Price<br/><input type="text" name="purchase_price" value="<?php echo number_format($purchase_price); ?>" /><br/>
            Down Payment<br/><input type="text" name="down_payment" value="<?php echo number_format($down_payment); ?>" /><br/>
           -->

           Purchase Price<br/><input placeholder="$" type="text" name="purchase_price" value="<?php echo $purchase_price; ?>" onkeyup="format(this)" /><br/>
            Down Payment<br/><input placeholder="$" type="text" name="down_payment" value="<?php echo $down_payment; ?>"  onkeyup="format(this)" /><br/>

            

            <?php




}


?>
 Zip Code<br/><input type="text" name="zip_code" value="<?php echo $zip_code; ?>" /><br/>

            Credit<br/><select name="credit" id="dropdown1">
            <?php
            if ($credit=="760+") {

            ?>
            <option value="760+" selected>760+</option>
            <?php

            }

            else {

            	 ?>
            <option value="760+" >760+</option>
            <?php

            }


            if ($credit=="721-759") {

            ?>
            <option value="721-759" selected>721-759</option>
            <?php

            }

            else {

            	 ?>
            <option value="721-759" >721-759</option>
            <?php

            }



             if ($credit=="681-720") {

            ?>
            <option value="681-720" selected>681-720</option>
            <?php

            }

            else {

            	 ?>
            <option value="681-720" >681-720</option>
            <?php

            }

            if ($credit=="641-680") {

            ?>
            <option value="641-680" selected>641-680</option>
            <?php

            }

            else {

            	 ?>
            <option value="641-680" >641-680</option>
            <?php

            }


            if ($credit=="580-640") {

            ?>
            <option value="580-640" selected>580-640</option>
            <?php

            }

            else {

            	 ?>
            <option value="580-640" >580-640</option>
            <?php

            }



            
            

            ?>

            
 
</select>

            <input type="submit" class="button green rounded" value="Submit" />

</form>
	</div>
	</div>

	<div class="column small-12 large-9">


<?php


            



echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');



//echo do_shortcode('[ldf_products_quote_table]');
?>
</div>
</div>
</div>