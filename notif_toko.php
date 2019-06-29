<?php include "header.php";

?>
 

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
          <h3 class="box-title">Notifikasi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		
		<?php 
	if (isset($_POST['simpan'])){
		$jumlah= $_POST['jumlah'];
		$sql="update notif set jum_minimal='$jumlah' where id=1";
		$exe=mysqli_query($koneksi,$sql);
		
	}	

 ?>
 
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
               <div class="form-group">
		
               
                <div class="form-group">
                  <label for="exampleInputEmail1">Jumlah Minimal Barang</label>
                  <input type="text" name="jumlah" class="form-control" id="exampleInputEmail1" placeholder="Jumlah Minimal Barang">
                </div>
              </div>
				
                
                <br>

        </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
            </form>
			
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
 
 