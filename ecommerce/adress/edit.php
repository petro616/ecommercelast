<?php
include "../connect.php";
$table = "adress";
$adressid  = filterRequest("adressid");
$name       =  filterRequest("name");
$city       =  filterRequest("city");
$street     =  filterRequest("street");
$lat        =  filterRequest("lat");
$long       =  filterRequest("long");
$data = array( 
"adress_name" => $name , 
"adress_city" => $city , 
"adress_street" => $street , 
"adress_lat" => $lat,
"adress_long" => $long, 	
);
updateData($table , $data , "adress_id  = $adressid");
?>