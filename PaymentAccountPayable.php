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
            $customer = $_POST["pelanggan"];
            $tanggal = $_POST["tanggal"];
            $TotalPR = $_POST["pembayaran"];
            $Session = $_SESSION['nama'];
            $insert_ar_payment = "Insert Into APPayment
            (
                customer_id,
                date,
                total,
                pembuat,
                dibuat
            )
            values
            (
                '".$customer."',
                '".$tanggal."',
                '".$TotalPR."',
                '".$Session."', 
                NOW()
            )";
            if ($koneksi->query($insert_ar_payment) === TRUE)
            {
                echo ("<script>location.href='ListAccountPayable.php';</script>");
            }
        }
        ?>
        <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="form-group">
                        <label class = "form-label"> Pelanggan </label>
                        <div class>
                        <select class="form-control" style="width: 100%;" name="pelanggan" id="pelanggan">
                        <option value="">Pilih Pelanggan:</option>
                                <?php
                                    $sql="SELECT id_pelanggan , nama_pelanggan FROM pelanggan";
                                    $exe=mysqli_query($koneksi,$sql);
                                    while($data=mysqli_fetch_array($exe))
                                    {
                                    ?>
                                        <option value=<?php echo $data['id_pelanggan'];?>><?php echo $data['nama_pelanggan'];?></option>
                                    <?php 
                                    } 
                                    ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sisa Piutang</label>
                        <div class="">
                            <input type="text" class="form-control" name="SisaPiutang" id="SisaPiutang" readonly/>
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
      $( "#pelanggan" ).on('change',function(){
        $.ajax({
                url: 'search_AP_By_Customer.php',
                type: 'POST',
                dataType: "json",
                data:
                {
                  customer_id: this.value
                }
            }).success(function(data){
              $("#SisaPiutang").val(data[0]['Piutang']);
            }).error(function(data){
                
            });
        });
    })
</script>
 
 
