<?php
include "../connect.php";
$email = filterRequest("email");
$password = sha1($_POST["password"]) ;

getData("users" , "user_email = ? AND user_password = ?" , array($email , $password));













