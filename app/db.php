<?php

$host = "localhost";
$dbname = "vtu_app";
$dbuser = "root";
$dbpass = "";

$conn = mysqli_connect("$host","$dbuser","$dbpass","$dbname");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
  
  class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "vtu_app";
	
	private static $conn;
	
	function __construct() {
	    $this->conn = $this->connectDB();
	    if(!empty($this->conn)) {
	        $this->selectDB();
	    }
	}
	
	function connectDB() {
	    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
	    return $conn;
	}
	
	function selectDB() {
	    mysqli_select_db($this->conn, $this->database);
	}
	
	function runQuery($query) {
	    $result = mysqli_query($this->conn, $query);
	    while($row=mysqli_fetch_assoc($result)) {
	        $resultset[] = $row;
	    }
	    if(!empty($resultset))
	        return $resultset;
	}
	
	function numRows($query) {
	    $result  = mysqli_query($this->conn, $query);
	    $rowcount = mysqli_num_rows($result);
	    return $rowcount;
	}
}

?>