 <?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

$room_id = $_POST['room_id'];
$user_id = $_POST['user_id'];

$sql = "SELECT * FROM conversations
                 WHERE room_id=?
                 AND from_id !=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$room_id, $user_id]);

    if ($stmt->rowCount() > 0) {
    	$chats = $stmt->fetchAll();
    	foreach ($chats as $chat) {
	    	if ($chat['opened'] == 0) {
	    		
	    		$opened = 1;
	    		$room_id = $chat['room_id'];

	    		$sql2 = "UPDATE conversations
	    		         SET opened = ?
	    		         WHERE room_id = ?";
	    		$stmt2 = $conn->prepare($sql2);
	            $stmt2->execute([$opened, $room_id]); 

	            ?>
                  <p class="ltext border 
					        rounded p-2 mb-1">
					    <?=$chat['msg']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
				  </p>        
	            <?php
	    	}
	    }
    }else {
    	$chats = [];
    	return $chats;
    }