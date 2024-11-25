
<?php 

$DbHost = "localhost";

$Dbname = "clickadc_vtuPo45";

$Dbuser = "clickadc_vtuPo45";

$Dbpass = "?R(]b{NYyZ6T";

$conn = mysqli_connect("$DbHost","$Dbuser","$Dbpass","$Dbname");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>