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
	  <div class="col-md-9">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Laporan Barang per Bulan</h3>

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
		
                <label>Pilih Bulan</label>
                <select class="form-control select2" style="width: 100%;" name="tgl">
				<option value="">Pilih Bulan :</option>
                  <?php
					$sqlhistory="SELECT jual_hargaakhir,CONCAT(YEAR(tanggal),'-',MONTH(tanggal))  AS tahun_bulan FROM barang_terjual
            GROUP BY YEAR(tanggal),MONTH(tanggal) " ;
					
					$exe=mysqli_query($koneksi,$sqlhistory);
					while($data=mysqli_fetch_array($exe)){
             $tahun =$data['tahun_bulan'];
				  ?>

                  <option name="tgl" value=<?php echo $tahun;?>><?php echo $tahun;?></option>
                 <?php } ?>
                </select>
              </div>
			  <input type="submit" name="cari" class="btn btn-primary" value="Cari">
				
                
                <br>
<div><table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Terjual</th>
                  <th>Modal</th>
                  <th>Harga Jual</th>
				  <th>Keuntungan</th>
                </tr>
                </thead>
                <tbody>
				<?php
				error_reporting(0);
         //$q = intval($_GET['q']);
		 if(isset($_POST['cari'])){
		 $tgl_his=$_POST['tgl'];
		 $pecah=explode("-",$tgl_his);
		 $thn=$pecah[0];
		 $bln=$pecah[1];

$sql="SELECT* FROM barang_terjual,stok_toko where barang_terjual.id_barangtoko=stok_toko.id_toko AND MONTH(barang_terjual.tanggal)='$bln' AND YEAR(barang_terjual.tanggal)='$thn'";
$result = mysqli_query($koneksi,$sql);

while($row = mysqli_fetch_array($result)) {
                 $hrg_jual=$row['jual_hargaakhir'] * $row['jual_jumlah'];
				 $hrg_modal=$row['modal_toko'] * $row['jual_jumlah'];
				 $untung= $hrg_jual - $hrg_modal;
				 $tot_ += $hrg_modal;
				 $tot__ += $hrg_jual;
				 $tot___ += $untung;
				 $tot_modal ="Rp. ".number_format($tot_,'0',',','.');
				 $tot_jual ="Rp. ".number_format($tot__,'0',',','.');
				 $tot_untung ="Rp. ".number_format($tot___,'0',',','.');
				
				?>
                <tr>
                  <td><?php echo $row['tanggal'];?></td>
                  <td><?php echo $row['nama_toko'];?></td>
                   <td><?php echo $row['jual_jumlah'];?></td>
                  <td><?php echo $hrg_modal;?></td>
                  <td><?php echo $hrg_jual;?></td>
                  <td><?php echo $untung;?></td>
                
                  
				
				  
                </tr>
					<?php }
		 }
					?>
                
                
              </table></div>
        </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
            
			
      
      </div>
	  </div>
      <!-- /.box -->
<div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Keuangan</h3>
            </div>
            <div class="box-body">


              
              <div class="form-group">

   
      <div>
         
                   
              <div class="box-body">
             
        
       
        
        <div class="box-footer">
                
              </div>
        
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
    </div>
  </div>

  


 
  

                  
       

       
          
           
              <!-- /.form group -->
             
<div class="row justify">
  <div class="col-sm-5 col-md-5">
    <div class="bord">
     
        Modal <br><br>
   
        <label class="justify" ><font color="#F44336"><label id="hutang" name="huntang" value=""></h3><?php echo $tot_modal;?></font></label>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
      
    </div>
  </div>

   <div class="col-sm-5 col-md-5">
    <div class="bord">
     
        Total Jual<br><br>
   
        <label> <font color="#2196F3"><label id="saldo" name="saldo" value=""></h3><?php echo $tot_jual;?></font></label>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
      
    </div>
  </div>
  <div class="col-sm-5 col-md-5">
    <div class="bord">
     
        Keuntungan<br><br>
   
        <label> <font color="#2186D3"><label id="saldo" name="saldo" value=""></h3><?php echo $tot_untung;?></font></label>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
      
    </div>
  </div>
  
  
  </div>
</div>    



         
         
      
          <!-- Custom Tabs -->
         
        <!-- /.col -->

       
        <!-- /.col -->
      </div>
   
     
            <!-- /.box-body -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  </form>
  <!-- /.content-wrapper -->
  
  
  
<?php include "footer.php";?>
 
 