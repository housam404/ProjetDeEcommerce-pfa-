<?php
require 'includes/db.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image']; // هنا ممكن تكون URL أو اسم الصورة

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image, $category]);

    echo "Product added successfully!";
}
?>
<form method="POST">
    Name: <input type="text" name="name"><br>
    Description: <textarea name="description"></textarea><br>
    Price: <input type="number" step="0.01" name="price"><br>
    Category: <input type="number" name="category"><br>
    Image: <input type="text" name="image"><br>
    <button type="submit" name="submit">Add Product</button>
</form>