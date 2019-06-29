
<!DOCTYPE html>

<html>
<head>
 


</head>
<body>

<?php
$q = intval($_GET['q']);

include 'koneksi.php';

$sql="SELECT * FROM barang WHERE id_gudang = '".$q."'";
$result = mysqli_query($koneksi,$sql);

while($row = mysqli_fetch_array($result)) {
?>
<div class="form-group">
                  
                  <input type="hidden" name="nama" class="form-control" id="exampleInputEmail1" value="<?php echo $row['nama']?>">
                </div>
				<div class="form-group">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" placeholder="Stok yang ada di gudang  <?php echo $row['jumlah']?>">
                </div>
<div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" class="form-control" id="exampleInputEmail1" value="<?php echo $row['jenis']?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" class="form-control" id="exampleInputEmail1" value="<?php echo $row['suplier']?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="modal" class="form-control" id="exampleInputEmail1" value="<?php echo $row['modal']?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Harga Atas</label>
                  <input type="text" name="harga_atas"class="form-control" id="exampleInputEmail1" value="<?php echo $row['harga_atas']?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">harga Bawah</label>
                  <input type="text" name="harga_bawah" class="form-control" id="exampleInputEmail1" value="<?php echo $row['harga_bawah']?>">
                </div>
				
				


<?php

 }

?>



</body>

</html>