<?php
include "../connect.php";
$adressid  = filterRequest("adressid");
deleteData("adress" , "adress_id  = $adressid");
?>