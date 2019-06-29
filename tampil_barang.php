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
	  
		$cek="SELECT * FROM barang where jumlah <=$nilai";
		$exe_cek=mysqli_query($koneksi,$cek);
		while ($data_exe=mysqli_fetch_array($exe_cek)){
		if($data_exe['jumlah']<=$nilai)	{
	  ?>
	  
	  <script>
			$(document).ready(function(){
				$('#pesan_sedia').css("color","red");
				$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
			});
		</script>
	  <?php
		echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $data_exe['nama']."</a> yang tersisa sudah kurang dari $nilai . silahkan pesan lagi !!</div>";	
			}
		}
		
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
         <table id="example1" class="table table-bordered table-striped">
<?php $jabatan=$_SESSION['level']?>  
           
			   <thead>
                <tr>
				
                  <th>Nama Barang</th>
                  
                  <th>Suplier</th>
                 
                  <th>harga</th>
				  <th>Lusin</th>
				  <th>Satuan</th>
				  <th>Tanggal</th>
		
		
		<?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
		?>
				   <th>modal</th>
				  <th>harga bawah</th>
				  
				  <th>Action</th>
				  
                </tr>
                </thead>
		
		<?php } ?>
                <tbody>
				<?php
				
					$sql="SELECT * FROM barang";
					$exe=mysqli_query($koneksi,$sql);
				
					while($data=mysqli_fetch_array($exe)){
					$jumlah_toko= $data['jumlah'];
            if ($data['jumlah'] >=12 ) {
              

               $lusin = (floor($data['jumlah']/12));
               $pcs = ($data['jumlah']%12);
               if ($pcs != 0) {
                    $jumlah_barang = $lusin. " Lusin  ";
               }else{
                $jumlah_barang = $lusin. " Lusin  ";
               }
              
			$jum_pcs = ($data['jumlah']%12). " Pcs";

            }else{
                $jumlah_barang = 0 ;
					$jum_pcs = ($data['jumlah']%12). " Pcs";
            }
              //Format uang
            $harga_bawah ="Rp. ".number_format($data['harga_bawah'],'0',',','.');
             $harga_atas = "Rp. ".number_format($data['harga_atas'],'0',',','.');
             $modal = "Rp. ".number_format($data['modal'],'0',',','.');
				?>
				<?php $jabatan=$_SESSION['level']?> 
                <tr>
                  <td><?php echo $data['nama'];?></td>
                  
                  <td><?php echo $data['suplier'];?></td>
				  <td><?php echo $harga_atas;?></td>
				  <td><a href="jml_barang.php?id=<?php echo $data['id_gudang']?>"><?php echo $jumlah_barang." + ".$jum_pcs;?></a></td>
				  <td><a href="jml_barang.php?id=<?php echo $data['id_gudang']?>"><?php echo $jumlah_toko;?></a></td>
				  <td><?php echo $data['tangal_masuk'];?></td>
	 <?php if ($jabatan=='Super Admin' or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
		?>
                  <td><?php echo $modal;?></td>
                  
				  <td><?php echo $harga_bawah;?></td>
				  
				  <td>

				 

				<a  class="btn btn-warning" href="edit_barang.php?id=<?php echo $data['id_gudang'];?>"> <span class="glyphicon glyphicon-pencil"></span> Edit</a>
				 
				<a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='hapus_barang.php?id=<?php echo $data['id_gudang']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>

				  
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
 
 