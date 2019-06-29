<?php
include 'koneksi.php';
		$id_pel=$_POST['id_pelanggan'];
		$total=$_POST['sisa'];
		$sql_sal="SELECT saldo from pelanggan  where id_pelanggan='$id_pel'";
		$exe_sal=mysqli_query($koneksi,$sql_sal);
		while ($data = mysqli_fetch_assoc($exe_sal)) {
			$saldoSekarang = $data['saldo'];
		}
		$totalSemua = $saldoSekarang+$total;
		$sql_up="UPDATE pelanggan set saldo='$totalSemua' where id_pelanggan='$id_pel'";
		$exe_up=mysqli_query($koneksi,$sql_up);
			if ($exe_up ==true) {
				echo "Saldo berhasil ditambahkan";
			}else{
				echo "gagal";
			}
 ?>