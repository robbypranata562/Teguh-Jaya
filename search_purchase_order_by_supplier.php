<?php 
include "koneksi.php";
$supplier_id = $_POST['supplier_id'];
$cek="SELECT
a.Id,
a.`Code`
FROM
purchaseorder AS a
WHERE
1=1
and a.Supplier = ".$supplier_id."
and a.`Status` = 1";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
    {
        $data[] = array(
        	"Id"=>$row['Id'],
            "Code"=>$row['Code']
			);
    }
    echo json_encode($data);
?>