
<?php 
while($datafile = $getfil->fetch_assoc())
						
						{
					
							
				echo '  <!-- grid column -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <!-- .card -->
                                <div class="card card-figure">
                                    <!-- .card-figure -->
                                    <figure class="figure">
                                        <!-- .figure-img -->
                                        <div class="figure-img">
                                            <img class="img-fluid" src="uploads/'.$datafile['filename'].'" alt="'.$datafile['name'].'" alt="Card image cap">
                                            <div class="figure-description">
                                                <h6 class="figure-title"> Service  Description </h6>
                                                <p class="text-muted mb-0">
                                                    <medium>'.$datafile['description'].'</medium>
                                                </p>
                                            </div>
                                            <div class="figure-tools">
                                                <a href="#" class="tile tile-circle tile-sm mr-auto"><span class="oi oi-data-transfer-download"></span></a>
                                                <span class="badge badge-warning">'.$datafile['name'].'</span>
                                            </div>
                                            <div class="figure-action">
                                                <a href="'.$datafile['link'].'" class="btn btn-block btn-sm btn-primary">'.$datafile['action'].'</a>
                                            </div>
                                        </div>
                                     
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /grid column -->';			
							
							
							}
	              
?>