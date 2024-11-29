<?php
include 'condb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลฝ่ายสต็อก</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="alert alert-primary h4 text-center mb-4 mt-4" role="alert">
                    เพิ่มข้อมูลฝ่ายสต็อก
                </div>
                <form name="form1" method="post" action="insert_stock.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>ชื่อ</label>
                        <input type="text" name="fname" class="form-control" placeholder="ชื่อ" required>
                    </div>
                    <div class="mb-3">
                        <label>นามสกุล</label>
                        <input type="text" name="lname" class="form-control" placeholder="นามสกุล" required>
                    </div>
                    <div class="mb-3">
                        <label>เบอร์โทร</label>
                        <input type="number" name="telephone" class="form-control" placeholder="เบอร์โทร" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-danger" href="report_stock.php" role="button">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>