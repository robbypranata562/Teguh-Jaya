<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from SalesOrder where Id ='$id'";
$exe=mysqli_query($koneksi,$sql);
if($koneksi->query($sql) === TRUE)
{
    $sql2="delete from SalesOrderDetail where SalesOrderId ='$id'";
    //$exe2=mysqli_query($koneksi,$sql2);
    if($koneksi->query($sql2) === TRUE)
    {
        header("location:SalesOrderMainList.php");
    }
}
?>