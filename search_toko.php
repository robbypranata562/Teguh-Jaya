<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT * FROM stok_toko where stok_toko.nama_toko LIKE '%".$searchTerm."%'";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) {
        $data[] = array(
        	"id"=>$row['id_toko'],
        	"label"=>$row['nama_toko'],
			"atas"=>$row['harga_atas_toko']);
    }
    

    //return json data
    echo json_encode($data);
?>