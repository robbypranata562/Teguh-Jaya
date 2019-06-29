<?php 
include 'koneksi.php';
$id=$_GET['id_karyawan'];
$sql="delete from karyawan where id='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:karyawan_tampil.php");

?>