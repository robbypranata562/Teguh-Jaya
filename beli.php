<?php 
session_start();
include "koneksi.php";
$sid = session_id();
$id=$_GET['id'];
 
 $x="select * from stok_toko where id_toko='$id'";
    $y=mysqli_query($koneksi,$x);
    while($z=mysqli_fetch_array($y)){
      $hrg=$z['harga_atas_toko'];
    $jum=$z['jumlah_toko'];
    $jum_tot= $jum - 1;
    }
 
//di cek dulu apakah barang yang di beli sudah ada di tabel keranjang
$sql ="SELECT id_barangtoko FROM keranjang WHERE id_barangtoko='$id'";
$exe=mysqli_query($koneksi,$sql);
    $ketemu=mysqli_num_rows($exe);
    if (!$ketemu){
        // kalau barang belum ada, maka di jalankan perintah insert
      
       $sql_0="INSERT INTO keranjang VALUES (NULL,'$id','0','1','$hrg','$hrg','$hrg','0','$sid',NOW())";
     $exe_0=mysqli_query($koneksi,$sql_0);
   
   $sql_ub="UPDATE stok_toko set jumlah_toko=$jum_tot where id_toko=$id";
   $exe_ub=mysqli_query($koneksi,$sql_ub);
    } else {
        //  kalau barang ada, maka di jalankan perintah update
        $sql_0u="UPDATE keranjang
                SET jumlah_keranjang = jumlah_keranjang WHERE id_sesion ='$sid' AND id_barangtoko='$id'";
        $exe_0u=mysqli_query($koneksi,$sql_0u) ;      
    }   
   header('Location:penjualan3.php');
 
?>