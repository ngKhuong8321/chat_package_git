<?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];

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

				if($chat['is_img'])
				{ ?>

				<p class="ltext border 
					         rounded p-2 mb-1">
						    <img style="padding: 10px 10px 10px 10px;" onclick="viewImage(this)" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($chat['img'])?>" width= "100%" object-fit = "contain"/>
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>

				<?php

				} else {
	            ?>
                  <p class="ltext border 
					        rounded p-2 mb-1">
					    <?=$chat['msg']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
				  </p>        
	            <?php }
	    	}
	    }
    }else {
    	$chats = [];
    	return $chats;
    }