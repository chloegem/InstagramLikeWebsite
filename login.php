<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include("connection.php");

if(isset($_POST["Username"]) && $_POST["Username"] != "" && isset($_POST["Password"]) && $_POST["Password"] != ""){
    $Username = $_POST["Username"];
    $Password = $_POST["Password"]
}else{
    $response = [];
    $response["success"] = false;
    echo json_encode($response);
    return;
}

$query = $mysqli->prepare("Select from users * WHERE Username = ? && Password = ?");
$query->bind_param("ss", $Username, $Password);
$query->execute();

$array=$query->get_result();
$response = [];
while($authentication = $array->fetch_assoc()){
    $response[] = $authentication;
}

if (!$response){
    $response["success"] = "User doesn't exist";
}else{
    $response["success"] = true;
}
echo json_encode($response);


