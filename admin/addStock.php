<?php
include 'condb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pro_id = $_POST['pro_id'];
    $new_amount = $_POST['amount'];
    $new_price = $_POST['price'];

    // ตรวจสอบว่าต้องการเพิ่มจำนวนสินค้า หรือปรับปรุงราคา หรือทั้งสองอย่าง
    if (!empty($new_amount)) {
        $sql_update_amount = "UPDATE product SET amount = amount + ? WHERE pro_id = ?";
        $stmt = $conn->prepare($sql_update_amount);
        $stmt->bind_param("ii", $new_amount, $pro_id);
        $stmt->execute();
    }

    if (!empty($new_price)) {
        $sql_update_price = "UPDATE product SET price = ? WHERE pro_id = ?";
        $stmt = $conn->prepare($sql_update_price);
        $stmt->bind_param("di", $new_price, $pro_id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('อัพเดตข้อมูลเรียบร้อยแล้ว'); window.location.href='add_product.php';</script>";
    } else {
        echo "<script>alert('ไม่มีการเปลี่ยนแปลงข้อมูล'); window.location.href='add_product.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    $pro_id = $_GET['id'];
    $sql = "SELECT * FROM product WHERE pro_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสต็อกสินค้า</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="h3 mb-2 text-gray-800">เพิ่มสต็อกสินค้า</h1>
        <form action="addStock.php" method="POST">
            <input type="hidden" name="pro_id" value="<?= $row['pro_id'] ?>">
            <div class="form-group">
                <label>ชื่อสินค้า: <?= $row['pro_name'] ?></label>
            </div>
            <div class="form-group">
                <label>จำนวนคงเหลือปัจจุบัน: <?= $row['amount'] ?></label>
            </div>
            <div class="form-group">
                <label>ราคา: <?= $row['price'] ?></label>
            </div>
            <div class="form-group">
                <label for="amount">เพิ่มจำนวนสินค้า:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">ปรับปรุงราคา:</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">อัพเดตข้อมูล</button>
            <a class="btn btn-danger" href="add_product.php" role="button">Cancel</a>
        </form>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
