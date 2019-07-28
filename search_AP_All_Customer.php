<?php
include "koneksi.php";
$iTotal = 0;
$cek_count="SELECT
Count(*) as Count
FROM
pelanggan AS a
LEFT JOIN ap AS b ON a.id_pelanggan = b.customer_id
group BY
a.id_pelanggan";
$k=mysqli_query($koneksi,$cek_count);
 while ($row = $k->fetch_assoc())
    {
        $iTotal = $row['Count'];
    }
$output = array(
    "sEcho" => intval("Test"),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iTotal,
    "aaData" => array()
);



$cek="SELECT
aa.nama_pelanggan,
aa.id_pelanggan,
format(sum(aa.Hutang) - sum(aa.pembayaran),2) as Hutang
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
group by aa.id_pelanggan";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc())
    {

        $data = array
            (
                $row['nama_pelanggan'],
                $row['id_pelanggan'],
                $row['Hutang']
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>
