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
          <a href="karyawan_tbh.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Karyawan</h3></a>


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
		
        <div class="box-body">
         <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama</th>
                  <th>Jekel</th>
                  <th>jabatan</th>
                  <th>Tanggal Gaji</th>
                  <th>Gaji</th>
                  <th>Alamat</th>
				  <th>Foto</th>
				  <th>Foto KTP</th>
				<th>No HP</th>
				<th>Hutang</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
					$sql="SELECT * FROM karyawan";
					$exe=mysqli_query($koneksi,$sql);
					while($data=mysqli_fetch_array($exe)){
						$hutang ="Rp. ".number_format($data['hutang'],'0',',','.')."-";
				?>
                <tr>
                  <td><?php echo $data['nama'];?></td>
                  <td><?php echo $data['jekel'];?>
                  </td>
                  
                  <td><?php echo $data['jabatan'];?></td>
                  <td><?php echo $data['tgl_gaji'];?></td>
                  <td><?php echo $data['jum_gaji'];?></td>
                  
				  <td><?php echo $data['alamat'];?></td>
				   <td><a href="foto/<?php echo $data['foto'];?>" class="fancybox" rel="group"><img src="foto/<?php echo $data['foto'];?>" width="100" height="100"></a></td>
				   
				   <td><a href="foto/ktp/<?php echo $data['ktp'];?>" class="fancybox" rel="group"><img src="foto/ktp/<?php echo $data['ktp'];?>" width="100" height="100"></a></td>
				   <td><?php echo $data['nohp'];?></td>
				   <td><?php echo $hutang;?></td>
				  <td>
				 <a class="btn btn-warning" href="karyawan_edit.php?id_karyawan=<?php echo $data['id'];?>"> <span class="glyphicon glyphicon-pencil">Edit</span></a>&nbsp;&nbsp;&nbsp;
				 
				 <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='karyawan_hapus.php?id_karyawan=<?php echo $data['id']; ?>' }"  class="glyphicon glyphicon-trash">Hapus</a>
				  
				  </td>
                </tr>
					<?php } ?>
                
                
              </table>
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
 
  

<!-- Add fancyBox -->
<link rel="stylesheet" href="source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="source/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>