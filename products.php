<?php
require 'includes/db.php';

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($products as $product){
    echo "ID: " . $product['id'] . "<br>";
    echo "Name: " . $product['name'] . "<br>";
    echo "Price: " . $product['price'] . "<br>";
    echo "<hr>";
}
?>