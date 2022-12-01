<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include("connection.php");

if (isset($_POST['image']) && isset($_FILES['my_image'])) {

echo "<pre>";
print_r($_FILES['my_image']);
echo "</pre>";

$img_name = $_FILES['my_image']['name'];
$img_size = $_FILES['my_image']['size'];
$tmp_name = $_FILES['my_image']['tmp_name'];
$error = $_FILES['my_image']['error'];

if ($error === 0) {
if ($img_size > 125000) {
$em = "Sorry, your file is too large.";
header("Location: index.php?error=$em");
}else{
	$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
	$img_ex_lc = strtolower($img_ex);
	$allowed_exs = array("jpg", "jpeg", "png"); 

if (in_array($img_ex_lc, $allowed_exs)) {
	$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
	$img_upload_path = 'uploads/'.$new_img_name;
	move_uploaded_file($tmp_name, $img_upload_path);
    $mysql = "INSERT INTO posts(image_url) VALUES ('$new_img_name')";
    mysqli_query($connection, $sql);    
    header("Location: view.php");

}else{
$em = "You can't upload files of this type";
header("Location: index.php?error=$em");
	}
	}
}else{
    $em = "unknown error occurred!";
	header("Location: index.php?error=$em");
}
}else{
	header("Location: index.php");
}