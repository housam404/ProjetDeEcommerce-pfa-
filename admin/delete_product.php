<?php
require 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->execute([$id]);

echo "Product deleted successfully!";
?>