<?php include "header.php";?>
<?php include 'koneksi.php'; ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grosir</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		<?php
        if (isset($_POST['simpan']))
        {
            $suplier = $_POST["suplier_name"];
            $tanggal = $_POST["tanggal"];
            $TotalPR = $_POST["pembayaran"];
            $Session = $_SESSION['nama'];
            $insert_ar_payment = "Insert Into ARPayment
            (
                supplier_id,
                date,
                total,
                pembuat,
                dibuat
            )
            values
            (
                '".$suplier."',
                '".$tanggal."',
                '".$TotalPR."',
                '".$Session."',
                NOW()
            )";
            if ($koneksi->query($insert_ar_payment) === TRUE)
            {
                echo ("<script>location.href='ListAccountReceiveable.php';</script>");
            }
        }
        ?>
        <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="form-group">
                        <label class = "form-label"> Suplier </label>
                        <div class>
                        <select class="form-control" style="width: 100%;" name="suplier_name" id="suplier_name">
                                <?php
                                    $sql="SELECT id_suplier , nama_suplier FROM Suplier";
                                    $exe=mysqli_query($koneksi,$sql);
                                    while($data=mysqli_fetch_array($exe))
                                    {
                                    ?>
                                        <option value=<?php echo $data['id_suplier'];?>><?php echo $data['nama_suplier'];?></option>
                                    <?php
                                    }
                                    ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDate">Tanggal Pembayaran</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input autocomplete="off" type="text" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pembayaran</label>
                        <div class="">
                            <input type="text" class="form-control" name="pembayaran" id="pembayaran"/>
                        </div>
                    </div>
                    <div class="box-footer">
                    <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
                </div>
            <form>
        </div>
		</div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
      $('#tanggal').datepicker({
                autoclose: true
            });
    })
</script>
