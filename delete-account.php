<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user']['id'];

mysqli_query($conn, "DELETE FROM users WHERE id=$id");

session_destroy();

header("Location:index.php");
?>