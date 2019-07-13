<?php 
include 'koneksi.php';
$id=$_GET['id'];
$poid=$_GET['PurchaseOrderId'];
$sql="delete from PurchaseOrderDetail where Id ='$id'";
$exe=mysqli_query($koneksi,$sql);
if($koneksi->query($sql) === TRUE)
{
    $sql_update_total_PO = "select sum(a.TotalPrice) as TotalAmount from purchaseorderdetail a where a.PurchaseOrderId = '".$poid."'";
    //die($sql_update_total_PO);
    $exe = mysqli_query($koneksi,$sql_update_total_PO);
    while ($data=mysqli_fetch_array($exe))
    {
        $sql_update_po = "Update PurchaseOrder Set Total = '".$data['TotalAmount']."' where id = '".$poid."'";
        //$exe_purchase_order_main = mysqli_query($koneksi,$sql_update_po);
        if($koneksi->query($sql_update_po) === TRUE)
        {
            header("location:PurchaseOrderList.php");
        }
    }
    
}
?>