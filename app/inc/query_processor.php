<?php 
$query_rec = mysqli_query($conn,"SELECT * FROM payment");
			
			$apib = mysqli_fetch_array($query_rec);
			
			$pstak = $apib['paystackSecret'];
			
			$flwPub = $apib['flutterpub'];
			
			$coinpub = $apib['bitpub'];
			$coinsec = $apib['bitsec'];


?>