<?php 

session_start();

$link = mysqli_connect("localhost", "root", "1234", "chat_package_db");

if ($link === false) {
    die("ERROR: Could not connect. "
                .mysqli_connect_error());
}


echo $_POST['id'];

if(isset($_POST['id'])){

    # database connection file
    include '../db_conn.php';

    echo $_POST['id'];

    #get data from POST request and store in var
    $id = $_POST['id'];
    header("Location: ../../chat_page.php?room_id=".$id."&user_id=1");
    exit;
}

    