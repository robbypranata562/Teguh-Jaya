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
	  
	  $sql_notif="SELECT * FROM notif where id='2'";
	  $exe_notif=mysqli_query($koneksi,$sql_notif);
		while($data_notif=mysqli_fetch_array($exe_notif)){
		$nilai=$data_notif['jum_minimal'];
		//echo $nilai;
		}
	  
		$cek="SELECT * FROM stok_toko, barang where barang.id_gudang=stok_toko.id_gudang and jumlah_toko <=$nilai";
		$exe_cek=mysqli_query($koneksi,$cek);
		while ($data_exe=mysqli_fetch_array($exe_cek)){
		if($data_exe['jumlah_toko']<=$nilai)	{
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
		<?php if ($jabatan=='Super Admin'){
		?>
        <form action="">  <a href="toko_tbh.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Stock Barang</h3></a></form>
			<?php } ?>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
		
        <div class="box-body">
		<form action="" method="post">
		<?php
			if(isset($_POST['hitung'])){
				$jum=$_POST['banyak'];
				$sql_b="UPDATE keranjang set jumlah_keranjang='$jum";
				$wxw=mysqli_query($koneksi,$sql_b);
				
			}
		?>
         <table id="example2" class="table table-bordered table-hover">
  
           
			   <thead>
                <tr>
				
                  <th>Nama Barang</th>
                  
                  <th>Harga</th>
                 
                  <th>Jumlah</th>
				  
				  <th>Sub Total</th>
				  <th>Tgl Belanja</th>
		
		
		
				   
				  
				  <th>Action</th>
				  
                </tr>
                </thead>
		
		
                <tbody>
				<?php
				$sid = session_id();
					$sql="SELECT * FROM keranjang, stok_toko, barang where id_sesion='$sid' AND keranjang.id_barangtoko=stok_toko.id_toko AND stok_toko.id_gudang=barang.id_gudang";
					$exe=mysqli_query($koneksi,$sql);
				
					while($data=mysqli_fetch_array($exe)){
						$subtotal = $data['harga_atas_toko'] * $data['jumlah_keranjang'];
						$total= $total + $subtotal;
            
				?>
				
                <tr>
                  <td><?php echo $data['nama'];?></td>
                  
                  <td><input type="text" name="jum" value="<?php echo $data['harga_atas_toko'];?>"></td>
				  <td><input type="text" name="banyak" value="<?php echo $data['jumlah_keranjang'];?>"></td>
				 
	 
                  <td><?php echo $subtotal;?></td>
                  
				  <td><?php echo $data['tanggal'];?></td>
				  
				  <td>
				 
				 <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='toko_hapus.php?id=<?php echo $data['id_toko']; ?>' }"  class="glyphicon glyphicon-trash">Hapus</a>
				  </td>
                </tr>
					
                <?php } ?>
                
              </table>
			 
        </div>
		
        <!-- /.box-body -->
        <div class="box-footer">
          <input type="submit" name="hitung" value="hitung">
        </div>
		 </form>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
<?php include "footer.php";?>
 
 