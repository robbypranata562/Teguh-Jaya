<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from suplier where id_suplier='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:suplier_tampil.php");

?>