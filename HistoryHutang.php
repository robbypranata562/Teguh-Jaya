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
              <th>Suplier</th>
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
          HistoryAR.nama_suplier,
          HistoryAR.Tanggal,
          sum(HistoryAR.Credit) AS Credit,
          sum(HistoryAR.Debit) AS Debit
        FROM
          (
            SELECT
              b.nama_suplier,
              Date(a.date) AS Tanggal,
              a.total AS Credit,
              0 AS Debit
            FROM
              ar AS a
            LEFT JOIN suplier AS b ON a.supplier_id = b.id_suplier
            WHERE
            id_suplier = ".$supplier_id."
            UNION ALL
              SELECT
                b.nama_suplier,
                Date(a.date) AS Tanggal,
                0 AS Credit,
                a.total AS Debit
              FROM
                arpayment AS a
              LEFT JOIN suplier AS b ON a.supplier_id = b.id_suplier
              WHERE
                id_suplier = ".$supplier_id."
          ) HistoryAR
        GROUP BY
          HistoryAR.nama_suplier,
          HistoryAR.Tanggal";
          $exe=mysqli_query($koneksi,$sql);
          while($data=mysqli_fetch_array($exe))
          {
            $TotalCredit ="Rp. ".number_format($data['Credit'],'0',',','.')."-";
            $TotalDebit ="Rp. ".number_format($data['Debit'],'0',',','.')."-";
            ?>
           <tr>
            <td><?php echo $data['nama_suplier'];?></td>
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
 
 