<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$suplier = $_GET['supplier'];
$cek="SELECT * FROM item a where a.NamaBarang LIKE '%".$searchTerm."%' and SupplierBarang = '".$suplier."'";
// print_r($cek);
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) {
        $data[] = array(
        	"id"=>$row['id'],
            "label"=>$row['NamaBarang'],
            "satuanbesar"=>$row['SatuanBesar'],
            "satuankonversi"=>$row['SatuanKonversi'],
            "modal"=>$row['Modal']
			);
    }
    

    //return json data
    echo json_encode($data);
?>