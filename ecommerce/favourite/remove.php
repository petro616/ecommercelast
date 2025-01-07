<?php
include "../connect.php";

$usersid = filterRequest("usersid");
$itemsid = filterRequest("itemsid");

deleteData("favoutire" , "favoutire_usersid = $usersid AND favoutire_itemsid = $itemsid");

?>