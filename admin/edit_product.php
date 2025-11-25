<?php
require 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=?, category=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $image, $category, $id]);

    echo "Product updated successfully!";
}
?>
<form method="POST">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>"><br>
    Description: <textarea name="description"><?= $product['description'] ?></textarea><br>
    Price: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br>
    Category: <input type="number" name="category" value="<?= $product['category'] ?>"><br>
    Image: <input type="text" name="image" value="<?= $product['image'] ?>"><br>
    <button type="submit" name="submit">Update Product</button>
</form>