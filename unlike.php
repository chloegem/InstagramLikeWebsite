<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

include("connection.php");

$response = [];

if (isset($_GET['User_id']) && isset($_GET['Image_id'])){

    if (empty($user_id) || empty($image_id)) {
        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();
    }else{
        $query1 = $mysqli->prepare("SELECT * FROM likes WHERE Image_id = ? AND User_id = ?");
        $query1->bind_param("ii", $image_id, $user_id);
        $query1->execute();
        $result1 = $query1->get_result();

        if (mysqli_num_rows($result1) == 0) {
            $response ["Error"] = "Cannot Delete Like";
            echo json_encode($response);
            exit();
        }else{
            $query2 = $mysqli->prepare("DELETE FROM likes WHERE Image_id = ? AND User_id = ?");
            $query2->bind_param("ii", $image_id, $user_id);
            $query2->execute();
            $response ["Success"] = "Like Deleted";
            echo json_encode($response);
            exit();
        }
    }
}else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}