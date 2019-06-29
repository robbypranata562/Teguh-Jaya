<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sid=session_id();
$sql="SELECT id_barangtoko from return_barang where id_return='$id'";
		$exe=mysqli_query($koneksi,$sql);
		while($data1=mysqli_fetch_array($exe)){
			$id_barangtoko=$data1['id_barangtoko'];
		}
		
		$sql="SELECT jumlah_barang from return_barang where id_return='$id'";
		$exe=mysqli_query($koneksi,$sql);
		while($data2=mysqli_fetch_array($exe)){
			$jum_keranjang=$data2['jumlah_barang'];
		}

		$sql="SELECT jumlah_toko from stok_toko where id_toko='$id_barangtoko'";
		$exe=mysqli_query($koneksi,$sql);
		while($data3=mysqli_fetch_array($exe)){
			$jum_toko=$data3['jumlah_toko'];
		}
		$back_stok= $jum_toko + $jum_keranjang;
		$sql_up_toko= "UPDATE stok_toko set jumlah_toko='$back_stok' where id_toko='$id_barangtoko'";
		$exe_upp=mysqli_query($koneksi,$sql_up_toko);
		if($exe_upp){
			
			$sql="delete from return_barang where id_return='$id'";
$exe=mysqli_query($koneksi,$sql);
		}

header("location:return_barang.php");

?>