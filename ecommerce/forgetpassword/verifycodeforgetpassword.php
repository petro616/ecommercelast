<?php
include "../connect.php";

$email = filterRequest("email");
$verifycode = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM `users` WHERE user_email = '$email' AND verify_code = '$verifycode'");
$stmt->execute();
$count = $stmt->rowCount();
if($count > 0){

echo json_encode(array("status" => "success"));
}else{
echo json_encode(array("status" => "failure"));
}

?>