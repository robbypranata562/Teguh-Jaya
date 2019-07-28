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
          <h3 class="box-title">Tambah Barang</h3>

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
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$suplier=$_POST['suplier'];
$modal=$_POST['modal'];
$harga_atas=$_POST['harga_atas'];
$harga_bawah=$_POST['harga_bawah'];
$jumlah=$_POST['jumlah'];
$sisa=$_POST['jumlah'];
$tgl=$_POST['tanggal'];

//02/01/2017
$tahun = substr($tgl,6,4);
$tglnya = substr($tgl,3,2);
$bulan= substr($tgl,0,2);

$tglKirim  = $tahun."-".$bulan."-".$tglnya;


$sql="INSERT INTO `item`(
  `NamaBarang`,
  `JenisBarang`,
  `SupplierBarang`,
  `Modal`,
  `HargaAtas`,
  `HargaBawah`,
  `SatuanBesar`,
  `SatuanKonversi`,
  `JumlahSatuanBesar`,
  `JumlahSatuanKecil`,
  `MinStock`,
  `UmurBarangMaksimal`,
  `UmurBarangNormal`,
  `TanggalMasuk`,
  `SatuanKecil`,
  `HargaDefault`) VALUES (
  '".$_POST['nama']."',
  '".$_POST['jenis']."',
  '".$_POST['suplier']."',
  '".$_POST['modal']."',
  '".$_POST['harga_atas']."',
  '".$_POST['harga_bawah']."',
  '".$_POST['satuan_besar']."',
  '".$_POST['satuan_konversi']."',
  '".$_POST['jumlah_satuan_besar']."',
  '".$_POST['jumlah_satuan_kecil']."',
  '".$_POST['min_stock']."',
  '".$_POST['umur_barang_maksimal']."',
  '".$_POST['umur_barang_normal']."',
  NOW(),
  '".$_POST['satuan_kecil']."',
  '".$_POST['harga_default']."')";


//print_r($sql);

$exe=mysqli_query($koneksi,$sql);

if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data barang berhasil disimpan
                                    </div>";

						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Barang gagal disimpan
                                    </div>";

						}
}
//header("location:tbh_barang.php");

 ?>

         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="control-label">Nama Barang</label>
                  <input type="text" name="nama" class="form-control" id="inputName"  placeholder="Nama Barang" data-error="Nama Tidak Boleh Kosong" required>
				          <div class="help-block with-errors"></div>
                </div>
				        <div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" class="form-control"  placeholder="Jenis Barang" data-error="Jenis Barang Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
				        <div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" class="form-control"  placeholder="Suplier Barang" data-error="Suplier Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Modal Beli</label>
                      <input type="text" name="ModalBeli" id="ModalBeli" class="form-control"  placeholder="Modal Beli" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Modal Jual</label>
                      <input type="text" name="modal" id="modal" class="form-control"  placeholder="Modal Jual" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Default</label>
                      <input type="text" name="harga_default" class="form-control"  placeholder="Harga Default" data-error="Harga Default Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Atas</label>
                      <input type="text" name="harga_atas"class="form-control"  placeholder="Harga Atas" data-error="Harga Atas Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Bawah</label>
                      <input type="text" name="harga_bawah" class="form-control"  placeholder="Harga Bawah" data-error="Harga Bawah Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Konversi</label>
                      <input type="text" name="satuan_konversi" class="form-control"  placeholder="Satuan Konversi" data-error="Satuan Konversi Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Kecil</label>
                      <input type="text" name="satuan_kecil" class="form-control"  placeholder="Satuan Kecil" data-error="Satuan Kecil Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Besar</label>
                      <input type="text" name="satuan_besar" class="form-control"  placeholder="Satuan Besar" data-error="Satuan Besar Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jumlah Satuan Besar</label>
                      <input type="text" name="jumlah_satuan_besar" class="form-control"  placeholder="Jumlah Jumlah Besar" data-error="Jumlah Satuan Besar Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jumlah Satuan Kecil</label>
                      <input type="text" name="jumlah_satuan_kecil" class="form-control"  placeholder="Jumlah Jumlah Kecil" data-error="Jumlah Satuan Kecil Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Umur Barang Normal</label>
                      <input type="text" name="umur_barang_normal" class="form-control"  placeholder="Umur Barang Normal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Umur Barang Maksimal</label>
                        <input type="text" name="umur_barang_maksimal" class="form-control"  placeholder="Umur Barang Maksimal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Min Stock</label>
                  <input type="text" name="min_stock" class="form-control"  placeholder="Min Stock" data-error="Min Stock Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputDate">Tangal Masuk</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
            </form>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
