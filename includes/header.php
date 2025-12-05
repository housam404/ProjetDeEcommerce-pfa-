<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = "/ProjetDeEcommerce(pfa)"; // غير هذا حسب اسم الفولدر ديالك
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= $base_url ?>/index.php">
            <img src="<?= $base_url ?>/assets/images/white.png" alt="logo" width="30" height="30"/>
            M0 Store
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/index.php">Home
                        <img src="<?= $base_url ?>/assets/images/Home.png" alt="logo" width="30" height="30"/>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/cart.php">Cart
                        <img src="<?= $base_url ?>/assets/images/ShoppingCart.png" alt="logo" width="30" height="30"/>
                    </a>
                </li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>/profile.php">Profile
                            <img src="<?= $base_url ?>/assets/images/profile.png" alt="logo" width="30" height="30"/>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base_url ?>/admin/dashboard.php">Dashboard
                                <img src="<?= $base_url ?>/assets/images/Editpng.png" alt="Admin" width="30" height="30"/>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>/logout.php">Logout
                            <img src="<?= $base_url ?>/assets/images/Logout.png" alt="logo" width="30" height="30"/>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>/login.php">Login
                            <img src="<?= $base_url ?>/assets/images/Login.png" alt="logo" width="30" height="30"/>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $base_url ?>/register.php">Register
                            <img src="<?= $base_url ?>/assets/images/add.png" alt="logo" width="30" height="30"/>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
 </div>
</nav>