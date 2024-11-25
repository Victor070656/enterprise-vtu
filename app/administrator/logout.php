<?php
session_start();
unset($_SESSION['user']);
if(session_destroy())
{
echo '<h2 align="center">Logging out...Please wait</h2> 
<p align="center"><img src="image/page-loader.gif" width="200" height="200"></p> <script> 
		setTimeout(function(){
		window.location.href="index.php";},3000);</script>';
}
exit;
?>
