<?php 
include "koneksi.php";
$startDate = $_POST['StartDate'];
$endDate = $_POST['EndDate'];


$iTotal = 0;

$cek_count="SELECT
Count(*) as CountRecords
FROM
grosir.deliveryorder c
LEFT JOIN grosir.deliveryorderdetail AS a ON c.Id = a.DeliveryId
LEFT JOIN grosir.item AS b ON a.ItemId = b.id
LEFT JOIN grosir.pelanggan AS d ON c.Customer = d.id_pelanggan
WHERE
1=1
and
date(c.Date) BETWEEN date('".$startDate."') AND date('".$endDate."')";
$k=mysqli_query($koneksi,$cek_count);
 while ($row = $k->fetch_assoc()) 
    {
        $iTotal = $row['CountRecords'];
    }


$output = array(
    "sEcho" => intval("Test"),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iTotal,
    "aaData" => array()
);



$cek="SELECT
c.`Code`,
Date(c.Date) AS Date,
d.nama_pelanggan,
b.NamaBarang,
-- a.DeliveryQty,
CASE
WHEN a.UOM != b.SatuanKecil THEN
a.DeliveryQty * a.Konversi
ELSE
a.DeliveryQty
END Qty,
Format(b.Modal,2) AS `HargaModal`,
Format(a.UnitPrice,2) AS `HargaJual`,
CASE
WHEN a.UOM != b.SatuanKecil THEN
Format((a.DeliveryQty * a.Konversi) * b.Modal,2)
ELSE
Format(a.DeliveryQty * b.Modal,2)
END `TotalModal`,
CASE
WHEN a.UOM != b.SatuanKecil THEN
Format((a.DeliveryQty * a.Konversi) * a.UnitPrice,2)
ELSE
Format(a.DeliveryQty * a.UnitPrice,2)
END `TotalPendapatan`,
CASE
WHEN a.UOM != b.SatuanKecil THEN
Format((
    (a.DeliveryQty * a.Konversi) * a.UnitPrice
) - (
    (a.DeliveryQty * a.Konversi) * b.Modal
),2)
ELSE
Format((a.DeliveryQty * a.UnitPrice) - (a.DeliveryQty * b.Modal),2)
END `Bersih`
FROM
grosir.deliveryorder c
LEFT JOIN grosir.deliveryorderdetail AS a ON c.Id = a.DeliveryId
LEFT JOIN grosir.item AS b ON a.ItemId = b.id
LEFT JOIN grosir.pelanggan AS d ON c.Customer = d.id_pelanggan
WHERE
1=1
and
date(c.Date) BETWEEN date('".$startDate."') AND date('".$endDate."')";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        
        $data = array
            (
                $row['Code'],
                $row['Date'],
                $row['nama_pelanggan'],
                $row['NamaBarang'],
                $row['Qty'],
                $row['HargaModal'],
                $row['HargaJual'],
                $row['TotalModal'],
                $row['TotalPendapatan'],
                $row['Bersih']
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>