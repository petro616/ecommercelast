<?php
include "../connect.php";
$username = filterRequest("username");
$email = filterRequest("email");
$password = sha1($_POST["password"]) ;
$phone = filterRequest("phone");
$verifycode = rand(10000 , 99999);
$stmt = $con->prepare("SELECT * from `users` WHERE user_email = ? OR user_phone = ?");
$stmt->execute(array($email , $phone));
$count = $stmt->rowCount();
if($count > 0){
echo json_encode(array("status" => "failure"));
}else{
    $data = array(
    "user_name" => $username,
    "user_email" => $email,
    "user_password" => $password,
    "user_phone" => $phone,
    "verify_code" => $verifycode,
    );
    sendmail($email , "babe" , "welcome your verify code => $verifycode");
    insertData("users" , $data);
}
