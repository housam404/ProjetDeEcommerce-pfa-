<?php
require 'includes/db.php';
include 'includes/header.php';

// جلب المنتجات
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Our Products</h2>
    <div class="row">
        <?php foreach($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong>dh<?= number_format($product['price'], 2) ?></strong></p>
                    <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php';?>