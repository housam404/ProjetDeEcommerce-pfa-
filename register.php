<?php
require 'includes/db.php';
if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$fullname, $email, $password]);

    echo "Registration successful!";
}
include 'includes/header.php';
?>
<form method="POST">
    Full Name: <input type="text" name="fullname" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="submit">Register</button>
</form>
<?php include 'includes/footer.php';?>