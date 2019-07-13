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
          if (isset($_POST['simpanmain']))
          {
            $ItemId = $_POST['id_barang'];
            $Qty = $_POST['qty'];
            $Satuan = $_POST['satuan_barang'];
            $Session = $_SESSION['nama'];
            $Id = $_POST['soid'];
            $Konversi = $_POST['konversi'];
            $sql_update_item =  "
            Update 
            SalesOrderDetail Set
            ItemId = '".$ItemId."',
            Qty = '".$Qty."',
            Satuan = '".$Satuan."',
            Konversi = '".$Konversi."',
            Pengubah = '".$Session."',
            Diubah =  NOW()
            where
            Id = '".$Id."'
            ";
            //$exe=mysqli_query($koneksi,$sql_Sales_order_main);
            if($koneksi->query($sql_update_item) === TRUE)
            {
                echo ("<script>location.href='SalesOrderMainList.php';</script>");
            }
            else
            {
              echo    "<div class='alert alert-danger'>
              <a class='close' data-dismiss='alert' href='#'>&times;</a>
              <strong>Success!</strong> Data Item Gagal Diubah
              </div>";
            }
          }
          ?>
          <?php
            $id = $_GET['id'];
            $sql="
            SELECT
                a.ItemId,
                b.NamaBarang,
                a.Satuan,
                a.Konversi,
                a.Qty,
                b.SatuanKonversi,
                b.JumlahSatuanBesar,
                b.JumlahSatuanKecil,
                d.nama_pelanggan,
                a.id,
                a.SalesOrderId
            FROM
                Salesorderdetail AS a
                LEFT JOIN item AS b ON a.ItemId = b.id
                LEFT JOIN Salesorder AS c ON a.SalesOrderId = c.Id
                LEFT JOIN pelanggan AS d ON c.Customer = d.id_pelanggan
            where 
                a.id = '".$id."'";
            // print_r($sql);
            $exe = mysqli_query($koneksi,$sql);
            while ($data = mysqli_fetch_array($exe))
            {
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class>
                <input type="hidden" id="soid" name="soid" value = "<?php echo $data['id'] ?>"/>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" value="<?php echo $data["NamaBarang"] ?>"  >
                            <input  type="hidden" name="id_barang" id="id_barang" value="<?php echo $data["ItemId"] ?>" />
                            <input  type="hidden" name="konversi" id="konversi" value="<?php echo $data["Konversi"] ?>" />
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat" name="tambah">Tambah</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Satuan Barang</label>
                        <div class>
                            <select class="form-control select2"   style="width: 100%;" name="satuan_barang" id="satuan_barang">
                            <?php
                                $sql_uom="SELECT SatuanBesar FROM Item where Id =  '".$data['ItemId']."'";
                                // print_r($sql_uom);
                                $exe_uom=mysqli_query($koneksi,$sql_uom);
                                while($data_uom = mysqli_fetch_array($exe_uom))
                                {
                                ?>
                                    <?php if ($data['Satuan'] == $data_uom['SatuanBesar']){?>
                                            <option value=<?php echo $data_uom['SatuanBesar'];?> selected><?php echo $data_uom['SatuanBesar'];?></option>
                                            <option value="Pcs">Pcs</option>
                                    <?php } else { ?>
                                            <option value=<?php echo $data_uom['SatuanBesar'];?>><?php echo $data_uom['SatuanBesar'];?></option>
                                            <option value="Pcs" selected>Pcs</option>
                                    <?php } ?>
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Satuan Besar</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_besar" id="jumlah_satuan_besar" value="<?php echo $data["JumlahSatuanBesar"] ?>"  readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Satuan Kecil</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_kecil" id="jumlah_satuan_kecil" value="<?php echo $data["JumlahSatuanKecil"] ?>"" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $data['Qty'] ?>"/>
                        </div>
                    </div>
                </div>              
                <div class="box-footer">
                    <input type="submit" name="simpanmain" class="btn btn-primary" value="Simpan">
                </div>
            </form>
            <?php } ?>
          </div>
        </div>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
	$(document).ready(function() {
        $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_item_for_sales_order.php", { term : $("#nama_barang").val()}, 
                response)},
                select: function(event, ui) 
                {
                    $('#satuan_barang').empty()
                    var e = ui.item;
                    $("#id_barang").val(e.id);
                    $("#nama_barang").val(e.NamaBarang);
                    $("#konversi").val(e.satuankonversi);
                    $("#satuan_barang").append(new Option(e.satuanbesar, e.satuanbesar));
                    $("#satuan_barang").append(new Option("Pcs", "Pcs"));
                    $("#jumlah_satuan_kecil").val(e.JumlahSatuanKecil)
                    $("#jumlah_satuan_besar").val(e.JumlahSatuanBesar)
                    
                }
            });

            $("#qty").on('keyup change click', function () {
                var satuan = $("#satuan_barang").val();
                if (satuan == "Pcs")
                {
                    var TotalPrice = this.value * $("#unit_price_satuan_kecil").val();
                    $("#total_price").val(TotalPrice); 
                }
                else
                {
                    var TotalPrice = this.value * $("#unit_price_satuan_besar").val();
                    $("#total_price").val(TotalPrice); 
                }
            });
    })
</script>