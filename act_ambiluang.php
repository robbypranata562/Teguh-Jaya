<?php
	include "koneksi.php";
	if(isset($_POST['btnAmbil'])){
		$id_pel=$_POST['id_pelanggan'];
		$total=$_POST['total'];
		$id_return=$_POST['idreturn'];
		$jum = $_POST['jum_bayar'];
		$hutang = $_POST['hutang'];
		$idsesion = $_POST['idsesion'];

if ($jum> $total) {
	 echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('TIDAK BISA');
         window.location.replace(\"return_barang.php\");
    </SCRIPT>";
    
}else{

$hutangKirim = $hutang-($total-$jum);
if ($hutang!=0) {

			$sql_up="UPDATE pelanggan set hutang='$hutangKirim' where id_pelanggan='$id_pel'";
		$exe_up=mysqli_query($koneksi,$sql_up);
		}else{
			$sql_up="UPDATE pelanggan set saldo='$hutangKirim' where id_pelanggan='$id_pel'";
		$exe_up=mysqli_query($koneksi,$sql_up);
		}
		

		$sql="SELECT id_barangtoko,jumlah_barang from return_barang where id_sesion='$idsesion'";
		$exe=mysqli_query($koneksi,$sql);
		$count = mysqli_num_rows($exe);
		while($data1=mysqli_fetch_array($exe)){
			$id_barangtoko[]=$data1['id_barangtoko'];
			$jum_keranjang[]=$data1['jumlah_barang'];

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

			$back_stok[$i]= $jum_toko[$i] + $jum_keranjang[$i];
			$sql_up_toko= "UPDATE stok_toko set jumlah_toko='$back_stok[$i]' where id_toko='$id_barangtoko[$i]'";
		$exe_upp=mysqli_query($koneksi,$sql_up_toko);
	
		if($exe_upp){
			
			$sql="delete from return_barang where id_sesion='$idsesion'";
$exe=mysqli_query($koneksi,$sql);
		
		
		// var_dump($sqltoko);
		
		
		}
		} 
		header('location:return_barang.php');
}

		
		
		
		
	}
?>