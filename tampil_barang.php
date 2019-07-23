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
	  <?php
	  
	  $sql_notif="SELECT * FROM notif where id='1'";
	  $exe_notif=mysqli_query($koneksi,$sql_notif);
		while($data_notif=mysqli_fetch_array($exe_notif)){
		$nilai=$data_notif['jum_minimal'];
		//echo $nilai;
		}
	  
    $cek=
        "
        SELECT
            item.NamaBarang,
            item.JenisBarang,
            item.SupplierBarang,
            item.Modal,
            item.HargaAtas,
            item.HargaBawah,
            item.SatuanKonversi,
            item.Stok,
            item.MinStock,
            item.UmurBarangMaksimal,
            item.UmurBarangNormal,
            item.TanggalMasuk,
            item.id
          FROM
            item
        ";
		$exe_cek=mysqli_query($koneksi,$cek);
		// while ($data_exe=mysqli_fetch_array($exe_cek)){
		// if($data_exe['jumlah']<=$nilai)	{
		// 	$(document).ready(function(){
		// 		$('#pesan_sedia').css("color","red");
		// 		$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
		// 	});

		// echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $data_exe['nama']."</a> yang tersisa sudah kurang dari $nilai . silahkan pesan lagi !!</div>";	
		// 	}
		// }
		
		?>
     
    </section>

    <!-- Main content -->
    <section class="content">
	
      <!-- Default box -->
      <div class="box">
	 <?php $jabatan=$_SESSION['level']?>
        <div class="box-header with-border">

		<?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
		?>
		<a href="tbh_barang.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Stock Barang</h3></a> 
        <?php } ?>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
		
        <div class="box-body">
          <table id="titem" class="table table-bordered table-striped">
          <?php $jabatan=$_SESSION['level']?>  

          <thead>
          <tr>
              <th>Tanggal Masuk</th>
              <?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){ ?>
              <th>Histori Barang</th>
              <?php } ?>
              <th>Nama Barang</th>
              <th>Jenis Barang</th>
              <th>Supplier</th>
            <?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){ ?>
              <th>Modal</th>
              <th>Harga Bawah</th>
              <th>Harga Atas</th>
            <?php } ?>
              <th>Jumlah Satuan Besar</th>
              <th>Konversi</th>
              <th>Jumlah Satuan Kecil</th>
              <th>Min Stok</th>
            <?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){ ?>
              <th>Action</th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php
          $sql="SELECT
          Date(item.TanggalMasuk) as TanggalMasuk,
          item.NamaBarang,
          item.JenisBarang,
          item.SupplierBarang,
          item.Modal,
          item.HargaBawah,
          item.HargaAtas,
          item.SatuanKonversi,
          item.JumlahSatuanKecil,
          item.MinStock,
          item.JumlahSatuanBesar,
          item.id
        FROM
          item";
          $exe=mysqli_query($koneksi,$sql);
          while($data=mysqli_fetch_array($exe))
          {

            $StokLargeUnit = $data['JumlahSatuanBesar'];
            $StokSmallUnit = $data['JumlahSatuanKecil'];

            if ($data['JumlahSatuanKecil'] <= $data['MinStock'])
            {
              $rowclass = "red-row-class"; 
            }
            else
            {
              $rowclass = ""; 
            }
            //Format uang
            $harga_bawah ="Rp. ".number_format($data['HargaBawah'],'0',',','.');
            $harga_atas = "Rp. ".number_format($data['HargaAtas'],'0',',','.');
            $modal = "Rp. ".number_format($data['Modal'],'0',',','.');
            ?>
            <?php $jabatan=$_SESSION['level']?> 
            <tr class="<?php echo $rowclass; ?>">
            <td><?php echo $data['TanggalMasuk'];?></td>
            <?php if ($jabatan=='Super Admin' or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
            ?>
             <td>
               <a  class="btn btn-warning" href="HistoryBarang.php?id=<?php echo $data['id'];?>"> <span class="glyphicon glyphicon-pencil"></span> History Barang</a>
             </td>
            <?php } ?>
            <td><?php echo $data['NamaBarang'];?></td>
            <td><?php echo $data['JenisBarang'];?></td>
            <td><?php echo $data['SupplierBarang'];?></td>
            <?php if ($jabatan=='Super Admin' or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
            ?>
            <td><?php echo $modal?></td>
            <td><?php echo $harga_bawah;?></td>
            <td><?php echo $harga_atas?></td>
            <?php } ?>
            <td><?php echo $StokLargeUnit; ?></td>
            <td><?php echo   $data["SatuanKonversi"]; ?></td>
          
            <td><?php echo $StokSmallUnit;?></td>
            <td><?php echo $data['MinStock'];?></td>
            <?php if ($jabatan=='Super Admin' or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
            ?>
            <td>
              <a  class="btn btn-warning" href="edit_barang.php?id=<?php echo $data['id'];?>"> <span class="glyphicon glyphicon-pencil"></span> Edit</a>
              <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='hapus_barang.php?id=<?php echo $data['id']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
            </td>
            </tr>
            <?php } ?>
          <?php } ?>
          </table>
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

<script>
    $('#titem').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
        "scrollX": true
    });
</script>
 
 