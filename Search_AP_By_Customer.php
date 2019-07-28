<?php
include "koneksi.php";
$customer_id = $_POST['customer_id'];
$cek="SELECT
format(sum(aa.Hutang) - sum(aa.pembayaran),2) as Piutang
from
(
SELECT
	a.nama_pelanggan,
	a.id_pelanggan,
	IFNULL(b.total, 0) AS Hutang,
	0 as pembayaran
FROM
	pelanggan AS a
LEFT JOIN ap AS b ON a.id_pelanggan = b.customer_id
union ALL
SELECT
	a.nama_pelanggan,
	a.id_pelanggan,
	0 as Hutang,
	IFNULL(b.total, 0) AS pembayaran
FROM
	pelanggan AS a
LEFT JOIN appayment AS b ON a.id_pelanggan = b.customer_id
) aa
where aa.id_pelanggan = ".$customer_id."
";
$k=mysqli_query($koneksi,$cek);
$sisaHutang = "";
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
            "Piutang"=>$row['Piutang']
            );
    }
    echo json_encode($data);
?>
