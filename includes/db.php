<?php
$host = "localhost";      // السيرفر ديال DB
$db_name = "db_store";    // اسم القاعدة
$username = "root";       // user ديال DB
$password = "";           // password ديال DB

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>