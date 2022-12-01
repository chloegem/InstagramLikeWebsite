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

$query = $mysqli->prepare("SELECT Comment FROM comments WHERE Image_id = ?");
$query->bind_param("i", $Image_id);
$query->execute();

$array = $query->get_result();
$response = [];
while($comments = $array->fetch_assoc()){
    $response[] = $comments;
}

if(!$response ){
    $response["success"] = "No comments on this post";   
}
echo json_encode($response);