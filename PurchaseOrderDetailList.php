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
         <table id="tpurchaseorderdetail" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NamaBarang</th>
                  <th>Satuan</th>
                  <th>Qty</th>
                  <th>Konversi</th>
                  <th>Harga</th>
                  <th>Total Harga</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
          $id = $_GET['id'];
					$sql="SELECT
                  b.NamaBarang,
                  a.Satuan,
                  a.Qty,
                  a.Konversi,
                  a.UnitPrice,
                  a.TotalPrice,
                  a.Id
                  FROM
                  purchaseorderdetail AS a
                  LEFT JOIN item AS b ON a.ItemId = b.id
                  WHERE
                  a.PurchaseOrderId = '$id'";
                    // LIMIT ".$limit." OFFSET ".$offset."";
					          $exe=mysqli_query($koneksi,$sql);
                    while($data=mysqli_fetch_array($exe))
                    {
                        $Total ="Rp. ".number_format($data['TotalPrice'],'0',',','.')."-";
                        $UnitPrice ="Rp. ".number_format($data['UnitPrice'],'0',',','.')."-";
				            ?>
                        <tr>
                            <td><?php echo $data['NamaBarang'];?></td>
                            <td><?php echo $data['Satuan'];?></td>
                            <td><?php echo $data['Qty'];?></td>
                            <td><?php echo $data['Konversi'];?></td>
                            <td><?php echo $UnitPrice;?></td>
                            <td><?php echo $Total;?></td>
                            <td>
                                <!-- <a class="btn btn-warning" href="PurchaseOrderDetailEdit.php?id="> <span class="glyphicon glyphicon-pencil"></span> Edit</a> -->
                                <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='PurchaseOrderDetailDelete.php?id=<?php echo $data['Id']; ?> &PurchaseOrderId=<?php echo $_GET['id']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                            </td>
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
    $('#tpurchaseorderdetail').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 