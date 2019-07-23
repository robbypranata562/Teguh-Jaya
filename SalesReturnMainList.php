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
          <a href="SalesReturnMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Retur Penjualan</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tsalesreturn" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Detail</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
				<?php
					$sql="SELECT
                    a.`Code`,
                    Date(a.Date) AS Tanggal,
                    b.nama_pelanggan,
                    a.Total,
                    a.Id
                    FROM
                        salesreturn AS a
                    LEFT JOIN pelanggan AS b ON a.customer = b.id_pelanggan
                    where 
                    1=1";
                        $k=mysqli_query($koneksi,$sql);
                        if(mysqli_num_rows($k) > 0 )
                        {
                            while($row=mysqli_fetch_array($k))
                            {
                                $Total ="Rp. ".number_format($row['Total'],'0',',','.')."-";
                                ?>
                                <tr>
                                    <td><?php echo $row['Code'];?></td>
                                    <td><a href="SalesReturnDetailList.php?id=<?php echo $row['Id'];?>">Detail</a></td>
                                    <td><?php echo $row['Tanggal'];?></td>
                                    <td><?php echo $row['nama_pelanggan'];?></td>
                                    <td><?php echo $Total;?></td>
                                </tr>
                    <?php   }
                        }  ?>

              </table>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
<script>
    $('#tsalesreturn').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 