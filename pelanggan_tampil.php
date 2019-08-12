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
          <a href="pelanggan_tbh.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Pelanggan</h3></a>


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
                  <th>Lihat Detail Piutang</th>
                  <th>Nama Pelanggan</th>
                  <th>Alamat</th>
                  <th>Saldo</th>
                  <th>No Handphone</th>
                  <th>Total Hutang</th>
                  <th>Total Bayar</th>
                  <th>Sisa</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
					$sql="SELECT
          customer.id_pelanggan,
          customer.nama_pelanggan,
          customer.alamat,
          customer.saldo,
          customer.nohp,
          (
            SELECT
              ifnull(sum(aa.total), 0)
            FROM
              ap AS aa
            WHERE
              aa.customer_id = customer.id_pelanggan
          ) AS TotalHutang,
          (
            SELECT
              ifnull(sum(aa.total), 0)
            FROM
              appayment AS aa
            WHERE
              aa.customer_id = customer.id_pelanggan
          ) AS TotalPembayaranHutang
        FROM
          pelanggan customer
        
        
        ";
					$exe=mysqli_query($koneksi,$sql);
					while($data=mysqli_fetch_array($exe)){
                $SisaHutang = $data['TotalHutang'] - $data['TotalPembayaranHutang'];
                $hutang ="Rp. ".number_format($data['TotalHutang'],'0',',','.')."-";
                $bayarhutang ="Rp. ".number_format($data['TotalPembayaranHutang'],'0',',','.')."-";
                $Sisa ="Rp. ".number_format($SisaHutang,'0',',','.')."-";
                
          ?>
                <tr>
                  <td> <a class="btn btn-warning" href="HistoryPiutang.php?id=<?php echo $data['id_pelanggan'];?>"> <span class="glyphicon glyphicon-pencil"></span> Detail Hutang</a></td>
                  <td><?php echo $data['nama_pelanggan'];?></td>
                  <td><?php echo $data['alamat'];?></td>
                  <td><?php echo $data['saldo'];?></td>
				          <td><?php echo $data['nohp'];?></td>
                  <td><?php echo $hutang; ?></td>
				          <td><?php echo $bayarhutang;?></td>
                  <td><?php echo $Sisa;?></td>
                  <td>
                      <a class="btn btn-warning" href="pelanggan_ubah.php?id=<?php echo $data['id_pelanggan'];?>"> <span class="glyphicon glyphicon-pencil"></span> Edit</a>
                      <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='pelanggan_hapus.php?id=<?php echo $data['id_pelanggan']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                  </td>
                </tr>
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
 
 