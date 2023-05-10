<?php

session_start();

include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

$name = $_POST['name'];

//Check if existed
$sql3 = "SELECT * FROM popular
           WHERE (article_name=?)";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->execute([$name]);

    if ($stmt3->rowCount() > 0) {
    	$newCount = $stmt3->fetchAll()[0]["count"] + 1;
    	
        // Insert new
        $sql4 = "UPDATE popular
	    		         SET count = ?, created_at = CURRENT_TIMESTAMP
	    		         WHERE article_name = ?";
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bindParam(1, $newCount);
        $stmt4->bindParam(2, $name);
        $res4 = $stmt4->execute([$newCount, $name]);
    }else {
    	// Insert new
        $sql = "INSERT INTO 
                    popular(article_name)
                    VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $name);
        $res = $stmt->execute([$name]);

    }


// Delete records older than 30 days
$sql2 = "DELETE FROM popular WHERE (created_at < DATEADD(day, -30, GETDATE())";
   $stmt2 = $conn->prepare($sql);
   $res = $stmt->execute([]);

   ?>