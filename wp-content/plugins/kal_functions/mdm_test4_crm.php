<?php











if(!function_exists(pre)){
    function pre($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}











$gc_post='abc';

if( isset($_POST['gc_post']) ) {

$gc_post=$_POST['gc_post'];

}




?>



	<style>
	.container{
    margin:0px auto;
    width: 800px; 
    text-align: center;
    font-size: 20px;
}
	</style>

	<div class="container">
		<h1 style="text-align: center;">MDM TEST1 API Checker</h1>

<?php



/*************** page 1 ********************/



if (!is_numeric($gc_post)) {


?>





Please hit the submit button to see the API response:
<form method="post" action="/adam2">


<input type="hidden" name="gc_post" value=2 />


<br/>


<br/><br/>

















<input type="submit" value="Submit" />

</form>

  







<?php
} // close out page 1

if ($gc_post==2) {

  ?>
  <h1 style="text-align: center;">VERSION 4</h1>
  <?php

    
//$username=$_POST['username'];
//$password=$_POST['password'];




//echo $username." - ".$password."<br/>";




/*
$data = array(
    'username' => 'gmanbooks456@gmail.com',
    'password' => 'pswd1234',
);

*/

//curl -X GET --header "Accept: application/json" 
//--header "Authorization: Bearer 02323e21-ece5-40a8-92f4-c566a4630f6f" "http://ec2-52-23-201-115.compute-1.amazonaws.com:9090/api/products"


//$data = array(
//    'username' => $username,
//    'password' => $password,
//);



//$data = http_build_query($data); // convert array to urlencoded string


//$gtoken='02323e21-ece5-40a8-92f4-c566a4630f6f';

//$token_string="Authorization: Bearer ".$gtoken;

//  MDM PLUGIN = 1

//  LOANTEK = 2

$g_choice=2;

if ($g_choice==1) {

$apiLink = get_option('apiLink') . "/products/quote?sortby=" . get_option('sortby') . "&count=" . get_option('productTypeCount');
    $log = "";

		
// ************* json data for mdm plugin:
// ************* json data for mdm plugin:
    // ************* json data for mdm plugin:
    // ************* json data for mdm plugin:


    $data = "{
          \"loanOriginatorId\": " . get_option('loanOriginatorId') . ",
          \"loanTerm\": [" . get_option('loanTerm') . "],
          \"loanType\": [" . get_option('loanType') . "],
					\"compensationPayer\": \"\",
          \"commitmentPeriod\": \"\",
          \"minCommitmentCredit\": " . get_option('minCommitmentCredit') . ",
          \"propertyState\": \"\",
          \"fico\": " . get_option('minFICO') . ",
          \"propertyAppraisedValue\": " . get_option('propertyAppraisedValue') . ",
          \"loanAmount\": " . get_option('loanAmount') . "
    }";

  }

if ($g_choice==2) {

$apiLink = 'http://ec2-54-209-66-20.compute-1.amazonaws.com:9090/api/Leads/lead';

    

// ************* json data for loantek:
    // ************* json data for loantek:
    // ************* json data for loantek:
    // ************* json data for loantek:
    // ************* json data for loantek:

    

    $data='{
  "loanTerm": [
    "Y30"
  ],
  "loanFamily": [
    "CONVENTIONAL"
  ],
  "loanClass": [
    "STANDARD"
  ],
  "loanType": [
    "ARM"
  ],
  "compensationPayer": "BORROWER",
  "lockPeriod": "D7",
  "quoteTypesToReturn": [
    "CLOSEST_TO_ZERO_WITH_FEE"
  ],
  "propertyZip": 48302,
  "fico": 800,
  "propertyAppraisedValue": 350000,
  "loanAmount": 200000
}';

/*
$data='{
  "compensationPayer": "BORROWER",
  "lockPeriod": "D30",
  "minCommitmentCredit": -2.0,
  "propertyZip": "48302",
  "fico": 800,
  "propertyAppraisedValue": 350000,
  "loanAmount": 200000
}';
*/


$data='{
  "loanTerm": [
    "Y30"
  ],
  "loanFamily": [
    "CONVENTIONAL"
  ],
  "loanClass": [
    "STANDARD"
  ],
  "loanType": [
    "ARM"
  ],
  "compensationPayer": "BORROWER",
  "lockPeriod": "D30",
    "quoteTypesToReturn": [
    "CLOSEST_TO_ZERO_WITH_FEE"
  ],
  "propertyZip": 48302,
  "fico": 800,
  "propertyAppraisedValue": 350000,
  "loanAmount": 200000
}';

$data='{
  "compensationPayer": "BORROWER",
  "lockPeriod": "D30",
    "quoteTypesToReturn": [
    "CLOSEST_TO_ZERO_WITH_FEE"
  ],
  "propertyZip": 48302,
  "fico": 800,
  "propertyAppraisedValue": 350000,
  "loanAmount": 200000
}';



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




$data='{ "leadSourceId": "97",
  "sourceLeadId": "ABC123",
  "sourceCreated": "2016-1-15:11:11:11",
  "hasCoBorrower": "false",
  "status": "Attempted",
  "userId": "1714",
  "email": "rstropoli@MaddogTechnology.com",
  "phone": "(732) 555-1212",
  "firstName": "Howard",
  "lastName": "Stropoli",
  "ficoScore": "720",
  "propertyValue": "290000",
  "propertyZipCode": "08736",
  "loanType": "Refinance",
  "loanAmount": "250000",
  "downPayment": “40000"}';

/*
  $data='{ "email": "rstropoli222@MaddogTechnology.com",
  "phone": "(732) 555-1212",
  "firstName": "Howard",
  "lastName": "Stropoli",
  "ficoScore": "720",
  "propertyValue": "290000",
  "propertyZipCode": "08736",
  "loanType": "Refinance",
  "loanAmount": "250000",
  "downPayment": “40000"}';

*/


$data='{
  "leadSourceId": "97",
  "sourceLeadId": "ABC123",
  "sourceCreated": "2016-1-15:11:11:11",
  "hasCoBorrower": "false",
  "status": "Attempted",
  "userId": "1714",
  "maritalStatus": "Unknown",
  "email": "rstropoli@MaddogTechnology.com",
  "phone": "(732) 555-1212",
  "phoneType": "Cell",
  "firstName": "Howardqqqqq",
  "lastName": "Stropoli",
  "streetAddress": "1257 Lakewood Road",
  "city": "Manasquan",
  "state": "NJ",
  "zipCode": "08776",
  "ficoScore": "720",
  "propertyValue": "290000",
  "propertyUsage": "PrimaryResidence",
  "propertyType": "SingleFamily",
  "propertyAddress": "1754 Newark Avenue",
  "propertyAddress2": "string",
  "propertyCity": "Wall Township",
  "propertyState": "NJ",
  "propertyZipCode": "08736",
  "propertyNumberOfUnits": "2",
  "propertyYearBuilt": "1978",
  "loanType": "Refinance",
  "loanAmount": "250000",
  "downPayment": "40000",
  "bestTimeToCall": "Unknown",
  "streetAdress2": "string",
  "additoinalInformation": "string"
}';


$data='{
  "email": "rstropoli@MaddogTechnology.com",
  "phone": "(732) 555-1212",
  "firstName": "Gerard",
  "lastName": "Stropoli",
  "ficoScore": "720",
  "propertyValue": "290000",
  "propertyZipCode": "08736",
  "loanType": "Refinance",
  "loanAmount": "250000",
  "downPayment": "40000"
}';





}


    //$data = http_build_query($data); // convert array to urlencoded string

    echo "jason url encoded string ok for crm: ";
    echo "<br/>";
    echo $data;
echo "<br/>";
echo "<br/>";



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






// put in second variable
$gman_resp=$resp;


print_r($resp);

echo "<br/>";

echo $gman_resp;



// extract array string from response

//$pos = strpos($gman_resp, "{");

/*
echo "<br/>".$pos;
*/
//$gresp2=substr($gman_resp,$pos);
echo "<br/>";
echo "<br/>";
echo "<br/>string length:";
echo "<br/>";
//$resp_len=strlen($gresp2);
//$resp_len2=$resp_len-1;
echo "<br/>";
echo "<br/>";

//$gresp5=substr($gresp2,0,$resp_len2);

// decode into array
//$gresp6=json_decode($gresp5, true);

//$error = json_last_error();
echo "<br/>";
echo "<br/>";

//echo $error;

echo "<br/>";
echo "<br/>";

// decode into array
//$gresp3=json_decode($gresp2, true);

?>

<?php

//$gresp4=json_decode($gman_resp, true);

//echo $gresp4;

//print_r($gresp3);
echo "<br/>";
echo "<br/>";
echo "Response code is: ".$code."<br/>";
echo "<br/>";
echo "<br/>";
?>

<a href="/adam2">Return to Page 1</a>

<?php
echo "<br/>";
echo "<br/>";
echo "string position: ";
//echo $pos;

echo "<br/>";
echo "<br/>";
echo "response stuff:";
echo "<br/>";
//echo $resp;
echo "<br/>";

echo "<br/>";
echo "<br/>";
echo "response stuff 2:";
//echo $gresp2;

echo "<br/>";
echo "<br/>";
echo "response stuff 5:";

//echo $gresp5;

echo "<br/>";
echo "<br/>";
echo "response stuff 6:";

//print_r($gresp6);
//echo $gresp6;



// decode into array
$gresp7=json_decode($resp, true);

$error2 = json_last_error();
echo "<br/>";
echo "<br/>";

echo $error2;

echo "<br/>";
echo "<br/>";
echo "printing resp7";

pre($gresp7);

$gresp8=$gresp7[0];

//print_r($gresp8);

$count_resp_array=count($gresp7);
echo "<br/>";
echo "<br/>";


echo $count_resp_array;
echo "<br/>";
echo $gresp7[0][productId];
echo "<br/>";
echo $gresp7[1][productId];
echo "<br/>";
echo $gresp7[2][productId];
echo "<br/>";
echo $gresp7[3][productId];
echo "<br/>";
echo $gresp7[4][productId];
echo "<br/>";
echo "<br/>";
echo $apiLink;
echo "<br/>";
echo "<br/>";
echo $jsonInput;
echo "<br/>";
echo "<br/>";

print_r($gresp7);

//for ($x=0;$x<$count_resp_array;$x++) {

//$gresp9[$x]=$gresp7

//}




/*

print_r($gresp3);

?>

<?php


echo "<br/>";
echo "ok";
echo "<br/>";

echo "username: ";
echo $gresp3[username];
echo "<br/>";
echo "array resp: ";
echo $gman_resp;
echo "array pos: ";
echo $pos;
echo "array resp gresp2: ";
echo $gresp2;
echo "array resp gresp3: ";
echo $gresp3;


echo "array resp: ";
print_r($gman_resp);
echo "array pos: ";
print_r($pos);
echo "array resp gresp2: ";
print_r($gresp2);
echo "array resp gresp3: ";
print_r($gresp3);

*/





}




?>
</div>