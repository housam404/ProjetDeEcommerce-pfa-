<?php
require 'includes/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['action']) && $_GET['action']=='add' && isset($_GET['id'])){
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE user_id=? AND product_id=?");
    $stmt->execute([$user_id, $product_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if($item){
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE id=?");
        $stmt->execute([$item['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $product_id]);
    }
}

include 'includes/header.php';

$stmt = $conn->prepare("SELECT c.id, p.name, p.price, c.quantity FROM cart_items c JOIN products p ON c.product_id = p.id WHERE c.user_id=?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($cart_items as $item){
    echo $item['name'] . " - " . $item['price'] . "$ x " . $item['quantity'];
    echo " <a href='cart.php?action=remove&id=".$item['id']."'>Remove</a><br>";
}

include 'includes/footer.php';
?>