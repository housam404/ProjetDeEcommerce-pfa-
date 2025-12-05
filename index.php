<?php
require 'includes/db.php';
session_start();

/* =====================================
   ADD TO CART — SESSION
===================================== */

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: index.php");
    exit;
}

/* =====================================
   FETCH PRODUCTS
===================================== */

$stmt = $conn->query("SELECT * FROM products ORDER BY category");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// أسماء الكاتيجوري
$category_names = [
    0 => 'Hoodies',
    1 => 'Jeans',
    2 => 'Scarfs',
    3 => 'Sneakers'
];

// تنظيم المنتجات حسب الكاتيجوري
$products_by_category = [];
foreach ($products as $product) {
    $cat = $product['category'];
    $products_by_category[$cat][] = $product;
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>

    <?php foreach ($products_by_category as $cat_id => $cat_products): ?>
        
        <h3 class="mt-5 mb-3"><?= $category_names[$cat_id] ?? "Category $cat_id" ?></h3>

        <div class="row">

            <?php foreach ($cat_products as $product): ?>
                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <a href="details.php?id=<?= $product['id'] ?>">
                            <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        </a>

                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <p class="card-text"><strong><?= number_format($product['price'], 2) ?> dh</strong></p>

                            <?php if (isset($_SESSION['user_id'])): ?>

                                <!-- زر Add to Cart -->
                                <form method="GET" action="cart.php">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Add to Cart
                                    </button>
                                </form>

                            <?php else: ?>

                                <!-- إذا ما مسجلش -->
                                <a href="login.php" class="btn btn-secondary w-100">Login to Buy</a>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endforeach; ?>

</div>

<?php include 'includes/footer.php';?>