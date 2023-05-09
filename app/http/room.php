<?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

function getRooms($conn){
   
   $sql = "SELECT * FROM rooms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    	$rooms = $stmt->fetchAll();
    	return $rooms;
    }else {
    	$rooms = [];
    	return $rooms;
    }

}