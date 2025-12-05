<?php
require 'includes/db.php';
session_start();

if(!isset($_GET['order_id'])){
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

// جلب تفاصيل الطلب
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow p-4">
                <div class="card-body">
                    <img src="https://img.icons8.com/color/96/000000/ok--v1.png" alt="Success" class="mb-3">
                    <h2 class="card-title text-success mb-3">Payment Successful!</h2>
                    <p class="mb-2"><strong>Order ID:</strong> <?= $order['id'] ?></p>
                    <p class="mb-4"><strong>Total Paid:</strong> <?= number_format($order['total'],2) ?> dh</p>
                    <a href="index.php" class="btn btn-primary btn-lg">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}
.card img {
    width: 80px;
    margin-bottom: 20px;
}
</style>

<?php include 'includes/footer.php';?>