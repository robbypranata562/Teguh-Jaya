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
                <h3 class="box-title">Purchase Order</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
            <?php
                if (isset($_POST['simpanpomain']))
                {
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    foreach ($Items as $key) 
                    {
                        $sql_purchase_order_detail = "";
                        $sql_purchase_order_detail="insert into PurchaseOrderDetail
                        (PurchaseOrderId , ItemId , Satuan , Konversi , UnitPrice , Qty , TotalPrice , Pembuat , Dibuat) 
                        values('".$_GET['id']."','".$key[0]."','".$key[2]."','".$key[3]."','".$key[5]."' , '".$key[4]."' , '".$key[6]."' , '".$Session."' , NOW())";
                        //$exe_purchase_order_detail = mysqli_query($koneksi,$sql_purchase_order_detail);
                        if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                        {
                            $sql_update_total_PO = "select sum(a.TotalPrice) as TotalAmount from purchaseorderdetail a where a.PurchaseOrderId = '".$_GET['id']."'";
                            $exe = mysqli_query($koneksi,$sql_update_total_PO);
                            while ($data=mysqli_fetch_array($exe))
                            {
                                $sql_update_po = "Update PurchaseOrder Set Total = '".$data['TotalAmount']."' where id = '".$_GET['id']."'";
                                $exe_purchase_order_main = mysqli_query($koneksi,$sql_update_po);
                            }
                            echo ("<script>location.href='PurchaseOrderMainList.php';</script>");
                        }
                        else
                        {
                            echo    "<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data Purchase Order Detail Gagal Disimpan
                                    </div>";
                        }
                    }
                }
            ?>
            <?php
                $purchase_order_id = $_GET['id'];
                $sql = "SELECT
                b.nama_suplier
                FROM
                purchaseorder AS a
                LEFT JOIN suplier AS b ON a.Supplier = b.id_suplier
                WHERE
                a.Id = '$purchase_order_id'";
                $exe = mysqli_query($koneksi,$sql);
                while ($data=mysqli_fetch_array($exe))
                {
                    ?>

            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class>
                    <input type="hidden" id="supplier_name" name="supplier_name" value = "<?php echo $data['nama_suplier'] ?>"/>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" >
                            <input  type="hidden" name="id_barang" id="id_barang" value="" />
                            <input  type="hidden" name="modal" id="modal" value="" />
                            <input  type="hidden" name="konversi" id="konversi" value="" />
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat" name="tambah">Tambah</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Satuan Barang</label>
                        <div class>
                            <select class="form-control select2"   style="width: 100%;" name="satuan_barang" id="satuan_barang">
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="form-label">Harga Barang (Satuan Kecil)</label>
                            <div class="">
                                    <input type="text" class="form-control" name="unit_price_satuan_kecil" id="unit_price_satuan_kecil" readonly/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Barang (Satuan Besar)</label>
                            <div class="">
                                    <input type="text" class="form-control" name="unit_price_satuan_besar" id="unit_price_satuan_besar" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="qty" id="qty"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Price</label>
                        <div class="">
                            <input type="text" class="form-control" name="total_price" id="total_price"/>
                        </div>
                    </div>  
                </div>              
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                </div>
                <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
                <table id="TablePurchaseOrderDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan Pemesanan</th>
                            <th>Nilai Konversi</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Sub Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="box-footer">
                    <input type="submit" name="simpanpomain" class="btn btn-primary" value="Simpan">					
                </div>
            </form>
                <?php } ?>
        </div>
        </div>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
            var DataItem = [];
            var t = 
                    $('#TablePurchaseOrderDetail').DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true
                    });
            $("#btnTambahBarang").click(function(e){
                var UnitPrice = "";
                if ($("#satuan_barang").val() == "Pcs")
                {
                    UnitPrice = $("#unit_price_satuan_kecil").val()
                }
                else
                {
                    UnitPrice = $("#unit_price_satuan_besar").val()
                }
                t.row.add(
                [
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    $("#satuan_barang").val(),
                    $("#konversi").val(),
                    $("#qty").val(),
                    UnitPrice,
                    $("#total_price").val()
                ]).draw( false );
                DataItem.push([ 
                        $("#id_barang").val(),
                        $("#nama_barang").val(),
                        $("#satuan_barang").val(),
                        $("#konversi").val(),
                        $("#qty").val(),
                        UnitPrice,
                        $("#total_price").val()
                    ]);
                $("#arrayItem").val(JSON.stringify(DataItem))
            })
            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_toko.php", { term : $("#nama_barang").val() , supplier: $( "#supplier_name" ).val() }, 
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