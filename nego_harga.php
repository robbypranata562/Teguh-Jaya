 <?php
 include 'koneksi.php';

				$idk=$_POST['id_keranjang'];
                $idtoko=$_POST['id_toko'];
                
                 $harga = $_POST['harga'];
                 $jumlah_keranjang = $_POST['jumlah_ker'];
                  
          
			//echo "oke";
            $sql_cekharga="SELECT * FROM  stok_toko where id_toko='$idtoko'";
            $connect=mysqli_query($koneksi,$sql_cekharga);
            while($z=mysqli_fetch_assoc($connect)){

            $hrgBawah=$z['harga_bawah_toko'];
            if ($harga <$hrgBawah) {
                echo "Maaf Tidak bisa" ;
            }else{
                   $jumlahSend  = $harga * $jumlah_keranjang;

                $sqlu="UPDATE keranjang set harga_akhir='$harga',sub_total ='$jumlahSend',sub_totaldiskon ='$jumlahSend'  where id_keranjang='".$idk."'";
                $exeu=mysqli_query($koneksi,$sqlu);
                echo "Sukses";
            }
        }
          

     //           if ($ == true) {
     //           	# code...
     //           	  echo "Thank you " . $jumlah;
     //           }else{
					// echo "Update gagal";
     //           }
           

         
         ?>