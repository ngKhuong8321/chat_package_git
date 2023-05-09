<?php

# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

//upload.php
$room_id = $_POST["room_id"];
$user_id = $_POST["user_id"];

if(isset($_POST["submit"])) {
    // Get file photo
    $filename = basename($_FILES["image"]["name"]);
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);

    //allow certain file format
    $allowTypes = array('jpg','png');
    if(in_array($fileType, $allowTypes)){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $sql = "INSERT into conversations (room_id, from_id, img, is_img) VALUES ($room_id, $user_id,'".$imgContent."', true)";        
        $stmt = $conn->prepare($sql);

        $res = $stmt->execute([]);
        if($res)
        {
            header("Location: ../../chat_page.php?room_id=".$room_id."&user_id=".$user_id);
            exit;
            
        } else;
                
        } else {
            $statusMsg = 'Please select an image file to upload.';
        }
}
header("Location: ../../chat_page.php?room_id=".$room_id."&user_id=".$user_id);
            exit;
        ?>