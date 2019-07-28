<?php 
include "koneksi.php";
$startDate = $_POST['StartDate'];
$endDate = $_POST['EndDate'];


$iTotal = 0;

$cek_count="SELECT
Count(*) as CountRecords
FROM
item AS a
LEFT JOIN deliveryorderdetail AS b ON a.id = b.ItemId and date(b.Dibuat) BETWEEN date('".$startDate."') AND date('".$endDate."')";
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
a.NamaBarang,
case when a.satuanbesar = b.uom then
a.SatuanKonversi * ifnull(b.DeliveryQty,0) else ifnull(b.DeliveryQty,0) end TotalPenjualan
FROM
item AS a
LEFT JOIN deliveryorderdetail AS b ON a.id = b.ItemId and date(b.Dibuat) BETWEEN date('".$startDate."') AND date('".$endDate."')
where 1=1
order by 
TotalPenjualan desc";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        
        $data = array
            (
                $row['NamaBarang'],
                $row['TotalPenjualan']
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>