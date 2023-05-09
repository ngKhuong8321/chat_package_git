 <?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

function isAdmin($user_id, $conn){
   
   $sql = "SELECT * FROM users
           WHERE (user_id=?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    $result = $stmt->fetchAll()[0]['is_admin'];
    return $result;

}