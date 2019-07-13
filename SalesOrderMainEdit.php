<?php 
    include "header.php";
    include "koneksi.php";
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
        <div class="box">
          <div class="box-header with-border">
                  <h3 class="box-title">Sales Order Edit</h3>
                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
          </div>
          <div class="box-body">
          <?php 
          if (isset($_POST['ubah'])){
          
            print_r($_POST);
            $id = $_POST['SOID'];
            $code=$_POST['code'];
            $tanggal=$_POST['tanggal'];
            $suplier=$_POST['Pelanggan'];
            $tipe_pembayaran=$_POST['tipe_pembayaran'];
            $tanggal_pembayaran = !empty($_POST['tanggal_pembayaran']) ? $_POST['tanggal_pembayaran'] : "NULL";
            if ($tipe_pembayaran == "1"){
              $tanggal_pembayaran = "NULL";
            }
            $sql_Sales_order_main= "Update SalesOrder Set 
            Code = '".$code."',
            Date = '".$tanggal."',
            Customer = '".$suplier."',
            Pembayaran = '".$tipe_pembayaran."',
            TanggalPembayaran = '".$tanggal_pembayaran."'
            where Id = '".$id."'";
            print_r($sql_Sales_order_main);
            //$exe=mysqli_query($koneksi,$sql_Sales_order_main);
            if($koneksi->query($sql_Sales_order_main) === TRUE)
            {
              echo ("<script>location.href='SalesOrderMainList.php';</script>");
            }
            else
            {
              echo    "<div class='alert alert-danger'>
              <a class='close' data-dismiss='alert' href='#'>&times;</a>
              <strong>Error!</strong> Data Sales Order Gagal Diubah
              </div>";
            }
          }
          ?>
          <?php
            $id = $_GET['id'];
            $sql="SELECT
            a.Id,
            a.`Code`,
            Date(a.Date) as Date,
            a.Customer,
            a.Pembayaran,
            Date(a.TanggalPembayaran) as TanggalPembayaran
            FROM
                salesorder AS a
            WHERE
                a.Id = '$id'";
            $exe=mysqli_query($koneksi,$sql);
           
            while ($data=mysqli_fetch_array($exe))
            {
              //print_r($exe);
            ?>
              
              <form role="form" action="" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <input type="hidden" name="SOID" class="form-control" id="SOID" value="<?php echo $data['Id'];?>" >
                  </div>
                  <div class="form-group">
                    <label>Sales Order Code</label>
                    <input type="text" name="code" class="form-control" id="code"  value="<?php echo $data['Code'];?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputDate">Tanggal Order</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    <input type="text" class="form-control pull-right" id="tanggal" name="tanggal" value="<?php echo $data['Date'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class = "form-label">Suplier</label>
                    <div class>
                    <select class="form-control" style="width: 100%;" name="Pelanggan" id="Pelanggan">
                            <?php
                                $sql_supplier="SELECT id_pelanggan , nama_pelanggan FROM Pelanggan";
                                $exe_supplier=mysqli_query($koneksi,$sql_supplier);
                                while($data_supplier=mysqli_fetch_array($exe_supplier))
                                {
                                ?>
                                    <?php 
                                      if ($data['Customer'] == $data_supplier['id_pelanggan']) { ?>
                                        <option value=<?php echo $data_supplier['id_pelanggan'];?> selected><?php echo $data_supplier['nama_pelanggan'];?></option>
                                    <?php } else { ?>
                                        <option value=<?php echo $data_supplier['id_pelanggan'];?>><?php echo $data_supplier['nama_pelanggan'];?></option>
                                   <?php } ?>
                                    
                                <?php 
                                } 
                                ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Pembayaran</label>
                    <div class>
                        <select class="form-control select2"   style="width: 100%;" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="0">Pilih Metode Pembayaran :</option>
                            <?php if ($data['Pembayaran'] == 1) { ?>
                                  <option value="1" selected>Cash</option>
                                  <option value="2">Credit</option>
                           <?php } else { ?>
                                  <option value="1" >Cash</option>
                                  <option value="2" selected>Credit</option> <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="columnTanggalPembayaran">
                    <label for="exampleInputDate">Tangal Pembayaran</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tanggal_pembayaran" name="tanggal_pembayaran" value = <?php echo $data['TanggalPembayaran'] ?>>
                    </div>
                </div>
                  <div class="box-footer">
                    <input type="submit" name="ubah" class="btn btn-primary" value="Ubah">
                  </div>
              <form>
			    <?php } ?>
          </div>
        </div>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
	$(document).ready(function() {

        $('#tanggal_pembayaran').datepicker({
                autoclose: true
            });

      if ($("#tipe_pembayaran").val() == 1)
      {
        $("#columnTanggalPembayaran").addClass('hide');
      }
      else
      {
        $("#columnTanggalPembayaran").removeClass('hide');
      }

      $("#tipe_pembayaran").on('change',function(e){
                if (this.value == 1)
                {
                    $("#columnTanggalPembayaran").addClass('hide');
                }
                else{
                    $("#columnTanggalPembayaran").removeClass('hide');
                }
            });
    })
</script>