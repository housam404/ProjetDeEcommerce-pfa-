<?php
session_start();
require 'includes/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// جلب بيانات المستخدم من DB
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="profile-container">
    <h2>My Profile</h2>
    <div class="profile-card">
        <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

        <a href="edit-profile.php" class="btn blue">Edit Profile</a>

        <form action="delete-account.php" method="POST"
              onsubmit="return confirm('Are you sure you want to delete your account?');">
            <button type="submit" class="btn red">Delete Account</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>