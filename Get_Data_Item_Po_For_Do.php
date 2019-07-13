<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT
a.ItemId,
b.NamaBarang,
a.Satuan,
a.UnitPrice,
a.Qty,
0 as receivingqty,
a.Konversi,
(0 * a.UnitPrice) as Total
FROM
purchaseorderdetail AS a
INNER JOIN item AS b ON a.ItemId = b.id
WHERE
a.PurchaseOrderId = '".$id."'";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_array()) {
        $data[] = array(
        	"id"=>$row['id_pelanggan'],
        	"label"=>$row['nama_pelanggan'],
			"hutang"=>$row['hutang']);
    }
    

    //return json data
    echo json_encode($data);
?>