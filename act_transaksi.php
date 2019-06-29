<?php
// if(isset($POST['jumlah'])){
// 	$id_pel=$_POST['id_pelanggan'];
// 	var_dump($id_pel);
// $jum_bayar=$_POST['jumlah'];
// $kembali = $jum_bayar - $total;
// $sql_trans="INSERT INTO transaksi VALUES('','$id_pel','$total','$jum_bayar','$kembali',NOW())";
// $exe_trans=mysqli_query($koneksi,$sql_trans);
//  if($exe_trans){
// 	 echo"sukses";
	 
//  }else{
// 	 echo "gagal";
//  }
// }

include 'koneksi.php';

if (isset($_POST['btnBayar'])) {
            $id_pelanggan = $_POST['id_pelanggan'];
            $jum_bayar=$_POST['jum_bayar'];
            $total = $_POST['total'];
             $kembali = $jum_bayar - $total;
         $sql_trans="INSERT INTO transaksi VALUES(NULL,'$id_pelanggan','$total','$jum_bayar','$kembali',NOW())";
$exe_trans=mysqli_query($koneksi,$sql_trans);

header("location:detail_pembelian.php");
          
           } 
		   
		   
		   ?>