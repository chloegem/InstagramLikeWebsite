<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

include("connection.php");

if(isset($_POST["User_id"]) && $_POST["User_id"] != "" && isset($_POST["Username"]) && $_POST["Username"] != "" && isset($_POST["FName"]) && $_POST["FName"] != "" && isset($_POST["LName"]) && $_POST["LName"] != "" && isset($_POST["Password"]) && $_POST["Password"] != ""){
    $User_id = $_POST["User_id"];
    $Username = $_POST["Username"];
    $FName = $_POST["FName"];
    $LName = $_POST["LName"];
    $Password = $_POST["Password"];
}else{
    $response = [];
    $response["success"] = false;   
    echo json_encode($response);
    return; 
}

$query = $mysqli->prepare("UPDATE users SET Username=?, FName=? , LName=?, Password=? WHERE User_id=?");
$query->bind_param("ssssi", $Username, $FName, $LName, $Password, $User_id);
$query->execute();

$response = [];
$response["success"] = true;

echo json_encode($response);