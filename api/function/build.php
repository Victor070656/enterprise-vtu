<?php
function UserdebitWallet($conn,$newBalc,$upp_cas_lx){
	$stmtDeb = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
	$stmtDeb->bind_Param("is",$newBalc,$upp_cas_lx);
	$stmtDeb->execute();
	$stmtDeb->close();
	    	}

?>