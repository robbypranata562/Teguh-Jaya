<?php 
include 'koneksi.php';
$id=$_GET['id_his'];
$sql="delete from his_login where id_login='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:karyawan_hislogin.php");

?>