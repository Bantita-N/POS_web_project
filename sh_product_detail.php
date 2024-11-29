<?php
include 'condb.php';

// ตรวจสอบว่ามีการระบุ ID สินค้าหรือไม่
$proId = isset($_GET['id']) ? $_GET['id'] : '';

// ตรวจสอบว่ามีการค้นหาหรือไม่
$searchValue = isset($_GET['search_value']) ? $_GET['search_value'] : '';

if (!empty($proId)) {
    // ป้องกัน SQL Injection
    $proId = mysqli_real_escape_string($conn, $proId);

    $sql = "SELECT p.*, t.type_name
            FROM product p
            JOIN type t ON p.type_id = t.type_id
            WHERE p.pro_id = '$proId'";
} elseif (!empty($searchValue)) {
    // ป้องกัน SQL Injection
    $searchValue = mysqli_real_escape_string($conn, $searchValue);

    $sql = "SELECT p.*, t.type_name
            FROM product p
            JOIN type t ON p.type_id = t.type_id
            WHERE p.pro_id = '$searchValue' OR p.pro_name LIKE '%$searchValue%'";
} else {
    echo "กรุณาระบุสินค้าที่ต้องการดู";
    exit;
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
include 'menu.php';
?>
    <div class="container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="row">
            <div class="col-md-4">
                <img src="image/<?= $row['image'] ?>" width="350px" class="mt-4 p-2 my-2 border" alt="<?= $row['pro_name'] ?>">
            </div>
            <div class="col-md-6">
                <br><br>
                ID: <?= $row['pro_id'] ?><br>
                <h5 class="text-success"><?= $row['pro_name'] ?></h5><br>
                ประเภทสินค้า: <?= $row['type_name'] ?><br>
                รายละเอียด: <?= $row['detail'] ?><br>
                ราคา: <b class="text-danger"><?= number_format($row['price'], 2) ?></b> บาท<br>
                <a class="btn btn-outline-success mt-2" href="order.php?id=<?= $row['pro_id'] ?>">Add cart</a>
            </div>
        </div>
        <hr>
        <?php
            }
        } else {
            echo "ไม่พบข้อมูลสินค้า";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>