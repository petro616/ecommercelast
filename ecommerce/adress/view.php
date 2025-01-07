<?php
include "../connect.php";
$usersid    =  filterRequest("usersid");
getAllData("adress" , "adress_usersid = $usersid");
?>