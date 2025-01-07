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
function sendGCM($title, $message, $topic, $pageid, $pagename)
{
    $url = 'https://fcm.googleapis.com/v1/projects/ecommerceapp2-aaed0/messages:send';
    $fields = array(
        "topic" => $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
        ),
        'android' => array(
            "notification" => array(
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
        )
        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )
    );
    $fields = json_encode($fields);
    $headers = array(
        'Authorization: Bearer ' . "ya29.c.c0ASRK0GYSNwvW2oPMVf32H3MY2Xa6QJclWLgbuNVf_XhPN7ixFlrPEN457EYjFKls5NLPU4b8H82GYx5su6kLHhjaJTSttlRxf2E007rd8n51Jo9qbPChYRHuNfgcNLunAm4BE0syQWCBnxkcCgEHpxbv1SIsBDk-4NW-Yn2vkBHMUJQExsCyfKEwOX3pf-BZzUrFKwIe_JtVAOjux4bK3hB5HqpCmiCeGz5-2SYZjiPg8yPRMSGVQjUEQ6nBCt-2KA8p5uv5KYtUVpC4VWOCJZ45sOtNRYNmYmSr9TzJ4J3pCJAc7UG7eiC8QWmWE2m3DKqgRnxk-lv9TvSot2MLG4DWl05g-KjPwFFC2DnwgQkGDsYC_e9tKGABM48sHQT391PbSbehd2gk0WOrJFVUYzYqiQq6I_1J-JxwYmzkX78x9_sbhnUVzxOzpcJVJmuXgyu8VUu-ypZqXOm9d-gM3XzUp59-Z9lwSyXjlUwXSpsYZa2bcO5-5uxzJ-FWBo2OZgFV2azeQF2MFsrubZl67OfUealmkcrbMI5qhnU4jX2uk8qB21r3mcyqRVkZoBrXlMup9Zw8_bqe2Baokb-fwFiUofk7-FWMpWlstks3zb4gOUXciwvimw60xZj_im90vru-j_Yg4XtQO8fgeO6Rr1h-2umprZg9hB3Vv7Xc_zdRIkitMSYpeUYwslX49VRvql_9SccFv7t7Wn_x9M-X5ghcpQrtahqu9cWl6XyxnOzn9d2VFq1abIQ47izfmUgI6VnZ6aYUkSkaYYOY-tza8pirjm1x9h-hQRRq36dkre33g1F8dVw4_6uzkm7iW-43RYehm_mRftUe4rS0lUOq5B9mOZqkRdIc1nsr54IIai6354URQt56xFztUfwsYvWXcd7B32I2mc9huonfkgunuJWiOF04xigjY1I-au95sIylVtcvspb-wQYfz9alq7aRfXIXa3JtscF4bRF2kJ8xyv0-lrq6qhRldV_YXkU1",
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}
