 <?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

function getChats($room_id, $conn){
   
   $sql = "SELECT * FROM conversations
           WHERE (room_id=?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$room_id]);

    if ($stmt->rowCount() > 0) {
    	$chats = $stmt->fetchAll();
    	return $chats;
    }else {
    	$chats = [];
    	return $chats;
    }

}