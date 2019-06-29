<?php
	include "koneksi.php";
	$id_pelanggan= $_GET['id_pel'];
	
	$del=" delete from keranjang where id_pelanggan='$id_pelanggan'";
			$exe_del=mysqli_query($koneksi,$del);

			header("location:penjualan3.php");
			?>