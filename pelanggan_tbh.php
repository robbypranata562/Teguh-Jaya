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
if (isset($_POST['simpan'])){
$nama=$_POST['nama'];
$rek=$_POST['alamat'];
//$hutang=$_POST['hutang'];
$hp=$_POST['hp'];
$saldo=$_POST['saldo'];


$sql="insert into pelanggan values(NULL,'$nama','0','$rek','$hp',NOW(),'$saldo')";
$exe=mysqli_query($koneksi,$sql);
if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data pelanggan disimpan
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Pelanggan gagal disimpan
                                    </div>";
							
						}

}
 ?>
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="control-label">Nama Pelanggan</label>
                  <input type="text" name="nama" class="form-control" id="nama"  placeholder="Nama Pelanggan" data-error="Nama Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." name="alamat" data-error="Alamat Tidak Boleh Kosong" required></textarea>
				  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Saldo</label>
                  <input type="text" name="saldo" class="form-control" id="exampleInputEmail1" placeholder="Jumlah Saldo"data-error="Saldo Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Nomor Handphone</label>
                  <input type="text" name="hp" class="form-control" id="exampleInputEmail1" placeholder="Nomor Handphone"data-error="Nomor HP Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				
				
				<div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
			  <form>
        </div>
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
 
 