<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$purchaseorderid = $_GET['poid'];
$cek="SELECT
a.ItemId,
b.NamaBarang,
a.Qty as orderqty,
0 as receivingqty,
a.Konversi,
a.UnitPrice,
a.Satuan
FROM
purchaseorderdetail a
LEFT JOIN item b  on a.ItemId = b.id
WHERE
1=1
AND b.NamaBarang like '%".$searchTerm."%'
AND a.PurchaseOrderId = ".$purchaseorderid."";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
 {
        $data[] = array(
        	"Id"=>$row['ItemId'],
            "label"=>$row['NamaBarang'],
            "orderqty"=>$row['orderqty'],
            "receivingqty"=>$row['receivingqty'],
            "Konversi"=>$row['Konversi'],
            "UnitPrice" => $row['UnitPrice'],
            "Satuan" => $row['Satuan']
			);
    }
    echo json_encode($data);
?>