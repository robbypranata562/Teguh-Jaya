 <?php
 include 'koneksi.php';

    
                 $id =$_POST['id_keranjang'];
                 $jumlah = $_POST['jumlah_barang'];
                 $idtk =$_POST['id_toko'];
                 $hargaAkhir = $_POST['harga_akhir'];
                  $x="select * from stok_toko where id_toko='$idtk'";
                  $y=mysqli_query($koneksi,$x);
                  while($z=mysqli_fetch_array($y)){
                    $hrg=$z['harga_atas_toko'];
                  $jum=$z['jumlah_toko'];
                  $jum_tot= $jum -$jumlah ;
                  
                  }


              if ($jumlah >$jum) {
                    echo "Jumlah yang anda masukan tidak tersedia";
                  }else{
                    $jumlahSend  = $hargaAkhir * $jumlah;
                      $cek="UPDATE return_barang set jumlah_barang= '$jumlah'
                  WHERE id_return= '".$id."'";

               $k=mysqli_query($koneksi,$cek);
               if ($k == true) {
                # code...
                 
                 
                  echo "Update Sukses " . $jumlah;
               }else{
                   echo "Update gagal";
               }
                  }
               

         
         ?>