<?php
session_start();
include 'condb.php';
$cusName = $_POST['cus_name'];
$cusAddress = $_POST['cus_add'];
$cusTel = $_POST['cus_tel'];

$sql = "insert into tb_order(cus_name,address,telephone,total_price,ordder_status)
values('$cusName','$cusAddress','$cusTel','". $_SESSION["sum_price"]."','1')";
mysqli_query($conn,$sql);

$orderID = mysqli_insert_id($conn);
$_SESSION["order_id"] = $orderID;

for($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
    if (($_SESSION["strProductID"][$i]) != "") {
        
        $sql1 = "select * from product where pro_id ='".$_SESSION["strProductID"][$i]."' ";
        $result1=mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_array($result1);
        $price = $row1["price"];
        $total = $_SESSION["strQty"][$i] * $price;
    
        $sql2 = "insert into order_detail(orderID,pro_id,orderPrice,orderQty,Total)
        values('$orderID','".$_SESSION["strProductID"][$i]."','$price','".$_SESSION["strQty"][$i]."','$total ')";
        if(mysqli_query($conn,$sql2)){
            $sql3 = "update product set amount= amount - '". $_SESSION["strQty"][$i]."'
            where pro_id = '".$_SESSION["strProductID"][$i]."'";
            mysqli_query($conn,$sql3);
            //echo"<script> alert('บันทึกข้อมูลเรียบร้อย') </script>";
            echo "<script> window.location='print_order.php'; </script>";
        }


    }

}
mysqli_close($conn);
unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
unset($_SESSION["sum_price"]);
?>