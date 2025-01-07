<?php
include "../connect.php";

$usersid = filterRequest("usersid");
getAllData("myfavourite" , "favoutire_usersid = ?" , array($usersid));

?>