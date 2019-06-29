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
          <h3 class="box-title">Tambah Barang</h3>

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
if(isset($_POST['simpan'])){
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$suplier=$_POST['suplier'];
$modal=$_POST['modal'];
$harga_atas=$_POST['harga_atas'];
$harga_bawah=$_POST['harga_bawah'];
$jumlah=$_POST['jumlah'];
$sisa=$_POST['jumlah'];
$tgl=$_POST['tanggal'];

//02/01/2017
$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglKirim  = $tahun."-".$bulan."-".$tglnya;


$sql="insert into barang values(NULL,'$nama','$jenis','$suplier','$modal','$harga_atas','$harga_bawah','$jumlah','$sisa','$tglKirim')";




$exe=mysqli_query($koneksi,$sql);

if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data barang berhasil disimpan
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Barang gagal disimpan
                                    </div>";
							
						}
}
//header("location:tbh_barang.php");

 ?>
 
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="control-label">Nama Barang</label>
                  <input type="text" name="nama" class="form-control" id="inputName"  placeholder="Nama Barang" data-error="Nama Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" class="form-control" id="exampleInputEmail1" placeholder="Jenis Barang" data-error="Jenis Barang Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" class="form-control" id="exampleInputEmail1" placeholder="Suplier Barang" data-error="Suplier Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="modal" class="form-control" id="exampleInputEmail1" placeholder="modal" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Harga Atas</label>
                  <input type="text" name="harga_atas"class="form-control" id="exampleInputEmail1" placeholder="Harga Atas" data-error="Harga Atas Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">harga Bawah</label>
                  <input type="text" name="harga_bawah" class="form-control" id="exampleInputEmail1" placeholder="Harga Bawah" data-error="Harga Bawah Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" placeholder="jumlah" data-error="Jumlah Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
        <label for="exampleInputDate">Tangal Masuk</label>
                   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
                </div>
                
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
            </form>
			 
        </div>
        <!-- /.box-body -->
      
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>


 