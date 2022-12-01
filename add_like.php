<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include("connection.php");

if(isset($_POST["User_id"]) && $_POST["User_id"] != "" && isset($_POST["Image_id"]) && $_POST["Image_id"] != "" ){
    $User_id = $_POST["User_id"];
    $Image_id = $_POST["Image_id"];

}else{
     $response = [];
     $response["success"] = false;   
     echo json_encode($response);
     return; 
 }

$query1 = $mysqli->prepare("SELECT * FROM users WHERE User_id = ?");
        $query1->bind_param("i", $User_id);
        $query1->execute();
        $result1 = $query1->get_result();

        $query2 = $mysqli->prepare("SELECT * FROM images WHERE Image_id = ?");
        $query2->bind_param("i", $Image_id);
        $query2->execute();
        $result2 = $query2->get_result();

        if (mysqli_num_rows($result1) == 0) {
            $response ["Error"] = "Invalid user";
            echo json_encode($response);
            exit();
        }
        
        else if (mysqli_num_rows($result2) == 0) {
            $response ["Error"] = "Invalid image";
            echo json_encode($response);
            exit();
        }
        else{      
            $query3 = $mysqli->prepare("INSERT INTO likes(Image_id, User_id, likes) VALUES (?, ?, 1)");
            $query3->bind_param("ii", $Image_id, $User_id);
            $query3->execute();
            $response ["Success"] = "Like Added";
            echo json_encode($response);
            exit();
        }