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
          <a href="PurchaseOrderMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tpurchaseorder" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Purchase Order Number</th>
                  <th>Detail</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Pembayaran</th>
                  <th>Tanggal Pembayaran</th>
				          <th>Total</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
                    // $limit = $_GET['length'];
                    // $offset = $_GET['start'];
					$sql="SELECT
                    a.`Code`,
                    Date(a.TanggalPembelian) as Tanggal,
                    b.nama_suplier,
                    CASE
                        WHEN Pembayaran = 1 then 'Cash' else 'Credit' end Pembayaran,
                    Date(a.TanggalPembayaran) as TanggalPembayaran,
                    a.Total,
                    a.Id
                    FROM
                    purchaseorder AS a
                    LEFT JOIN suplier AS b ON a.Supplier = b.id_suplier
                    where 
                    1=1
                    and a.status = 1
                    Order By a.Code"
                    ;
                    // LIMIT ".$limit." OFFSET ".$offset."";
					          $exe=mysqli_query($koneksi,$sql);
                    while($data=mysqli_fetch_array($exe))
                    {
                        $Total ="Rp. ".number_format($data['Total'],'0',',','.')."-";
				        ?>
                        <tr>
                            <td><?php echo $data['Code'];?></td>
                            <td><a href="PurchaseOrderDetailList.php?id=<?php echo $data['Id'];?>">Detail</a></td>
                            <td><?php echo $data['Tanggal'];?></td>
                            <td><?php echo $data['nama_suplier'];?></td>
                            <td><?php echo $data['Pembayaran'];?></td>
                            <td><?php echo $data['TanggalPembayaran'];?></td>
                            <td><?php echo $Total;?></td>
                            <td>
                                <a class="btn btn-warning" href="PurchaseOrderMainEdit.php?id=<?php echo $data['Id'];?>"> <span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='PurchaseOrderMainDelete.php?id=<?php echo $data['Id']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
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
    $('#tpurchaseorder').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 