<?php
	include "koneksi.php";
	if(isset($_POST['btnHutang'])){
		$id_pel=$_POST['id_pelanggan'];
		$hutang=$_POST['jum_hutang'];
		
		$sql="SELECT hutang from pelanggan where id_pelanggan='$id_pel'";
		$exe=mysqli_query($koneksi,$sql);
		while($data=mysqli_fetch_array($exe)){
			$jum_hutang=$data['hutang'];
		}
		$byr_hutang= $jum_hutang - $hutang;
		if($byr_hutang < 0){
			$byr_hutang=0;
		}
		$sql_up="UPDATE pelanggan set hutang='$byr_hutang' where id_pelanggan='$id_pel'";
		$exe_up=mysqli_query($koneksi,$sql_up);
		header('location:penjualan3.php');
	}
?>