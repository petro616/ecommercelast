<?php
include "../connect.php";
$usersid = filterRequest("usersid");
$data = getAllData("cartview","cart_usersid = $usersid", null,false);
$stmt = $con->prepare("SELECT SUM(itemsprice) AS totalprice , SUM(countitems) AS totalcount FROM cartview
WHERE cartview.cart_usersid = $usersid
GROUP BY cart_usersid");
$stmt->execute();
$totalpricebycountandtotalcount = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode(array("status" => "success" , "datacartview" => $data ,"totalpricebycountandtotalcount" => $totalpricebycountandtotalcount));
?>