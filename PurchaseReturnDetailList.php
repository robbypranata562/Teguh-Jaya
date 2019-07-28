<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="PurchaseOrderDetailCreate.php?id=<?php echo $_GET['id']; ?>"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tpurchasereturndetail" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NamaBarang</th>
                  <th>Satuan</th>
                  <th>Qty</th>
                  <th>Konversi</th>
                  <th>Harga</th>
                  <th>Total Harga</th>
                </tr>
                </thead>
                <tbody>
				<?php
          $id = $_GET['id'];
					$sql="SELECT
                    b.NamaBarang,
                    a.Satuan,
                    a.Qty,
                    b.SatuanKonversi as Konversi,
                    format(a.UnitPrice,2) UnitPrice,
                    format(a.TotalPrice,2) TotalPrice,
                    a.Id
                FROM
                    purchasereturndetail AS a
                LEFT JOIN item AS b ON a.ItemId = b.id
                WHERE
                    a.PurchaseReturnId = '$id'";
                    // LIMIT ".$limit." OFFSET ".$offset."";
					          $exe=mysqli_query($koneksi,$sql);
                    while($data=mysqli_fetch_array($exe))
                    {
				            ?>
                        <tr>
                            <td><?php echo $data['NamaBarang'];?></td>
                            <td><?php echo $data['Satuan'];?></td>
                            <td><?php echo $data['Qty'];?></td>
                            <td><?php echo $data['Konversi'];?></td>
                            <td><?php echo $data['UnitPrice'];?></td>
                            <td><?php echo $data['TotalPrice'];?></td>
                        </tr>
            <?php   } ?>
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
    $('#tpurchasereturndetail').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 