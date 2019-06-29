<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from barang where id_gudang='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:tampil_barang.php");

?>