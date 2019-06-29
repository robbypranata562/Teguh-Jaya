<?php
              include "koneksi.php";
              if(isset($_POST['tambah'])){
                 $id =$_POST['getID'];
                 $cek="SELECT * FROM stok_toko, barang where barang.id_gudang=stok_toko.id_gudang and stok_toko.id_gudang = '$id'";
               $k=mysqli_query($koneksi,$cek);
                $data=mysqli_fetch_array($k);
     $nama=$data['nama'];
     $harga_atas = $data['harga_atas_toko'];
     $jumlah = 1;
     $totalHarga = $jumlah * $harga_atas;

    
  echo $nm;

                 
			  } 
              

             ?>