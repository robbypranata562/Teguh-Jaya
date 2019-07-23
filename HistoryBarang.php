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
          <table id="titemhistory" class="table table-bordered table-striped">
          <?php $jabatan=$_SESSION['level']?>  

          <thead>
          <tr>
              <th>Tanggal</th>
              <th>Nama Barang</th>
              <th>Income</th>
              <th>Outcome</th>
              <th>Result</th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <?php
          $item_id = $_GET['id'];
          $sql="SELECT
          main.Tanggal,
          main.NamaBarang,
          sum(main.Income) Income,
          sum(main.Outcome) Outcome,
          (sum(main.Income) - sum(main.Outcome)) AS Result
        FROM
          (
            SELECT
              Date(c.Date) AS Tanggal,
              b.NamaBarang,
              CASE
            WHEN a.UOM = 'Pcs' THEN
              a.ReceivingQty
            ELSE
              a.ReceivingQty * a.Konversi
            END AS Income,
            0 AS Outcome
          FROM
            receivingdetail a
          LEFT JOIN item b ON a.ItemId = b.id
          LEFT JOIN receiving c ON a.ReceivingId = c.Id
          WHERE
            a.ItemId = '".$item_id."'
          UNION
            SELECT
              Date(c.Date) AS Tanggal,
              b.NamaBarang,
              0 AS Income,
              CASE
            WHEN a.UOM = 'Pcs' THEN
              a.DeliveryQty
            ELSE
              a.DeliveryQty * a.Konversi
            END AS Outcome
            FROM
              deliveryorderdetail a
            LEFT JOIN item b ON a.ItemId = b.id
            LEFT JOIN deliveryorder c ON a.DeliveryId = c.Id
            WHERE
            a.ItemId = '".$item_id."'
          ) main
        GROUP BY main.Tanggal,main.NamaBarang";
          $exe=mysqli_query($koneksi,$sql);
          while($data=mysqli_fetch_array($exe))
          {
            ?>
           <tr>
            <td><?php echo $data['Tanggal'];?></td>
            <td><?php echo $data['NamaBarang'];?></td>
            <td><?php echo $data['Income'];?></td>
            <td><?php echo $data['Outcome'];?></td>
            <td><?php echo $data['Result'];?></td>
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
    $('#titemhistory').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
        "scrollX": true
    });
</script>
 
 