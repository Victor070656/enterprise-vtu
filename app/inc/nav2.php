<?php
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

if($data[0]['level'] !== 'paid'){
$mesg = '<li class="nav-item">
<a class="nav-link" href="../reseller.php">Setup Your Own Portal</a>
</li> <li class="nav-item">
<a class="nav-link" href="../commission.php">Commission Rates</a>
</li> ';     
                                          
}else{
$mesg = '<li class="nav-item">
<a class="nav-link" href="../apikey.php">Create API Key</a>
</li> <li class="nav-item">
<a class="nav-link" href="../commission.php">Commission Rates</a>
</li> ';  
                                          
}?>
 <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                              MENU  
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="../dashboard.php" ><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                                
                            </li>
                           <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Bulk SMS</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        
                                        <li class="nav-item">
                                          <a class="nav-link" href="../sendsms.php">Send SMS</a>
                                        </li>
                                        
                                         <li class="nav-item">
                                          <a class="nav-link" href="../message-history">Message History</a>
                                        </li>
                                        
                                        
                                  
                                    </ul>
                                </div>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-tv"></i>TV Subscription</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../paytv.php">Subscribe TV</a>
                                        </li>
                                      
                                     
                                    </ul>
                                </div>
                            </li>
                            
                             <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-10" aria-controls="submenu-10"><i class="fas fa-fw fa-tasks"></i>Buy Airtime</a>
                                <div id="submenu-10" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../airtime.php">Buy Airtime</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" href="../airtime-pins.php">Buy Airtime PIN</a>
                                        </li>
                                      
                                     
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-11" aria-controls="submenu-11"><i class="fas fa-fw fa-signal"></i>Buy Data</a>
                                <div id="submenu-11" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../data.php">Buy Data</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" href="../spectranet.php">Spectranet Data</a>
                                        </li>
                                      <li class="nav-item">
                                            <a class="nav-link" href="../smile.php">Smile Data</a>
                                        </li>
                                       
                                     
                                    </ul>
                                </div>
                            </li>   
                            
                         <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-plug"></i>Electricity</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                         <li class="nav-item">
                                            <a class="nav-link" href="../electricity.php">Pay Electricity</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            
                            
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-money-bill-alt"></i>Payment</a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../add-fund.php">Credit Wallet</a>
                                        </li>
                                        
                                      
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" href="../paynotify.php">Payment Notification</a>
                                        </li>
                                        
                                         
                                    </ul>
                                </div>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-tasks"></i> Transactions </a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../transaction-history">Transaction History</a>
                                        </li>
                                        
                                       
                                  
                                    
                                    </ul>
                                </div>
                            </li>
                            
                          
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-hand-holding-usd"></i>Reseller<span class="badge badge-secondary">New</span></a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                      
                                       <?php echo $mesg; ?>
                                      
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-users"></i>Referrals</a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../earnings.php">My Earnings</a>
                                        </li>
                                      
                                   
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-wrench"></i>Settings</a>
                                <div id="submenu-9" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../resetpass.php">Change Password</a>
                                        </li>
                                        
                                        
                                         <li class="nav-item">
                                            <a class="nav-link" href="../profile.php">Manage Profile</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../logout" ><i class="fas fa-f fa-power-off"></i>Logout</a>
                                
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>