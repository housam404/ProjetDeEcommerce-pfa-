<?php
require 'includes/db.php';
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}
include 'includes/header.php';
echo "<h2>Admin Dashboard</h2>";
echo "<a href='add_product.php'>Add Product</a><br>";
echo "<a href='products.php'>Manage Products</a><br>";
include 'footer.php';