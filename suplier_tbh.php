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
$rek=$_POST['rekening'];
$hutang=$_POST['hutang'];
$tgl=$_POST['tempo'];
$bank=$_POST['level'];

$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglTempo  = $tahun."-".$bulan."-".$tglnya;


$sql="insert into suplier values(NULL,'$nama','$bank','$rek','$hutang','$tglTempo')";
$exe=mysqli_query($koneksi,$sql);
if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data Suplier disimpan
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Suplier gagal disimpan
                                    </div>";
							
						}

}
 ?>
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Suplier</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  placeholder="Nama Suplier"data-error="Nama Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
		
                <label>Bank</label>
                <select class="form-control select2"   style="width: 100%;" name="level">
				<option value="">Pilih Bank:</option>
                  

                  <option name="level" value="BRI">BRI</option>
                  <option name="level" value="BRI Syariah">BRI Syariah</option>
				  <option name="level" value="BNI">BNI</option>
				  <option name="level" value="BNI Syariah">BNI Syariah</option>
				  <option name="level" value="BCA">BCA</option>
				  <option name="level" value="BCA Syariah">BCA Syariah</option>
				  <option name="level" value="MANDIRI">MANDIRI</option>
				  <option name="level" value="MANDIRI Syariah">MANDIRI Syariah</option>
				  <option name="level" value="MUAMALAT INDONESIA">MUAMALAT INDONESIA</option>
				  <option name="level" value="DANAMON">DANAMON</option>
				  <option name="level" value="CIMB">CIMB</option>
				  <option name="level" value="Bukopin">Bukopin</option>
				  <option name="level" value="OCBC NISP">OCBC NISP</option>
				  <option name="level" value="MEGA">MEGA</option>
				  <option name="level" value="PANIN">PANIN</option>
				  <option name="level" value="PRIMA Master Bank">PRIMA Master Bank</option>
				  <option name="level" value="Tabungan Pensiun">Tabungan Pensiun</option>
				  <option name="level" value="PERMATA">PERMATA</option>
				  <option name="level" value="ARTHA GRAHA">ARTHA GRAHA</option>
				 
                 
                </select>
              </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">No Rekening</label>
                  <input type="text" name="rekening" class="form-control" id="exampleInputEmail1" placeholder="No Rekening"data-error="No Rekening Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">hutang</label>
                  <input type="text" name="hutang" class="form-control" id="exampleInputEmail1" placeholder="Hutang" value="0">
                </div>
				<div class="form-group">
        <label for="exampleInputDate">Tempo</label>
                   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="tempo"data-error="Tanggal Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
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
 
 