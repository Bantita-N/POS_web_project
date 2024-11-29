<?php
include 'condb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="alert alert-primary h4 text-center mb-4 mt-4" role="alert">
                    เพิ่มข้อมูลสินค้า
                </div>
                <form name="form1" method="post" action="insert_product.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>ชื่อสินค้า:</label>
                        <input type="text" name="pname" class="form-control" placeholder="ชื่อสินค้า" required>
                    </div>
                    <div class="mb-3">
                        <label>ประเภทสินค้า:</label>
                        <select class="form-select" name="typeID">
                            <?php
                            $sql = "SELECT * FROM type ORDER BY type_name";
                            $hand = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($hand)) {
                                ?>
                                <option value="<?= $row['type_id'] ?>"><?= $row['type_name'] ?></option>
                            <?php
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>ราคาสินค้า:</label>
                        <input type="number" name="price" class="form-control" placeholder="ราคา" required>
                    </div>
                    <div class="mb-3">
                        <label>จำนวนสินค้า:</label>
                        <input type="number" name="num" class="form-control" placeholder="จำนวน" required>
                    </div>
                    <div class="mb-3">
                        <label>รูปสินค้า:</label>
                        <input type="file" name="file1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-danger" href="admin/add_product.php" role="button">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>