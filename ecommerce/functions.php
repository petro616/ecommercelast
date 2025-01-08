<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null , $json = true)
{
    global $con;
    $data = array();
    if($where == null){
        $stmt = $con->prepare("SELECT  * FROM $table");
    }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");    
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }else{
    if($count > 0){
    return array("status" => "success" , "data" => $data);
    }else{
    return  array("status" => "failure");
    }
    }
    
}

function getData($table, $where = null, $values = null , $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }else{
    return $count;
    }
    
    
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest)
{
  global $msgError;
  $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
  if ($imagesize > 2 * MB) {
    $msgError = "size";
  }
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  "../upload/" . $imagename);
    return $imagename;
  } else {
    return "fail";
  }
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}
function sendmail($to , $title , $body){
    $header = "From: rebal@repostoree.online\r\n";
$header = "CC: repo@repostoree.online\r\n";
    mail($to , $title , $body , $header);
}
function sendGCM($title, $message, $topic, $pageid, $pagename) {  
    // URL for Firebase Cloud Messaging  
    $url = 'https://fcm.googleapis.com/v1/projects/ecommerceapp2-aaed0/messages:send';  

    // Constructing the message payload  
    $fields = array(  
        "message" => array(  
            "topic" => $topic,  
            "notification" => array(  
                "body" => $message,  
                "title" => $title  
            ),  
            "data" => array(  
                "keysandvalues" => json_encode(array(  
                    "pageid" => $pageid,  
                    "pagename" => $pagename  
                ))  
            ),  
            "android" => array(
                "priority" => "high",
                "notification" => array(  
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK" // Adjust if necessary  
                )  
            ),  
            "apns" => array( // Optional: for iOS notifications  
                "payload" => array(  
                    "aps" => array(  
                        "category" => "NEW_MESSAGE_CATEGORY" // Adjust if necessary  
                    )  
                )  
                    ),
               
        )  
    );  
    
    // Encoding the fields as JSON  
    $fields = json_encode($fields);  
    
    // Headers for the request  
    $headers = array(  
        'Authorization: Bearer ya29.c.c0ASRK0GbrAgXe7L9ek9bQLwqkrLDsR_Xi-FG5_26VobJa0Tus7Zg9O9na4Lit3D0hJhnqr2yDV8Autk0xGHIFI-yIjHAOMf4NOoIohamMSLO_h9M0TghS09z_X6x49UVEkw76fQXkcjNZtVbIn8o1tYRImVE2tTKyMH6pfND-h0MZsYZccVPjBIw-VR2U7VSWRLPtPVjIYRUspVlbRdZw-W8VXC4GA8Vtol0q9k8_5rXoNDkHJjMKS2ZSeySUtIUL2ybpb4EbQmK4AHM3bF5ttHUjyphm3j1p1uHqDwlzfBlYMDzU9rm_isPgeC828cn346TgXYmKKjErgYHtW-QAhisq7RAzElkvX2CGp6HOvh0LBEd9jyWP8QIxquQKL389C-Rka44Ok4IJZw9Wv9_OOsJcu01zxS7Z52S82R34YYfmdZgwmquvcsh31y6k28SldzjvmmUv-kxaSq9fxh4Y3ai2ol7n5zSFRkXnvhc343vYQipe6c6-0kv3aMwFMRUhvUm5m9XoxZp-yI_escUyuoIU7ztZQmIbdabQVZao8o-bBVJdIwunxJij_3Zg-t6Y9z8xgV7-q5fzkpMsRXqoZyhIk_so9il-mbZfXY3fMIyrex3hyoX6oxzZ5cu_aoaJudpgUz3hX-qpu08eg9f-4BFIO1wp_OqBUUgFoJk1QI1InpBUZi_QXm7bUJfw6c7BzQFBW22uSJ4_6RURXrtouhqt75IqJ-cbS02ZcVhF_zib2kelwmIWsYm3iZn611s59lReYO4-Q2akfYpOq-_BguIFip2VerJ0yuxnYX9wSgwxb_40VJ-b6MJRnYIz-MynJm5lW8R9dlUzv02_UaSOeXJhhpn0Uzm-B4ue3XJYcuoVsWw35t22qFRSIx5lYqVShFqoVF1azqqndcVJ28jF6zo-BqYzkZ5B2_Rh7xvnx5_wJ3F1tIhBYpbcmwvF4nFxOSgXMf6xOtzmQeytwzrxgSzUbyY7qjFbSyVcygxe', // Use the actual token  
        'Content-Type: application/json'  
    );  
    
    // Initializing a cURL session  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_POST, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);  
    
    // Executing the cURL request  
    $result = curl_exec($ch);  
    
    // Error handling  
    if ($result === false) {  
        echo 'Curl error: ' . curl_error($ch);  
    }  
    
    // Closing cURL session  
    curl_close($ch);  
    
    // Returning the result  
    return $result;  
}