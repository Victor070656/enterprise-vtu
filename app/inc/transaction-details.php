
<h2 class='margin-tp-10'>Your Transaction Details are as Follows:</h2>     
                                      
                                        
                              <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <td width="30%">Product</td>
                            <td id="mainService"> <?php echo $pnt;?></td>
                        </tr>
                        
                        <tr>
                            <td width="30%"><?php echo $decoder;?></td>
                            <td id="mainService"><?php echo $iuc;?>  </td>
                        </tr>
                        
                         <?php echo $customer; ?>
                         
                          <?php echo $showAddress; ?>
                                                <tr>
                            <td width="30%">Phone</td>
                            <td><?php echo $_SESSION['phone'];?></td>
                        </tr>                   
                                                            <tr>
                        <td width="30%">Amount</td>
                        <td>₦ <?php echo $_SESSION['amt'];?>.00 +  ₦ <?php echo $charge ?>.00 <i class="conv_fee">
                            
                                                                (Convenience Fee)
                                                        
                        </i></td>
                    </tr>
                                          
                    <tr>
                        <td width="30%">Total Payable Amount</td>
                        <td>₦ <d id="total_amount"><?php echo $chargeAmt;?>.00</d></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>Transaction ID</h4></td>
                        <td id="transactionId"><?php echo $_SESSION['transid'];?></td>
                    </tr>                    
                    <tr>
                        <td width="30%">Status</td>
                        <td><?php echo $rowTrans['status']; ?></td>
                    </tr>       
                    
                    <tr>
                        <td width="30%">Payment Method</td>
                        <td><?php echo $rowTrans['channel']; ?></td>
                    </tr>
                    
                    <tr>
                        <td width="30%">Date</td>
                        <td><?php echo $rowTrans['date']; ?></td>
                    </tr>             
                                            <tr>
                            <td colspan="2">
                                                                                            <div style="margin-top: 20px;"><strong>Recommended Services:</strong></div>
                                
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table>              
                                         
                                        
                                                      
                                                
                       
                                                </p>
                                                
                                                <p align="center">
                                                    
                                                
                                                     </p>
                                               
                                            </div>       
                                      