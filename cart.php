<?php
session_start();
include 'condb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>
   <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
   <?php include 'menu.php'; ?>
   <br><br>
   <div class="container">
       <form id="form1" method="POST" action="insert_cart.php">
           <div class="row">
               <div class="col-md-10">
               <div class="alert alert-success h4" role="alert">
                    การสั่งซื้อสินค้า
                </div>
                   <table class="table table-hover">
                       <tr>
                           <th>ลำดับที่</th>
                           <th>ชื่อสินค้า</th>
                           <th>ราคา</th>
                           <th>จำนวน</th>
                           <th>เพิ่ม/ลด</th>
                           <th>ราคารวม</th>
                           <th>ลบรายการ</th>
                       </tr>
                       <?php
                       $total = 0;
                       $sumPrice = 0;
                       $m = 1;
                       for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
                           if (($_SESSION["strProductID"][$i]) != "") {
                               $sql1 = "select * from product where pro_id = '" . $_SESSION["strProductID"][$i] . "'";
                               $result1 = mysqli_query($conn, $sql1);
                               $row_pro = mysqli_fetch_array($result1);
                               $_SESSION["price"] = $row_pro['price'];
                               $total = $_SESSION["strQty"][$i];
                               $sum = $total * $row_pro['price'];
                               $sumPrice += $sum;
                               $_SESSION["sum_price"] = $sumPrice;
                               
                       ?>
                               <tr>
                                   <td><?= $m ?></td>
                                   <td>
                                       <img src="image/<?= $row_pro['image'] ?>" width="80px" height="100px" class="border"> <?= $row_pro['pro_name'] ?>
                                   </td>
                                   <td><?= $row_pro['price'] ?></td>
                                   <td><?= $_SESSION["strQty"][$i] ?></td>
                                   <td><a href="order.php?id=<?= $row_pro['pro_id'] ?>" class="btn btn-outline-primary">+</a>
                                       <?php if($_SESSION["strQty"][$i] > 1){ ?>
                                         <a href="order_del.php?id=<?= $row_pro['pro_id'] ?>" class="btn btn-outline-primary">-</a>
                                       <?php } ?>
                                   </td>
                                   <td><?= $sum ?></td>
                                   <td><a href="pro_delete.php?Line=<?= $i ?>"><img src="image/images (1).jpg" width="30px"></a></td>
                               </tr>
                       <?php
                               $m++;
                           }
                       }
                       ?>
                       <tr>
                         <td class = "text-end"colspan="4">รวมเป็นเงิน</td>
                         <td class = "text-center"><?=$sumPrice?></td>
                         <td>บาท</td>
                       </tr>
                   </table>
                   <div style="text-align:right">
                       <a href="show_product.php"><button type="button" class="btn btn-outline-secondary">เลือกสินค้า</button></a> |
                       <button type="submit" class="btn btn-outline-success">ยืนยันรายการ</button>
                   </div>
               </div>
               <br>
               <div class="row">
                    <div class="col-md-4">
                        <div class="alert alert-success"  h4 role="alert">
                            ที่อยู่จัดส่งสินค้า
                        </div>
                        ชื่อ-นามสกุล:
                        <input type="text" name="cus_name" class = "form-control " required placeholder="ชื่อ-นามสกุล"><br>
                        ที่อยู่จัดส่งสินค้า:
                        <textarea class="form-control " required placeholder="ที่อยู่" name = "cus_add" rows="3"></textarea><br>
                        เบอร์โทร:
                        <input type="number" name="cus_tel" class = "form-control " required placeholder="เบอร์โทร"><br>
                        <br><br><br>
                    </div>
                </div>
           </div>
       </form>
   </div>
</body>
</html>
