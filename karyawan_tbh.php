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
          <h3 class="box-title">Karyawan</h3>

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
$jekel=$_POST['jekel'];
$jabatan=$_POST['jabatan'];
$alamat=$_POST['alamat'];
$nohp=$_POST['nohp'];
$htg=$_POST['hutang'];
$gaji=$_POST['gaji'];
$tgl=$_POST['tempo'];
$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglTempo  = $tahun."-".$bulan."-".$tglnya;
$gambar=$_FILES['gambar']['name'];
if(strlen($gambar)>0){
	if(is_uploaded_file($_FILES['gambar']['tmp_name'])){
	move_uploaded_file($_FILES['gambar']
	['tmp_name'],"foto/".$gambar);
	} }
	
	$ktp=$_FILES['ktp']['name'];
if(strlen($ktp)>0){
	if(is_uploaded_file($_FILES['ktp']['tmp_name'])){
	move_uploaded_file($_FILES['ktp']
	['tmp_name'],"foto/ktp/".$ktp);
	} }


$sql="insert into karyawan values(NULL,'$nama','$jekel','$jabatan','$alamat','$gambar','$ktp','$nohp','$htg','$tglTempo','$gaji')";
$exe=mysqli_query($koneksi,$sql);
if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data Karyawan disimpan
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Karyawan gagal disimpan
                                    </div>";
							
						}

}
 ?>
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Karyawan</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  placeholder="Nama Karyawan"data-error="Nama Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
		
                <label>Jenis Kelamin</label>
                <select class="form-control select2" id=""  style="width: 100%;" name="jekel">
                 

                  <option  value="">Pilih Jenis Kelamin:</option>
                  <option  value="Laki-laki">Laki-laki</option>
				  <option  value="Perempuan">Perempuan</option>
                 
                </select>
				
              </div>
			 <div class="form-group">
    
                <label>Jabatan</label>
                <select class="form-control select2"   style="width: 100%;" name="jabatan">
        <option value="">Pilih Jabatan:</option>
                  
          
    ?>
                  <option name="jabatan" value="Manager"   >Manager</option>
         
          <option name="jabatan" value="Karyawan"   >Karyawan</option>
          <option name="jabatan" value="Kasir"   >Kasir</option>
                 
                </select>
              </div>
				<div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" placeholder="Alamat ..." name="alamat"data-error="Alamat Tidak Boleh Kosong" required></textarea>
				  <div class="help-block with-errors"></div>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputFile">Foto</label>
                  <input type="file" id="exampleInputFile" name="gambar"data-error="Foto Tidak Boleh Kosong" required>
					<div class="help-block with-errors"></div>
                  
                </div>
				<div class="form-group">
                  <label for="exampleInputFile">Foto KTP</label>
                  <input type="file" id="exampleInputFile" name="ktp"data-error="Foto Tidak Boleh Kosong" required>
					<div class="help-block with-errors"></div>

                  
                </div>
				<div class="form-group">
                  <label>No HP</label>
                  <input type="text" name="nohp" class="form-control" id="exampleInputEmail1"  placeholder="No HP"data-error="No HP Tidak Boleh Kosong" required>
					<div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
                  <label>Hutang</label>
                  <input type="text" name="hutang" class="form-control" id="exampleInputEmail1"  placeholder="Hutang" value="0">
                </div>
                <div class="form-group">
        <label for="exampleInputDate">Jadwal Gajian</label>
                   <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="tempo"data-error="Tanggal Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
                </div>
                <div class="form-group">
                  <label>Jumlah Gaji</label>
                  <input type="text" name="gaji" class="form-control" id="exampleInputEmail1"  placeholder="Gaji" data-error="Gaji Tidak Boleh Kosong" required>
					<div class="help-block with-errors"></div>
                </div>
				
				<div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
			  <form>
        </div>
		</div>
      
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>
 
 