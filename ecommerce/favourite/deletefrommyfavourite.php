<?php
include "../connect.php";

$id = filterRequest("id");

deleteData("favoutire" , "favoutire_id = $id");

?>