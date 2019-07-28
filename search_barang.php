<?php
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT * FROM item a where a.NamaBarang LIKE '%".$searchTerm."%'";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc())
 {
        $data[] = array(
        	"id"=>$row['id'],
            "label"=>$row['NamaBarang'],
            "satuanbesar"=>$row['SatuanBesar'],
            "satuankonversi"=>$row['SatuanKonversi'],
            "satuankecil"=>$row['SatuanKecil'],
            "modal"=>$row['Modal']
			);
    }


    //return json data
    echo json_encode($data);
?>
