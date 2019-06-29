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
          <h3 class="box-title">Register Admin</h3>

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
	
$id=$_POST['users'];	

$uname=$_POST['user'];
//$nama=$_POST['nama'];
$password=md5($_POST['password']);
$lev=$_POST['level'];
//$foto=$_POST['foto'];





	
$sql="insert into admin VALUES(NULL,'$id','$uname','$password','$lev')";
$exe=mysqli_query($koneksi,$sql);

if($exe){
	
 
 
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data Admin berhasil disimpan
										
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Barang Toko gagal disimpan
                                    </div>";
							
						}



//header("location:tbh_barang.php");
}
 ?>
 
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
               <div class="form-group">
		
                <label>Nama Karyawan</label>
                <select class="form-control select2"  onchange="showUser(this.value)" style="width: 100%;" name="users">
				<option value="">Pilih Karyawan :</option>
                  <?php
					$sql="SELECT * FROM karyawan";
					$exe=mysqli_query($koneksi,$sql);
          //$nomor =1;
					while($data=mysqli_fetch_array($exe)){
           // $nomor++;
				  ?>

                  <option name="suplier" value=<?php echo $data['id'];?>   ><?php echo $data['nama'];?></option>
                 <?php } ?>
                </select>
              </div>
				
                
                <br>
<div id="txtHint"><b>...</b></div>
        </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
            </form>
			
      
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getresult_reg.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
  
<?php include "footer.php";?>
 
 