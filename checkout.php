<?php
require 'includes/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ===========================
   FETCH CART ITEMS
=========================== */
$stmt = $conn->prepare("
    SELECT c.id, p.id AS product_id, p.name, p.price, p.image, c.quantity 
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===========================
   HANDLE PAYMENT SUBMIT
=========================== */
if(isset($_POST['pay_now'])){
    $payment_method = $_POST['payment_method'] ?? '';
    if($payment_method && !empty($cart_items)){
        $total = array_sum(array_map(fn($i) => $i['price']*$i['quantity'], $cart_items));

        // إضافة الطلب للقاعدة
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total, payment_method) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $total, $payment_method]);
        $order_id = $conn->lastInsertId();

        // إضافة كل item في order_items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach($cart_items as $item){
            $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        // مسح الكارت
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id=?");
        $stmt->execute([$user_id]);

        // التوجيه لصفحة success.php
        header("Location: success.php?order_id=$order_id");
        exit;
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2>Checkout</h2>

    <?php if(empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach($cart_items as $item): ?>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="<?= $item['image'] ?>" class="card-img-top" style="height:150px; object-fit:contain;">
                        <div class="card-body">
                            <h6><?= $item['name'] ?></h6>
                            <p><?= number_format($item['price'],2) ?> dh</p>
                            <p>Qty: <?= $item['quantity'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" class="mt-4" action="process_payment.php">
            <h5>Select Payment Method:</h5>
            <div class="payment-methods d-flex gap-3">
                <label>
                    <input type="radio" name="payment_method" value="paypal" style="display:none;" required>
                    <img src="assets/images/Paypal.png" alt="PayPal" style="max-width:30px;">
                </label>
                <label>
                    <input type="radio" name="payment_method" value="card" style="display:none;" required>
                    <img src="assets/images/Card1.png" alt="Card" style="max-width:30px;">
                </label>
                <label>
                    <input type="radio" name="payment_method" value="cash" style="display:none;" required>
                    <img src="assets/images/cash2.png" alt="Cash" style="max-width:30px;">
                </label>
            </div>

            <button type="submit" name="pay_now" class="btn btn-success mt-3">Pay Now</button>
        </form>
    <?php endif; ?>
</div>

<style>
.payment-methods label {
    border:2px solid #ccc;
    border-radius:8px;
    padding:5px;
    cursor:pointer;
    transition: all 0.3s;
}
.payment-methods input[type="radio"]:checked + img {
    border:2px solid #28a745;
    box-shadow:0 0 10px #28a745;
    border-radius:8px;
}
.payment-methods label:hover {
    transform: scale(1.05);
    border-color:#007bff;
    box-shadow:0 0 8px #007bff;
}
</style>

<?php include 'includes/footer.php';?>