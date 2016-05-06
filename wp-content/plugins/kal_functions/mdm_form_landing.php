<?php
//your code here!
session_start();
$entry_id=$_SESSION['entry_id'];

//echo "entry id from SESSION is: ".$entry_id."<br/>";

if (is_null($_SESSION['entry_id'])) {
	
$entry_id=$_GET['eid'];
	
//	echo "entry id from url is: ".$entry_id."<br/>";


	
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

//if (is_null($_SESSION['entry_id'])) {

//$_SESSION['entry_id']=1;
//}


}





$timestamp=time();

//echo "<br/>";

//echo "credit: ".$credit."<br/>";
//echo "loan amount: ".$loan_amount."<br/>";
//echo "appraised amount: ".$appraised_amount."<br/>";
//echo "form id: ".$form_id."<br/>";

//echo "purchase price: ".$purchase_price."<br/>";
//echo "down payment: ".$down_payment."<br/>";
echo "</div>";


//echo "<br/>";

//echo "credit: ".$credit."<br/>";
//echo "loan amount: ".$loan_amount."<br/>";
//echo "appraised amount: ".$appraised_amount."<br/>";
//echo "form id: ".$form_id."<br/>";

//echo "purchase price: ".$purchase_price."<br/>";
//echo "down payment: ".$down_payment."<br/>";

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

//echo "<br/>";
//print_r($form_input1);
//echo "<br/>";


$implode_entries=implode("|",$form_input1);

?>


            <?php




 if ($form_input1[buy_refi]!=25 AND $form_input1[buy_refi]!=26 ) {

//echo "have neither form input - need to get from page id";
//echo "<br/>";
//echo "<br/>";
$post_id = get_the_ID();
//echo "post: ".$post_id;
//echo "<br/>";
//echo "<br/>";


if ($post_id==12866) {
$form_input1[buy_refi]=25;
}

if ($post_id==12868) {
$form_input1[buy_refi]=26;
}

//echo "form id is now set to: ".$form_input1[buy_refi];
//echo "<br/>";
//echo "<br/>";

 }


            
 if ($form_input1[buy_refi]==25) {

//echo "this is a REFI FORM...<br/>";

    ?>
    <form method="post" class="recalculation-form" action="/refinance-options">


          <input type="hidden" name="buy_refi_form" value=25 />
          <input type="hidden" name="post_form" value="yes" />
<div class="row">
<div class="col-xs-12 col-md-9">
	<div class="row">
		<div class="col-xs-12 col-md-2">
			<div class="options-form-label">HOME</div>
		</div>
		<div class="col-xs-12 col-md-5">
			<label>Appraised Amount</label><br>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" class="form-control" placeholder="Appraised Amount" name="appraised_amount" value="<?php echo $appraised_amount; ?>" />
					<div class="input-group-addon">.00</div>
				</div>
		</div>
		<div class="col-xs-12 col-md-5">
		 <?php if ($form_input1[buy_refi]==25) { ?>
			<label for="loanamount">Loan Amount</label><br>
				<div class="input-group more-bottom-margin">
				<div class="input-group-addon">$</div>
			<input type="text" class="form-control" name="loan_amount" placeholder="Loan Amount" value="<?php echo $loan_amount; ?>" />
				<div class="input-group-addon">.00</div>
			</div>
			<?php } if ($form_input1[buy_refi]==26) { ?>
			<label for="downpayment">Down Payment</label>
			<div class="input-group more-bottom-margin">
				<div class="input-group-addon">$</div>
				<input id="downpayment" class="form-control" type="text" placeholder="Down Payment" name="down_payment" value="<?php echo $down_payment; ?>" />
				<div class="input-group-addon">.00</div>
			</div>
			<?php   
		    
			}
		?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-2">
			<div class="options-form-label">FINANCE</div>
		</div>
		<div class="col-xs-12 col-md-5">
			<div class="form-group">
				<label for="zipcode">Zip Code</label><br>
				<input id="zipcode" class="form-control" type="text" placeholder="Zip Code" name="zip_code" value="<?php echo $zip_code; ?>" />
			</div>
		</div>
	
          <?php




      }



if ($form_input1[buy_refi]==26) {

    $purchase_price_display=number_format($purchase_price);

//	echo "this is a PURCH FORM...<br/>";

    ?>

    <form method="post" class="recalculation-form" action="/purchase-options">
            <input type="hidden" name="buy_refi_form" value=26 />
            <input type="hidden" name="post_form" value="yes" />

            <!--
            Purchase Price<br/><input type="text" name="purchase_price" value="<?php echo number_format($purchase_price); ?>" /><br/>
            Down Payment<br/><input type="text" name="down_payment" value="<?php echo number_format($down_payment); ?>" /><br/>
        -->
<div class="row">
<div class="col-xs-12 col-md-9">	 
	<div class="row">
		<div class="col-xs-12 col-md-2">
			<div class="options-form-label more-bottom-margin">HOME</div>
		</div>
		<div class="col-xs-12 col-md-5 more-bottom-margin">
			<label for="purchaseprice">Purchase Price</label><br>
			<div class="input-group more-bottom-margin">
				<div class="input-group-addon">$</div>
			<input type="text" id="purchaseprice" class="form-control" placeholder="Purchase Price" name="purchase_price" value="<?php echo $purchase_price; ?>" />
				<div class="input-group-addon">.00</div>
				</div>
		</div>
		<div class="col-xs-12 col-md-5 more-bottom-margin">
			 <?php if ($form_input1[buy_refi]==25) { ?>
			 <label for="loanamount">Loan Amount</label><br>
			 <div class="input-group more-bottom-margin">
				<div class="input-group-addon">$</div>
			<input type="text" id="loanamount" class="form-control" name="loan_amount" placeholder="Loan Amount" value="<?php echo $loan_amount; ?>" />
				<div class="input-group-addon">.00</div>
				</div>
			<?php } if ($form_input1[buy_refi]==26) { ?>
			<label for="downpayment">Down Payment</label><br>
			 <div class="input-group more-bottom-margin">
			 <div class="input-group-addon">$</div>
			<input id="downpayment" type="text" placeholder="Down Payment" class="form-control" name="down_payment" value="<?php echo $down_payment; ?>" />
			<div class="input-group-addon">.00</div>
				</div>
			<?php   
		    
			}
			?>		
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-2">
			<div class="options-form-label more-bottom-margin">FINANCE</div>
		</div>
		<div class="col-xs-12 col-md-5 more-bottom-margin">
			<label for="zipcode">Zip Code</label><br>
			<input id="zipcode" class="form-control" type="text" placeholder="Zip Code" name="zip_code" value="<?php echo $zip_code; ?>" />
		</div>

					<?php
				}
				?>
		<div class="col-xs-12 col-md-5 more-bottom-margin">
				<label for="credit">Credit</label><br>
					<select id="credit" name="credit" class="form-control" placeholder="Credit" id="dropdown1">
					<option value="Select One" selected>Select One</option>
						     <?php
						     if ($credit=="760+") {

						     ?>
						     <option value="760+">760+</option>
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
		</div>
	</div>
</div>
<div class="col-xs-12 col-md-3">
            <input type="submit" class="btn btn-primary btn-block recalc-submit" value="Recalculate" />
</div>
</div>
</form>


<div class="row">
	<div class="col-xs-12">


<?php


//echo "<br/>";
//echo "<br/>";
//echo $implode_entries;
//echo "<br/>";
//echo "<br/>";



echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');



//echo do_shortcode('[ldf_products_quote_table]');
?>
	</div>
</div>