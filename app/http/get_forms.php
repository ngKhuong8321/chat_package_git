 <?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

function getForms($conn){
   
   $sql = "SELECT * FROM forms";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);

    if ($stmt->rowCount() > 0) {
    	$forms = $stmt->fetchAll();
    	return $forms;
    }else {
    	$forms = [];
    	return $forms;
    }

}