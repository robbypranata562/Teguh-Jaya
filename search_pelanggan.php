<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT * FROM pelanggan where nama_pelanggan LIKE '%".$searchTerm."%'";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_array()) {
        $data[] = array(
        	"id"=>$row['id_pelanggan'],
        	"label"=>$row['nama_pelanggan'],
			"hutang"=>$row['hutang']);
    }
    

    //return json data
    echo json_encode($data);
?>