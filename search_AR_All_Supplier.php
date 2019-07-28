<?php
include "koneksi.php";
$iTotal = 0;
$cek_count="SELECT
Count(*) as Count
FROM
suplier AS a
LEFT JOIN ar AS b ON a.id_suplier = b.supplier_id
GROUP BY
a.id_suplier";
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
ax.nama_suplier,
format(sum(ax.hutang) - sum(ax.pembayaran),2) as SisaHutang
FROM
(
SELECT
	a.id_suplier,
	b.date,
	a.nama_suplier,
	sum(IFNULL(b.total, 0)) AS hutang,
	0 as pembayaran
FROM
	suplier AS a
LEFT JOIN ar AS b ON a.id_suplier = b.supplier_id

union ALL
SELECT
	a.id_suplier,
	b.date,
	a.nama_suplier,
	0 as hutang,
	sum(IFNULL(b.total, 0)) AS pembayaran
FROM
	suplier AS a
LEFT JOIN arpayment AS b ON a.id_suplier = b.supplier_id
) ax
LEFT join suplier bx on ax.id_suplier = bx.id_suplier

";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc())
    {

        $data = array
            (
                $row['nama_suplier'],
                $row['SisaHutang']
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>
