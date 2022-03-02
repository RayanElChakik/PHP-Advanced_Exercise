<?php
$bdname = 'users';
$dbuser = 'root';
$dbpassword = 'root';
$dbhost = 'localhost'; 

try{
$dsn = "mysql:host=$dbhost;dbname=$bdname;charset=UTF8";
$pdo = new PDO($dsn, $dbuser, $dbpassword );
// echo "Connected to the $bdname database successfully!";
}catch(PDOException $err){
    echo "Database connection problem " . $err->getMessage(); // the getMessage is getting the error from the PDOException 
    exit(); //If it fails to connect the whole process will exit and won't exist 
}
?>