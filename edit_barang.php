<?php include "header.php";?>
 

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data Barang
        <small></small>
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
$tgl=$_POST['tanggal'];

$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglTempo  = $tahun."-".$bulan."-".$tglnya;

$sql="update barang set nama='$nama', jenis='$jenis', suplier='$suplier', modal='$modal', harga_atas='$harga_atas', harga_bawah='$harga_bawah', jumlah='$jumlah', sisa='$jumlah', tangal_masuk='$tglTempo' where id_gudang='$id'";
$exe=mysqli_query($koneksi,$sql);

if($exe){
							echo ("<script>location.href='tampil_barang.php';</script>");
							
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
			$sql_1="SELECT * FROM barang where id_gudang='$id_brg'";
			$exe=mysqli_query($koneksi,$sql_1);
			while ($data=mysqli_fetch_array($exe)){
		?>
		
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  <div class="form-group">
                 
                  <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id_gudang'] ?>" >
                </div>
                <div class="form-group">
                  <label>Nama Barang</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['nama'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" class="form-control" id="exampleInputEmail1"value="<?php echo $data['jenis'];?>"
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" class="form-control" id="exampleInputEmail1" value="<?php echo $data['suplier'];?>"
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="modal" class="form-control" id="exampleInputEmail1"value="<?php echo $data['modal'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Harga Atas</label>
                  <input type="text" name="harga_atas"class="form-control" id="exampleInputEmail1" value="<?php echo $data['harga_atas'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">harga Bawah</label>
                  <input type="text" name="harga_bawah" class="form-control" id="exampleInputEmail1" value="<?php echo $data['harga_bawah'];?>">
                </div>
				<div class="form-group">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" value="<?php echo $data['jumlah'];?>">
                </div>
                <div class="form-group">
        <label for="exampleInputDate">Tangal Masuk</label>
                   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" placeholder="<?php echo $data['tangal_masuk']?>">
                </div>
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
 
 