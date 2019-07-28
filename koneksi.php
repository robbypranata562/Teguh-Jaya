<?php
$db_host = "localhost";
$db_user = "teguhjaya";
$db_pass = "teguhjaya123";
$db_name = "grosir";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>
