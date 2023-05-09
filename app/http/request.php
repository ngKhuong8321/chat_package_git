<?php

session_start();

$link = mysqli_connect("localhost", "root", "1234", "chat_package_db");

if ($link === false) {
    die("ERROR: Could not connect. "
                .mysqli_connect_error());
}

#check if username, password, name submitted
if(isset($_POST['id']) &&
   isset($_POST['message']) &&
   isset($_POST['name'])){

    # database connection file
    include '../db_conn.php';

    #get data from POST request and store in var
    $room_id = $_POST['id']*2;
    $id = $_POST['id'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    #making URL data format
    $data = 'id='.$id.'&name'.$name.'&message'.$message;

    $sql = "INSERT INTO 
            conversations(room_id, from_id, msg)
            VALUES (?, ?, ?)";
   $stmt = $conn->prepare($sql);

   // Explicitly bind parameters
   $stmt->bindParam(1, $room_id);
   $stmt->bindParam(2, $id);
   $stmt->bindParam(3, $message);

   $res = $stmt->execute([$room_id, $id, $message]);

   // Update room list   
   $sql2 = "SELECT * FROM rooms WHERE (id=$room_id)";
   if ($res2 = mysqli_query($link, $sql2)) {
      if (mysqli_num_rows($res2) == 0) {
         $sql3 = "INSERT INTO 
                  rooms(id)
                  VALUES (?)";
         
         $stmt3 = $conn->prepare($sql3);
         $stmt3->bindParam(1, $room_id);

         $res3 = $stmt3->execute([$room_id]);
         mysqli_free_result($res2);
      } else {};
   }

   

   // Update user list
   $sql4 = "SELECT * FROM users WHERE (user_id=$id)";
   if ($res4 = mysqli_query($link, $sql4)) {
      if (mysqli_num_rows($res4) == 0) {
         $sql5 = "INSERT INTO 
                  users(user_id, user_name)
                  VALUES (?, ?)";
         
         $stmt5 = $conn->prepare($sql5);
         $stmt5->bindParam(1, $id);
         $stmt5->bindParam(2, $name);

         $res5 = $stmt5->execute([$id, $name]);
         mysqli_free_result($res4);
      } else {};
   }

   if($res)
   {
      header("Location: ../../chat_page.php?room_id=".$room_id."&user_id=".$id);
      exit;
      
   } else;
   } else {
    header("Location: ../../chat_page.php");
    exit;
   }