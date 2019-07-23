<?php 
include "koneksi.php";
$PurchaseOrderId = $_POST['id'] == "" ? "-1" : $_POST['id'];
$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
purchaseorderdetail AS a
LEFT JOIN item AS b ON a.ItemId = b.id
where 
a.PurchaseOrderId = ".$PurchaseOrderId."
";
$k=mysqli_query($koneksi,$cek_count);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        $iTotal = $row['Count'];
    }
}
$output = array(
    "sEcho" => intval("Test"),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iTotal,
    "aaData" => array()
);



$cek="SELECT
b.id,
b.NamaBarang,
a.Satuan,
a.Qty AS OrderQty,
a.Qty AS receivingQty,
a.Konversi,
b.JumlahSatuanBesar,
b.SatuanBesar,
b.JumlahSatuanKecil,
b.SatuanKecil,
b.HargaAtas,
b.HargaBawah,
b.modal as HargaModal,
b.HargaDefault as HargaDefault,
b.modal AS UnitPrice,
0 AS TotalPrice
FROM
purchaseorderdetail AS a
LEFT JOIN item AS b ON a.ItemId = b.id
where 
a.PurchaseOrderId = ".$PurchaseOrderId."
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        $data = array
            (

                $row['id'],
                $row['NamaBarang'],
                $row['Satuan'],
                $row['OrderQty'],
                $row['receivingQty'],
                $row['Konversi'],
                $row['JumlahSatuanBesar'],
                $row['SatuanBesar'],
                $row['JumlahSatuanKecil'],
                $row['SatuanKecil'],
                $row['HargaAtas'],
                $row['HargaBawah'],
                $row['HargaModal'],
                $row['HargaDefault'],
                $row['UnitPrice'],
                $row['TotalPrice']
            );
            $output['aaData'][] = $data;
    }
}else
{
    $data = array();

}

    echo json_encode($output);
?>