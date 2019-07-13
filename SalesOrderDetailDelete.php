<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from SalesOrderDetail where Id ='$id'";
$exe=mysqli_query($koneksi,$sql);
if($koneksi->query($sql) === TRUE)
{
    header("location:SalesOrderMainList.php");
}
?>