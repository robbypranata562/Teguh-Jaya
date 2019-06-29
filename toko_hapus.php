<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from stok_toko where id_toko='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:toko_tampil.php");

?>