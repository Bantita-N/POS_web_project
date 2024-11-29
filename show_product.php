<?php
include 'condb.php';
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
    <div class="container text-center">
        <br><br>
        <div class="row">
            <?php
            // Query to select all products from the database, ordered by pro_id
            $sql = "SELECT * FROM product ORDER BY pro_id";
            $result = mysqli_query($conn, $sql);

            // Loop through the result set and display each product
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="col-sm-3">
                <img src="image/<?= $row['image'] ?>" width="200" height="250" class="mt-5 p-2 my-2 border" alt="<?= $row['pro_name'] ?>">
                <br>
                ID: <?= $row['pro_id'] ?><br>
                <h5 class="text-success"><?= $row['pro_name'] ?></h5><br>
                ราคา: <b class="text-danger"><?= number_format($row['price'],2) ?></b> บาท<br>
                <a class="btn btn-outline-success mt-2" href="sh_product_detail.php?id=<?= $row['pro_id'] ?>">รายระเอียด</a>
                <br>
            </div>
            <?php
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>