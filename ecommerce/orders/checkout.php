<?php
include "../connect.php";
$usersid = filterRequest("usersid");
$ordertype = filterRequest("ordertype");
$address = filterRequest("address");
$shippingprice = filterRequest("shippingprice");
$orderprice = filterRequest("orderprice");
$couponid = filterRequest("couponnid");
$paymentmethod = filterRequest("paymentmethod");
$discountcopon = filterRequest("copondiscount");
  
if($ordertype == "1"){
    $shippingprice = 0;
}
$totalprice = $orderprice + $shippingprice;

//check copon
$now = date("Y-m-d H:i:s");
$checkcopon = getData("coupon" , "coupon_id = '$couponid' AND coupon_expiredata > '$now' And coupon_count > 0" , null , false);
if($checkcopon > 0){
$totalprice = $totalprice - $orderprice * $discountcopon / 100;
$stmt = $con->prepare("UPDATE `coupon` SET `coupon_count`= coupon_count - 1 WHERE coupon_id = '$couponid'");
$stmt->execute();
}


$data = array(
    "orders_usersid" => $usersid,
    "orders_type" => $ordertype,
    "orders_address" => $address,
    "orders_shipingprice" => $shippingprice,
    "orders_price" => $orderprice,
    "orders_coupon" => $couponid,
    "orders_paymentmethod" => $paymentmethod,
    "orders_totalprice" => $totalprice,
);
$count = insertData("orders" , $data , false);
if($count > 0){
    $stmt = $con->prepare("SELECT MAX(orders_id) FROM orders");
    $stmt->execute();
    $maxid = $stmt->fetchColumn();
    $data = array(
    "cart_orders" => $maxid
    );
    updateData("cart" , $data , "cart_usersid = $usersid AND cart_orders = 0");
}
?>