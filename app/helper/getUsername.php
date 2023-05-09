 <?php 
# database connection file
include 'C:\xampp\htdocs\dashboard\chat_package\app/db_conn.php';

function getName($user_id, $conn){
   
   $sql = "SELECT * FROM users
           WHERE (user_id=?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    $result = $stmt->fetchAll()[0]['user_name'];
    return $result;

}