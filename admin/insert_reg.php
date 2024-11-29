<?php
include 'condb.php';
$name = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$password = $_POST['password'];

$password = hash('sha512',$password );

$sql = "INSERT INTO tb_member(์name,lastname,telephone,username,password) 
VALUES('$name','$lastname','$phone','$username','$password')";
$result = mysqli_query($conn,$sql);
if($result){
    echo"<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo"<script> window.location='register.html'; </script>";
}else{
    echo"Error:" . $sql . "<br>" . mysqli_error($conn);
    echo"<script> alert('เกิดข้อผิดพลาด'); </script>";
}
mysqli_close($conn);
?>