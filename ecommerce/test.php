<?php
include "connect.php";
$notauth = "";
$response =  sendGCM("hi" , "repo" , "users" , "" , "");
echo "SEND";
echo $response;
?>