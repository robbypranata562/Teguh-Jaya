<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from pelanggan where id_pelanggan='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:pelanggan_tampil.php");

?>