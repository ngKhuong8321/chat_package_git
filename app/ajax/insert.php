<?php

session_start();

include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

$message = $_POST['message'];
$room_id = $_POST['room_id'];
$from_id = $_POST['from_id'];

$sql = "INSERT INTO 
            conversations(room_id, from_id, msg)
            VALUES (?, ?, ?)";
   $stmt = $conn->prepare($sql);

   // Explicitly bind parameters
   $stmt->bindParam(1, $room_id);
   $stmt->bindParam(2, $from_id);
   $stmt->bindParam(3, $message);

   $res = $stmt->execute([$room_id, $from_id, $message]);


   // Setting up the timeZone
   define('TIMEZONE', 'Asia/Ho_Chi_Minh');
   date_default_timezone_set(TIMEZONE);

   $time = date("Y-m-d H:i:s");
   ?>

    <p class="rtext align-self-end
                                    border rounded p-2 mb-1">
                                <?=$message?> 
                                <small class="d-block">
                                    <?=$time?>
                                </small>      	
                            </p>