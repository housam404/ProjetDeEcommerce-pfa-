<?php
require 'includes/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// مثال: جمع المنتجات من الكارت
$stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// حساب المجموع
$total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart_items));

// إدراج الطلب
$stmt = $conn->prepare("INSERT INTO orders (user_id, total, payment_method) VALUES (?, ?, ?)");
$payment_method = "PayPal"; // مثال
$stmt->execute([$user_id, $total, $payment_method]);
$order_id = $conn->lastInsertId();

// إدراج عناصر الطلب
foreach($cart_items as $item){
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
}

// مسح الكارت بعد الدفع
$stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id=?");
$stmt->execute([$user_id]);

// توجيه المستخدم للصفحة الناجحة
header("Location: success.php?order_id=$order_id");
exit;
?>