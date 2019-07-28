<?php 
include "koneksi.php";


$iTotal = 0;

$cek_count="SELECT
count(*) as CountRecords
FROM
item AS a
LEFT JOIN receivingdetail AS b ON a.id = b.Id";
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
a.UmurBarangNormal,
a.UmurBarangMaksimal,
case when b.CreatedDate is NULL
THEN
DATEDIFF(date(NOW()),date(a.TanggalMasuk))
ELSE
DATEDIFF(date(NOW()),date(b.CreatedDate))
end as UmurBarang
FROM
item AS a
LEFT JOIN receivingdetail AS b ON a.id = b.Id";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        
        $data = array
            (
                $row['NamaBarang'],
                $row['UmurBarangNormal'],
                $row['UmurBarangMaksimal'],
                $row['UmurBarang']
            );
            $output['aaData'][] = $data;
    }

    echo json_encode($output);
?>