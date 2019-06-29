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
			include"koneksi.php";
			if(isset($_POST['ubah'])){
				$id_ad= $_SESSION['id_admin'];
				$pw_baru=md5($_POST['pw_baru']);
				$sql_pw="UPDATE admin set pass='$pw_baru' where id_admin='$id_ad'";
				$exe_pw=mysqli_query($koneksi,$sql_pw);
				if($exe_pw){
					echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Password Berhasil Diubah
                                    </div>";
				}else{
					echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Password Gagal Diubah
                                    </div>";
				}
				
			}
		?>
		<form role="form" data-toggle="validator" action="" method="post">
         <div class="form-group">
    <label for="inputPassword" class="control-label">Password Baru</label>
    <div class="form-inline row">
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
        
      </div>
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" id="inputPasswordConfirm" name="pw_baru" data-match="#inputPassword" data-match-error="Password tidak cocok" placeholder="Ulangi Password Baru" required>
		<div class="help-block with-errors"></div>
        
      </div>
    </div>
  </div>
   <div class="box-footer">
                <input type="submit" name="ubah" class="btn btn-primary" value="Ubah">
              </div>
	</form>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>
 
 