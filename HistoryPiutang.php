<?php include "header.php";?>
  <div class="content-wrapper">
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
	 <?php $jabatan=$_SESSION['level']?>
        <div class="box-header with-border">

		<?php if ($jabatan=='Super Admin'or $jabatan=='Super Super Admin' or $jabatan=='Stok Admin'){
		?>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
		
        <div class="box-body">
          <table id="tARhistory" class="table table-bordered table-striped">
          <?php $jabatan=$_SESSION['level']?>  

          <thead>
          <tr>
              <th>Customer</th>
              <th>Tanggal</th>
              <th>Credit</th>
              <th>Debit</th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php
          $supplier_id = $_GET['id'];
          $sql="SELECT
          HistoryAP.nama_pelanggan,
          HistoryAP.Tanggal,
          sum(HistoryAP.Credit) AS Credit,
          sum(HistoryAP.Debit) AS Debit
        FROM
          (
            SELECT
              b.nama_pelanggan,
              Date(a.date) AS Tanggal,
              a.total AS Credit,
              0 AS Debit
            FROM
              ap AS a
            LEFT JOIN pelanggan AS b ON a.customer_id = b.id_pelanggan
            WHERE
            b.id_pelanggan = '$supplier_id'
            union
              SELECT
                b.nama_pelanggan,
                Date(a.date) AS Tanggal,
                0 AS Credit,
                a.total AS Debit
              FROM
                appayment AS a
              LEFT JOIN pelanggan AS b ON a.customer_id = b.id_pelanggan
              WHERE
                b.id_pelanggan = '$supplier_id'
          ) HistoryAP
        GROUP BY
          HistoryAP.nama_pelanggan,
          HistoryAP.Tanggal";
          $exe=mysqli_query($koneksi,$sql);
          while($data=mysqli_fetch_array($exe))
          {
            $TotalCredit ="Rp. ".number_format($data['Credit'],'0',',','.')."-";
            $TotalDebit ="Rp. ".number_format($data['Debit'],'0',',','.')."-";
            ?>
           <tr>
            <td><?php echo $data['nama_pelanggan'];?></td>
            <td><?php echo $data['Tanggal'];?></td>
            <td><?php echo $TotalCredit;?></td>
            <td><?php echo $TotalDebit;?></td>
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

<script>
    $('#tARhistory').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
        "scrollX": true
    });
</script>
 
 