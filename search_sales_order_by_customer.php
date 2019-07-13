<?php 
include "koneksi.php";
$customer_id = $_POST['customer_id'];
$cek="SELECT
a.Id,
a.`Code`,
a.Pembayaran,
Date(a.TanggalPembayaran) as TanggalPembayaran
FROM
salesorder AS a
WHERE
1=1
and a.Customer = ".$customer_id."
and a.`Status` = 1";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
        	"Id"=>$row['Id'],
            "Code"=>$row['Code'],
            "Pembayaran"=>$row['Pembayaran'],
            "TanggalPembayaran"=>$row['TanggalPembayaran'],
			);
    }
    echo json_encode($data);
?>