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
          <h3 class="box-title">Bayar Hutang</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
		 
        <div class="box-body">
		<?php
	//include "koneksi.php";
	if(isset($_POST['btn_bayar'])){
	
	$jum_hutang=$_POST['hutang'];
	$jum_bayar=$_POST['bayar'];
	
	$sisa_hutang= $jum_hutang - $jum_bayar; 
	
	$sql="update suplier set hutang='$sisa_hutang' where hutang='$jum_hutang'";
$exe=mysqli_query($koneksi,$sql);
if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Hutang berhasil dibayar
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Hutang gagal disimpan
                                    </div>";
							
						}
	}	
?>
		<form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
		
                <label>Pilih Suplier</label>
                <select class="form-control select2" id="mySelect" onchange="changeSuplier(this)" style="width: 100%;" name="suplier">
                  <?php
					$sql="SELECT * FROM suplier";
					$exe=mysqli_query($koneksi,$sql);
          $nomor =1;
					while($data=mysqli_fetch_array($exe)){
            $nomor++;
				  ?>

                  <option name="suplier" value=<?php echo $data['hutang'];?>   ><?php echo $data['nama_suplier'];?></option>
                 <?php } ?>
                </select>
              </div>
			  <label>Jumlah Hutang</label>
                  <input type="text" name="hutang" class="form-control" id="hutang">
				  <label>Jumlah Bayar</label>
                  <input type="text" name="bayar" class="form-control" id="bayar">
				  
				  
				  <div class="box-footer">
                <input type="submit" name="btn_bayar" class="btn btn-primary" value="Bayar">
              </div>
				</form>
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
  <script type="text/javascript">
    function changeSuplier(obj){
        //alert(obj.options[obj.selectedIndex].value);
         document.getElementById("hutang").value = obj.options[obj.selectedIndex].value;

      }
  </script>
  
  
<?php include "footer.php";?>
 
 