<?php
include "../connect.php";
$usersid = filterRequest("id");
getAllData("orders" , "orders_usersid = '$usersid'");
?>