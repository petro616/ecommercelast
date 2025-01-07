<?php
include "../connect.php";

$email = filterRequest("email");
$verifycode = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM `users` WHERE user_email = '$email' AND verify_code = '$verifycode'");
$stmt->execute();
$count = $stmt->rowCount();
if($count > 0){
$data = array("user_approve" => "1");
updateData("users", $data,"user_email = '$email'");
}else{
echo json_encode(array("status" => "failure"));
}


?>