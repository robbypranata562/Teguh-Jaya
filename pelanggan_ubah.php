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
$id=$_POST['id'];
$nama=$_POST['nama'];
$rek=$_POST['alamat'];
$hp=$_POST['nohp'];
//$tempo=$_POST['tempo'];
$hutang=$_POST['hutang'];
$saldo=$_POST['saldo'];

$sql="update pelanggan set nama_pelanggan='$nama', hutang='$hutang', alamat='$rek', nohp='$hp', saldo='$saldo' where id_pelanggan='$id'";
$exe=mysqli_query($koneksi,$sql);
//header("location:suplier_tampil.php");
if($exe){
							echo ("<script>location.href='pelanggan_tampil.php';</script>");
							
						} else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        Data gagal diubah
                                    </div>";
						}

}
?>
			<?php
			$id_sup=$_GET['id'];
			$sql="SELECT * FROM pelanggan where id_pelanggan='$id_sup'";
			$exe=mysqli_query($koneksi,$sql);
			while ($data=mysqli_fetch_array($exe)){
		?>
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  			  <div class="form-group">
                 
                  <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id_pelanggan'];?>" >
                </div>
                <div class="form-group">
                  <label>Nama pelanggan</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['nama_pelanggan'];?>">
                </div>
				<div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." name="alamat"><?php echo $data['alamat'];?></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Saldo</label>
                  <input type="text" name="saldo" class="form-control" id="exampleInputEmail1" value="<?php echo $data['saldo'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Hutang</label>
                  <input type="text" name="hutang" class="form-control" id="exampleInputEmail1" value="<?php echo $data['hutang'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">No Handphone</label>
                  <input type="text" name="nohp" class="form-control" id="exampleInputEmail1" value="<?php echo $data['nohp'];?>">
                </div>
				
				<div class="box-footer">
                <input type="submit" name="ubah" class="btn btn-primary" value="Ubah">
              </div>
			  <form>
			<?php } ?>
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
 
 