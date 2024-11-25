<?php 

			$query_rec = mysqli_query($conn,"SELECT * FROM api_setting");
			
			$apib = mysqli_fetch_array($query_rec);
		
			$query_apiS = mysqli_query($conn,"SELECT * FROM api_setting");
			
			$apiSet = mysqli_fetch_array($query_apiS);
		
	
			
//Airtime services

			if($apiSet['active'] == 'epins'){
				
				$epstat = "checked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
				$mobilng = "unchecked";
				$vtusimhost = "unchecked";	
				$vtusimhost = "unchecked";
				$shagostat = "unchecked";
				
				}elseif($apiSet['active'] === 'vtpass'){
					
				$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "checked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "unchecked";
				$vtusimhost = "unchecked";
				$shagostat = "checked";
					}
					elseif($apiSet['active'] === 'shago'){
					
				$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "unchecked";
				$vtusimhost = "unchecked";
				$shagostat = "checked";
					}
					elseif($apiSet['active'] === 'clubkonnect'){
						
					$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "checked";  
					$smstat  = "unchecked";
					$mobilng = "unchecked";
				$vtusimhost = "unchecked";
				$shagostat = "unchecked";
				
						}elseif($apiSet['active'] === 'smartrecharge'){
							
						$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "checked";
					$mobilng = "unchecked";	
					$vtusimhost = "unchecked";
					$shagostat = "unchecked";
							}

				elseif($apiSet['active'] === 'mobileng'){
				$shagostat = "unchecked";			
						$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "checked";
					$vtusimhost = "unchecked";		
							}


			elseif($apiSet['active'] === 'simhost'){
					$shagostat = "unchecked";		
						$epstat = "unchecked";
				$smeplug = "unchecked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "checked";
					$vtusimhost = "checked";		
							}
							
				elseif($apiSet['active'] === 'smeplug'){
					$shagostat = "unchecked";		
						$epstat = "unchecked";
				$smeplug = "checked";
				$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "unchecked";
					$vtusimhost = "checked";		
							}			
					
					else{ 
					$shagostat = "unchecked";    
					$smeplug = "unchecked";
					$epstat = "unchecked";
					$vstat = "unchecked"; 
					$cstat = "unchecked";  
					$smstat  = "unchecked";
					$mobilng = "unchecked";
					$vtusimhost = "unchecked";	
					}
			


// SME Setting

			if($apiSet['smeactive'] === 'epins'){
				
				$depstat = "checked";
				$gongoz = "unchecked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
				$dmobilng = "unchecked";
				$simhost = "unchecked";	
				$husmo = "unchecked";
				$alrahuz = "unchecked";
				}elseif($apiSet['smeactive'] === 'clubkonnect'){
					$gongoz = "unchecked";	
					$depstat = "unchecked";
				$alrahuz = "unchecked";
				    $smeplugdata = "unchecked";
					$dcstat = "checked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";	
					$husmo = "unchecked";
				
						}elseif($apiSet['smeactive'] === 'smartrecharge'){
						$gongoz = "unchecked";	
						$depstat = "unchecked";
				    $alrahuz = "unchecked";
				    $smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "checked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";
					$husmo = "unchecked";
							}
							elseif($apiSet['smeactive'] === 'smeplug'){
						$gongoz = "unchecked";	
						$depstat = "unchecked";
				$alrahuz = "unchecked";
				    $smeplugdata = "checked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";	
					$husmo = "unchecked";
							}

				elseif($apiSet['smeactive'] === 'mobileng'){
					$gongoz = "unchecked";		
						$depstat = "unchecked";
				$alrahuz = "unchecked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "checked";
					$simhost = "unchecked";	
					$husmo = "unchecked";
							}


				elseif($apiSet['smeactive'] === 'simhost'){
						$gongoz = "unchecked";	
						$depstat = "unchecked";
				$alrahuz = "unchecked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "checked";
					$husmo = "unchecked";		
							}
							
				else if($apiSet['smeactive'] === 'husmodata'){
						$gongoz = "unchecked";	
						$depstat = "unchecked";
				$alrahuz = "unchecked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";
					$husmo = "checked";		
							}
							
							else if($apiSet['smeactive'] === 'alrahuz'){
							
						$depstat = "unchecked";
				$alrahuz = "checked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";
					$husmo = "unchecked";
					$gongoz = "unchecked";
							}
							
							else if($apiSet['smeactive'] === 'gongoz'){
							
						$depstat = "unchecked";
				$alrahuz = "unchecked";
				$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";
					$husmo = "unchecked";
					$gongoz = "checked";
							}
					
					else{ 
					$alrahuz = "unchecked";
					$depstat = "unchecked";
					$smeplugdata = "unchecked";
					$dcstat = "unchecked";  
					$dsmstat  = "unchecked";
					$dmobilng = "unchecked";
					$simhost = "unchecked";	
					$husmo = "unchecked";	
					$gongoz = "unchecked";
					}
			

//TV Active

if($apiSet['tvactive'] == 'epins'){
				
				$Tepstat = "checked";
				$Tshagostat = "unchecked";
				$Tvstat = "unchecked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "unchecked";
				$Tmobilng = "unchecked";
				
				}elseif($apiSet['tvactive'] === 'vtpass'){
					
				$Tepstat = "unchecked";
				$Tshagostat = "unchecked";
				$Tvstat = "checked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "unchecked";
					$Tmobilng = "unchecked";
				
				
					}elseif($apiSet['tvactive'] === 'shago'){
					
				$Tepstat = "unchecked";
				$Tshagostat = "checked";
				$Tvstat = "unchecked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "unchecked";
					$Tmobilng = "unchecked";
				
					}
					elseif($apiSet['tvactive'] === 'clubkonnect'){
						
					$Tepstat = "unchecked";
				$Tshagostat = "unchecked";
				$Tvstat = "unchecked"; 
					$Tcstat = "checked";  
					$Tsmstat  = "unchecked";
					$Tmobilng = "unchecked";
				
						}elseif($apiSet['tvactive'] === 'smartrecharge'){
							
						$Tepstat = "unchecked";
				$Tshagostat = "unchecked";
				$Tvstat = "unchecked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "checked";
					$Tmobilng = "unchecked";		
							}

				elseif($apiSet['tvactive'] === 'mobileng'){
							
						$Tepstat = "unchecked";
				$Tshagostat = "unchecked";
				$Tvstat = "unchecked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "unchecked";
					$Tmobilng = "checked";
							
							}
					
					else{ 
					$Tshagostat = "unchecked";
					$Tepstat = "unchecked";
					$Tvstat = "unchecked"; 
					$Tcstat = "unchecked";  
					$Tsmstat  = "unchecked";
					$Tmobilng = "unchecked";
					}






//Electricity Active

if($apiSet['poweractive'] == 'epins'){
				
				$Eepstat = "checked";
				$Eshagostat = "unchecked";
				$Evstat = "unchecked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "unchecked";
				$Emobilng = "unchecked";
				
				}elseif($apiSet['poweractive'] === 'vtpass'){
					
				$Eepstat = "unchecked";
				$Eshagostat = "unchecked";
				$Evstat = "checked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "unchecked";
					$Emobilng = "unchecked";
				
					}
					elseif($apiSet['poweractive'] === 'shago'){
					
				$Eepstat = "unchecked";
				$Eshagostat = "checked";
				$Evstat = "unchecked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "unchecked";
					$Emobilng = "unchecked";
				
					}
					
					elseif($apiSet['poweractive'] === 'clubkonnect'){
						
					$Eepstat = "unchecked";
				$Eshagostat = "unchecked";
				$Evstat = "unchecked"; 
					$Ecstat = "checked";  
					$Esmstat  = "unchecked";
					$Emobilng = "unchecked";
				
						}elseif($apiSet['poweractive'] === 'smartrecharge'){
							
						$Eepstat = "unchecked";
				$Eshagostat = "unchecked";
				$Evstat = "unchecked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "checked";
					$Emobilng = "unchecked";		
							}

				elseif($apiSet['poweractive'] === 'mobileng'){
							
						$Eepstat = "unchecked";
				$Eshagostat = "unchecked";
				$Evstat = "unchecked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "unchecked";
					$Emobilng = "checked";
							
							}
					
					else{ 
					$Eshagostat = "unchecked";
					$Eepstat = "unchecked";
					$Evstat = "unchecked"; 
					$Ecstat = "unchecked";  
					$Esmstat  = "unchecked";
					$Emobilng = "unchecked";
					}


//Smile Active

if($apiSet['smileactive'] == 'epins'){
				
				$Sepstat = "checked";
				
				$Svstat = "unchecked"; 
					$Scstat = "unchecked";  
					$Ssmstat  = "unchecked";
				$Smobilng = "unchecked";
				
				}elseif($apiSet['smileactive'] === 'vtpass'){
					
				$Sepstat = "unchecked";
				
				$Svstat = "checked"; 
					$Scstat = "unchecked";  
					$Ssmstat  = "unchecked";
					$Smobilng = "unchecked";
				
					}
					
					else{ 
					
					$Sepstat = "unchecked";
					$Svstat = "unchecked"; 
					$Scstat = "unchecked";  
					$Ssmstat  = "unchecked";
					$Smobilng = "unchecked";
					}


//DATA Bundle Active


if($apiSet['dataactive'] == 'epins'){
				
				$dtepstat = "checked";
				$dtvstatshago = "unchecked";
				$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
				$dtmobilng = "unchecked";
				$datasimhost = "unchecked";
				
				}elseif($apiSet['dataactive'] === 'vtpass'){
					
				$dtepstat = "unchecked";
				$dtvstatshago = "unchecked";
				$dtvstat = "checked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "unchecked";
					$datasimhost = "unchecked";
				
					}
					elseif($apiSet['dataactive'] === 'shago'){
					$dtvstatshago = "checked";
				$dtepstat = "unchecked";
				
				$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "unchecked";
					$datasimhost = "unchecked";
				
					}
					
					elseif($apiSet['dataactive'] === 'clubkonnect'){
						
					$dtepstat = "unchecked";
				$dtvstatshago = "unchecked";
				$dtvstat = "unchecked"; 
					$dtcstat = "checked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "unchecked";
					$datasimhost = "unchecked";
				
						}elseif($apiSet['dataactive'] === 'smartrecharge'){
							
						$dtepstat = "unchecked";
				$dtvstatshago = "unchecked";
				$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "checked";
					$dtmobilng = "unchecked";	
				$datasimhost = "unchecked";
							}

				elseif($apiSet['dataactive'] === 'mobileng'){
							
						$dtepstat = "unchecked";
				$dtvstatshago = "unchecked";
				$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "checked";
					$datasimhost = "unchecked";
							
							}

		elseif($apiSet['dataactive'] === 'simhost'){
							
						$dtepstat = "unchecked";
				$dtvstatshago = "unchecked";
				$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "unchecked";
					$datasimhost = "checked";		
							}

					
					else{ 
					$dtvstatshago = "unchecked";
					$dtepstat = "unchecked";
					$dtvstat = "unchecked"; 
					$dtcstat = "unchecked";  
					$dtsmstat  = "unchecked";
					$dtmobilng = "unchecked";
					$datasimhost = "unchecked";
					}






//WAEC Active


if($apiSet['waecactive'] == 'epins'){
				
				$wepstat = "checked";
				$wvstatshago = "unchecked";
				$wvstat = "unchecked"; 
					
				$wmobilng = "unchecked";
				
				}elseif($apiSet['waecactive'] === 'vtpass'){
					
				$wepstat = "unchecked";
				$wvstatshago = "unchecked";
				$wvstat = "checked"; 
				$wmobilng = "unchecked";
				
					}
					
					elseif($apiSet['waecactive'] === 'shago'){
					
				$wepstat = "unchecked";
				$wvstatshago = "checked";
				$wvstat = "unchecked"; 
				$wmobilng = "unchecked";
				
					}

				elseif($apiSet['waecactive'] === 'mobileng'){
							
						$wepstat = "unchecked";
				$wvstatshago = "unchecked";
				$wvstat = "unchecked"; 
					
					$wmobilng = "checked";
							
							}
					
					else{ 
					$wvstatshago = "unchecked";
					$wepstat = "unchecked";
					$wvstat = "unchecked"; 
					
					$wmobilng = "unchecked";
					}
					
//NECO Active


if($apiSet['necoactive'] == 'epins'){
    
    
				$Necoepinstat = "checked";
				$wepstat = "unchecked";
				
				$wvstat = "unchecked"; 
					
				$Necomobilng = "unchecked";
				
				
				}elseif($apiSet['necoactive'] === 'vtpass'){
					
				$wepstat = "unchecked";
				$Necoepinstat = "unchecked";
				$wvstat = "checked"; 
				
					$Necomobilng = "unchecked";
				
					}

				elseif($apiSet['necoactive'] === 'mobileng'){
							
						$wepstat = "unchecked";
				$Necoepinstat = "unchecked";
				$wvstat = "unchecked"; 
					
					$Necomobilng = "checked";
							
							}
					
					else{ 
					$Necoepinstat = "unchecked";
					$wepstat = "unchecked";
					$wvstat = "unchecked"; 
					
					$Necomobilng = "unchecked";
					}
					
					
	//Money Transfer Active

if($apiSet['moneytransfer'] == 'monnify'){
    
    
				$mfystat = "checked";
				$vultestat = "unchecked";
				
				
				}else if($apiSet['moneytransfer'] === 'vulte'){
					
				$mfystat = "unchecked";
				$vultestat = "checked";
				
					}

					else{ 
				$mfystat = "unchecked";
				$vultestat = "unchecked";
					}				
					
//Spectranet Active

if($apiSet['spectranet'] == 'epins'){
    
				$epinSpecstat = "checked";
				$shagospec = "unchecked";
				
				}else if($apiSet['moneytransfer'] === 'shago'){
					
				$epinSpecstat = "unchecked";
				$shagospec = "checked";
				
					}

					else{ 
				$epinSpecstat = "unchecked";
				$shagospec = "unchecked";
					}				
					
					
					

?>