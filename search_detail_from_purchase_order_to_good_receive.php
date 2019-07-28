<?php 
include "koneksi.php";
$purchase_order_id = $_POST['purchase_order_id'];
$cek="SELECT
a.Id,
a.`Code`,
a.Pembayaran,
Date(a.TanggalPembayaran) as TanggalPembayaran
FROM
purchaseorder AS a
WHERE
1=1
and a.Id = ".$purchase_order_id."";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        $data[] = array(
        "Pembayaran"=>$row['Pembayaran'],
        "TanggalPembayaran"=>$row['TanggalPembayaran'],
        );
    }
}
    echo json_encode($data);
?>