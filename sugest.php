<?php
include "koneksi.php";
$search = strtolower($_GET["q"]);
if (!$search) return;
$sql = "select DISTINCT cari as cari from barang where nama LIKE '%$cari%' limit 5";
$query = mysqli_query($koneksi,$sql);
while($row = mysqli_fetch_array($query)) {
	$name = $row['nama'];
	echo "$name\n";
}
?>