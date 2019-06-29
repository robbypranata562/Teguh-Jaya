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
          <h3 class="box-title">Tambah Barang Toko</h3>

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
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$suplier=$_POST['suplier'];
$modal=$_POST['modal'];
$harga_atas=$_POST['harga_atas'];
$harga_bawah=$_POST['harga_bawah'];
$jumlah=$_POST['jumlah'];
$sisa=$_POST['jumlah'];
//$tgl=$_POST['tanggal'];

$sql_t="SELECT * from barang where id_gudang='$id'";
$exe_t=mysqli_query($koneksi,$sql_t);
$data_t=mysqli_fetch_array($exe_t);
$tt=$data_t['jumlah'];
$t=$tt-$jumlah;





if ($t < 0){
	echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Stok Barang Gudang Tidak mencukupi, Stok yang ada digudang sebanyak: $tt
                                    </div>";
}else{

$val="SELECT id_gudang FROM stok_toko where id_gudang='$id'";
$exe_val=mysqli_query($koneksi,$val);
$ketemu=mysqli_num_rows($exe_val);



if($ketemu==0){
$sql_u="update barang set jumlah='$t' where id_gudang='$id'";
$exe_u=mysqli_query($koneksi,$sql_u);
	
$sql="insert into stok_toko values(NULL,'$id','$nama','$jenis','$suplier','$modal','$harga_atas','$harga_bawah','$jumlah','$sisa',NOW())";
$exe=mysqli_query($koneksi,$sql);

if($exe){
	
 
 
							
	
	
				echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Jumlah berhasil ditambah
										
                                    </div>";
			

							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Barang Toko gagal disimpan
                                    </div>";
							
						}
} else{
	$sql_uu="update stok_toko, barang set stok_toko.jumlah_toko=stok_toko.jumlah_toko + $jumlah, barang.jumlah='$t' where stok_toko.id_gudang='$id' and barang.id_gudang='$id'";
	$exe_uu=mysqli_query($koneksi,$sql_uu);
	
	if($exe_uu){
		
		
		
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Jumlah berhasil ditambah
										
                                    </div>";
		
	}else{
		echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         jumlah gagal ditambah
                                    </div>";
		
	}


}

}
//header("location:tbh_barang.php");
}
 ?>
 
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
               <div class="form-group">
		
                <label>Nama Barang</label>
                <select class="form-control select2"  onchange="showUser(this.value)" style="width: 100%;" name="users">
				<option value="">Pilih Barang:</option>
                  <?php
					$sql="SELECT * FROM barang";
					$exe=mysqli_query($koneksi,$sql);
          //$nomor =1;
					while($data=mysqli_fetch_array($exe)){
           // $nomor++;
				  ?>

                  <option name="suplier" value=<?php echo $data['id_gudang'];?>   ><?php echo $data['nama'];?></option>
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
			
      
        <!-- /.box-footer-->
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
        xmlhttp.open("GET","getresult.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
  
<?php include "footer.php";?>
 
 