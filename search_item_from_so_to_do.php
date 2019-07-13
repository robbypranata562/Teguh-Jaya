<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$salesorderid = $_GET['soid'];
$cek="SELECT
a.ItemId,
b.NamaBarang,
a.Qty as orderqty,
0 as receivingqty,
a.Konversi,
a.Satuan,
b.JumlahSatuanBesar,
b.JumlahSatuanKecil,
b.Modal
FROM
salesorderdetail a
LEFT JOIN item b  on a.ItemId = b.id
WHERE
1=1
AND b.NamaBarang like '%".$searchTerm."%'
AND a.SalesOrderId = ".$salesorderid."";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
 {
        $data[] = array(
        	"Id"=>$row['ItemId'],
            "label"=>$row['NamaBarang'],
            "orderqty"=>$row['orderqty'],
            "receivingqty"=>$row['receivingqty'],
            "Konversi"=>$row['Konversi'],
            "Satuan" => $row['Satuan'],
            "JumlahSatuanBesar"=>$row['JumlahSatuanBesar'],
            "JumlahSatuanKecil" => $row['JumlahSatuanKecil'],
            "Modal" => $row['Modal']
			);
    }
    echo json_encode($data);
?>