<?php 

// Reseller Charge


if($network === 'gotv' && $level !== $access ){
		
		$per = $gotv;	
		
		$charge = 0;
		
		$ckcode = "02";
	
	
			}


if($network === 'dstv' && $level !== $access){
				
			$per = $dstv;
			
			$charge = 0;	
			
			$ckcode = "01";
			
				}



if($network === 'startimes' && $level !== $access){
					
				$per = $startimes;	
				
				$charge = 0;
				
				$ckcode = "03";
				
					}


if($network === 'ikeja-electric' && $level !== $access){
						
						$per = $ikeja;
						
						$charge = 0;
						
						$ckcode = "02";
	
	if($plan == 'postpaid'){
		
	$smartCode = "ikedc_postpaid_custom";
		
	}else{$smartCode = "ikedc_prepaid_custom"; }
	
						
			}


if($network === 'portharcourt-electric' && $level !== $access){	
										
				$per = $phed;
				
				$charge = 0;
				
				$ckcode = "05";	
	
	if($plan == 'postpaid'){
		
	$smartCode = "phed_postpaid_custom";
		
	}else{$smartCode = "phed_prepaid_custom"; }
	
	
					}





			

if($network === 'ibadan-electric' && $level !== $access){
						
					$per = $ibedc;	
					
					$charge = 0;
					
					$ckcode = "07";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "ibedc_postpaid_custom";
		
	}else{$smartCode = "ibedc_prepaid_custom"; }
	
	
						}


if($network === 'kaduna-electric' && $level !== $access){
						
					$per = $ibedc;	
					
					$charge = 0;
					
					$ckcode = "07";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "knedc_postpaid_custom";
		
	}else{$smartCode = "knedc_prepaid_custom"; }
	
	
						}




						

if($network === 'kano-electric' && $level !== $access){
							
						$per = $kano;
						$charge = 0;	
						
						$ckcode = "04";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "kano_postpaid_custom";
		
	}else{$smartCode = "kano_prepaid_custom"; }
							
							}





						

if($network === 'jos-electric' && $level !== $access){
								
							$per = $jos;
							$charge = 0;
							$ckcode = "06";	
	
	if($plan == 'postpaid'){
		
	$smartCode = "jedc_postpaid_custom";
		
	}else{$smartCode = "jedc_prepaid_custom"; }
	
	
								}


						

if($network === 'eko-electric' && $level !== $access){
								
							$per = $eko;
							$charge = 0;
							$ckcode = "01";	
	
	if($plan == 'postpaid'){
		
	$smartCode = "ekedc_postpaid_custom";
		
	}else{$smartCode = "ekedc_prepaid_custom"; }
	
	
							}





if($network === 'abuja-electric' && $level !== $access){
								
							$per = $eko;
							$charge = 0;
							$ckcode = "01";	
	if($plan == 'postpaid'){
		
	$smartCode = "aedc_postpaid_custom";
		
	}else{$smartCode = "aedc_prepaid_custom"; }
	
	
					
							}



if($network === 'enugu-electric' && $level !== $access){
								
							$per = $eko;
							$charge = 0;
							$ckcode = "01";	
	if($plan == 'postpaid'){
		
	$smartCode = "eedc_postpaid_custom";
		
	}else{$smartCode = "eedc_prepaid_custom"; }
	
	
					
							}




if($network === 'smile-direct' && $level !== $access){
							    
							 $per = $smile;
							$charge = 0;  
							}
							
							
		
	
// Regular Charge
						
						
	$dstvR = $Regubil['dstv'];
	$gotvR = $Regubil['gotv'];
	$startimesR = $Regubil['startimes'];
	$ikejaR = $Regubil['IkejaElectric'];
		$ekoR = $Regubil['EkoElectric'];
		$kanoR = $Regubil['Kedc'];
		$josR = $Regubil['JosElectric'];
		$phedR = $Regubil['Phed'];
		$ibedcR = $Regubil['Ibedc'];
		$smileR = $Regubil['smile'];				
								

if($network === 'gotv' && $level == $access ){
		
		$per = $gotvR;	
		
		$charge = $Regubil['conv'];
		
		$ckcode = "02";
			
			}

if($network === 'dstv' && $level == $access){
				
			$per = $dstvR;
			
			$ckcode = "01";
			
			$charge = $Regubil['conv'];	
				}

if($network === 'startimes' && $level == $access){
					
				$per = $startimesR;
				
				$ckcode = "03";	
				
				$charge = $Regubil['conv'];
				
					}


// Electricity

if($network === 'ikeja-electric' && $level == $access){
						
						$per = $ikejaR;
						$ckcode = "02";
						
						$charge = $Regubil['conv'];
	
	if($plan == 'postpaid'){
		
	$smartCode = "ikedc_postpaid_custom";
		
	}else{$smartCode = "ikedc_prepaid_custom"; }
	
						
			}







if($network === 'portharcourt-electric' && $level == $access){	
										
				$per = $phedR;
				
				$ckcode = "05";
				
				$charge = $Regubil['conv'];	
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "phed_postpaid_custom";
		
	}else{$smartCode = "phed_prepaid_custom"; }
					}





				

if($network === 'ibadan-electric' && $level == $access){
						
					$per = $ibedcR;	
					
					$ckcode = "07";
					
					$charge = $Regubil['conv'];
	
	if($plan == 'postpaid'){
		
	$smartCode = "ibedc_postpaid_custom";
		
	}else{$smartCode = "ibedc_prepaid_custom"; }
	
	
						}
				



if($network === 'kano-electric' && $level == $access){
							
						$per = $kanoR;
						$charge = $Regubil['conv'];	
						
						$ckcode = "04";	
	
	if($plan == 'postpaid'){
		
	$smartCode = "kano_postpaid_custom";
		
	}else{$smartCode = "kano_prepaid_custom"; }
	
							
							}
						

if($network === 'jos-electric' && $level == $access){
								
							$per = $josR;
							$charge = $Regubil['conv'];
							
							$ckcode = "06";	
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "jedc_postpaid_custom";
		
	}else{$smartCode = "jedc_prepaid_custom"; }
								}


						


if($network === 'eko-electric' && $level == $access){
								
							$per = $ekoR;
							$charge = $Regubil['conv'];	
							
							$ckcode = "01";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "ekedc_postpaid_custom";
		
	}else{$smartCode = "ekedc_prepaid_custom"; }
								
							}






if($network === 'abuja-electric' && $level == $access){
								
							$per = $ekoR;
							$charge = $Regubil['conv'];	
							
							$ckcode = "01";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "aedc_postpaid_custom";
		
	}else{$smartCode = "aedc_prepaid_custom"; }
								
							}



if($network === 'enugu-electric' && $level == $access){
								
							$per = $ekoR;
							$charge = $Regubil['conv'];	
							
							$ckcode = "01";
	
	
	if($plan == 'postpaid'){
		
	$smartCode = "eedc_postpaid_custom";
		
	}else{$smartCode = "eedc_prepaid_custom"; }
								
							}





if($network === 'smile-direct' && $level == $access){
							    
							 $per = $smileR;
							$charge = $Regubil['conv'];  
							}
							
							
											
						
						
								
								
								
					
if($network === 'gotv' ){
	
		$affpay = $afi['gotv'];
		$product = "GOTV Payment";
		$img = "Gotv-Payment.jpg";
			
			}

if($network === 'dstv'){
			
			$affpay = $afi['dstv'];
			
			$product = "DSTV Payment";
			
			$img = "Pay-DSTV-Subscription.jpg";
				
			}


if($network === 'startimes'){
					
					$affpay = $afi['startimes'];
					
					$product = "Startimes Payment";
					
					$img = "Startimes-Subscription.jpg";
				
						}
						



// Service Label & affiliate payment

						
if($network === 'portharcourt-electric'){
					
					$affpay = $afi['Phed'];
					
					$product = "PortHarcourt Electric Payment - PHED";
					
					$img = "18112019141721Port-Harcourt-Electric.jpg";
				
						}else{ $affpay = 0;	$product = "";}
						
						

if($network === 'ikeja-electric'){
					
					$affpay = $afi['IkejaElectric'];
					
					$product = "Ikeja Electric Payment - IKEDC";
					
					$img = "Ikeja-Electric-Payment-PHCN.jpg";
				
						}else{ $affpay = 0;	$product = "";}
						
						

if($network === 'ibadan-electric'){
					
					$affpay = $afi['Ibedc'];
					
					$product = "Ibadan Electric Payment - IBEDC";
					
					$img = "IBEDC-Ibadan-Electricity-Distribution-Company.jpg";
				
						}else{ $affpay = 0;	$product = "";}
						
						
							


if($network === 'eko-electric'){
					
					$affpay = $afi['EkoElectric'];
					
					$product = "Eko Electric Payment - EKEDC";
					
					$img = "Eko-Electric-Payment-PHCN.jpg";
				
						}else{ $affpay = 0;	$product = "";}
						
						
						


if($network === 'jos-electric'){
					
					$affpay = $afi['JosElectric'];
					
					$product = "Jos Electric Payment - JED";
					
					$img = "Jos-Electric-JED.jpg";
				
						}else{ $affpay = 0;	$product = "";}
						
						
						


if($network === 'kano-electric'){
					
					$affpay = $afi['Kedc'];
					
					$product = "Kano Electric Payment - KEDCO";
					
					$img = "Kano-Electricity-Distribution-Company-KEDCO-logo.png";
				
	}else{ $affpay = 0;	$product = "";}
						
						
						
						
						
						
				$payko = ($affpay/100)*$xamount;			
	
	
	$comi = ($per/100)*$xamount;
	$debit = $xamount-$comi;
						
						
										
						$chargeAmt = $debit + $charge;
						
						 $payable = $chargeAmt;
						
						$ShowName = '<tr>
                            <td width="30%">Customer Name</td>
                            <td id="mainService"> '.$CustomerName.'  </td>
                        </tr>
                        
                        ';
                      
							if($network === 'gotv'){
							$decoder = "IUC Number";
							$pnt = $plan;
							if(!is_null($CustomerName)){
							
							$customer = $ShowName;
							
							}else{$customer = "";}
							}elseif($network === 'dstv'){
								
								$pnt = $plan;
								$decoder = "SmartCard No";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								
								elseif($network === 'portharcourt-electric'){
								
								$pnt = "Port Harcourt Electricity - PHED";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								
								elseif($network === 'eko-electric'){
								
								$pnt = "Eko Electricity - EKEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}

								elseif($network === 'abuja-electric'){
								
								$pnt = "Abuja Electricity - AEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}


								
								elseif($network === 'jos-electric'){
								
								$pnt = "Jos Electricity - JED";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								
								elseif($network === 'ikeja-electric'){
								
								$pnt = "Ikeja Electricity - IKEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								elseif($network === 'ibadan-electric'){
								
								$pnt = "Ibadan Electricity - IBEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								
								elseif($network === 'kaduna-electric'){
								
								$pnt = "Kaduna Electricity - KAEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}

							
								elseif($network === 'enugu-electric'){
								
								$pnt = "Enugu Electricity - EEDC";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}

							
								elseif($network === 'kano-electric'){
								
								$pnt = "Kano Electricity - KEDCO";
								$decoder = "Meter Number";
								
								if(!is_null($CustomerName)){
								$customer = $ShowName;
							   		}else{$customer = "";}
								
								}
								
								elseif($network === 'startimes'){
									$pnt = "Startimes $plan";
									$decoder = "SmartCard No";
									
									if(!is_null($CustomerName)){
										
									$customer = $ShowName;
										
									}else{$customer = "";}
									
									}elseif($network === 'smile-direct'){
									    
									     $img = "Smile-Payment.jpg";
										
										if($type !== 'voice'){
										
									$pnt = "Smile $plan";
									$decoder = "Smile Account No";
										
									if(!is_null($CustomerName)){
										
									$customer = $ShowName;
										
									}else{$customer = "";}
										
										}else{ 
										
										$pnt = "Smile $plan";
									$decoder = "Smile Voice Number";
										
									if(!is_null($CustomerName)){
										
									$customer = $ShowName;
										
									}else{$customer = "";}   }
										
										}
									
									else{
										
										if(!is_null($CustomerName)){
										
									$customer = $ShowName;
										
									}else{$customer = "";}
									
									$pnt = $_SESSION['plan'];	
									$decoder = "Meter Number";
										}

?>