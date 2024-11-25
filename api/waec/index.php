<?php
date_default_timezone_set('Africa/Lagos');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include('../Connections/dbQuery.php');
include('../function/build.php');

// API parameter

//	if(isset($_REQUEST['apikey']) && isset($_REQUEST['service'])  && isset($_REQUEST['vcode']) && isset($_REQUEST['amount']) && isset($_REQUEST['ref'])){

// API parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// get posted data
	$get_data = json_decode(file_get_contents("php://input"));
	if (!isset($get_data)) {
		$apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
		$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
		$variation_code = $conn->real_escape_string(test_input($_REQUEST['vcode']));
		$amountPayee = $conn->real_escape_string(test_input(floatval($_REQUEST['amount'])));
		$requestid = $conn->real_escape_string(test_input($_REQUEST['ref']));
		$qty = $conn->real_escape_string(test_input($_REQUEST['iuc']));
	} else {
		$apikey = $conn->real_escape_string(test_input($get_data->apikey));
		$serviceID = $conn->real_escape_string(test_input($get_data->service));
		$variation_code = $conn->real_escape_string(test_input($get_data->vcode));
		$amountPayee = $conn->real_escape_string(test_input(floatval($get_data->amount)));
		$requestid = $conn->real_escape_string(test_input($get_data->ref));
		$qty = $conn->real_escape_string(test_input($get_data->iuc));
	}
	$auth = "paid";
	$txtadmin = "08084121526";

	if (is_numeric($amountPayee)) {

		$amount = max(0, $amountPayee);

		if ($amount == 0) {

			response(107, "BAD REQUEST");
		} else {

			// process request

			$dateTime = date('Y-m-d h:i:A');

			$action = "Pay";

			$email = $user;
			$proc = '_pay-tv';
			$charge = '';

			$channel = "API";
			$view = "View";

			// check if the account is valid

			if ($param) {

				response(107, "BAD REQUEST");
			} else {

				$retr = "SELECT * FROM users WHERE apikey='$apikey' ";

				$exe = mysqli_query($conn, $retr);
				$rob = mysqli_fetch_array($exe);

				$user = $rob['apikey'];
				$aut = $rob['level'];

				$arr = array("$apikey", "$auth");

				$pair = array("$user", "$aut");

				if ($arr === $pair) {

					// check if the user have balance

					$gb = mysqli_query($conn, "SElECT * FROM users WHERE apikey = '$user' ");
					$reco = mysqli_fetch_array($gb);
					$fname = $reco['firstname'];
					$lname = $reco['lastname'];
					$level = $reco['level'];
					$email = $reco['email'];
					$upp_cas_lx = $reco['email'];
					$customNam = $fname . ' ' . $lname;
					$CustomerPhone = $reco['phone'];
					//extract account info
					$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
					$Wafi_user_pros->bind_Param("s", $upp_cas_lx);
					$Wafi_user_pros->execute();
					$Wafi_user_pros->store_result();
					$Wafi_user_pros->bind_result($mid_wxpi);
					$Wafi_user_pros->fetch();
					$Wafi_user_pros->close();

					$apiMulti = json_decode(Apidefault($conn, $variation_code));
					$product_name = $apiMulti->plan;
					$amount = $apiMulti->price_api;
					$network = $serviceID;
					$iuc = $variation_code;

					$debit = floatval($amount);

					$newBalc = bcsub($mid_wxpi, $debit);

					if ($debit < $mid_wxpi) {


						// check if ref number exist

						$req = mysqli_query($conn, "SElECT * FROM transactions WHERE ref = '$requestid' ");
						$nu = mysqli_num_rows($req);

						if ($nu == 0) {



							if ($apiMulti->gateway === 'epins') {
								$resp = json_decode(ePinsPay($conn, $network, $variation_code, $amount, $requestId));
								$responseCode = $resp->code;
								$pin = $resp->description->Content;
							} else if ($apiMulti->gateway === 'n3t') {

								$resp_marker = json_decode(n3tWaec($conn, $qty));
								$responseCode = $resp_marker->status;
								$pin = $resp_marker->pin;
							} else if ($apiMulti->gateway === 'markersapi') {

								$resp_marker = json_decode(ePinsPay($conn, $network, $variation_code, $amount, $requestId));
								$responseCode = $resp_marker->code;
								$pin = $resp_marker->description->Content;
							} else if ($apiMulti->gateway === 'shago') {

								$resp_shag = json_decode(shagopay($conn, $amount, $iuc, $requestId), true);

								$responseCode = $resp_shag['status'];
								$pin = 'PIN: ' . $resp_shag['pin'][0]['pin'] . '' . 'serial:' . $resp_shag['pin'][0]['serial'];
							} else if ($apiMulti->gateway === 'vtpass') {

								$resp_vpas = json_decode(VTPas($conn, $requestId, $network, $iuc, $variation_code,  $amount));

								$responseCode = $resp_vpas->code;
								$pin = $resp_vpas->purchased_code;
							} else if ($apiMulti->gateway === 'mobileng') {
								$resp_mobng = json_decode(MobilNg($conn, $requestId));

								$responseCode = $resp_mobng->code;
								$pin = 'SerialNo: ' . $resp_mobng->serial . ' ' . 'PIN: ' . $resp_mobng->pin;
							}



							if ($responseCode == '000' or $responseCode == '101' or $responseCode == '100' or $responseCode == '200' or $responseCode == "success") {
								// debit account
								UserdebitWallet($conn, $newBalc, $upp_cas_lx);
								$stat = "Completed";
								response(101, array("Content" => $pin, "product_name" => $product_name, "transaction_date" => $dateTime));
							} else {
								response(105, array("response_description" => "Failed"));
								$stat = "Failed";
							}

							$Data_store = $conn->query("INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,newBal,customer,metertoken,qty) VALUES('$product_name','$variation_code','$channel','$CustomerPhone','$amount','$debit','$requestid','$stat','$dateTime','$email','$newBalc','$customNam','$pin','$qty')");
						} else {
							response(104, "TRANSACTION ID ALREADY EXIST");
						}
					}
					// echo low balance
					else {

						response(102, "LOW BALANCE");
					}

					// close account not found
				} else {

					response(103, "INVALID ACCOUNT");
				}
			} // close wrong parameter

		}
		//end process request
	} else {
		response(107, "BAD REQUEST");
	}
	//check negative value;

} else {

	response(400, "INVALID PARAMETER");
}


function response($status, $status_message)
{


	$response['code'] = $status;
	$response['description'] = $status_message;


	$json_response = json_encode($response);
	echo $json_response;
}

function Apidefault($conn, $variation_code)
{
	$query_MapiS = $conn->query("SELECT * FROM exam_package WHERE plancode='$variation_code'");
	$api_defualt = $query_MapiS->fetch_assoc();
	return json_encode($api_defualt);
}


function ePinsPay($conn, $network, $variation_code, $amount, $requestId)
{
	function fetchEpin($conn)
	{
		$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
		$fetchepkey = $query_ep->fetch_assoc();
		return json_encode($fetchepkey);
	}
	$json_ep = json_decode(fetchEpin($conn));
	//Initialize cURL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/waec/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
		"apikey" => $json_ep->privatekey,
		"service" => $network,
		"vcode" => $variation_code,
		"amount" => $amount,
		"ref" => $requestId
	)));

	$veridata = curl_exec($ch);
	curl_close($ch);

	return $veridata;
}

function n3tWaec($conn, $quantity)
{
	function fetchn3t($conn)
	{
		$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
		$fetchepkey = $query_ep->fetch_assoc();
		return json_encode($fetchepkey);
	}
	$json_ep = json_decode(fetchn3t($conn));
	$basic = base64_encode($json_ep->username . ":" . $json_ep->password);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://n3tdata.com/api/user");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt(
		$curl,
		CURLOPT_HTTPHEADER,
		[
			"Authorization: Basic " . $basic,
		]
	);
	$N3Tresponse = curl_exec($curl);
	$n3result = json_decode($N3Tresponse);
	curl_close($curl);
	$n3_accesscode = $n3result->AccessToken;

	//Initialize cURL.
	$paypload = array(
		'exam' => 1,
		'quantity' => $quantity
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://n3tdata.com/api/exam');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paypload));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = [
		"Authorization: Token $n3_accesscode",
		'Content-Type: application/json'
	];
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);

	return $response;
}

function MarkerPay($conn, $network, $variation_code, $amount, $requestId)
{
	function fetchMarkers($conn)
	{
		$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
		$fetchmakey = $query_maks->fetch_assoc();
		return json_encode($fetchmakey);
	}
	$json_maks = json_decode(fetchMarkers($conn));
	//Initialize cURL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/waec/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
		"apikey" => $json_maks->privatekey,
		"service" => $network,
		"vcode" => $variation_code,
		"amount" => $amount,
		"ref" => $requestId
	)));

	$veridata = curl_exec($ch);
	curl_close($ch);

	return $veridata;
}

function shagopay($conn, $amount, $iuc, $requestId)
{
	function fetchshago($conn)
	{
		$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
		$shagokey = $query_sh->fetch_assoc();
		return json_encode($shagokey);
	}
	$json_shago = json_decode(fetchshago($conn));
	$hashkey = $json_shago->privatekey;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
		'serviceCode' => "WAP",
		'numberOfPin' => $iuc,
		'amount' => $amount,
		'request_id' => $requestId
	)));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"hashKey: $hashkey"
	));

	$response_shago = curl_exec($ch);
	curl_close($ch);
	return $response_shago;
}


function VTPas($conn, $requestId, $network, $iuc, $variation_code,  $amount)
{
	function fetchVtp($conn)
	{
		$query_vtp = $conn->query("SELECT * FROM providers_api_key WHERE provider='vtpass'");
		$vtpkey = $query_vtp->fetch_assoc();
		return json_encode($vtpkey);
	}
	$json_vt = json_decode(fetchVtp($conn));
	$curl       = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://vtpass.com/api/pay',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_USERPWD => $json_vt->privatekey . ":" . $json_vt->secretkey,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_SSL_VERIFYPEER => true,
		CURLOPT_POSTFIELDS => array(
			'request_id' => $requestId,
			'serviceID' => $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
			'billersCode' => $iuc, // e.g smartcardNumber, meterNumber,
			'variation_code' => $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
			'amount' =>  $amount, // integer (optional for somes services)
			'phone' => $iuc //integer

		),
	));
	$successVTp = curl_exec($curl);
	$curl_errno = curl_errno($curl);
	curl_close($curl);

	return $successVTp;
}

function MobilNg($conn, $requestId)
{
	function fetchmobng($conn)
	{
		$query_mob = $conn->query("SELECT * FROM providers_api_key WHERE provider='mobileng'");
		$mobkey = $query_mob->fetch_assoc();
		return json_encode($mobkey);
	}
	$json_mob = json_decode(fetchmobng($conn));
	$mobilekey = $json_mob->privatekey;
	$mobileID = $json_mob->secretkey;
	//Initialize cURL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/waecdirect?userid=$mobileID&pass=$mobilekey&jsn=json&user_ref=$requestId");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$wdata_ng = curl_exec($ch);
	$result_ng = json_decode($wdata_ng);
	//Close the cURL handle.
	curl_close($ch);

	return $wdata_ng;
}
