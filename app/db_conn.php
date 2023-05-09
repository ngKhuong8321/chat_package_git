<?php

#server name
$sName = "localhost";
#user name
$uName = "root";
#server name
$pass = '1234';

#server name
$db_name = "chat_package_db";

#creating database connection
try{
    $conn = new PDO("mysql:host=$sName;dbname=$db_name",$uName,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo "Connection failed : ". $e->getMessage();
}