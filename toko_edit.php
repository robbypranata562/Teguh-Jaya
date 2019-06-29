<?php include "header.php";?>
 

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small>admin</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Barang</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		<?php 
//include 'koneksi.php';
if (isset($_POST['ubah'])){
$id=$_POST['id'];
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$suplier=$_POST['suplier'];
$modal=$_POST['modal'];
$harga_atas=$_POST['harga_atas'];
$harga_bawah=$_POST['harga_bawah'];
$jumlah=$_POST['jumlah'];

$sql="update stok_toko set jenis_toko='$jenis', suplier_toko='$suplier', modal_toko='$modal', harga_atas_toko='$harga_atas', harga_bawah_toko='$harga_bawah', jumlah_toko='$jumlah' where id_toko='$id'";
$exe=mysqli_query($koneksi,$sql);

if($exe){
							echo ("<script>location.href='toko_tampil.php';</script>");
							
						} else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        Data gagal diubah
                                    </div>";
						}
//header("location:tampil_barang.php");
}
?>

		<?php
			$id_brg=$_GET['id'];
			$sql="SELECT * FROM stok_toko, barang where stok_toko.id_toko='$id_brg' and barang.id_gudang=stok_toko.id_gudang";
			$exe=mysqli_query($koneksi,$sql);
			while ($data=mysqli_fetch_array($exe)){
		?>
		
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  <div class="form-group">
                 
                  <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id_toko'] ?>" >
                </div>
                <div class="form-group">
                  <label>Nama Barang</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['nama'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" class="form-control" id="exampleInputEmail1"value="<?php echo $data['jenis_toko'];?>"
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" class="form-control" id="exampleInputEmail1" value="<?php echo $data['suplier_toko'];?>"
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="modal" class="form-control" id="exampleInputEmail1"value="<?php echo $data['modal_toko'];?>"">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Harga Atas</label>
                  <input type="text" name="harga_atas"class="form-control" id="exampleInputEmail1" value="<?php echo $data['harga_atas_toko'];?>"">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">harga Bawah</label>
                  <input type="text" name="harga_bawah" class="form-control" id="exampleInputEmail1" value="<?php echo $data['harga_bawah_toko'];?>"">
                </div>
				<div class="form-group">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" value="<?php echo $data['jumlah_toko'];?>"">
                </div>
                
                
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="ubah" class="btn btn-primary" value="Simpan">
              </div>
            </form>
			<?php } ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>
 
 