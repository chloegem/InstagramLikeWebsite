<?php
include("connection.php");

$response = [];

if (isset($_GET['User_id'])) {
    if (empty($User_id)) {
        $response ["Error"] = "Id is empty";
        echo json_encode($response);
        exit();
    }
    else{
        $query1 = $mysqli->prepare("SELECT * FROM users WHERE User_id = ? ");
        $query1->bind_param("i", $User_id);
        $query1->execute();
        $result1 = $query1->get_result();
        
        if (mysqli_num_rows($result1) != 0) {
            $query2 = $mysqli->prepare("SELECT Username, url, description, i.id FROM users as u, images as i WHERE u.id = i.User_id AND i.id NOT IN (SELECT image_id FROM hidden_images WHERE user_id_hidden_from = ?)");
            $query2->bind_param("i", $User_id);
            $query2->execute();
            $result2 = $query2->get_result();
            if (mysqli_num_rows($result2) == 0) {
                $response ["Error"] = "No Images";
                echo json_encode($response);
                exit();
            }
            else{
                while($image = mysqli_fetch_assoc($result2)){
                    $response[] = $image;
                };
                echo json_encode($response);
                exit();
            }
        }   
        else{
            $response["Error"] = "Invalid User";
            echo json_encode($response);
            exit();
        }
    }
}else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}