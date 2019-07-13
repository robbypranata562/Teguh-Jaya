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
          <a href="DeliveryOrderMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tDeliveryorder" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Detail</th>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
					$sql="
                    SELECT
                        a.`Code`,
                        Date(a.Date) Date,
                        a.Type,
                        Date(a.PaymentDate) PaymentDate,
                        b.nama_pelanggan,
                        a.Total,
                        a.Id
                    FROM
                        deliveryorder AS a
                        LEFT JOIN pelanggan AS b ON a.Customer = b.id_pelanggan
                    ORDER BY 
                        a.Date desc";
					$exe=mysqli_query($koneksi,$sql);
                    while($data=mysqli_fetch_array($exe))
                    {
                        $Total ="Rp. ".number_format($data['Total'],'0',',','.')."-";
				        ?>
                        <tr>
                            <td><?php echo $data['Code'];?></td>
                            <td><a href="DeliveryOrderDetailList.php?id=<?php echo $data['Id'];?>">Detail</a></td>
                            <td><?php echo $data['Date'];?></td>
                            <td><?php echo $data['Type'];?></td>
                            <td><?php echo $data['PaymentDate'];?></td>
                            <td><?php echo $data['nama_pelanggan'];?></td>
                            <td><?php echo $Total;?></td>
                            <td>
                                <a class="btn btn-warning" href="DeliveryOrderMainEdit.php?id=<?php echo $data['Id'];?>"> <span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                <a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='DeliveryOrderDelete.php?id=<?php echo $data['Id']; ?>' }"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                            </td>
                        </tr>
            <?php   } ?>
              </table>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
<script>
    $('#tDeliveryorder').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 