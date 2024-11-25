
<?php 
while($smtnServ_airtime->fetch()){
					
?> <!-- grid column -->
                            <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                                <!-- .card -->
                                <div class="card card-figure">
                                    <!-- .card-figure -->
                                    <figure class="figure">
                                        <!-- .figure-img -->
                                        <div class="figure-img">
                                            <img class="img-fluid" src="uploads/<?php echo $filNam; ?>" alt="<?php echo $SevyName; ?>" alt="Card image cap">
                                            <div class="figure-description">
                                                <h6 class="figure-title"> Service Description</h6>
                                                <p class="text-muted mb-0">
                                                    <small><?php echo $savyDescr; ?></small>
                                                </p>
                                            </div>
                                            <div class="figure-tools">
                                                <a href="#" class="tile tile-circle tile-sm mr-auto">   </a>
                                                <span class="badge badge-danger"><?php echo $SevyName; ?></span>
                                            </div>
                                            <div class="figure-action">
                                                <a href="<?php echo $ActLink; ?>" class="btn btn-block btn-sm btn-primary"><?php echo $actBtn; ?></a>
                                            </div>
                                        </div>
                                        <!-- /.figure-img -->
                                    </figure>
                                    <!-- /.card-figure -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /grid column -->                       
                            
                            <?php
							}
							
    $smtnServ_airtime->close();  
    
?>