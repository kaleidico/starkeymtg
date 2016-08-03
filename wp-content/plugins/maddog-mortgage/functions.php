<?php

//****************************************************

// Version 1.5 3/7/2016

//****************************************************


if(!function_exists(pre)){
    function pre($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}




add_action( 'admin_menu', 'mdm_add_admin_menu' );
add_action('admin_init', 'mdm_settings_init');

//Register mortgage plugin options page
function mdm_add_admin_menu() {

	add_menu_page( 'Mad Dog Mortgage Plugin', 'Mortgage Options', 'manage_options', 'mad_dog_mortgage', 'mad_dog_mortgage_options_page', plugins_url( 'maddog-mortgage/images/mortgage-plugin-icon.png' ), 99 );

}

//Register mortgage plugin settings using the Settings API
function mdm_settings_init() {

    //register default settings to build JSON query for API
    register_setting('mdm-settings-group', 'apiLink'); //defaults to 'https://maddogmortgage.com:8443/api'
    register_setting('mdm-settings-group', 'bearer_token'); //bearer token for oauth...

    register_setting('mdm-settings-group', 'best_execution_method'); //defaults to 'rate'

    register_setting('mdm-settings-group', 'lock_period'); //defaults to 'rate'
    register_setting('mdm-settings-group', 'quote_types_to_return'); //defaults to 'rate'
    register_setting('mdm-settings-group', 'dont_return_cached_results'); //defaults to 'rate'

    register_setting('mdm-settings-group', 'compensation_payer'); //defaults to 'rate'

    register_setting('mdm-settings-group', 'sortby'); //defaults to 'rate'
    register_setting('mdm-settings-group', 'productTypeCount'); //defaults to '1'
    register_setting('mdm-settings-group', 'loanOriginatorId'); //defaults to '1'
    register_setting('mdm-settings-group', 'loanTerm'); //defaults to '30,20,15,10'
    register_setting('mdm-settings-group', 'loanType'); //defaults to 'conventional,arm,fha,nonagency'

    register_setting('mdm-settings-group', 'commitmentPeriod'); //currently unused
    register_setting('mdm-settings-group', 'minCommitmentCredit'); //defaults to '-2'
    register_setting('mdm-settings-group', 'property_zip'); //defaults to ''
    register_setting('mdm-settings-group', 'minFICO'); //defaults to '760'
    register_setting('mdm-settings-group', 'propertyAppraisedValue'); //defaults to '315000'
    register_setting('mdm-settings-group', 'loanAmount'); //defaults to '250000'

    //register default settings for fees
    register_setting('mdm-settings-group', 'defaultFees');
    register_setting('mdm-settings-group', 'closingCosts');
    register_setting('mdm-settings-group', 'points');
    register_setting('mdm-settings-group', 'lenderFees');

    //register default settings for rates
    register_setting('mdm-settings-group', 'indexRate');
    register_setting('mdm-settings-group', 'marginRate');
}

//Create options page for collection mortgage plugin settings
function mad_dog_mortgage_options_page()
{
	?>
	<div class="wrap">
		<h2>MadDog Mortgage Plugin</h2>
		<p>This plugin allows you to integrate with the Mad Dog Mortgage online lending platform. If you have any questions or concerns about configuring these settings please contact <a href="mailto:support@kaleidico.com">support@kaleidico.com</a>.</p>

			<form method="post" action="options.php">
					<?php settings_fields('mdm-settings-group'); ?>
					<?php do_settings_sections('mdm-settings-group'); ?>
					<table class="form-table">
						<th scope="colgroup" colspan="2">API Integration</th>
							<tr valign="top">
									<th scope="row">API Link:</th>
									<td><input type="text" size="70" name="apiLink" value="<?php echo esc_attr(get_option('apiLink')); ?>"/>
									</td>
							</tr>
							<!-- NEW Bearer token field -->
							<tr valign="top">
                                    <th scope="row">Bearer Token:</th>
                                    <td><input type="text" size="70" name="bearer_token" value="<?php echo esc_attr(get_option('bearer_token')); ?>"/>
                                    </td>
                            </tr>


                            <tr valign="top">
									<th scope="row">Best Execution Method:</th>
									<td><input type="text" size="70" name="best_execution_method" value="<?php echo esc_attr(get_option('best_execution_method')); ?>"/>
									</td>
							</tr>



                            <tr valign="top">
                                    <th scope="row">Lock Period:</th>
                                    <td><input type="text" size="70" name="lock_period" value="<?php echo esc_attr(get_option('lock_period')); ?>"/>
                                    </td>
                            </tr>

                            <tr valign="top">
                                    <th scope="row">Quote Types to Return:</th>
                                    <td><input type="text" size="70" name="quote_types_to_return" value="<?php echo esc_attr(get_option('quote_types_to_return')); ?>"/>
                                    </td>
                            </tr>

                            <tr valign="top">
                                    <th scope="row">Dont Return Cached Results:</th>
                                    <td><input type="text" size="70" name="dont_return_cached_results" value="<?php echo esc_attr(get_option('dont_return_cached_results')); ?>"/>
                                    </td>
                            </tr>


                             <tr valign="top">
                                    <th scope="row">Compensation Payer:</th>
                                    <td><input type="text" size="70" name="compensation_payer" value="<?php echo esc_attr(get_option('compensation_payer')); ?>"/>
                                    </td>
                            </tr>



                             <tr valign="top">
                                    <th scope="row">Property Zip Code:</th>
                                    <td><input type="text" size="70" name="property_zip" value="<?php echo esc_attr(get_option('property_zip')); ?>"/>
                                    </td>
                            </tr>





							<tr valign="top">
								<th scope="row">Loan Originator ID:</th>
								<td><input type="text" size="5" name="loanOriginatorId" placeholder="1" value="<?php echo esc_attr(get_option('loanOriginatorId')); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">How many of similar product types do you want to display?</th>
								<td><input type="text" size="5" name="productTypeCount" placeholder="1" value="<?php echo esc_attr(get_option('productTypeCount')); ?>"/>
								</td>
							</tr>
						<th scope="colgroup" colspan="2">Mortgage Quote Assumptions and Defaults</th>
							<tr valign="top">
								<th scope="row">List loan terms you would like to quote to your customers?</th>
								<td><input type="text" size="50" name="loanTerm" placeholder="30,20,15,10" value="<?php echo esc_attr(get_option('loanTerm')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">How do you want mortgage quotes sorted?</th>
									<td>
											<select name="sortby">
													<option
															value="rate" <?php if (esc_attr(get_option('sortby')) == 'rate') echo 'selected'; ?>>
															Rate
													</option>
													<option
															value="payment" <?php if (esc_attr(get_option('sortby')) == 'payment') echo 'selected'; ?>>
															Payment
													</option>
													<option
															value="closingcost" <?php if (esc_attr(get_option('sortby')) == 'closingcost') echo 'selected'; ?>>
															Closing Cost
													</option>
													<option
															value="truecost" <?php if (esc_attr(get_option('sortby')) == 'truecost') echo 'selected'; ?>>
															True Cost
													</option>
													<option
															value="apr" <?php if (esc_attr(get_option('sortby')) == 'apr') echo 'selected'; ?>>
															APR
													</option>
													<option
															value="none" <?php if (esc_attr(get_option('sortby')) == 'none') echo 'selected'; ?>>
															None
													</option>
											</select>
									</td>
							</tr>
							<tr valign="top">
									<th scope="row">List product types you would like to quote to your customers?</th>
									<td><input type="text" size="50" name="loanType" placeholder="conventional, arm, fha, nonagency" value="<?php echo esc_attr(get_option('loanType')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">MinFICO</th>
									<td><input type="text" name="minFICO" value="<?php echo esc_attr(get_option('minFICO')); ?>"/></td>
							</tr>
							<th scope="colgroup" colspan="2">Loan Amount Assumptions and Defaults</th>
							<tr valign="top">
									<th scope="row">Loan Amount:</th>
									<td><input type="text" placeholder="250000" name="loanAmount"
														 value="<?php echo esc_attr(get_option('loanAmount')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Property Appraised Value:</th>
									<td><input type="text" placeholder="315000"name="propertyAppraisedValue"
														 value="<?php echo esc_attr(get_option('propertyAppraisedValue')); ?>"/></td>
							</tr>
							<th scope="colgroup" colspan="2">Fee Assumptions and Defaults</th>
							<tr valign="top">
									<th scope="row">Lender Fees:</th>
									<td><input type="text" name="lenderFees"
														 value="<?php echo esc_attr(get_option('lenderFees')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Closing Costs:</th>
									<td><input type="text" name="closingCosts"
														 value="<?php echo esc_attr(get_option('closingCosts')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Points:</th>
									<td><input type="text" name="points" value="<?php echo esc_attr(get_option('points')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Other Fees:</th>
									<td><input type="text" name="defaultFees"
														 value="<?php echo esc_attr(get_option('defaultFees')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Minimum Commitment Credit:</th>
									<td><input type="text" name="minCommitmentCredit"
														 value="<?php echo esc_attr(get_option('minCommitmentCredit')); ?>"/></td>
							</tr>
							<!--<tr valign="top">
									<th scope="row">Compensation Payer:</th>
									<td><input type="text" name="compensationPayer"
														 value="<?php echo esc_attr(get_option('compensationPayer')); ?>"/></td>
							</tr>
							<tr valign="top">
									<th scope="row">Commitment Period:</th>
									<td><input type="text" name="commitmentPeriod"
														 value="<?php echo esc_attr(get_option('commitmentPeriod')); ?>"/></td>-->
							</tr>
							<th scope="colgroup" colspan="2">Rate Assumptions and Defaults</th>
							<tr valign="top">
									<th scope="row">Index rate:</th>
									<td><input type="text" name="indexRate" value="<?php echo esc_attr(get_option('indexRate')); ?>"/>
									</td>
							</tr>
							<tr valign="top">
									<th scope="row">Margin:</th>
									<td><input type="text" name="marginRate" value="<?php echo esc_attr(get_option('marginRate')); ?>"/>
									</td>
							</tr>
					</table>

					<?php submit_button(); ?>

			</form>
	</div>
<?php
}

//LDF products
function read_json($jsonURL, $token1)
{

// new code for bearer token...dec 4 2015

$token1=esc_attr(get_option('bearer_token'));



$token_string="Authorization: Bearer ".$token1;


    $curl = curl_init($jsonURL);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json",$token_string));
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($status != 200) {

        global $wpdb;

        $error_timestamp=time();
        $line_number=287;
        $error_msg='Lenderful Alert: API call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));

        //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to URL $jsonURL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        die("Error: call to URL $jsonURL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);

    return $json_response;
}

function post_json($jsonURL, $jsonData, $method, $token1)
{

    $token1=esc_attr(get_option('bearer_token'));
$token_string="Authorization: Bearer ".$token1;

    $curl = curl_init($jsonURL);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json", $token_string, 'Content-Length: ' . strlen($jsonData)));
    if ($method == "POST") {
        curl_setopt($curl, CURLOPT_POST, true);
    } else {
//        curl_setopt($curl, CURLOPT_PUT, 1);
    }
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);



    if ($status != 200) {
        global $wpdb;
$error_timestamp=time();
        $line_number=337;
        $error_msg='Lenderful Alert: API call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));



        //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to quote API failed");
        error_log("Error: call to URL $jsonURL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);

    return $json_response;
}

function process_json($jsonText)
{
    return json_decode($jsonText);
}

function calculate_irr($i, $amount)
{
// Brute forcing a solution

    $begin = -$amount;
    $closest_to_0_so_far = 1;
    $r = 0;
    $step = 0.01;

// Iterate...For more precision, just add zeros. Note that it will slow down
    for ($x = 0.0001; $x < 1; $x += $step) {
        $npv_formula = $begin;
        for ($c = 1; $c < count($i); $c++) {
            // Create formula
            $npv_formula .= " + (" . $i[$c] . "/(pow(1+$x,$c)))";
        }
        // Evaluate the created formula
        eval ("(float) $" . "npv=" . $npv_formula . ";");

        // Make number positive to compare difference with 0
        if ($npv < 0) $npv *= -1;

        // Compare number closest to 0 and save it
        if ($npv < $closest_to_0_so_far) {
            $closest_to_0_so_far = $npv;
            $r = $x;
        } else {
            if ($r != 0) {
                break;
            }
        }
    }

    return $r * 100;
}

function getAmount($money)
{
    $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
    $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '', $stringWithCommaOrDot);

    return (float)str_replace(',', '.', $removedThousendSeparator);
}

//Uses API and mortgage plugin settings/defaults to create mortgage product carousel on home page
function ldf_products()
{
// Build Mad Dog Mortgage API JSON query based on plugin settings



    //$apiLink = get_option('apiLink') . "/products/quote?sortby=" . get_option('sortby') . "&count=" . get_option('productTypeCount');
    //new api link for loantek



//echo "<br/>";
//echo "<br/>test data:";
//echo "<br/>";

    //echo $test1;
    //echo "<br/>";
    //echo "<br/>";

//echo $test2;
  //  echo "<br/>";
    //echo "<br/>";



    $apiLink = get_option('apiLink');

    $log = "";

		$jsonInput = "{
          \"bestExecutionMethod\": " . get_option('best_execution_method') . ",
         \"compensationPayer\": " . get_option('compensation_payer') . ",
           \"lockPeriod\": " . get_option('lock_period') . ",
          \"quoteTypesToReturn\": [" . get_option('quote_types_to_return') . "],
          \"dontReturnCachedResults\": " . get_option('dont_return_cached_results') . ",
          \"propertyZip\": " . get_option('property_zip') . ",
          \"fico\": " . get_option('minFICO') . ",
          \"propertyAppraisedValue\": " . get_option('propertyAppraisedValue') . ",
          \"loanAmount\": " . get_option('loanAmount') . "
    }";



          $jsonArray[bestExecutionMethod]=get_option('best_execution_method');



         $jsonArray[compensationPayer]=get_option('compensation_payer');



           $jsonArray[lockPeriod]=get_option('lock_period');

          //$jsonArray[quoteTypesToReturn]=$test2;

          $jsonArray[dontReturnCachedResults]=get_option('dont_return_cached_results');


          $jsonArray[propertyZip]=get_option('property_zip');

          $jsonArray[fico]=get_option('minFICO');

          $jsonArray[propertyAppraisedValue]=get_option('propertyAppraisedValue');


          $jsonArray[loanAmount]=get_option('loanAmount');


          $gcode_json=json_encode($jsonArray);

          $gcode2=substr($gcode_json,0,-1);

          $gcode3=$gcode2.",\"quoteTypesToReturn\": ".$test2."}";

          $jsonArray=array();




$jsonInput =
        "{\"loanTerm\":&nbsp;[".get_option('loanTerm')."],
        \"loanType\":&nbsp;[".get_option('loanType')."],
        \"bestExecutionMethod\":&nbsp;\"".get_option('best_execution_method')."\",
        \"compensationPayer\":&nbsp;\"".get_option('compensation_payer')."\",
         \"lockPeriod\":&nbsp;\"".get_option('lock_period')."\",
         \"quoteTypesToReturn\":&nbsp;[".get_option('quote_types_to_return')."],
         \"dontReturnCachedResults\":&nbsp;".get_option('dont_return_cached_results').",
         \"propertyZip\":&nbsp;".get_option('property_zip').",
         \"fico\":&nbsp;".get_option('minFICO').",
         \"propertyAppraisedValue\":&nbsp;".get_option('propertyAppraisedValue').",
         \"loanAmount\":&nbsp;".get_option('loanAmount')."}";



          $jsonInput = "{
          \"loanTerm\": [" . get_option('loanTerm') . "],
          \"loanType\": [" . get_option('loanType') . "],
             \"bestExecutionMethod\":&nbsp;\"".get_option('best_execution_method')."\",
        \"compensationPayer\":&nbsp;\"".get_option('compensation_payer')."\",
         \"lockPeriod\":&nbsp;\"".get_option('lock_period')."\",
         \"quoteTypesToReturn\": [" . get_option('quote_types_to_return') . "],
         \"propertyZip\": " . get_option('property_zip') . ",
         \"fico\": " . get_option('minFICO') . ",
          \"propertyAppraisedValue\": " . get_option('propertyAppraisedValue') . ",
          \"loanAmount\": " . get_option('loanAmount') . "
    }";


    $test1=get_option('quote_types_to_return');

$test2="[".$test1."]";

$test1a=get_option('loanTerm');

$test2a="[".$test1a."]";

$test1b=get_option('loanType');

$test2b="[".$test1b."]";


$jsonArray[bestExecutionMethod]=get_option('best_execution_method');



         $jsonArray[compensationPayer]=get_option('compensation_payer');



           $jsonArray[lockPeriod]=get_option('lock_period');

          //$jsonArray[quoteTypesToReturn]=$test2;

          //$jsonArray[dontReturnCachedResults]=get_option('dont_return_cached_results');


          $jsonArray[propertyZip]=get_option('property_zip');

          $jsonArray[fico]=get_option('minFICO');

          $jsonArray[propertyAppraisedValue]=get_option('propertyAppraisedValue');


          $jsonArray[loanAmount]=get_option('loanAmount');


          $gcode_json=json_encode($jsonArray);

          $gcode2=substr($gcode_json,0,-1);

          $gcode3=$gcode2.",\"quoteTypesToReturn\": ".$test2.",";
          $gcode4=$gcode3."\"loanTerm\": ".$test2a.",";
          $gcode5=$gcode4."\"loanType\": ".$test2b."}";







          //$gcode2=stripslashes($gcode_json);

          //$gcode3=str_replace('"["CLOSEST_TO_ZERO_WITH_FEE","CLOSEST_TO_ZERO_NO_FEE"]"','["CLOSEST_TO_ZERO_WITH_FEE","CLOSEST_TO_ZERO_NO_FEE"]',$gcode2);


//$test3='"'.$test2.'"';
//$gode4=str_replace($test3,$test2,$gcode2);





 /*

$data='{
  "bestExecutionMethod": "'.get_option('best_execution_method').'",'
.'"compensationPayer": "'.get_option('compensation_payer').'",'
.'"lockPeriod": "'.get_option('lock_period').'",'
.'"quoteTypesToReturn": ['.get_option('quote_types_to_return').'],'
.'"dontReturnCachedResults": '.get_option('dont_return_cached_results').','
.'"propertyZip": "'.get_option('property_zip').'",'
.'"fico": "'.get_option('minFICO').'",'
.'"propertyAppraisedValue": "'.get_option('propertyAppraisedValue').'",'
.'"loanAmount": "'.get_option('loanAmount').'"}';

*/

$data='{
  "bestExecutionMethod": "BY_LOAN_PRODUCT",
  "compensationPayer": "LENDER",
  "lockPeriod": "D30",
  "quoteTypesToReturn": [
    "CLOSEST_TO_ZERO_WITH_FEE", "CLOSEST_TO_ZERO_NO_FEE"
  ],
  "dontReturnCachedResults": false,
  "propertyZip": "48009",
  "fico": "740",
  "propertyAppraisedValue": "350000",
  "loanAmount": "200000"
}';


$data2='{
"loanTerm": ["Y30","Y15","Y10","Y7_1"],
"loanType": ["FIXED","ARM"],
"bestExecutionMethod":"BY_POINT_GROUP",
  "compensationPayer": "BORROWER",
  "lockPeriod": "D30",
    "quoteTypesToReturn": [
    "CLOSEST_TO_ZERO_WITH_FEE","CLOSEST_TO_ZERO_NO_FEE"
  ],
  "propertyZip": 48009,
  "fico": 760,
  "propertyAppraisedValue": 250000,
  "loanAmount": 200000
}';







$jsonInput=$gcode5;


// for carousel

/*

$jsonInput=json_encode(array(
'loanTerm' => ((get_option('loanTerm') != false) ? array(get_option('loanTerm')) : 'some_deafault_value'),
'loanType' => ((get_option('loanType') != false) ? array(get_option('loanType')) : 'some_deafault_value'),
'bestExecutionMethod' => ((get_option('best_execution_method') != false) ? get_option('best_execution_method') : 'some_deafault_value'),
'compensationPayer' => ((get_option('compensation_payer') != false) ? get_option('compensation_payer') : 'some_deafault_value'),
'lockPeriod' => ((get_option('lock_period') != false) ? get_option('lock_period') : 'some_deafault_value'),
'quoteTypesToReturn' => ((get_option('quote_types_to_return') != false) ? array(get_option('quote_types_to_return')) : 'some_deafault_value'),
'propertyZip' => ((get_option('property_zip') != false) ? get_option('property_zip') : 'some_deafault_value'),
'fico' => ((get_option('minFICO') != false) ? get_option('minFICO') : 'some_deafault_value'),
'propertyAppraisedValue' => ((get_option('propertyAppraisedValue') != false) ? get_option('propertyAppraisedValue') : 'some_deafault_value'),
'loanAmount' => ((get_option('loanAmount') != false) ? get_option('loanAmount') : 'some_deafault_value')));
*/


//echo "<br/>";
//echo "<br/>";
//echo $jsonInput;
//echo "<br/>";
//echo "<br/>";

    try {
        $time_start = microtime(true);
        $token1=esc_attr(get_option('bearer_token'));
        $jsonText = post_json($apiLink, $jsonInput, "POST",$token1);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Call API Time: </b> ' . $execution_time . '<br>';
        $time_start = microtime(true);
        $products = process_json($jsonText);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Process JSON Time: </b> ' . $execution_time . '<br>';
        $log .= '<b>Total results: </b>' . count($products) . '<br>';
        $log .= '<br>';


//echo "status: ".$status;

//echo $json_response;


  //      echo "<br/>";
    //    echo "<br/>";
      //  echo $jsonInput;
       // echo "<br/>";
       // echo "<br/>";
       // echo $apiLink;
       //echo "<br/>";
       //echo "<br/>";

        //print_r($jsonText);
       //pre($products);

        if (!empty($products)) {



            //$gresp7=json_decode($products[0], true);

           // echo "vendor product id ".$products[0]->vendorProductId;

           // echo "<br/>";
            // echo "<br/>";

             //pre($gresp7);

            ?>
            <div class="fp-trending row">
                <div class="column small-12">
                    <div class="gallery js-flickity tg-gallery" data-flickity-options='{ "wrapAround": "true" }'>
                        <?php
                        $financial = new Financial();

                        //Calculate monthly payment
                        //echo "<br/>";
                       // echo "******* TERM= ".$lp->productTerm;
                       // echo "<br/>";

                        //$min_term = intval($lp->matchedTerm) == 0 ? 30 : intval($lp->matchedTerm);
                        $min_term = intval($lp->matchedTerm) == 0 ? 30 : intval($lp->matchedTerm);

                        $min_amount = intval(get_option('loanAmount'));
                        $full_amount = intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees')) + intval(get_option('loanAmount'));

                        // add in points
                        $points = intval(get_option('points'));
                        if (empty($points)) $points = 0;
                        $min_amount = ($points / 100) * $min_amount + $min_amount;

                        // for ARM products
                        $adjustment_months = intval($lp->rateAdjustmentPeriod) == 0 ? 12 : intval($lp->rateAdjustmentPeriod);
                        $rate_remain_fixed = intval($lp->minTerm);
                        $max_rate = floatval($lp->interestRateCap);

                        foreach ($products as $lp) {
                            //$start_interest_rate = floatval($lp->interestRate) / 100;
                            $start_interest_rate = floatval($lp->rate) / 100;


                            //$min_term = intval($lp->matchedTerm);
                            $min_term = intval($lp->productTerm);
                            // change from $balance = $min_amount
                            $balance = $min_amount + intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees'));
                            $start_monthly_payment = ($start_interest_rate / 12 * $min_amount) / (1 - pow(1 + $start_interest_rate / 12, -$min_term * 12));

                            if ($lp->arm !== false || $lp->arm !== 'false') {
                                $adjustment_expected = floatval(get_option('marginRate')) == 0 ? 0 : (floatval(get_option('marginRate')) / 100);
                                $rate_remain_fixed = intval($lp->rateAdjustmentPeriod) == 0 ? intval($lp->matchedTerm) : intval($lp->rateAdjustmentPeriod);
                                $indexRate = floatval(get_option('indexRate')) == 0 ? $start_interest_rate : (floatval(get_option('indexRate')) / 100);

                                //Calculate APR
                                $payment_dues = array();
                                $payment_dues[] = -$min_amount;

                                for ($i = 1; $i <= $min_term * 12; $i++) {
                                    if ($i <= $rate_remain_fixed * 12) {
                                        $payment_due = $start_monthly_payment;
                                        $interest_rate = $start_interest_rate;
                                        $interest = $interest_rate / 12 * $balance;
                                    } else {
                                        $interest_rate = ($indexRate + $marginRate) > $max_rate ? $max_rate : ($indexRate + $marginRate);
                                        $interest_rate = $indexRate + (floor(($i - 1 - $rate_remain_fixed * 12) / $adjustment_months) + 1) * $adjustment_expected;
                                        $interest = $interest_rate / 12 * $balance;
                                        $payment_due = -$financial->PMT($interest_rate / 12, $min_term * 12 - $i + 1, $balance);
                                    }
                                    $principal = $payment_due - $interest;
                                    if ($i == $min_term * 12) {
                                        $payment_due = $balance;
                                        $balance = 0;
                                    } else {
                                        $balance = $balance - $principal;
                                    }
                                    $payment_dues[] = $payment_due;
                                }
                                $apr = $financial->IRR($payment_dues) * 12;
                            } else {
                                $apr = $start_interest_rate;
                              }


                              //$new_prod_name=$lp->productTerm." ".$lp->productType." ".$lp->productFamily;

                              if ($lp->productType=='FIXED') {
                                    $new_prod_name=$lp->productTerm." YEAR ".$lp->productType." ".$lp->productFamily;
                                    }

                        else {

                        $new_prod_name=$lp->productTerm." ".$lp->productType." ".$lp->productFamily;

                        }


                            ?>
                            <div class="gallery-cell tg-cell">
                                <div class="tg-top">
                                    <p class="tg-title"><?php echo $new_prod_name; ?></p>

                                    <p class="tg-price-container"><span

                                            class="tg-price">$<?php echo number_format($lp->principalAndInterestPayment,2); ?></span>
                                        <span class="tg-per-month">/ mo</span></p>
                                </div>
                                <div class="tg-bottom">
                                    <p class="center select-button"><a href="<?php echo get_page_link(2263); ?>" class="btn-block caps more-top-margin btn orange btn-primary btn-large">Get Approved</a>
                                    </p>

                                    <p>
                                    	<span class="tg-number-label">Rate:</span> <span class="tg-number"><?php echo number_format($lp->rate, 3); ?>%</span><br>
                                        <span class="tg-number-label">APR:</span> <span class="tg-number"><?php echo number_format($lp->apr, 3); ?>%</span><br>
                                        <span class="tg-number-label">Fees:</span> <span class="tg-number">$<?php echo $lp->quoteFees; ?></span>
                                    </p>
                                </div>
                                <div class="tg-details-container">
                                  <div class="loan-details-buttons"><a class="show-button"><img src="<?php echo get_template_directory_uri(); ?>/img/icon-plus.png" alt=""> Loan Details</a><a class="hide-button"><img src="<?php echo get_template_directory_uri(); ?>/img/icon-minus.png" alt=""> Loan Details</a></div>
                                 <p class="tg-more-details">
                                    <!--<span class="tg-number tg-description"><?php echo $lp->lenderProductName; ?></span><br>-->
                                    <span class="tg-number-label">Loan Amount:</span>
                                    <span class="tg-number">$<?php echo get_option('loanAmount'); ?><span><br>
                                    <!--
                                    <span class="tg-number-label">Loan Term:</span>
                                    <span class="tg-number"><?php echo $lp->matchedTerm; ?><span> Years<br>
                                    -->
                                    <?php

                                    if ($lp->productType=='FIXED') {
                                    $int_cap='N/A';
                                    }

                                    else {

                                     $int_cap=$lp->armDetails->initialCap.", ".$lp->armDetails->periodicCap.", ".$lp->armDetails->lifetimeCap;



                                    }


                                    ?>


                                    <span class="tg-number-label">Interest Rate Cap:</span>
                                    <!--
                                    <span class="tg-number"><?php echo $lp->interestRateCap == 0 ? $lp->interestRate : $lp->interestRateCap; ?><span><br>
                                    -->
                                        <span class="tg-number"><?php echo $int_cap; ?><span><br>


                                    <span class="tg-number-label">Credit Score:</span>
                                    <span class="tg-number"><?php echo $lp->fico; ?><span><br>
                                    <span class="tg-number-label">Loan to Value (LTV):</span>
                                    <span class="tg-number"><?php echo $lp->loanToValue; ?><span><br>
                                    <!--
                                    <span class="tg-number-label">Lender Fees:</span>
                                    <span class="tg-number">$<?php echo get_option('lenderFees'); ?><span><br>
                                  -->
                                  </p>
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>

                    <div class="carousel-footnotes">
                        <ul>
                            <li>Your actual rate, payment and costs could be higher. Get an official Loan Estimate before choosing the loan.
                            </li>
                            <li>Additional third-party fees such as lender underwriting, appraisal, credit reporting, title services, government recording, etc. will be applied at or before closing.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }catch (Exception $e) {

        global $wpdb;
$error_timestamp=time();
        $line_number=880;
        $error_msg='Lenderful Alert: API call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));





        //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
        error_log($e->getMessage());
    }

    error_log("Debug api call: ".$log);
    // wp_mail('support@kaleidico.com', 'Lenderful Alert: API call log', $log.' <br> json: '.$jsonInput);
	file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}

//unaltered function

/*
function ldf_products_quote_table($echo = false)
{
		$apiLink = get_option('apiLink') . "/products/quote?sortby=" . get_option('sortby') . "&count=" . get_option('productTypeCount');
    $log = "";

    if ($_POST['input_2'] == "refinancing my house") {
        $min_amount = getAmount($_POST['input_58']);
        $propertyAppraisedValue = getAmount($_POST['input_57']);
    } else {
        $min_amount = getAmount($_POST['input_54']) - getAmount($_POST['input_62']);
        $propertyAppraisedValue = getAmount($_POST['input_54']);
    }

    if (empty($propertyAppraisedValue) == true || $propertyAppraisedValue < 0) $propertyAppraisedValue = 500000;
    if (empty($min_amount) == true || $min_amount < 0) $min_amount = 200000;
    $min_amount = intval(get_option('closingCosts')) + intval(get_option('defaultFees')) + $min_amount;

    $points = intval(get_option('points'));
    if (empty($points)) $points = 0;
    $min_amount = ($points / 100) * $min_amount + $min_amount;

    $sortby = get_option('sortby');
    if (empty($sortby) == true) $sortby == "interest_rate";
    elseif ($sortby == 'rate') $sortby == "interest_rate";

    $max_filco_str = $_POST['input_15'];

    if (empty($max_filco_str) == true) $max_fico = 720;
    elseif($max_filco_str=='platinum (760+)') $max_fico = 760;
    elseif($max_filco_str=='gold (721-759)') $max_fico = 759;
    elseif($max_filco_str=='gold (681-720)') $max_fico = 720;
    elseif($max_filco_str=='silver (641-680)') $max_fico = 680;
    else $max_fico = 720;

    $jsonInput = "{
          \"loanOriginatorId\": " . get_option('loanOriginatorId') . ",
          \"loanTerm\": [" . get_option('loanTerm') . "],
          \"loanType\": [" . get_option('loanType') . "],
          \"compensationPayer\": \"\",
          \"commitmentPeriod\": \"\",
          \"minCommitmentCredit\": " . get_option('minCommitmentCredit') . ",
          \"propertyState\": \"\",
          \"fico\": " . $max_fico . ",
          \"propertyAppraisedValue\": " . $propertyAppraisedValue . ",
          \"loanAmount\": " . $min_amount . "
    }";

    try {
        $time_start = microtime(true);
        $token1=esc_attr(get_option('bearer_token'));
        $jsonText = post_json($apiLink, $jsonInput, "POST",$token1);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Call API Time: </b> ' . $execution_time . '<br>';
        $time_start = microtime(true);
        $products = process_json($jsonText);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Process JSON Time: </b> ' . $execution_time . '<br>';
        $log .= '<b>Total results: </b>'.count($products).'<br>';
		$log .= '<b>JSON Input: </b> ' . $jsonInput .'<br>';
		$log .= '<br>';
        if (!empty($products)) {
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery('#datatable').DataTable();
                    jQuery('#trending-section').toggle();
                });
            </script>

            <h2>Popular Mortgage Programs</h2>

            <p>Lenderful clients, with mortgage situations like yours, have recently selected the following products.</p>

            <p>By selecting the product that you think might best fit your needs or your preferred next step, we can start the pre-approval process and finalize your home purchase or refinance.</p>

            <table id="datatable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Loan Type</th>
                    <th>Monthly Payment</th>
                    <th>Rate</th>
                    <th>APR</th>
                    <th>Fees</th>
                    <th></th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Product Type</th>
                    <th>Payment</th>
                    <th>Rate</th>
                    <th>APR</th>
                    <th>Fees</th>
                    <th></th>
                </tr>
                </tfoot>


                <tbody>

                  <?php
                  $financial = new Financial();

                  //Calculate monthly payment

                  $min_term = intval($lp->matchedTerm) == 0 ? 30 : intval($lp->matchedTerm);
                  $min_amount = intval(get_option('loanAmount'));
                  $full_amount = intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees')) + intval(get_option('loanAmount'));

                  // add in points
                  $points = intval(get_option('points'));
                  if (empty($points)) $points = 0;
                  $min_amount = ($points / 100) * $min_amount + $min_amount;

                  // for ARM products
                  $adjustment_months = intval($lp->rateAdjustmentPeriod) == 0 ? 12 : intval($lp->rateAdjustmentPeriod);
                  $rate_remain_fixed = intval($lp->minTerm);
                  $max_rate = floatval($lp->interestRateCap);

                  foreach ($products as $lp) {
                      $start_interest_rate = floatval($lp->interestRate) / 100;
                      $min_term = intval($lp->matchedTerm);
                      // change from $balance = $min_amount
                      $balance = $min_amount + intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees'));
                      $start_monthly_payment = ($start_interest_rate / 12 * $min_amount) / (1 - pow(1 + $start_interest_rate / 12, -$min_term * 12));

                      if ($lp->arm !== false || $lp->arm !== 'false') {
                          $adjustment_expected = floatval(get_option('marginRate')) == 0 ? 0 : (floatval(get_option('marginRate')) / 100);
                          $rate_remain_fixed = intval($lp->rateAdjustmentPeriod) == 0 ? intval($lp->matchedTerm) : intval($lp->rateAdjustmentPeriod);
                          $indexRate = floatval(get_option('indexRate')) == 0 ? $start_interest_rate : (floatval(get_option('indexRate')) / 100);

                          //Calculate APR
                          $payment_dues = array();
                          $payment_dues[] = -$min_amount;

                          for ($i = 1; $i <= $min_term * 12; $i++) {
                              if ($i <= $rate_remain_fixed * 12) {
                                  $payment_due = $start_monthly_payment;
                                  $interest_rate = $start_interest_rate;
                                  $interest = $interest_rate / 12 * $balance;
                              } else {
                                  $interest_rate = ($indexRate + $marginRate) > $max_rate ? $max_rate : ($indexRate + $marginRate);
                                  $interest_rate = $indexRate + (floor(($i - 1 - $rate_remain_fixed * 12) / $adjustment_months) + 1) * $adjustment_expected;
                                  $interest = $interest_rate / 12 * $balance;
                                  $payment_due = -$financial->PMT($interest_rate / 12, $min_term * 12 - $i + 1, $balance);
                              }
                              $principal = $payment_due - $interest;
                              if ($i == $min_term * 12) {
                                  $payment_due = $balance;
                                  $balance = 0;
                              } else {
                                  $balance = $balance - $principal;
                              }
                              $payment_dues[] = $payment_due;
                          }
                          $apr = $financial->IRR($payment_dues) * 12;
                      } else {
                          $apr = $start_interest_rate;
                        }

                      ?>

                    <tr>
                        <td><?php echo $lp->productDescription; ?></td>
                        <td class="right-aligned">$<?php echo number_format($start_monthly_payment); ?></td>
                        <td class="right-aligned"><?php echo number_format($start_interest_rate * 100, 3); ?></td>
                        <td class="right-aligned"><?php echo number_format($apr * 100, 3); ?></td>
                        <td class="right-aligned">
                            $<?php echo intval(get_option('closingCosts')) + intval(get_option('defaultFees')); ?></td>
                        <td class="center-aligned"><a href="<?php bloginfo('siteurl'); ?>/contact-options/"
                                                      class="mortgage-products-select-button">Select</a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
        }
    } catch (Exception $e) {
        wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
        error_log($e->getMessage());
    }

    error_log("Debug api call: ".$log);
    // wp_mail('support@kaleidico.com', 'Lenderful Alert: API call log', $log.' <br> json: '.$jsonInput);
	file_put_contents('./log_debug_short_form'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}
*/

//gggggggg

function ldf_products_quote_table($atts)
{

/*
 $pull_quote_atts = shortcode_atts( array(
        'quote' => 'My Quote',
        'author' => 'Author',
    ), $atts );
*/

//$entries_string1=$pull_quote_atts[ 'entries_string' ];

    //$implode_options=implode("|",$option_array);

$entries_string1=$atts[ 'entries_string' ];

$form_input1=explode('|',$entries_string1,99);


//echo "<br/>";
//echo "<br/>";
//echo "printing array from plugin function via shortcode!";
//echo "<br/>";
//echo "<br/>";
//print_r($form_input1);
//echo "<br/>";
//echo "<br/>";



$form_id=$form_input1[0];



if ($form_id==25) {
$_POST['input_2']='refinancing my house';
}

if ($form_id==26) {
$_POST['input_2']='purchasing a house';
}








//$_POST['input_2']=$form_input[0];


$_POST['input_58']=$form_input1[1];
$_POST['input_57']=$form_input1[2];
$_POST['input_62']=$form_input1[3];
$_POST['input_54']=$form_input1[4];
$_POST['input_15']=$form_input1[5];

$zip_code=$form_input1[6];

//echo "<br/>";
//echo "<br/>";
//echo "zip code: ".$zip_code;
//echo "<br/>";
//echo "<br/>";

        //$apiLink = get_option('apiLink') . "/products/quote?sortby=" . get_option('sortby') . "&count=" . get_option('productTypeCount');

        $apiLink = get_option('apiLink');

    $log = "";

    if ($_POST['input_2'] == "refinancing my house") {
        $min_amount = getAmount($_POST['input_58']);
        $loan_amount2 = getAmount($_POST['input_58']);
        $propertyAppraisedValue = getAmount($_POST['input_57']);
    } else {
        $min_amount = getAmount($_POST['input_54']) - getAmount($_POST['input_62']);
        $loan_amount2 = getAmount($_POST['input_54']) - getAmount($_POST['input_62']);
        $propertyAppraisedValue = getAmount($_POST['input_54']);
    }

    if (empty($propertyAppraisedValue) == true || $propertyAppraisedValue < 0) $propertyAppraisedValue = 500000;
    if (empty($min_amount) == true || $min_amount < 0) $min_amount = 200000;
    $min_amount = intval(get_option('closingCosts')) + intval(get_option('defaultFees')) + $min_amount;

    $points = intval(get_option('points'));
    if (empty($points)) $points = 0;
    $min_amount = ($points / 100) * $min_amount + $min_amount;

    $sortby = get_option('sortby');
    if (empty($sortby) == true) $sortby == "interest_rate";
    elseif ($sortby == 'rate') $sortby == "interest_rate";

    $max_filco_str = $_POST['input_15'];

    /*

    if (empty($max_filco_str) == true) $max_fico = 720;
    elseif($max_filco_str=='platinum (760+)') $max_fico = 760;
    elseif($max_filco_str=='gold (721-759)') $max_fico = 759;
    elseif($max_filco_str=='gold (681-720)') $max_fico = 720;
    elseif($max_filco_str=='silver (641-680)') $max_fico = 680;
    else $max_fico = 720;

    */



    if (empty($max_filco_str) == true) $max_fico = 720;
    elseif($max_filco_str=='760+') $max_fico = 760;
    elseif($max_filco_str=='721-759') $max_fico = 759;
    elseif($max_filco_str=='681-720') $max_fico = 720;
    elseif($max_filco_str=='641-680') $max_fico = 680;
    else $max_fico = 720;

    $jsonInput = "{
          \"loanOriginatorId\": " . get_option('loanOriginatorId') . ",
          \"loanTerm\": [" . get_option('loanTerm') . "],
          \"loanType\": [" . get_option('loanType') . "],
          \"compensationPayer\": \"\",
          \"commitmentPeriod\": \"\",
          \"minCommitmentCredit\": " . get_option('minCommitmentCredit') . ",
          \"propertyState\": \"\",
          \"fico\": " . $max_fico . ",
          \"propertyAppraisedValue\": " . $propertyAppraisedValue . ",
          \"loanAmount\": " . $min_amount . "
    }";





    $test1=get_option('quote_types_to_return');

$test2="[".$test1."]";

$test1a=get_option('loanTerm');

$test2a="[".$test1a."]";

$test1b=get_option('loanType');

$test2b="[".$test1b."]";


$jsonArray[bestExecutionMethod]=get_option('best_execution_method');



         $jsonArray[compensationPayer]=get_option('compensation_payer');



           $jsonArray[lockPeriod]=get_option('lock_period');

          //$jsonArray[quoteTypesToReturn]=$test2;

          //$jsonArray[dontReturnCachedResults]=get_option('dont_return_cached_results');


          $jsonArray[propertyZip]=$zip_code;

          $jsonArray[fico]=$max_fico;

          $jsonArray[propertyAppraisedValue]=$propertyAppraisedValue;


          $jsonArray[loanAmount]=$loan_amount2;


          //if (is_null($_SESSION['entry_id'])) {

          if ($loan_amount2==0) {

//echo "<br/>looks like the session variable was lost...<br/>";





$jsonArray[propertyZip]=get_option('property_zip');

          $jsonArray[fico]=get_option('minFICO');

          $jsonArray[propertyAppraisedValue]=get_option('propertyAppraisedValue');


          $jsonArray[loanAmount]=get_option('loanAmount');




}

$zip_code3=$zip_code;
$fico3=$max_fico;
$prop_value3=$propertyAppraisedValue;
$loan_amount3=$loan_amount2;


          //if (is_null($_SESSION['entry_id'])) {

            if ($loan_amount2==0) {

//echo "<br/>looks like the session variable was lost...<br/>";


$zip_code3=get_option('property_zip');

          $fico3=get_option('minFICO');

          $prop_value3=get_option('propertyAppraisedValue');


          $loan_amount3=get_option('loanAmount');




}










          $gcode_json=json_encode($jsonArray);

          $gcode2=substr($gcode_json,0,-1);

          $gcode3=$gcode2.",\"quoteTypesToReturn\": ".$test2.",";
          $gcode4=$gcode3."\"loanTerm\": ".$test2a.",";
          $gcode5=$gcode4."\"loanType\": ".$test2b."}";

          $jsonInput=$gcode5;


$jsonInput=json_encode(array(
'loanTerm' => ((get_option('loanTerm') != false) ? array(get_option('loanTerm')) : 'some_deafault_value'),
'loanType' => ((get_option('loanType') != false) ? array(get_option('loanType')) : 'some_deafault_value'),
'bestExecutionMethod' => ((get_option('best_execution_method') != false) ? get_option('best_execution_method') : 'some_deafault_value'),
'compensationPayer' => ((get_option('compensation_payer') != false) ? get_option('compensation_payer') : 'some_deafault_value'),
'lockPeriod' => ((get_option('lock_period') != false) ? get_option('lock_period') : 'some_deafault_value'),
'quoteTypesToReturn' => ((get_option('quote_types_to_return') != false) ? array(get_option('quote_types_to_return')) : 'some_deafault_value'),
'dontReturnCachedResults' => ((get_option('dont_return_cached_results') != false) ? get_option('dont_return_cached_results') : 'some_deafault_value'),
'propertyZip' => ((get_option('property_zip') != false) ? get_option('property_zip') : 'some_deafault_value'),
'fico' => ((get_option('minFICO') != false) ? get_option('minFICO') : 'some_deafault_value'),
'propertyAppraisedValue' => ((get_option('propertyAppraisedValue') != false) ? get_option('propertyAppraisedValue') : 'some_deafault_value'),
'loanAmount' => ((get_option('loanAmount') != false) ? get_option('loanAmount') : 'some_deafault_value')));


// for carousel

$jsonInput=json_encode(array(
'loanTerm' => ((get_option('loanTerm') != false) ? array(get_option('loanTerm')) : 'some_deafault_value'),
'loanType' => ((get_option('loanType') != false) ? array(get_option('loanType')) : 'some_deafault_value'),
'bestExecutionMethod' => ((get_option('best_execution_method') != false) ? get_option('best_execution_method') : 'some_deafault_value'),
'compensationPayer' => ((get_option('compensation_payer') != false) ? get_option('compensation_payer') : 'some_deafault_value'),
'lockPeriod' => ((get_option('lock_period') != false) ? get_option('lock_period') : 'some_deafault_value'),
'quoteTypesToReturn' => ((get_option('quote_types_to_return') != false) ? array(get_option('quote_types_to_return')) : 'some_deafault_value'),
'propertyZip' => ((get_option('property_zip') != false) ? get_option('property_zip') : 'some_deafault_value'),
'fico' => ((get_option('minFICO') != false) ? get_option('minFICO') : 'some_deafault_value'),
'propertyAppraisedValue' => ((get_option('propertyAppraisedValue') != false) ? get_option('propertyAppraisedValue') : 'some_deafault_value'),
'loanAmount' => ((get_option('loanAmount') != false) ? get_option('loanAmount') : 'some_deafault_value')));

// for table

$jsonInput=json_encode(array(
'loanTerm' => ((get_option('loanTerm') != false) ? array(get_option('loanTerm')) : 'some_deafault_value'),
'loanType' => ((get_option('loanType') != false) ? array(get_option('loanType')) : 'some_deafault_value'),
'bestExecutionMethod' => ((get_option('best_execution_method') != false) ? get_option('best_execution_method') : 'some_deafault_value'),
'compensationPayer' => ((get_option('compensation_payer') != false) ? get_option('compensation_payer') : 'some_deafault_value'),
'lockPeriod' => ((get_option('lock_period') != false) ? get_option('lock_period') : 'some_deafault_value'),
'quoteTypesToReturn' => ((get_option('quote_types_to_return') != false) ? array(get_option('quote_types_to_return')) : 'some_deafault_value'),
'propertyZip' => $zip_code3,
'fico' => $fico3,
'propertyAppraisedValue' => $prop_value3,
'loanAmount' => $loan_amount3));



 $jsonInput=$gcode5;


//echo "<br/>";
//echo "<br/>";
//echo $jsonInput;
//echo "<br/>";
//echo "<br/>";


$json_decoded=json_decode($jsonInput, true);

//echo "<br/>";

//print_r($json_decoded);



//echo "<br/>";



    try {
        $time_start = microtime(true);
        $token1=esc_attr(get_option('bearer_token'));
        $jsonText = post_json($apiLink, $jsonInput, "POST",$token1);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Call API Time: </b> ' . $execution_time . '<br>';
        $time_start = microtime(true);
        $products = process_json($jsonText);
        $execution_time = microtime(true) - $time_start;
        $log .= '<b>Total Process JSON Time: </b> ' . $execution_time . '<br>';
        $log .= '<b>Total results: </b>'.count($products).'<br>';
        $log .= '<b>JSON Input: </b> ' . $jsonInput .'<br>';
        $log .= '<br>';

        $products_array=json_decode(json_encode($products), True);

         echo "<div class='hide'><br/>normal array:";

          //pre($products_array);

        foreach ($products_array as $key99=>$value99) {

            $new_product_id=$products_array[$key99][vendorProductId];
            $new_product_type=$products_array[$key99][productType];
            $new_product_term=$products_array[$key99][productTerm];

            $product_Key_guide[$new_product_id]=$key99;

            //echo $lp2->vendorProductId." | ".$lp2->productType." | ".$lp2->productTerm."<br/>";

            //echo $new_product_id." | ".$new_product_type." | ".$new_product_term."<br/>";

            if ($new_product_type=='ARM') {

                $term_string=substr($new_product_term,0,-2);



                $products_arm[$new_product_id]=$term_string;

            }

            if ($new_product_type=='FIXED') {

                $products_fixed[$new_product_id]=$new_product_term;

            }

        }

       //pre($products_arm);
        //echo "<br/>";
        //pre($products_fixed);
        //echo "<br/>";





        arsort($products_fixed);

        arsort($products_arm);

        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        echo "sorted...";

echo "<br/>";
        echo "<br/>";

        print_r($sort1);
        echo "<br/>";
        pre($sort2);
        echo "<br/>";

        pre($products_arm);
        echo "<br/>";
        pre($products_fixed);
        echo "<br/>";

        $products_all=array_merge($products_fixed,$products_arm);

        echo "sorted...";

echo "<br/>";
        echo "</div>";

        echo "<br/>";

         //pre($products_all);



        if (empty($products)) {
            echo "<br/>";
            echo "We’re sorry but there are no loans available for the terms you entered. Please change the terms or if you have questions, contact us through our chat service or phone to discuss.";
            echo "<br/>";

        }


        if (!empty($products)) {


?>




 <table class="mortgage-options-table">
                      <thead>
                <tr>
                   <th style="align: center;">Loan Type</th>
                    <th style="align: center;">Payment</th>
                    <th style="align: center;">Rate</th>
                    <th style="align: center;">APR</th>
                    <th style="align: center;">Fees</th>
                    <th></th>
                </tr>
                </thead>
<tbody>
                <?php

foreach ($products_all as $product_id=>$product_term) {

            $array_key=$product_Key_guide[$product_id];



             $payment100=$products_array[$array_key][principalAndInterestPayment];
             $fees100=$products_array[$array_key][quoteFees];
             $rate100=$products_array[$array_key][rate];
             $apr100=$products_array[$array_key][apr];

             $term100=$products_array[$array_key][productTerm];
             $type100=$products_array[$array_key][productType];
             $family100=$products_array[$array_key][productFamily];






              if ($type100=='FIXED') {
                                    $new_prod_name=$term100." YEAR ".$type100." ".$family100;
                                    }

                        else {

                        $new_prod_name=$term100." ".$type100." ".$family100;

                        }
            ?>







            <tr>
            <td>
                <?php echo $new_prod_name; ?>
            </td>
            <td class="right-aligned">$<?php echo number_format($payment100,2); ?></td>
            <td class="right-aligned"><?php echo number_format($rate100, 3); ?></td>

            <td class="right-aligned"><?php echo number_format($apr100, 3); ?></td>
             <td class="right-aligned">
                            $<?php echo intval($fees100); ?></td>
            <td>
                <a href="<?php echo get_page_link(2263); ?>" class="btn btn-block btn-primary green-gradient caps">Apply Now</a>
            </td>
        </tr>

            <?Php
/*

echo "product id: ".$new_prod_name."<br/>";
             echo "payment101: ".$payment100."<br/>";
             echo "fees101: ".$fees100."<br/>";
             echo "rate101: ".$rate100."<br/>";
             echo "apr101: ".$apr100."<br/>";
             echo "<hr>";


  */


         }

         ?>
</tbody>
	  </table>

     <?php

         echo "<br/>";
echo "<br/>";
echo "<br/>";







            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery('#datatable').DataTable();
                    jQuery('#trending-section').toggle();
                });

		  $('#datatable').DataTable( {
			ordering: false
		} );
            </script>
            <!--

            <h2>Popular Mortgage Programs</h2>

            <p>Lenderful clients, with mortgage situations like yours, have recently selected the following products.</p>

            <p>By selecting the product that you think might best fit your needs or your preferred next step, we can start the pre-approval process and finalize your home purchase or refinance.</p>

        -->
<div class="hide">
            <table id="datatable" data-order='[[ 0 ]]'  class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Loan Type</th>
                    <th class="data-table-column-2">Payment</th>
                    <th>Rate</th>
                    <th>APR</th>
                    <th>Fees</th>
                    <th></th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Loan Type</th>
                    <th>Payment</th>
                    <th>Rate</th>
                    <th>APR</th>
                    <th>Fees</th>
                    <th></th>
                </tr>
                </tfoot>


                <tbody>

                  <?php
                  $financial = new Financial();

                  //Calculate monthly payment

                  $min_term = intval($lp->matchedTerm) == 0 ? 30 : intval($lp->matchedTerm);
                  $min_amount = intval(get_option('loanAmount'));
                  $full_amount = intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees')) + intval(get_option('loanAmount'));

                  // add in points
                  $points = intval(get_option('points'));
                  if (empty($points)) $points = 0;
                  $min_amount = ($points / 100) * $min_amount + $min_amount;

                  // for ARM products
                  $adjustment_months = intval($lp->rateAdjustmentPeriod) == 0 ? 12 : intval($lp->rateAdjustmentPeriod);
                  $rate_remain_fixed = intval($lp->minTerm);
                  $max_rate = floatval($lp->interestRateCap);

/*
echo "<br/>";
echo "<br/>products array:";

                  echo "<br/>";
                  pre($products);
                  echo "<br/>";
                  echo "<br/>";
*/







                  foreach ($products as $lp) {
                      $start_interest_rate = floatval($lp->rate) / 100;
                      $min_term = intval($lp->matchedTerm);
                      // change from $balance = $min_amount
                      $balance = $min_amount + intval(get_option('lenderFees')) + intval(get_option('closingCosts')) + intval(get_option('defaultFees'));
                      $start_monthly_payment = ($start_interest_rate / 12 * $min_amount) / (1 - pow(1 + $start_interest_rate / 12, -$min_term * 12));

                      if ($lp->arm !== false || $lp->arm !== 'false') {
                          $adjustment_expected = floatval(get_option('marginRate')) == 0 ? 0 : (floatval(get_option('marginRate')) / 100);
                          $rate_remain_fixed = intval($lp->rateAdjustmentPeriod) == 0 ? intval($lp->matchedTerm) : intval($lp->rateAdjustmentPeriod);
                          $indexRate = floatval(get_option('indexRate')) == 0 ? $start_interest_rate : (floatval(get_option('indexRate')) / 100);

                          //Calculate APR
                          $payment_dues = array();
                          $payment_dues[] = -$min_amount;

                          for ($i = 1; $i <= $min_term * 12; $i++) {
                              if ($i <= $rate_remain_fixed * 12) {
                                  $payment_due = $start_monthly_payment;
                                  $interest_rate = $start_interest_rate;
                                  $interest = $interest_rate / 12 * $balance;
                              } else {
                                  $interest_rate = ($indexRate + $marginRate) > $max_rate ? $max_rate : ($indexRate + $marginRate);
                                  $interest_rate = $indexRate + (floor(($i - 1 - $rate_remain_fixed * 12) / $adjustment_months) + 1) * $adjustment_expected;
                                  $interest = $interest_rate / 12 * $balance;
                                  $payment_due = -$financial->PMT($interest_rate / 12, $min_term * 12 - $i + 1, $balance);
                              }
                              $principal = $payment_due - $interest;
                              if ($i == $min_term * 12) {
                                  $payment_due = $balance;
                                  $balance = 0;
                              } else {
                                  $balance = $balance - $principal;
                              }
                              $payment_dues[] = $payment_due;
                          }
                          $apr = $financial->IRR($payment_dues) * 12;
                      } else {
                          $apr = $start_interest_rate;
                        }

                        if ($lp->productType=='FIXED') {
                                    $new_prod_name=$lp->productTerm." YEAR ".$lp->productType." ".$lp->productFamily;
                                    }

                        else {

                        $new_prod_name=$lp->productTerm." ".$lp->productType." ".$lp->productFamily;

                        }






                      ?>



                    <tr>
                        <td><?php echo $new_prod_name; ?></td>
                        <td class="right-aligned">$<?php echo number_format($payment100,2); ?></td>
                        <td class="right-aligned"><?php echo number_format($rate100, 3); ?></td>
                        <td class="right-aligned"><?php echo number_format($apr100, 3); ?></td>
                        <td class="right-aligned">
                            $<?php echo intval($fess100); ?></td>
                        <td class="center-aligned">
						<a href="<?php echo get_page_link(2263); ?>" class="btn btn-primary green-gradient mortgage-select-button btn-block caps">Apply Now</a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
	     </div>
            <?php
        }
    } catch (Exception $e) {

        global $wpdb;
$error_timestamp=time();
        $line_number=1779;
        $error_msg='Lenderful Alert: API call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));




        //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
        error_log($e->getMessage());
    }

    error_log("Debug api call: ".$log);
    // wp_mail('support@kaleidico.com', 'Lenderful Alert: API call log', $log.' <br> json: '.$jsonInput);
    file_put_contents('./log_debug_short_form'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}







// Add Shortcode
function shortcode_ldf_shortcode()
{
    return ldf_products(false);
}

function shortcode_ldf_table_quote_shortcode($atts)
{
    return ldf_products_quote_table($atts);
}

//Function to create contact
function create_contact($echo = false)
{
    $apiLink = get_option('apiLink') . "/contacts";
    //print_r($_POST);
    if (!empty($_POST['input_1_3']) && !empty($_POST['input_1_6'])) {
        $firtName = $_POST['input_1_3'];
        $lastName = $_POST['input_1_6'];
        $phone = $_POST['input_48'];
        $email = $_POST['input_47'];

        $i_am = $_POST['input_2'];
        $i_have = $_POST['input_61'];
        $purchase_price = $_POST['input_54'];
        $funds_totaling = $_POST['input_59'];
        $these_funds_are = $_POST['input_50'];

        $i_want = $_POST['input_8'];
        $want_borrow = $_POST['input_58'];
        $value_of_house = $_POST['input_57'];
        $plan_my_home = $_POST['input_52'];

        $credit = $_POST['input_15'];

        $using_this_property = $_POST['input_17'];
        $property_is = $_POST['input_18'];
        $job = $_POST['input_20'];
        $monthly_gross = $_POST['input_60'];

        $jsonInput = "{
              \"preferredName\": \"" . $firtName . "\",
              \"primaryPhone\": \"" . $phone . "\",
              \"primaryEmail\": \"" . $email . "\",
              \"prefix\": \"\",
              \"firstName\": \"" . $firtName . "\",
              \"middleName\": \"\",
              \"lastName\": \"" . $lastName . "\",
              \"suffix\": \"\",
              \"street\": \"\",
              \"city\": \"\",
              \"state\": \"\",
              \"zip\": \"\",
              \"avatarUrl\": \"\",
              \"facebookId\": \"\",
              \"linkedinUrl\": \"\"
            }";

        $contactId = "0";
        $current_user = wp_get_current_user();
        $isCreate = true;
        if ($current_user->exists()) {
            $isCreate = false;
            $user = $current_user->ID;
            error_log("userID: " . $user);
            $contactId = get_user_meta($user, "contact_id", true) != null ? get_user_meta($user, "contact_id", true) : "";
        } else {
            $result_user = $user = register_new_user($firtName . $lastName, $email);
            if ($result_user instanceof WP_Error) {

                global $wpdb;
$error_timestamp=time();
        $line_number=1879;
        $error_msg='Lenderful Alert: Cant create user';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));

                //wp_mail('support@kaleidico.com', 'Lenderful Alert', "Cant create user " . $email);
            }
        }

        if (empty($contactId)) {
            try {
                $token1=esc_attr(get_option('bearer_token'));
                $jsonText = post_json($apiLink, $jsonInput, "POST",$token1);
                $rs = process_json($jsonText);
                if (!empty($rs)) {
                    $contactId = $rs->{'contactId'};
                }
            } catch (Exception $e) {

                global $wpdb;
$error_timestamp=time();
        $line_number=1905;
        $error_msg='Lenderful Alert: API Call failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));

                //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
                error_log($e->getMessage());
            }
        } else {
            $apiLink = $apiLink . "/" . $contactId;
            try {
                $token1=esc_attr(get_option('bearer_token'));
                $jsonText = post_json($apiLink, $jsonInput, "PUT",$token1);
                $rs = process_json($jsonText);
                if (!empty($rs)) {
                    $contactId = $rs->{'contactId'};
                }
            } catch (Exception $e) {
global $wpdb;
$error_timestamp=time();
        $line_number=1931;
        $error_msg='Lenderful Alert: API Call Failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));


                //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
                error_log($e->getMessage());
            }
        }

        if (($isCreate && !is_wp_error($user)) || (!$isCreate && $user > 0)) {
            update_usermeta($user, "first_name", $firtName);
            update_usermeta($user, "last_name", $lastName);
            update_field("i_am", $i_am, "user_" . $user);
            if ($i_am == "buying a house") {
                update_field("i_have", $i_have, "user_" . $user);
                update_field("purchase_price", $purchase_price, "user_" . $user);
                update_field("funds_totaling", $funds_totaling, "user_" . $user);
                update_field("these_funds_are", $these_funds_are, "user_" . $user);
            } else {
                update_field("i_want", $i_want, "user_" . $user);
                update_field("want_borrow", $want_borrow, "user_" . $user);
                update_field("value_of_house", $value_of_house, "user_" . $user);
                update_field("plan_my_home", $plan_my_home, "user_" . $user);
            }

            update_field("credit", $credit, "user_" . $user);
            update_field("using_this_property", $using_this_property, "user_" . $user);
            update_field("property_is", $property_is, "user_" . $user);
            update_field("job", $job, "user_" . $user);
            update_field("monthly_gross", $monthly_gross, "user_" . $user);
            update_field("phone", $phone, "user_" . $user);
            if ($contactId > 0) {
                update_field("contact_id", $contactId, "user_" . $user);
            }
        }
    }

}

// Add Shortcode
function shortcode_create_contact()
{
//    $contactAPIThread = new ContactAPIThread();
//    $contactAPIThread->run();
}

function my_profile_update($user_id, $old_user_data)
{
    $apiLink = get_option('apiLink') . "/contacts";
    $new_user_data = get_userdata($user_id);
    $contactId = get_field("contact_id", "user_" . $user_id);
    $phone = get_field("phone", "user_" . $user_id);
    $facebook = get_user_meta($user_id, "facebook", true) != null ? get_user_meta($user_id, "facebook", true) : "";
    $jsonInput = "{
          \"preferredName\": \"" . $new_user_data->display_name . "\",
          \"primaryPhone\": \"" . $phone . "\",
          \"primaryEmail\": \"" . $new_user_data->user_email . "\",
          \"prefix\": \"\",
          \"firstName\": \"" . $new_user_data->user_firstname . "\",
          \"middleName\": \"\",
          \"lastName\": \"" . $new_user_data->user_lastname . "\",
          \"suffix\": \"\",
          \"street\": \"\",
          \"city\": \"\",
          \"state\": \"\",
          \"zip\": \"\",
          \"avatarUrl\": \"\",
          \"facebookId\": \"" . $facebook . "\",
          \"linkedinUrl\": \"\"
    }";

    if ($contactId == null || $contactId == "") {
        try {
            $token1=esc_attr(get_option('bearer_token'));
            $jsonText = post_json($apiLink, $jsonInput, "POST",$token1);
            $rs = process_json($jsonText);
            if (!empty($rs)) {
                $contactId = $rs->{'contactId'};
                update_field("contact_id", $contactId, "user_" . $user_id);
            }
        } catch (Exception $e) {

            global $wpdb;
$error_timestamp=time();
        $line_number=2021;
        $error_msg='Lenderful Alert: API Call Failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));
            //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
            error_log($e->getMessage());
        }
    } else {
        $apiLink = $apiLink . "/" . $contactId;
        try {
            $token1=esc_attr(get_option('bearer_token'));
            $jsonText = post_json($apiLink, $jsonInput, "PUT",$token1);
            $rs = process_json($jsonText);
            if (!empty($rs)) {
                error_log("update contact: " . $jsonText);
            }
        } catch (Exception $e) {

            global $wpdb;
$error_timestamp=time();
        $line_number=2046;
        $error_msg='Lenderful Alert: API Call Failure';


        $wpdb->insert("lenderful_api_errors", array(
   "error_timestamp" => $error_timestamp,
   "line_number" => $line_number,
   "error_msg" => $error_msg
   ));


            //wp_mail('support@kaleidico.com', 'Lenderful Alert: API call failure', "Error: call to contact API failed");
            error_log($e->getMessage());
        }
    }
}
// create profile update
add_action('profile_update', 'my_profile_update', 10, 2);

//class ContactAPIThread extends Thread {
//    public function run() {
//        create_contact(false);
//    }
//}

//Create cron job to run import
// Scheduled Action Hook

function add_new_intervals($schedules)
{
    // add weekly and monthly intervals
    $schedules['custom15'] = array(
        'interval' => 900,
        'display' => __('Once 15 minutes')
    );

    return $schedules;
}
add_filter( 'cron_schedules', 'add_new_intervals');

register_activation_hook(__FILE__, 'my_activation');
add_action('my_15mins_event', 'import_ldf_products');

function my_activation() {
    wp_schedule_event( current_time( 'timestamp' ), 'custom15', 'my_15mins_event');
}

register_deactivation_hook(__FILE__, 'my_deactivation');

function my_deactivation() {
    wp_clear_scheduled_hook('my_15mins_event');
}
