<?php 
include 'koneksi.php';
$id=$_GET['id'];

			
			$sql="delete from keranjang where id_sesion='$id'";
$exe=mysqli_query($koneksi,$sql);
		

header("location:penjualan3.php");

?>