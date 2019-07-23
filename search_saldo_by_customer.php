<?php 
include "koneksi.php";
$customer_id = $_POST['customer_id'];
$cek="SELECT
a.Saldo
FROM
Pelanggan AS a
WHERE
1=1
and a.id_pelanggan = ".$customer_id."";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
        	"Saldo"=>$row['Saldo']
			);
    }
    echo json_encode($data);
?>