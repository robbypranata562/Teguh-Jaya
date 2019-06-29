<?php 
include 'koneksi.php';
if (isset($_POST['simpan'])){
$nama=$_POST['nama'];
$rek=$_POST['alamat'];
//$hutang=$_POST['hutang'];
$hp=$_POST['hp'];


$sql="insert into pelanggan values(NULL,'$nama','0','$rek','$hp',NOW(),'0')";

$exe=mysqli_query($koneksi,$sql);
if($exe){
	 $last_id = mysqli_insert_id($koneksi);

							 
// 							  echo "<SCRIPT type='text/javascript'> //not showing me this
//         alert('TIDAK BISA');
  
//     </SCRIPT>";
// header("location:penjualan3.php?id_pelanggan=$last_id");
	 	 echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Pelanggan baru berhasil ditambahkan');
         window.location.replace(\"penjualan3.php?id_pelanggan=$last_id\");
    </SCRIPT>";
							
						}else{
							 echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Pelanggan baru gagal ditambahkan');
         window.location.replace(\"penjualan3.php\");
    </SCRIPT>";
							
						}

}
 ?>