 <?php
 include"koneksi.php";
        //error_reporting(0);
		
          $id =$_POST['getID'];
		   $id_pel=$_POST['idd_pelanggan'];
          $hrg=$_POST['hrg_atas'];
                
         $sid= $_POST['sesion'];
         //di cek dulu apakah barang yang di beli sudah ada di tabel keranjang
//$sql ="SELECT id_barangtoko FROM keranjang WHERE id_barangtoko='$id' AND id_sesion='$sid'";
//$exe=mysqli_query($koneksi,$sql);
  // $ketemu=mysqli_num_rows($exe);
    //if ($ketemu==0){
    
        // kalau barang belum ada, maka di jalankan perintah insert
       $sql_0="INSERT INTO keranjang VALUES (NULL,'$id','$id_pel','1','$hrg','$sid',NOW())";
     $exe_0=mysqli_query($koneksi,$sql_0);
    //} else {
        //  kalau barang ada, maka di jalankan perintah update
      //sql_0u="UPDATE keranjang
       //       SET jumlah_keranjang = jumlah_keranjang WHERE id_sesion ='$sid' AND id_barangtoko='$id'";
        //$exe_0u=mysqli_query($koneksi,$sql_0u) ;      
    //}   
   // header('Location:penjualan.php');
   
                
        
                
              ?>