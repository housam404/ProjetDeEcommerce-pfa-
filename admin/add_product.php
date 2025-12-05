<?php
require '../includes/db.php';
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../index.php");
    exit();
}

$message = '';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image']; // URL أو اسم الصورة

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$name, $description, $price, $image, $category])){
        $message = "Product added successfully!";
    } else {
        $message = "Error adding product.";
    }
}

include '../includes/header.php';
?><div class="container mt-5">
    <h2 class="mb-4">Add New Product</h2><?php if($message): ?>
    <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Price (dh)</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
            <option value="0">Hoodies</option>
            <option value="1">Jeans</option>
            <option value="2">Scarfs</option>
            <option value="3">Sneakers</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Image URL / Name</label>
        <input type="text" name="image" class="form-control" required>
    </div>
    <div class="col-12">
        <button type="submit" name="submit" class="btn btn-success">Add Product</button>
    </div>
</form>

</div><?php include '../includes/footer.php';?>