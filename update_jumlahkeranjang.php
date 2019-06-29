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
                      $cek="UPDATE keranjang set jumlah_keranjang= '$jumlah',sub_total ='$jumlahSend',sub_totaldiskon ='$jumlahSend' 
                  WHERE id_keranjang = '".$id."'";

               $k=mysqli_query($koneksi,$cek);
               if ($k == true) {
                # code...
                 
                //  $sql_ub="UPDATE stok_toko set jumlah_toko=$jum_tot where id_toko=$idtk";
                // $exe_ub=mysqli_query($koneksi,$sql_ub);
                  echo "Update Sukses " . $jumlah;
               }else{
                   echo "Update gagal";
               }
                  }
               

         
         ?>