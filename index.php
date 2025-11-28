<?php
require 'includes/db.php';
session_start(); // ضروري باش session تخدم

// إذا المستخدم ما مسجلش
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// ================= ADD TO CART =================
if(isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'add'){
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE user_id=? AND product_id=?");
    $stmt->execute([$user_id, $product_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if($item){
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE id=?");
        $stmt->execute([$item['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $product_id]);
    }

    header("Location: index.php"); // يبقى فـ نفس الصفحة
    exit;
}

// =============== FETCH PRODUCTS =================
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Our Products</h2>
    <div class="row">
        <?php foreach($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- تصحيح مسار الصورة -->
                <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>"> 
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong><?= number_format($product['price'], 2) ?>dh</strong></p>

                    <form method="GET">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php';?>