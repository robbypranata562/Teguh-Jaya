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
$rek=$_POST['rekening'];
$hutang=$_POST['hutang'];
$tgl=$_POST['tempo'];
$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglTempo  = $tahun."-".$bulan."-".$tglnya;

$sql="update suplier set nama_suplier='$nama', no_rekening='$rek', hutang='$hutang', tempo='$tglTempo' where id_suplier='$id'";
$exe=mysqli_query($koneksi,$sql);
//header("location:suplier_tampil.php");
if($exe){
							echo ("<script>location.href='suplier_tampil.php';</script>");
							
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
			$sql="SELECT * FROM suplier where id_suplier='$id_sup'";
			$exe=mysqli_query($koneksi,$sql);
			while ($data=mysqli_fetch_array($exe)){
		?>
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
			  			  <div class="form-group">
                 
                  <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id_suplier'];?>" >
                </div>
                <div class="form-group">
                  <label>Nama Suplier</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['nama_suplier'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">No Rekening</label>
                  <input type="text" name="rekening" class="form-control" id="exampleInputEmail1" value="<?php echo $data['no_rekening'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">hutang</label>
                  <input type="text" name="hutang" class="form-control" id="exampleInputEmail1" value="<?php echo $data['hutang'];?>">
                </div>
				<div class="form-group">
        <label for="exampleInputDate">Tempo</label>
                   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="tempo" value="<?php echo $data['tempo'];?>">
                </div>
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
 
 