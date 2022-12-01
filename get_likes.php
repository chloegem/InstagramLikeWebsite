<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

include("connection.php");

if(isset($_GET["Image_id"]) ){
    $Image_id = $_GET["Image_id"];
}else{
    $response = [];
    $response["success"] = false;   
    echo json_encode($response);
    return;  
}

$query = $mysqli->prepare("SELECT User_id FROM likes WHERE Image_id = ? && likes = 1");
$query->bind_param("i", $Image_id);
$query->execute();

$response = [];
$array = $query->get_result();
$like_count = 0;
while($Likes = $array->fetch_assoc()){
    $like_count = $like_count + 1;
}
$response["success"] = true;
echo json_encode($like_count);