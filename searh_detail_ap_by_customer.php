<?php 
include "koneksi.php";
$CustomerId = $_POST['id'];
$iTotal = 0;
$cek_count="SELECT
Count(*) as Count
FROM
pelanggan AS a
LEFT JOIN ap AS b ON a.id_pelanggan = b.customer_id
LEFT JOIN deliveryorder AS c ON b.delivery_id = c.Id
WHERE
a.id_pelanggan = ".$CustomerId."";
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
a.nama_pelanggan,
c.`Code`,
Date(c.Date) Date,
Format(c.Total, 2) AS TotalBelanja,
Format(IFNULL(b.total, 0), 2) AS Hutang
FROM
pelanggan AS a
LEFT JOIN ap AS b ON a.id_pelanggan = b.customer_id
LEFT JOIN deliveryorder AS c ON b.delivery_id = c.Id
WHERE
a.id_pelanggan = ".$CustomerId."";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        
        $data = array
            (

                $row['Code'],
                $row['Date'],
                $row['nama_pelanggan'],
                $row['TotalBelanja'],
                $row['Hutang'],
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>