<?php
require 'includes/db.php';
session_start();
include 'includes/header.php';

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){
    echo "<p>Product not found!</p>";
    include 'includes/footer.php';
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $product['image'] ?>" class="img-fluid" alt="<?= $product['name'] ?>" style="height:300px; object-fit:contain;">
        </div>
        <div class="col-md-6">
            <h2><?= $product['name'] ?></h2>
            <p><?= $product['description'] ?></p>
            <h4>Price: <?= number_format($product['price'], 2) ?> dh</h4>

            <form method="POST" action="cart.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php';?>