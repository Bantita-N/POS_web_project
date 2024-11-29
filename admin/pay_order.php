<?php
include 'condb.php';
$id = $_GET['id'];

$sql = "UPDATE tb_order SET ordder_status = 2 WHERE orderID='$id' ";
$result = mysqli_query($conn,$sql);
if($result){
    echo "<script>window.location='fb_order.php';</script>";

}else{
    echo "<script>alert('ไม่สามารถลบข้อมูลได้');</script>";

}

mysqli_close($conn);

?>