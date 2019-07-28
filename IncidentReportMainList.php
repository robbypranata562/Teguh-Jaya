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
          <a href="IncidentReportMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Incident</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tIncidentReport" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Detail</th>
                    <th>Tanggal</th>
                    <th>Pelapor</th>
                    <th>Total Item</th>
                    <th>Deskripsi</th>
                    <th>Nominal</th>
                    
                </tr>
                </thead>
                <tbody>
				<?php
					$sql= "
                  SELECT
                  a.`Code`,
                  Date(a.Date) as Date,
                  a.ReportBy,
                  count(b.Id) AS JumlahBarang,

                  a.Description,
                  a.Total,
                  a.id
                  FROM
                  incident AS a
                  LEFT JOIN incidentdetail AS b ON a.Id = b.IncidentId
                  group by a.id
                  ORDER BY
                  a.Code DESC
                ";
					          $exe=mysqli_query($koneksi,$sql);
                    while($data=mysqli_fetch_array($exe))
                    {
                      $Total ="Rp. ".number_format($data['Total'],'0',',','.')."-";
				            ?>
                        <tr>
                            <td><?php echo $data['Code'];?></td>
                            <td><a href="IncidentReportDetailList.php?id=<?php echo $data['id'];?>">Detail</a></td>
                            <td><?php echo $data['Date'];?></td>
                            <td><?php echo $data['ReportBy'];?></td>
                            <td><?php echo $data['JumlahBarang'];?></td>
                            <td><?php echo $data['Description'];?></td>
                            <td><?php echo $Total;?></td>
                        </tr>
            <?php   } ?>
              </table>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
<script>
    $('#tIncidentReport').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true
    });
</script>
 
 