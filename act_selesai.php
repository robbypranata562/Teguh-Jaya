<?php
include "koneksi.php";
		$id_pelanggan=$_GET['id_pel'];
		$idBarangTabel = $GET['id_barangtabel'];
		$jumkertabel = $_GET['jumkertabel'];


		$sql="SELECT id_barangtoko,jumlah_keranjang from keranjang where id_pelanggan='$id_pelanggan'";
		$exe=mysqli_query($koneksi,$sql);
		$count = mysqli_num_rows($exe);
		while($data1=mysqli_fetch_array($exe)){
			$id_barangtoko[]=$data1['id_barangtoko'];
			$jum_keranjang[]=$data1['jumlah_keranjang'];

			// var_dump($id_barangtoko);
		}
		
		for($i=0; $i < $count; $i++){
			$sqltoko="SELECT jumlah_toko from stok_toko where id_toko IN('$id_barangtoko[$i]')";
		$exetoko=mysqli_query($koneksi,$sqltoko);
		$counttoko = mysqli_num_rows($exetoko);
		while($data3=mysqli_fetch_array($exetoko)){
			$jum_toko[]=$data3['jumlah_toko'];
		}
			// var_dump($sqltoko);

			$back_stok[$i]= $jum_toko[$i] - $jum_keranjang[$i];
			$sql_up_toko= "UPDATE stok_toko set jumlah_toko='$back_stok[$i]' where id_toko='$id_barangtoko[$i]'";
		$exe_upp=mysqli_query($koneksi,$sql_up_toko);
	
		if($exe_upp){
			
			$del=" delete from keranjang where id_pelanggan='$id_pelanggan'";
			$exe_del=mysqli_query($koneksi,$del);
		
		// var_dump($sqltoko);
		
		
		}
	}
			// $del=" delete from keranjang where id_pelanggan='$id_pelanggan'";
			// $exe_del=mysqli_query($koneksi,$del);

			header("location:penjualan3.php");
		
		?>