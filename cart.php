<?php
require 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ===========================
   UPDATE CART (qty/remove)
=========================== */
if (isset($_GET['action']) && isset($_GET['id'])) {
    $cart_id = $_GET['id'];

    if ($_GET['action'] === 'increase') {
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE id=? AND user_id=?");
        $stmt->execute([$cart_id, $user_id]);
    } 
    elseif ($_GET['action'] === 'decrease') {
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = GREATEST(quantity - 1, 1) WHERE id=? AND user_id=?");
        $stmt->execute([$cart_id, $user_id]);
    } 
    elseif ($_GET['action'] === 'remove') {
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE id=? AND user_id=?");
        $stmt->execute([$cart_id, $user_id]);
    }

    header("Location: cart.php");
    exit;
}

/* ===========================
   FETCH CART ITEMS
=========================== */
$stmt = $conn->prepare("
    SELECT c.id, p.name, p.price, p.image, c.quantity 
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Your Cart</h2>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>

    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($cart_items as $item): ?>
                <?php $total = $item['price'] * $item['quantity']; ?>

                <div class="col-md-3">
                    <div class="card h-100" style="width: 100%; max-width: 250px; margin:auto;">
                        
                        <img src="<?= $item['image'] ?>" 
                             class="card-img-top"
                             alt="<?= $item['name'] ?>"
                             style="height:150px; object-fit:contain;">

                        <div class="card-body p-2">
                            <h6 class="card-title mb-1"><?= $item['name'] ?></h6>

                            <p class="card-text mb-1">
                                <?= number_format($item['price'], 2) ?> dh
                            </p>

                            <p class="card-text mb-1">
                                Qty: <?= $item['quantity'] ?>
                            </p>

                            <div class="d-flex justify-content-between">
                                <a href="cart.php?action=decrease&id=<?= $item['id'] ?>" class="btn btn-sm btn-secondary">-</a>
                                <a href="cart.php?action=increase&id=<?= $item['id'] ?>" class="btn btn-sm btn-secondary">+</a>
                                <a href="cart.php?action=remove&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <?php 
            $grand_total = array_sum(
                array_map(fn($i) => $i['price'] * $i['quantity'], $cart_items)
            );
        ?>

        <div class="mt-4 text-end">
            <h4>Grand Total: <?= number_format($grand_total, 2) ?> dh</h4>
        </div>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
