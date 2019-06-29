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
          <h3 class="box-title">Grosir</h3>

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
	
$idgudang=$_POST['idgudang'];
//$idtoko=$_POST['idtoko'];
$nama=$_POST['nama'];
$jumlah=$_POST['jumlah'];

$sql_t="SELECT * from barang where id_gudang='$idgudang'";
$exe_t=mysqli_query($koneksi,$sql_t);
$data_t=mysqli_fetch_array($exe_t);
$tt=$data_t['jumlah'];
$t=$tt + $jumlah;




$sql_g="update barang set jumlah='$t' where id_gudang='$idgudang'";
$exe_g=mysqli_query($koneksi,$sql_g);

//$sql="update stok_toko set jumlah_toko='$jumlah' where id_toko='$idtoko'";
//$exe=mysqli_query($koneksi,$sql_g);
//header("location:suplier_tampil.php");
if($exe_g){
							echo ("<script>location.href='tampil_barang.php';</script>");
							
						} else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        Data gagal diubah
                                    </div>";
						}

}

?>
			<?php
			$id_gudang=$_GET['id'];
			$sql="SELECT * FROM barang where id_gudang='$id_gudang'";
			$exe=mysqli_query($koneksi,$sql);
			while ($data=mysqli_fetch_array($exe)){
		?>
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  			  <div class="form-group">
                 
                  <input type="hidden" name="idgudang" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id_gudang'];?>" >
                </div> 
				
                <div class="form-group">
                  <label>Nama Barang Toko</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['nama'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" placeholder="Stok di gudang: <?php echo $data['jumlah'];?>">
                </div>
				
				
				
				<div class="box-footer">
                <input type="submit" name="ubah" class="btn btn-primary" value="Tambah">
              </div>
			  <form>
			<?php } ?>
        </div>
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
 
 