<?php
require '../includes/db.php';
session_start();

// تأكد أن المستخدم أدمين
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../index.php");
    exit();
}

include '../includes/header.php';

// حذف منتج إذا تم الضغط على delete
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$delete_id]);
    echo "<div class='alert alert-success'>Product deleted successfully.</div>";
}

// جلب كل المنتجات
$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><div class="container mt-5">
    <h2 class="mb-4">Manage Products</h2>
    <a href="add_product.php" class="btn btn-success mb-3">Add New Product</a><table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price (dh)</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td>
                <?php 
                // أظهر اسم الكاتيغوري بدل الرقم
                switch($product['category']){
                    case 0: echo "Hoodies"; break;
                    case 1: echo "Jeans"; break;
                    case 2: echo "Scarfs"; break;
                    case 3: echo "Sneakers"; break;
                    default: echo "Other"; break;
                }
                ?>
            </td>
            <td><?= number_format($product['price'],2) ?></td>
            <td><img src="../<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="height:50px;"></td>
            <td>
                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="manage.php?delete=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div><?php include '../includes/footer.php';?>