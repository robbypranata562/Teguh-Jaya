<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$pelanggan = $_GET['pelanggan'];
$cek="SELECT
b.itemId,
c.NamaBarang,
b.UnitPrice,
c.SatuanBesar,
c.SatuanKecil,
b.Konversi
FROM
deliveryorder AS a
LEFT JOIN deliveryorderdetail AS b ON a.Id = b.DeliveryId
LEFT JOIN item AS c ON b.ItemId = c.id
WHERE
a.Customer = ".$pelanggan."";
// print_r($cek);
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
 {
        $data[] = array(
        	"id"=>$row['itemId'],
            "label"=>$row['NamaBarang'],
            "satuanbesar"=>$row['SatuanBesar'],
            "satuankecil"=>$row['SatuanKecil'],
            "unitprice" => $row['UnitPrice'],
            "konversi" => $row['Konversi']
			);
    }
    

    //return json data
    echo json_encode($data);
?>