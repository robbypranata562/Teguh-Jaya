<?php
include 'koneksi.php';
	session_start();
				if(!isset($_SESSION['uname'])){
					echo"<script>window.location.assign('index.php')</script>";
				}
?>
<!DOCTYPE html>

<html>
<head>
 
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Terjual</th>
                  <th>Harga</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
         $q = intval($_GET['q']);

$sql="SELECT * FROM barang_terjual,stok_toko,CONCAT(YEAR(barang_terjual.tanggal),'-',MONTH(barang_terjual.tanggal))  AS tahun_bulan WHERE tahun_bulan = '".$q."' and barang_terjual.id_barangtoko=stok_toko.id_toko";
$result = mysqli_query($koneksi,$sql);

while($row = mysqli_fetch_array($result)) {
                 $hrg=$row['jual_hargaakhir'] * $row['jual_jumlah'];
          
				?>
                <tr>
                  <td><?php echo $row['tanggal'];?></td>
                  <td><?php echo $row['nama_toko'];?></td>
                   <td><?php echo $row['jual_jumlah'];?></td>
                  <td><?php echo $q;?></td>
                
                  
				
				  <td>
				 <a class="btn btn-primary" href="detail_history.php?id=<?php echo $data['id_transaksi'];?>"> <span class="glyphicon glyphicon-file"></span> Lihat Detail</a>
				 
				  
				  </td>
                </tr>
					<?php } ?>
                
                
              </table>



</body>
</html>