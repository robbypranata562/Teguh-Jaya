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
                  <h3 class="box-title">Purchase Order Edit</h3>
                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
          </div>
          <div class="box-body">
          <?php 
          if (isset($_POST['ubah']))
          {
            $PurchaseOrderId = $_POST['poid'];
            $ItemId = $_POST['id_barang'];
            $Satuan = $_POST['satuan_barang'];
            $Qty = $_POST['qty'];
            $TotalPrice = $_POST['total_price'];
            $Id = $_POST['id'];
            $modal = $_POST['modal'];
            $Session = $_SESSION['nama'];
            $Konversi = $_POST['konversi'];
            if ($Satuan == "Pcs"){
                $UnitPrice = $modal;
            } else {
                $UnitPrice = $modal * $Konversi;
            };

            $sql_update_item =  "Update 
            PurchaseOrderDetail Set
            ItemId = '".$ItemId."',
            Satuan = '".$Satuan."',
            Konversi = '".$Konversi."',
            UnitPrice = '".$UnitPrice."',
            Qty = '".$Qty."',
            TotalPrice = '".$TotalPrice."',
            Pengubah = '".$Session."',
            Diubah =  NOW()
            where
            Id = '".$Id."'
            ";
            //$exe=mysqli_query($koneksi,$sql_purchase_order_main);
            if($koneksi->query($sql_update_item) === TRUE)
            {
                $sql_update_total_PO = "select sum(a.TotalPrice) as TotalAmount from purchaseorderdetail a where a.PurchaseOrderId = '".$PurchaseOrderId."'";
                $exe = mysqli_query($koneksi,$sql_update_total_PO);
                while ($data=mysqli_fetch_array($exe))
                {
                    $sql_update_po = "Update 
                    PurchaseOrder 
                    Set 
                        Total = '".$data['TotalAmount']."',
                        Pengubah = '".$Session."',
                        Diubah =  NOW()
                    where 
                        id = '".$PurchaseOrderId."'";
                    $exe_purchase_order_main = mysqli_query($koneksi,$sql_update_po);
                    echo ("<script>location.href='PurchaseOrderList.php';</script>");
                }

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
                a.UnitPrice,
                a.Qty,
                a.TotalPrice,
                b.SatuanKonversi,
                b.HargaBawah,
                b.HargaAtas,
                d.nama_suplier,
                a.id,
                b.modal,
                a.PurchaseOrderId
            FROM
                purchaseorderdetail AS a
                LEFT JOIN item AS b ON a.ItemId = b.id
                LEFT JOIN purchaseorder AS c ON a.PurchaseOrderId = c.Id
                LEFT JOIN suplier AS d ON c.Supplier = d.id_suplier
            where 
                a.id = '".$id."'";
            // print_r($sql);
            $exe = mysqli_query($koneksi,$sql);
            while ($data = mysqli_fetch_array($exe))
            {
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class>
                    <input type="hidden" id="supplier_name" name="supplier_name" value = "<?php echo $data['nama_suplier'] ?>"/>
                    <input type="hidden" id="id" name="id" value = "<?php echo $data['id'] ?>"/>
                    <input type="hidden" id="poid" name="poid" value = "<?php echo $data['PurchaseOrderId'] ?>"/>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" value = "<?php echo $data['NamaBarang'] ?>" >
                            <input  type="hidden" name="id_barang" id="id_barang" value="<?php echo $data['ItemId'] ?>" />
                            <input  type="hidden" name="modal" id="modal" value="<?php echo $data['modal'] ?>" />
                            <input  type="hidden" name="konversi" id="konversi" value="<?php echo $data['SatuanKonversi'] ?>" />
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
                                $sql_uom="SELECT SatuanBesar , SatuanKecil FROM Item where Id =  '".$data['ItemId']."'";
                                // print_r($sql_uom);
                                $exe_uom=mysqli_query($koneksi,$sql_uom);
                                while($data_uom = mysqli_fetch_array($exe_uom))
                                {
                                ?>
                                    <?php if ($data['Satuan'] == $data_uom['SatuanBesar']){?>
                                            <option value=<?php echo $data_uom['SatuanBesar'];?> selected><?php echo $data_uom['SatuanBesar'];?></option>
                                            <option value=<?php echo $data_uom['SatuanKecil'];?>><?php echo $data_uom['SatuanKecil'];?></option>
                                    <?php } else { ?>
                                            <option value=<?php echo $data_uom['SatuanBesar'];?>><?php echo $data_uom['SatuanBesar'];?></option>
                                            <option value=<?php echo $data_uom['SatuanKecil'];?> selected><?php echo $data_uom['SatuanKecil'];?></option>
                                    <?php } ?>
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="form-label">Harga Barang (Satuan Kecil)</label>
                            <div class="">
                                    <input type="text" class="form-control" name="unit_price_satuan_kecil" id="unit_price_satuan_kecil" value="<?php echo $data['HargaBawah'] ?>" readonly/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Barang (Satuan Besar)</label>
                            <div class="">
                                    <input type="text" class="form-control" name="unit_price_satuan_besar" id="unit_price_satuan_besar" value="<?php echo $data['HargaBawah'] *  $data['SatuanKonversi']?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $data['Qty'] ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Price</label>
                        <div class="">
                            <input type="text" class="form-control" name="total_price" id="total_price" value="<?php echo $data['TotalPrice'] ?>"/>
                        </div>
                    </div>  
                </div>              
                <div class="box-footer">
                    <input type="submit" name="ubah" class="btn btn-primary" value="Simpan">					
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
                $.getJSON("search_toko.php", { term : $("#nama_barang").val() , supplier: $("#supplier_name").val() }, 
                response)},
                select: function(event, ui) 
                {
                    $('#satuan_barang').empty()
                    var e = ui.item;
                    $("#id_barang").val(e.id);
                    $("#nama_barang").val(e.NamaBarang);
                    $("#konversi").val(e.satuankonversi);
                    $("#satuan_barang").append(new Option(e.satuanbesar, e.satuanbesar));
                    $("#satuan_barang").append(new Option(e.satuankecil, e.satuankecil));
                    $("#unit_price_satuan_kecil").val(e.modal);
                    $("#unit_price_satuan_besar").val(e.modal * e.satuankonversi),
                    console.log(ui.item)
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