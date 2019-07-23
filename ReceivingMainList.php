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
          <a href="ReceivingMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
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
                    <th>Code</th>
                    <th>Detail</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Biaya Pengiriman</th>
                    <th>BIaya Ekstra</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
				<?php
					$sql="
                    SELECT
                        a.`Code`,
                        Date(a.Date) Date,
                        b.nama_suplier,
                        a.CostDelivery,
                        a.CostExtra,
                        a.Total,
                        a.Id
                    FROM
                        receiving AS a
                    LEFT JOIN suplier AS b ON a.Supplier = b.id_suplier
                    Order By Date Desc";
                    $k=mysqli_query($koneksi,$sql);
                    if(mysqli_num_rows($k) > 0 )
                    {
                      while($data=mysqli_fetch_array($k))
                        {
                        $BiayaPengiriman ="Rp. ".number_format($data['CostDelivery'],'0',',','.')."-";
                        $BiayaEkstra ="Rp. ".number_format($data['CostExtra'],'0',',','.')."-";
                        $Total ="Rp. ".number_format($data['Total'],'0',',','.')."-";
                    ?>
                        <tr>
                            <td><?php echo $data['Code'];?></td>
                            <td><a href="ReceivingDetailList.php?id=<?php echo $data['Id'];?>">Detail</a></td>
                            <td><?php echo $data['Date'];?></td>
                            <td><?php echo $data['nama_suplier'];?></td>
                            <td><?php echo $BiayaPengiriman;?></td>
                            <td><?php echo $BiayaEkstra;?></td>
                            <td><?php echo $Total;?></td>
                        </tr>
            <?php     }
                    } ?>
              </table>
        </div>
      </div>
    </section>
  </div>
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
 
 