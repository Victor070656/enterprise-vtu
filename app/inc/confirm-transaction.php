
 
 <form method="post" action="" >
                               
<h2 class='margin-tp-10'>Please Confirm your Transaction Details: </h2>     
                                      
                                        
                              <table class="table  margin-tp-10" id="transTable">
                     
                      <?php 
                      $Netary =  array("mtn","airtel","etisalat","glo","Reseller Account Upgrade","mtn-data","airtel-data","glo-data","etisalat-data","01","02","03","04");
                      
                      $bilarray = array("ikeja-electric","kano-electric","portharcourt-electric","eko-electric","ibadan-electric","smile-direct","jos-electric","abuja-electric","enugu-electric","waec","gotv","dstv","startimes","nabteb","nbais","neco");
                      
                      if(in_array($network,$Netary)){
                          
                         $prod = '<tr>
                            <td width="30%">Product</td>
                            <td id="mainService">'.$pnt .'  </td>
                        </tr>'; 
                        
                         
                         $payable = $debit ;
                         
                         
                      }else if(in_array($network,$bilarray)){
                          
                           
                          $prod = "
                          
                          <tr>
                            <td width='30%'>Product</td>
                            <td id='mainService'>$pnt ($plan)  </td>
                        </tr>
                          
                          <tr>
                            <td width='30%'>$decoder</td>
                            <td id='mainService'>$valu  </td>
                        </tr>
                        
                        $customer
                         
                         $showAddress ";
                          
                          
                          
                          $payable = $chargeAmt;
                          
                          }
                      
                      if(in_array($network,array("mtn","airtel","glo","etisalat"))){
                          
                        $lgo = '<tr>
                            <td width="30%"> </td>
                            <td id="mainService"><img src="../assets/images/'.$img.'" width="120" height="110" >  </td>
                        </tr>'; 
                          
                      }else{
                          
                       
                        $lgo = '<tr>
                            <td width="30%"> </td>
                            <td id="mainService"><img src="../../assets/images/'.$img.'" width="120" height="110" >  </td>
                        </tr>';   
                          
                      }
                      
                      ?>  
                        
                        <?php echo $lgo; ?>
                        
                        
                        <?php echo $prod; ?>
                        
                                                <tr>
                            <td width="30%">Phone</td>
                            <td><?php echo $_SESSION['phone'];?></td>
                        </tr>                   
                                                            <tr>
                        <td width="30%">Amount</td>
                        <td>₦<?php echo $_SESSION['amt'];?>.00 +  ₦<?php echo $charge ?>.00 <i class="conv_fee">
                            
                                                                (Convenience fee)
                                                        
                        </i></td>
                    </tr>
                    
                    <tr>
                        <td width="30%">Discount</td>
                        <td>₦<d id="total_amount"><?php echo $comi;?></d></td>
                    </tr>
                    
                                          
                    <tr>
                        <td width="30%">Total Payable Amount</td>
                        <td>₦<d id="total_amount"><?php echo $payable;?></d></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>Transaction ID</h4></td>
                        <td id="transactionId"><?php echo $rowTrans['ref'];?></td>
                    </tr>                    
                    <tr>
                        <td width="30%">Status</td>
                        <td><?php echo $rowTrans['status']; ?></td>
                    </tr>       
                    
                    <tr>
                        <td width="30%">Time Left to Complete Transaction</td>
                        <td><?php echo '<strong id="timing">' ?></td>
                    </tr>             
                                            <tr>
                            <td colspan="2">
                                                                                            <div style="margin-top: 20px;"><strong>Choose Payment Method:</strong></div>
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              		</td>
                        </tr>
                                    </table>              
                                         
                                        
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" name="pay" class="btn btn-rounded btn-primary"><i class="fas fa-fw fa-money-bill-alt"></i> Pay With Wallet</button>
    <button type="submit" name="cardpay" class="cardpay"></button>                  
                                                
                       
                                                </p>
                                                
                                                <p align="center">
                                                    
                                                
                                                     </p>
                                               
                                            </div>       
                                        </form>