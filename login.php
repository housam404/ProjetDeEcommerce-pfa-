<?php
require 'includes/db.php';
session_start();
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid email or password!";
    }
}
include 'includes/header.php';
?>
<form method="POST">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="submit">Login</button>
</form>
<?php include 'includes/footer.php';?>