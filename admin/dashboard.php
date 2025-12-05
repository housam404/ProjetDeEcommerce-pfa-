<?php
require '../includes/db.php'; // ../ يعني واحد فولدر لفوق
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <div class="list-group">
        <a href="add_product.php" class="list-group-item list-group-item-primary mb-2">Add Product</a>
        <a href="manage.php" class="list-group-item list-group-item-secondary">Manage Products</a>
    </div>
</div>

<?php include '../includes/footer.php';?>