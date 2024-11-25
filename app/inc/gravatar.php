<?php
$email = $data[0]['email'];
$default = 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'])."/assets/images/avatar_user.png";
$size = 40;
include('social_icon.php');
$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;

?>