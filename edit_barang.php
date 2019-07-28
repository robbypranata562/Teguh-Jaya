<?php include "header.php";?>
 

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data Barang
        <small></small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Barang</h3>

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
$sql="update Item 
set 
  NamaBarang            ='".$_POST['nama']."',
  JenisBarang           ='".$_POST['jenis']."',
  SupplierBarang        ='".$_POST['suplier']."',
  Modal                 ='".$_POST['modal']."',
  ModalBeli             ='".$_POST['ModalBeli']."', 
  HargaAtas             ='".$_POST['harga_atas']."', 
  HargaBawah            ='".$_POST['harga_bawah']."',
  SatuanBesar           ='".$_POST['satuan_besar']."',
  SatuanKonversi        ='".$_POST['satuan_konversi']."',
  JumlahSatuanBesar     ='".$_POST['jumlah_satuan_besar']."',
  JumlahSatuanKecil     ='".$_POST['jumlah_satuan_kecil']."',
  MinStock              ='".$_POST['min_stock']."',
  UmurBarangMaksimal    ='".$_POST['umur_barang_maksimal']."',
  UmurBarangNormal      ='".$_POST['umur_barang_normal']."',
  TanggalMasuk          ='".$_POST['tanggal']."',
  SatuanKecil           ='".$_POST['satuan_kecil']."',
  HargaDefault          ='".$_POST['harga_default']."'
where 
  Id='".$_POST['id']."'";
  print_r($sql);
$exe=mysqli_query($koneksi,$sql);

if($exe){
							echo ("<script>location.href='tampil_barang.php';</script>");
							
						} else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        Data gagal diubah
                                    </div>";
						}
//header("location:tampil_barang.php");
}
?>

		<?php
			$id_brg=$_GET['id'];
			$sql_1="SELECT * FROM item where id ='$id_brg'";
			$exe=mysqli_query($koneksi,$sql_1);
			while ($data=mysqli_fetch_array($exe)){
		?>
      <form role="form" action="" method="post" enctype="multipart/form-data">
      <div class="box-body">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="<?php echo $data['id'] ?>" >
            </div>
            <div class="form-group">
                  <label for="inputName" class="control-label">Nama Barang</label>
                  <input type="text" name="nama" class="form-control" id="inputName" value="<?php echo $data['NamaBarang'] ?>"  placeholder="Nama Barang" data-error="Nama Tidak Boleh Kosong" required>
                  <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Jenis Barang</label>
                  <input type="text" name="jenis" value="<?php echo $data['JenisBarang'] ?>" class="form-control"  placeholder="Jenis Barang" data-error="Jenis Barang Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Suplier Barang</label>
                  <input type="text" name="suplier" value="<?php echo $data['SupplierBarang'] ?>" class="form-control"  placeholder="Suplier Barang" data-error="Suplier Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Modal Beli</label>
                      <input type="text" name="ModalBeli" id="ModalBeli" value="<?php echo $data['ModalBeli'] ?>" class="form-control"  placeholder="Modal Beli" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Modal Jual</label>
                      <input type="text" name="modal" id="modal" value="<?php echo $data['Modal'] ?>" class="form-control"  placeholder="Modal Jual" data-error="Modal Tidak Boleh Kosong" required readonly><div class="help-block with-errors"></div>
                    </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Default</label>
                      <input type="text" name="harga_default"  value="<?php echo $data['HargaDefault'] ?>" class="form-control"  placeholder="Harga Default" data-error="Harga Default Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Atas</label>
                      <input type="text" name="harga_atas"  value="<?php echo $data['HargaAtas'] ?>" class="form-control"  placeholder="Harga Atas" data-error="Harga Atas Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Harga Bawah</label>
                      <input type="text" name="harga_bawah"  value="<?php echo $data['HargaBawah'] ?>" class="form-control"  placeholder="Harga Bawah" data-error="Harga Bawah Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Konversi</label>
                      <input type="text" name="satuan_konversi"  value="<?php echo $data['SatuanKonversi'] ?>" class="form-control"  placeholder="Satuan Konversi" data-error="Satuan Konversi Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Kecil</label>
                      <input type="text" name="satuan_kecil" class="form-control"  value="<?php echo $data['SatuanKecil'] ?>"  placeholder="Satuan Kecil" data-error="Satuan Kecil Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Satuan Besar</label>
                      <input type="text" name="satuan_besar" class="form-control"  value="<?php echo $data['SatuanBesar'] ?>"  placeholder="Satuan Besar" data-error="Satuan Besar Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jumlah Satuan Besar</label>
                      <input type="text" name="jumlah_satuan_besar" class="form-control"  value="<?php echo $data['JumlahSatuanBesar'] ?>"  placeholder="Jumlah Jumlah Besar" data-error="Jumlah Satuan Besar Tidak Boleh Kosong" required readonly><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Jumlah Satuan Kecil</label>
                      <input type="text" name="jumlah_satuan_kecil" class="form-control"  value="<?php echo $data['JumlahSatuanKecil'] ?>"  placeholder="Jumlah Jumlah Kecil" data-error="Jumlah Satuan Kecil Tidak Boleh Kosong" required readonly><div class="help-block with-errors"></div>
                    </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Umur Barang Normal</label>
                      <input type="text" name="umur_barang_normal" class="form-control"  value="<?php echo $data['UmurBarangNormal'] ?>"  placeholder="Umur Barang Normal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Umur Barang Maksimal</label>
                        <input type="text" name="umur_barang_maksimal" class="form-control"  value="<?php echo $data['UmurBarangMaksimal'] ?>"  placeholder="Umur Barang Maksimal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                      </div>
                    </div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Min Stock</label>
                  <input type="text" name="min_stock" class="form-control"  value="<?php echo $data['MinStock'] ?>"  placeholder="Min Stock" data-error="Min Stock Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                    <label for="exampleInputDate">Tangal Masuk</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right"  value="<?php echo $data['TanggalMasuk'] ?>" id="datepicker" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
            </div>
        <div class="box-footer">
        <input type="submit" name="ubah" class="btn btn-primary" value="Simpan">
        </div>
      </form>
			<?php } ?>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
 
 