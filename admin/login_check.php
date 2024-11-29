<?php
include 'condb.php';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

// เข้ารหัส password ด้วย sha512
$hashed_password = hash('sha512', $password);

// Check if the username is 'admin' and password is '555'
$admin_password = '555';
$hashed_admin_password = hash('sha512', $admin_password);
if ($username == 'admin' && $hashed_password == $hashed_admin_password) {
    // Redirect to show_product.php for admin
    header("Location: index.php");
    exit(); // Ensure no further code is executed
} elseif ($username == 'stock' && $hashed_password == hash('sha512', '111')) {
    // Redirect to stock-specific page
    header("Location: stock/index.php");
    exit();
} elseif ($username == 'seller' && $hashed_password == hash('sha512', '222')) {
    // Redirect to seller-specific page
    header("Location: seller/index.php");
    exit();
}

// Normal user login process
$sql = "SELECT * FROM tb_member WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $_SESSION["username"] = $row['username'];
    $_SESSION["pw"] = $row['password'];
    $_SESSION["firstname"] = $row['name'];
    $_SESSION["lastname"] = $row['lastname'];
    // Redirect to index.php for regular users
    header("Location: ../show_product.php");
} else {
    $_SESSION["Error"] = "<p>Your username or password is invalid</p>";
    header("Location: login.html");
}
?>



