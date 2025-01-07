<?php
include "../connect.php";

$usersid = filterRequest("usersid");
$itemsid = filterRequest("itemsid");

$data = array(
"favoutire_usersid" =>$usersid,
"favoutire_itemsid" => $itemsid  
);
insertData("favoutire" , $data);

?>