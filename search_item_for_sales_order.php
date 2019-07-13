<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT * FROM item a where a.NamaBarang LIKE '%".$searchTerm."%' and JumlahSatuanKecil <> 0";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
 {
        $data[] = array(
        	"id"=>$row['id'],
            "label"=>$row['NamaBarang'],
            "JumlahSatuanBesar"=>$row['JumlahSatuanBesar'],
            "JumlahSatuanKecil"=>$row['JumlahSatuanKecil'],
            "satuanbesar"=>$row['SatuanBesar'],
            "satuankonversi"=>$row['SatuanKonversi']
			);
    }
    

    //return json data
    echo json_encode($data);
?>