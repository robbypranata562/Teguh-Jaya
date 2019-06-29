<?php 
include 'koneksi.php';
$id=$_GET['id_akun'];
$sql="delete from admin where id_admin='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:karyawan_tampiladmin.php");

?>