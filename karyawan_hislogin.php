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
          


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <?php
        	if(isset($_POST['hapus_semua'])){
        		$login = $_POST['pilih'];
        		$jum_login =  count($login);
        		
        		for($x=0;$x<$jum_login;$x++){
        			$sql="DELETE FROM his_login WHERE id_login='$login[$x]'";
        			$exe=mysqli_query($koneksi,$sql);
        		}
        		
        	}
        ?>
		
        <div class="box-body">
        <form action="" method="post" role="form">
         <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
				                  <th>Waktu Login</th>

					<th>Nama Lengkap</th>
                  <th>Username</th>
				  
                  <th>Level</th>
                  
                  
                 
				  <th><button class="btn btn-danger" name="hapus_semua" class="glyphicon glyphicon-trash">Hapus</button></th>
                </tr>
                
                </thead>
                <tbody>
				<?php
					$sql="SELECT * FROM his_login  group by tanggal";
            // $sql="SELECT uname,level,COUNT(*) AS `jumlahlogin`, DATE_FORMAT(tanggal, '%Y-%m-%d') AS `tanggal` 
            //   FROM `his_login` GROUP BY `id_karyawan";
					$exe=mysqli_query($koneksi,$sql);
					while($data=mysqli_fetch_array($exe)){
				?>
                <tr>
				<td><?php echo $data['tanggal'];?></td>
                  <td><?php echo $data['uname'];?></td>
				  <td><?php echo $data['uname'];?></td>
				  <td><?php echo $data['level'];?></td>
					
                  
				  
				   
				  <td>
				
				 <input type="checkbox" name="pilih[]" value="<?php echo $data['id_login']?>">
				 
				  </td>
                </tr>
					<?php } ?>
                
                
              </table>
              </form>
        </div>
		
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>
 
 