<?php
include "koneksi.php";
$supplier_id = $_POST['supplier_id'];
$cek="SELECT
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
GROUP BY a.id_suplier
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
GROUP BY a.id_suplier
) ax
where ax.id_suplier = ".$supplier_id."
";
$k=mysqli_query($koneksi,$cek);
$sisaHutang = "";
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
            "SisaHutang"=>$row['SisaHutang']
            );
    }

    echo json_encode($data);
?>
