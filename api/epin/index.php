<?php
date_default_timezone_set('Africa/Lagos');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../Connections/dbQuery.php');
include('../function/build.php');

// API parameter

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// get posted data
	$jdata = json_decode(file_get_contents("php://input"));
	if (isset($jdata)) {
		$apikey = $conn->real_escape_string(test_input($jdata->apikey));
		$serviceID = $conn->real_escape_string(test_input($jdata->service));
		$billersCode = $conn->real_escape_string(test_input($jdata->network));
		$variation_code = $conn->real_escape_string(test_input($jdata->pinDenomination));
		$pinNo = $conn->real_escape_string(test_input(floatval($jdata->pinQuantity)));
		$requestId = $conn->real_escape_string(test_input($jdata->ref));
	} else {
		$apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
		$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
		$billersCode = $conn->real_escape_string(test_input($_REQUEST['network']));
		$variation_code = $conn->real_escape_string(test_input($_REQUEST['pinDenomination']));
		$pinNo = $conn->real_escape_string(test_input(floatval($_REQUEST['pinQuantity'])));
		$requestId = $conn->real_escape_string(test_input($_REQUEST['ref']));
	}
	$auth = "paid";
	$txtadmin = "08084121526";

	$dateTime = date('Y-m-d h:i:A');

	$query_com = $conn->query("SELECT * FROM billing");
	$rate = $query_com->fetch_assoc();

	if ($serviceID == 'epin') {


		// process request

		$convee = '';

		$customer = '';

		$xname = '';

		$action = "Pay";

		$proc = '_pay-tv';
		$charge = '';

		$channel = "API";
		$view = "View";

		// check if the account is valid

		$retr = "SELECT * FROM users WHERE apikey='$apikey' ";

		$exe = mysqli_query($conn, $retr);
		$rob = mysqli_fetch_array($exe);

		$user = $rob['apikey'];
		$aut = $rob['level'];

		$fname = $rob['firstname'];
		$lname = $rob['lastname'];
		$UserEmail = $rob['email'];
		$fcusName = $fname . ' ' . $lname;
		$arr = array("$apikey", "$auth");

		$pair = array("$user", "$aut");

		if ($arr === $pair) {

			/// check if account is dealer pro 

			function checkMerchantExist($conn, $UserEmail)
			{
				$checkMerch = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$UserEmail' AND plan='Premium'");
				$resMerch = $checkMerch->num_rows;
				return $resMerch;
			}

			if (checkMerchantExist($conn, $UserEmail) > 0) {

				// check if the user have balance

				$gb = $conn->query("SElECT * FROM users WHERE apikey='$apikey'");
				$reco = $gb->fetch_assoc();

				$blcurx = $reco['bal'];
				$level = $reco['level'];
				$email = $reco['email'];
				$prevBal = floatval($reco['bal']);
				$UserPhone = $reco['phone'];


				$upp_cas_lx = $reco['email'];
				//extract account info
				$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
				$Wafi_user_pros->bind_Param("s", $upp_cas_lx);
				$Wafi_user_pros->execute();
				$Wafi_user_pros->store_result();
				$Wafi_user_pros->bind_result($mid_wxpi);
				$Wafi_user_pros->fetch();
				$Wafi_user_pros->close();



				if (strtolower($serviceID) === 'epin') {

					$per = 0;
					$comi = $per;

					/////////////////////////////////

					function fetchPINRate($conn, $billersCode, $variation_code)
					{
						$QryPin = $conn->query("SELECT * FROM pins_package WHERE network='$billersCode' AND code='$variation_code'");
						$pinROw = $QryPin->fetch_assoc();
						return json_encode($pinROw);
					}
					$json_unitPrice = json_decode(fetchPINRate($conn, $billersCode, $variation_code));

					$unitprice = $json_unitPrice->price_api;

					$value_debit = strval(floatval($unitprice) * floatval($pinNo));
					$chargeAmt = strval(floatval($value_debit) * floatval($variation_code));

					////PIN variations

					if ($variation_code == '1') {
						$dn = '100';
					}
					if ($variation_code == '2') {
						$dn = '200';
					}
					if ($variation_code == '4') {
						$dn = '400';
					}
					if ($variation_code == '5') {
						$dn = '500';
					}
					if ($variation_code == '7.5') {
						$dn = '750';
					}
					if ($variation_code == '10') {
						$dn = '1000';
					}
					if ($variation_code == '15') {
						$dn = '1500';
					}

					$pnt = strtoupper($billersCode) . " ePIN $dn";
					/////////////////////////////////

					if ($chargeAmt <= $mid_wxpi) {

						$newBalc = bcsub($mid_wxpi, $chargeAmt);


						// check if ref number exist

						$Qry_req = $conn->query("SElECT * FROM transactions WHERE ref = '$requestId'");
						//$check_num_row = mysqli_num_rows($Qry_req);

						if ($Qry_req->num_rows == 0) {


							try {
								////////////////////////////////////////////////////////////////////
								// Generate PIN if  enough balance

								$qryPins = $conn->query("SELECT * FROM pinstock WHERE net='$billersCode' AND deno='$variation_code' LIMIT $pinNo");

								if ($qryPins->num_rows < 1) {


									$rp_gen = json_decode(epinsGen($conn, $billersCode, $variation_code, $pinNo, $requestId));


									if ($rp_gen->code == '101') {

										$pins = $rp_gen->description->PIN;
										$xtrato = explode("\n", $pins);
										$counter = count($xtrato);
										$proces = "TRANSACTION SUCCESSFUL";
										$stat = "Completed";

										UserdebitWallet($conn, $newBalc, $upp_cas_lx);

										StorePin($conn, $billersCode, $variation_code, $pins, $email, $requestId);

										InsertTrans($conn, $pnt, $variation_code, $channel, $UserPhone, $chargeAmt, $requestId, $stat, $dateTime, $email, $fcusName, $customerName, $serviceID, $billersCode, $newBalc);
										moveToPurchased($conn, $variation_code, $pins, $email, $requestId);
										$printcardId = base64_encode($requestId);

										response(101, array("status" => $proces, "PIN" => $pins, "network" => $billersCode, "pinDenomination" => $dn, "pinQuantity" => $count, "product_name" => $pnt, "TransactionDate" => $dateTime));
									} else {

										response(207, "$billersCode N$dn PIN currently unavailable");
									}
								} else if ($qryPins->num_rows >= $pinNo) {

									while ($row = $qryPins->fetch_assoc()) {
										$mypin[] =  $row['pins'];
										$spac = implode("\n", $mypin);
										$showPIN =   $spac;
									}
									$explo = explode("\n", $spac);
									$count = count($explo);
									$proces = "TRANSACTION SUCCESSFUL";
									$stat = "Completed";

									$value_to_debit = strval(floatval($unitprice) * floatval($count));
									$TotalchargeAmt = strval(floatval($value_to_debit) * floatval($variation_code));

									// debit account
									UserdebitWallet($conn, $newBalc, $upp_cas_lx);

									response(101, array("status" => $proces, "PIN" => $showPIN, "network" => $billersCode, "pinDenomination" => $dn, "pinQuantity" => $count, "product_name" => $pnt, "TransactionDate" => $dateTime));

									////////////////////////////////////////////////////////////////////////////

									$Trans_add = $conn->query("INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,customerName,servicetype,meterno,metertoken,newBal) VALUES('$pnt','$variation_code','$channel','$UserPhone','$TotalchargeAmt','$TotalchargeAmt','$requestId','$stat','$dateTime','$email','$fcusName','$customerName','$serviceID','$billersCode','$pnt','$newBalc')");

									/////////////////////// Cut PINs ///////////////////////////////////
									$store_purchased = $conn->query("INSERT INTO purchased_pin(network,category,pins,email)VALUES('$billersCode','$variation_code','$showPIN','$email')");
									if ($store_purchased) {

										////////////////////Add to my Pin/////////////////////////////    
										$stmt_Pin = $conn->prepare("INSERT INTO mypin (net,cat,pins,email)VALUES(?,?,?,?);");
										$stmt_Pin->bind_Param("ssss", $billersCode, $variation_code, $showPIN, $email);
										$stmt_Pin->execute();
										////////////////////End Add to my pin////////////////////////////    

										////////////////////Delete PINS///////////////   
										foreach ($explo as $PINDeleted) {
											$delxp = $conn->query("DELETE FROM pinstock WHERE pins='$PINDeleted'");
										}
										////////////////END Delet epINs //////////////

									}
									///////////////////////////////////////////////////////////////////////////
								} else {

									response(208, "INSUFFICIENT QUANTITY");
								}



								////////////////////////////////////////////////////////			

								//End requery
							}
							//catch exception
							catch (Exception $ch) {
								echo 'Message: ' . $ch->getMessage();
							}
						} else {

							response(104, "TRANSACTION ID ALREADY EXIST");
						}
					}
					// echo low balance
					else {

						response(102, "LOW BALANCE");
					}

					// close account not found
					//}else{ response(304,"Amount too low. Minimum is N$amountPayee ");   }
					////Close validate Service ID

				} else {
					response(303, "Invalid Service ID [serviceID must be epin]");
				}
				////Close validate Service ID

			} else {
				response(304, "Unauthorized [Please Activate your account]");
			}
		} else {

			response(103, "Invalid or missing APIKEY");
		}
	} else {

		response(108, "WRONG SERVICE TYPE [Service type must be epin ]");
	}
	// close JAMB variation Check
} else {

	response(400, "INVALID REQUEST METHOD [Request Method must be POST]");
}


function response($status, $status_message)
{


	$response['code'] = $status;
	$response['description'] = $status_message;


	$json_response = json_encode($response);
	echo $json_response;
}



function StorePin($conn, $billersCode, $variation_code, $pins, $email, $requestId)
{
	$sto = $conn->query("INSERT INTO mypin (net,cat,pins,email,ref)VALUES('$billersCode','$variation_code','$pins','$email','$requestId')");
	return $sto;
}


function InsertTrans($conn, $pnt, $variation_code, $channel, $UserPhone, $chargeAmt, $requestId, $stat, $dateTime, $email, $fcusName, $customerName, $serviceID, $billersCode, $newBalc)
{
	$Trans_add = $conn->query("INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,customerName,servicetype,meterno,metertoken,newBal) VALUES('$pnt','$variation_code','$channel','$UserPhone','$chargeAmt','$chargeAmt','$requestId','$stat','$dateTime','$email','$fcusName','$customerName','$serviceID','$billersCode','$pnt','$newBalc')");

	return $Trans_add;
}

function moveToPurchased($conn, $variation_code, $pins, $email, $requestId)
{
	global $billersCode;
	$storePurchased = $conn->query("INSERT INTO purchased_pin(network,category,pins,email,ref) VALUES('$billersCode','$variation_code','$pins','$email','$requestId')");
	return $storePurchased;
}

function epinsGen($conn, $billersCode, $variation_code, $pinNo, $requestId)
{
	function urlbasemain()
	{
		//Initialize cURL.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$basedata = curl_exec($ch);
		$result = json_decode($basedata, true);
		//Close the cURL handle.
		curl_close($ch);
		return $result['description'][0]['main'];
	}
	function fetchEpin($conn)
	{
		$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
		$fetchepkey = $query_ep->fetch_assoc();
		return json_encode($fetchepkey);
	}
	$json_ep = json_decode(fetchEpin($conn));
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "epin/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
		'apikey' => $json_ep->privatekey,
		'service' => 'epin',
		'network' => $billersCode,
		'pinDenomination' => $variation_code,
		'pinQuantity' => $pinNo,
		'ref'	=> $requestId
	)));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
	));
	$EPIN_response = curl_exec($ch);
	curl_close($ch);
	file_put_contents('pin.txt', $EPIN_response);
	return $EPIN_response;
}


function n3t($conn, $network, $plan_type, $quantity, $requestId = null)
{
	function fetchn3t($conn)
	{
		$query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
		$n3tkey = $query_n3t->fetch_assoc();
		return json_encode($n3tkey);
	}
	$json_n3t = json_decode(fetchn3t($conn));
	/////N3TDATA
	$basic = base64_encode($json_n3t->username . ':' . $json_n3t->password);
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

	// cURL 2
	$paypload = array(
		'network' => $network,
		'plan_type' => $plan_type,
		'quantity' => $quantity,
		'card_name' => 'Ateeku',
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://n3tdata.com/api/recharge_card');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paypload));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = [
		"Authorization: Token $n3_accesscode",
		'Content-Type: application/json'
	];
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$n3tRes = curl_exec($ch);
	curl_close($ch);
	file_put_contents('airtime.txt', $n3tRes);
	return  $n3tRes;
}
