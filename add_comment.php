<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include("connection.php");

if(isset($_POST["Comment_id"]) && isset($_POST["User_id"]) && isset($_POST["Image_id"]) && isset($_POST["Comment"])){
    $Comment_id = $_POST["Comment_id"];
    $User_id = $_POST["User_id"];
    $Post_id = $_POST["Image_id"];
    $Comment = $_POST["Comment"];
}else{
    $response=[];
    $response["success"]=false;
    echo json_encode($response);
}

$query=$mysqli->prepare("INSERT into comments(Comment_id, User_id, Image_id, Comment) VALUES (?,?,?,?)");
$query=bind_param("iiis", $Comment_id, $User_id, $Post_id, $Comment);
$query->execute();

$response=[];
$response["success"]=true;
echo json_encode($response);


