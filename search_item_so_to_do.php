<?php 
include "koneksi.php";
$SalesOrderId = $_POST['id'] == "" ? "-1" : $_POST['id'] ;
$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
salesorderdetail AS a
LEFT JOIN item AS b ON a.ItemId = b.id
where 
a.SalesOrderId = ".$SalesOrderId."
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
	a.Qty AS SaleQty,
	a.Konversi,
	b.JumlahSatuanBesar,
	b.SatuanBesar,
	b.JumlahSatuanKecil,
	b.SatuanKecil,
	b.HargaAtas,
	b.HargaBawah,
	b.Modal AS HargaModal,
	b.HargaDefault,
	case when (
		SELECT
			bb.UnitPrice
		FROM
			deliveryorderdetail bb
		WHERE
			bb.ItemId = a.ItemId
		ORDER BY
			dibuat DESC
		LIMIT 1
	) is null then b.HargaDefault else (
		SELECT
			bb.UnitPrice
		FROM
			deliveryorderdetail bb
		WHERE
			bb.ItemId = a.ItemId
		ORDER BY
			dibuat DESC
		LIMIT 1
	) end  AS UnitPrice,
	0 AS TotalPrice
        FROM
        salesorderdetail AS a
        LEFT JOIN item AS b ON a.ItemId = b.id
        WHERE
        a.SalesOrderId = ".$SalesOrderId."
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
                $row['SaleQty'],
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
}
else
{
    $data = array();

}
echo json_encode($output);
?>