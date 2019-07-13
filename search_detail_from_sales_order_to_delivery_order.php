<?php 
include "koneksi.php";
$sales_order_id = $_POST['sales_order_id'];
$cek="SELECT
a.Id,
a.`Code`,
a.Pembayaran,
Date(a.TanggalPembayaran) as TanggalPembayaran
FROM
salesorder AS a
WHERE
1=1
and a.Id = ".$sales_order_id."";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
            "Pembayaran"=>$row['Pembayaran'],
            "TanggalPembayaran"=>$row['TanggalPembayaran'],
			);
    }
    echo json_encode($data);
?>