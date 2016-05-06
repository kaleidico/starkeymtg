<?php
//your code here!
session_start();
$entry_id=$_SESSION['entry_id'];

if (is_null($entry_id)) {

//if ($entry_id=="") {

	$entry_id=$_GET['eid'];
//echo "<br/>";
//echo "Sorry but your form input was not received on the page.  Please try again.";
//echo "entry id from session is: ".$entry_id;
//echo "<br/>";
}

else {

//echo "<br/>";
//echo "entry id from session is: ".$entry_id;
//echo "<br/>";

}


// BEGIN TEMPORARY HIDING
echo "<div class='hide'>";
// END TEMPORARY HIDING -- SEE LINE 662 FOR ENDING DIV TAG
	
	echo "<br/>";
echo "<br/>";

	echo "entry id is: ";
	echo $entry_id;
	echo "<br/>";
	echo "<br/>";

/*

if (is_user_logged_in()) {
		
		
		
		
		global $current_user;
      get_currentuserinfo();
      $user_id=$current_user->ID;
}
//echo "user is ".$user_id;

*/

global $wpdb;



foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1) = 1.1") as $key200 => $row200) {
       
        $street_address = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1)=1.3") as $key200 => $row200) {
       
        $city = $row200->value;
}


foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1)=1.4") as $key200 => $row200) {
       
        $state = $row200->value;
}



foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND ROUND(field_number,1)=1.5") as $key200 => $row200) {
       
        $zip_code = $row200->value;
}





foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=7") as $key200 => $row200) {
       
        $credit = $row200->value;
}


foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id") as $key200 => $row200) {
       
        $form_id = $row200->form_id;
}


foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=2") as $key200 => $row200) {
       
        $financing_type = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=3") as $key200 => $row200) {
       
        $home_worth = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=4") as $key200 => $row200) {
       
        $to_borrow = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=6") as $key200 => $row200) {
       
        $down_payment = $row200->value;
}

foreach( $wpdb->get_results("SELECT * FROM wp_rg_lead_detail WHERE lead_id=$entry_id AND field_number=5") as $key200 => $row200) {
       
        $purchase_price = $row200->value;
}


echo $street_address;
echo "<br/>";
echo $city;
echo "<br/>";
echo $zip_code;
echo "<br/>";
echo $state;
echo "<br/>";
echo $form_id;
echo "<br/>";
echo $credit;
echo "<br/>";
echo $financing_type;
echo "<br/>";
echo $home_worth;
echo "<br/>";
echo $to_borrow;

echo "<br/>";
echo $down_payment;

echo "<br/>";
echo $purchase_price;




if(!function_exists('pre')){
    function pre($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}	

?>
<div id="shrink_text1" style="font-size: 75%;">
<?php	

/*

$street_address=rgar( $entry, '1.1' );
$city=rgar( $entry, '1.3' );
$state=rgar( $entry, '1.4' );
$zip_code=rgar( $entry, '1.5' );

*/

echo "<br/>";

echo "<u>Inputted Address:</u><br/>";
echo "Street Address: ".$street_address;
echo "<br/>";
echo "City: ".$city;
echo "<br/>";
echo "State: ".$state;
echo "<br/>";
echo "Zip: ".$zip_code;
echo "<br/>";
echo "<br/>";

$address2=$street_address;
$city=$city;
$state=$state;
$zip=$zip_code;

$city2=$city.", ".$state." ".$zip;





$zw_id='X1-ZWz19yuvk9be2z_64j9s';


echo "<br/>";
echo "Url encoded address: ";


$address3=urlencode($address2);
echo $address3;
echo "<br/>";
echo "Url encoded city: ";

$city3=urlencode($city2);
echo $city3;
echo "<br/>";
echo "<br/>";
echo "<br/>";




//****************start new api call
//****************start new api call
//****************start new api call
//****************start new api call
// Get Search Results
// Get Search Results
// Get Search Results
// Get Search Results

//echo "<br/>";
//echo "************GET Search Results<br/>";
//echo "<br/>";


$gc_api_call1='http://www.zillow.com/webservice/GetSearchResults.htm?zws-id='.$zw_id.'&address='.$address3.'&citystatezip='.$city3;





$gc_id3=$gc_api_call1;



$response3 = file_get_contents($gc_id3);


$xml = simplexml_load_string($response3);

//pre($xml);

//put xml stuff into normal array (with values still being xml objects)
$api_details['zpid']=$xml->response->results->result->zpid;

//decode and put into another array (now just values and not objects; but values are still arrays with one item)
$array_gman = json_decode(json_encode($api_details), true);



//clear first array
$array_details=array();


//finally make it so values are just in normal array key/value pairs...
foreach ($array_gman as $key=>$value) {

$array_details[$key]=$value[0];

}

//echo "<br/>";
//echo "<br/>";

//echo "<br/>";


$zpid=$array_details['zpid'];




//ggggggggggggggggg

//****************start new api call
//****************start new api call
//****************start new api call
//****************start new api call
// Get Updated Property Details
// Get Updated Property Details
// Get Updated Property Details
// Get Updated Property Details
// Get Updated Property Details
// Get Updated Property Details


echo "<br/>";
echo "************GET UPDATED PROP DETAILS<br/>";
echo "<br/>";

$gc_api_call1='http://www.zillow.com/webservice/GetUpdatedPropertyDetails.htm?zws-id='.$zw_id.'&zpid='.$zpid;




$gc_id3=$gc_api_call1;



$response3 = file_get_contents($gc_id3);


$xml2 = simplexml_load_string($response3);



//put xml stuff into normal array (with values still being xml objects)
$api_details2['image_url']=$xml2->response->images->image->url;


$api_details2['message_code']=$xml2->message->code;


$api_details2['page_view_current']=$xml2->response->pageViewCount->currentMonth;
$api_details2['pageview_total']=$xml2->response->pageViewCount->total;

$api_details2['latitude']=$xml2->response->address->latitude;
$api_details2['longitude']=$xml2->response->address->longitude;

$api_details2['links-photogallery']=$xml2->response->links->photoGallery;
$api_details2['links-homeinfo']=$xml2->response->links->homeInfo;

$api_details2['links-homeinfo']=$xml2->response->links->homeInfo;

$api_details2['numFloors']=$xml2->response->editedFacts->numFloors;
$api_details2['numRooms']=$xml2->response->editedFacts->numRooms;
$api_details2['roof']=$xml2->response->editedFacts->roof;
$api_details2['parkingType']=$xml2->response->editedFacts->parkingType;
$api_details2['coveredParkingSpaces']=$xml2->response->editedFacts->coveredParkingSpaces;
$api_details2['heatingSources']=$xml2->response->editedFacts->heatingSources;
$api_details2['heatingSystem']=$xml2->response->editedFacts->heatingSystem;
$api_details2['coolingSystem']=$xml2->response->editedFacts->coolingSystem;
$api_details2['appliances']=$xml2->response->editedFacts->appliances;
$api_details2['rooms']=$xml2->response->editedFacts->rooms;
$api_details2['architecture']=$xml2->response->editedFacts->architecture;

$api_details2['homeDescription']=$xml2->response->homeDescription;
$api_details2['schoolDistrict']=$xml2->response->schoolDistrict;



$image_count=count($api_details2['image_url']);


$array_gman2 = json_decode(json_encode($api_details2), true);



//finally make it so values are just in normal array key/value pairs...
foreach ($array_gman2 as $key=>$value) {

$array_updated_details_final[$key]=$value[0];




}







//finally make it so values are just in normal array key/value pairs...
foreach ($array_gman2[message_code] as $key=>$value) {
$message_code3[$key]=$value;
}

if ($message_code3[0]!=0) {
echo "<br/>";
echo "<br/>";

	echo "We are sorry but there are no updated details for this property...";

	echo "<br/>";
	echo "<br/>";
	}

	else {

		//pre($xml2);

		//finally make it so values are just in normal array key/value pairs...
foreach ($array_gman2[image_url] as $key=>$value) {
$api_details3[$key]=$value;
}



//print_r($api_details2);
//echo "<br/>";
//echo "<br/>";
//echo "<br/>";

//echo "<br/>";
//echo "<br/>";
//echo "print r array gman2<br/>";

//echo "<br/>";
//print_r($array_gman2);
//echo "<br/>";
//echo "<br/>";
//echo "<br/>";

//echo "<br/>";
//echo "print r api details 3<br/>";
//echo "<br/>";
//print_r($api_details3);
//echo "<br/>";
//echo "<br/>";
//echo "<br/>";


echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "image count= ".$image_count;
echo "<br/>";
echo "<br/>";

foreach ($api_details3 as $value3) {

?>
<img src="<?php echo $value3; ?>">
<?php

}


echo "<br/>";

pre($array_updated_details_final);

echo "<br/>";
echo "<br/>";

//print_r($message_code3);

}


//222222222222222222222222222222

//****************start new api call
//****************start new api call
//****************start new api call
//****************start new api call
// Get Zestimate
// Get Zestimate
// Get Zestimate
// Get Zestimate
// Get Zestimate
// Get Zestimate
// Get Zestimate

echo "<br/>";
echo "************GET ZESTIMATE<br/>";
echo "<br/>";

$gc_api_call1='http://www.zillow.com/webservice/GetZestimate.htm?zws-id='.$zw_id.'&zpid='.$zpid;




$gc_id4=$gc_api_call1;



$response4 = file_get_contents($gc_id4);


$xml4 = simplexml_load_string($response4);


//put xml stuff into normal array (with values still being xml objects)
$api_details_zestimate['message_code']=$xml4->message->code;

$api_details_zestimate['z_amount']=$xml4->response->zestimate->amount;
//$api_details_zestimate['z_last_updated']=$xml4->response->zestimate->'last-updated';

$api_details_zestimate['z_valuation_low']=$xml4->response->zestimate->valuationRange->low;

$api_details_zestimate['z_valuation_high']=$xml4->response->zestimate->valuationRange->high;


//make it so it is normal array
$array_zestimate = json_decode(json_encode($api_details_zestimate), true);

//finally make it so values are just in normal array key/value pairs...
foreach ($array_zestimate as $key=>$value) {

$array_zestimate_final[$key]=$value[0];




}


if ($array_zestimate_final[message_code]!=0) {

echo "<br/>";
echo "<br/>";
echo "We are sorry but there is no Zestimate data for this property...";
echo "<br/>";
echo "<br/>";
}



else {

//pre($xml4);

//echo "<br/>";
//echo "<br/>";
//echo "<br/>";

//pre ($array_zestimate);

echo "<br/>";
echo "<br/>";
//echo "<br/>";

pre($array_zestimate_final);

echo "<br/>";
echo "<br/>";
echo "<br/>";

}





//****************start new api call
//****************start new api call
//****************start new api call
//****************start new api call
// Get Deep Search Results
// Get Deep Search Results
// Get Deep Search Results
// Get Deep Search Results
// Get Deep Search Results
// Get Deep Search Results
echo "<br/>";
echo "************GET DEEP SEARCH RESULTS<br/>";
echo "<br/>";




$gc_api_call1='http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id='.$zw_id.'&address='.$address3.'&citystatezip='.$city3;

$gc_id4=$gc_api_call1;



$response4 = file_get_contents($gc_id4);


$xml4 = simplexml_load_string($response4);



//put xml stuff into normal array (with values still being xml objects)
$api_details_deepresults['request_address']=$xml4->request->address;
$api_details_deepresults['request_citystatezip']=$xml4->request->citystatezip;
$api_details_deepresults['message_code']=$xml4->message->code;
$api_details_deepresults['message_text']=$xml4->message->text;

$api_details_deepresults['zpid']=$xml4->response->results->result->zpid;
$api_details_deepresults['homedetails']=$xml4->response->results->result->links->homedetails;
$api_details_deepresults['graphsanddata']=$xml4->response->results->result->links->graphsanddata;
$api_details_deepresults['mapthishome']=$xml4->response->results->result->links->mapthishome;
$api_details_deepresults['comparables']=$xml4->response->results->result->links->comparables;

$api_details_deepresults['street']=$xml4->response->results->result->address->street;
$api_details_deepresults['zipcode']=$xml4->response->results->result->address->zipcode;
$api_details_deepresults['city']=$xml4->response->results->result->address->city;
$api_details_deepresults['state']=$xml4->response->results->result->address->state;
$api_details_deepresults['latitude']=$xml4->response->results->result->address->latitude;
$api_details_deepresults['longitude']=$xml4->response->results->result->address->longitude;

$api_details_deepresults['FIPScounty']=$xml4->response->results->result->FIPScounty;
$api_details_deepresults['useCode']=$xml4->response->results->result->useCode;
$api_details_deepresults['taxAssessmentYear']=$xml4->response->results->result->taxAssessmentYear;
$api_details_deepresults['taxAssessment']=$xml4->response->results->result->taxAssessment;
$api_details_deepresults['yearBuilt']=$xml4->response->results->result->yearBuilt;
$api_details_deepresults['lotSizeSqFt']=$xml4->response->results->result->lotSizeSqFt;
$api_details_deepresults['finishedSqFt']=$xml4->response->results->result->finishedSqFt;
$api_details_deepresults['bathrooms']=$xml4->response->results->result->bathrooms;
$api_details_deepresults['bedrooms']=$xml4->response->results->result->bedrooms;
$api_details_deepresults['totalRooms']=$xml4->response->results->result->totalRooms;
$api_details_deepresults['lastSoldDate']=$xml4->response->results->result->lastSoldDate;


$api_details_deepresults1['lastSoldPrice_a']=$xml4->response->results->result->lastSoldPrice;

//$api_details_deepresults['lastSoldPrice']=$api_details_deepresults['lastSoldPrice_a'][1];



//pre($api_details_deepresults);

echo "<br/>";
echo "<br/>";
echo "<br/>";

//make it so it is normal array
$array_deepresults = json_decode(json_encode($api_details_deepresults), true);

//finally make it so values are just in normal array key/value pairs...
foreach ($array_deepresults as $key=>$value) {

$array_deepresults_final[$key]=$value[0];




}


//pre($array_deepresults_final);

echo "<br/>";
echo "<br/>";
echo "<br/>";

$array_deepresults1 = json_decode(json_encode($api_details_deepresults1), true);

//pre($array_deepresults1);

//echo "<br/>";
//echo "<br/>";
//echo "<br/>";
//echo "Last Sold Price: ".$array_deepresults1[lastSoldPrice_a][0];

$array_deepresults_final['lastSoldPrice']=$array_deepresults1[lastSoldPrice_a][0];

pre($array_deepresults_final);

echo "<br/>";
echo "<br/>";
echo "<br/>";

?>
</div>
<?php




?>
<br/>
<br/>
<a href="/zillow2/">Return to Page 1</a>

<br/>
<br/>
<?php







$form_input1[buy_refi]=$form_id;
$form_input1[to_borrow]=$loan_amount;
$form_input1[home_worth]=$appraised_amount;
$form_input1[down_payment]=$down_payment;
$form_input1[purchase_price]=$purchase_price;
$form_input1[credit]=$credit;



// BEGIN TEMPORARY HIDING
echo "</div>";
// END TEMPORARY HIDING -- SEE LINE 687 FOR MORE TEMPORARY HIDING


// Styled Output to Wordpress page.
include('zillow_output.php');















// BEGIN TEMPORARY HIDING
echo "<div class='hide'>";
// END TEMPORARY HIDING -- SEE LINE 697 FOR ENDING DIV TAG


$implode_entries=implode("|",$form_input1);



echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');

// BEGIN TEMPORARY HIDING END TAG
echo "</div>";
// END TEMPORARY HIDING END TAG










?>