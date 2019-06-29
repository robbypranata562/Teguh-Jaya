<?php
	include "koneksi.php";
	if(isset($_POST['btnSimpan'])){
		$id_pel=$_POST['id_pelanggan'];
		$total=$_POST['total'];
		$idsesion = $_POST['idsesion'];
		$saldoSekarang= '0';
		$jumSimpan = $_POST['jum_simpan'];
		
		
		
		$sql_sal="SELECT saldo from pelanggan  where id_pelanggan='$id_pel'";
		$exe_sal=mysqli_query($koneksi,$sql_sal);
		while ($data = mysqli_fetch_assoc($exe_sal)) {
			$saldoSekarang = $data['saldo'];
		}
	

		if ($total=='0') {
				$totalSemua = $jumSimpan+$saldoSekarang;
		}else{
			$totalSemua = $total+$saldoSekarang;
		}
		$sql_up="UPDATE pelanggan set saldo='$totalSemua' where id_pelanggan='$id_pel'";
		$exe_up=mysqli_query($koneksi,$sql_up);
			$sql="delete from return_barang where id_sesion='$idsesion'";
		$exe=mysqli_query($koneksi,$sql);
		header('location:return_barang.php');
	}
	// else if (isset($_POST['simpanUangDetPembelian'])) {
	// 	$id_pel=$_POST['id_pelanggan'];
	// 	$total=$_POST['sisa'];

	// 	$sql_sal="SELECT saldo from pelanggan  where id_pelanggan='$id_pel'";
	// 	$exe_sal=mysqli_query($koneksi,$sql_sal);
	// 	while ($data = mysqli_fetch_assoc($exe_sal)) {
	// 		$saldoSekarang = $data['saldo'];
	// 	}
	// 	$totalSemua = $total+$saldoSekarang;
	// 	$sql_up="UPDATE pelanggan set saldo='$totalSemua' where id_pelanggan='$id_pel'";
	// 	$exe_up=mysqli_query($koneksi,$sql_up);
	// }
?>