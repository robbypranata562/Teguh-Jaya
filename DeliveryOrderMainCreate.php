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
                <h3 class="box-title">Delivery</h3>
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
                    print_r($_POST);
                    $code=$_POST['code'];
                    $tanggal=$_POST['tanggal'];
                    $PaymentDate=$_POST['PaymentDate'];
                    $suplier=$_POST['Pelanggan'];
                    $SalesOrderCode=$_POST['SalesOrderCode'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    $PaymentType = $_POST['tipe_pembayaran'];

                    //insert Delivery main dulu
                    $sql_purchase_order_main="insert into DeliveryOrder 
                    (
                    Code , 
                    Date , 
                    Customer , 
                    SalesOrderId,
                    CreatedBy,
                    CreatedDate,
                    Type,
                    PaymentType,
                    PaymentDate) 
                    values(
                    '".$code."',
                    '".$tanggal."',
                    '".$suplier."',
                    '".$SalesOrderCode."',
                    '".$Session."' , 
                    NOW(),
                    '1',
                    '".$PaymentType."',
                    '".$PaymentDate."'
                    )";
                    //die($sql_purchase_order_main);
                    //$exe_purchase_order_main = mysqli_query($koneksi,$sql_purchase_order_main);
                    if($koneksi->query($sql_purchase_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert purchase order detail
                        $last_id = $koneksi->insert_id;
                        $TotalDelivery = 0;
                        foreach ($Items as $key) 
                        {
                            // $("#id_barang").val(),
                            // $("#nama_barang").val(),
                            // $("#Satuan").val(),
                            // $("#OrderQty").val(),
                            // $("#DeliveryQty").val(),
                            // $("#Konversi").val(),
                            // $("#UnitPrice").val(),
                            // $("#TotalPrice").val()

                            $sql_purchase_order_detail = "";
                            $sql_purchase_order_detail="insert into DeliveryOrderDetail
                            (
                                DeliveryId, 
                                ItemId, 
                                OrderQty, 
                                DeliveryQty, 
                                UOM, 
                                Konversi,
                                UnitPrice,
                                SubPrice,
                                TotalPrice, 
                                CreatedBy, 
                                CreatedDate
                            ) 
                            values
                            (
                                '".$last_id."',
                                '".$key[0]."',
                                '".$key[3]."',
                                '".$key[4]."',
                                '".$key[2]."',
                                '".$key[5]."',
                                '".$key[6]."',
                                '".$key[7]."',
                                '".$Session."', 
                                NOW()
                            )";
                            if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                            {
                                if (strtolower($key[5]) == 'pcs'){
                                    $sql_update_stok_item = "
                                    update item set
                                    jumlahsatuankecil = jumlahsatuankecil - ".$key[4].",
                                    where
                                    id = '".$key[0]."'
                                    ";
                                    //echo $sql_update_stok_item;
                                }
                                else
                                {
                                    //rubah dulu satuan besar ke satuan kecil
                                    
                                    $AddValueStock = $key[5] * $key[4];
                                    $HPP = $key[7] / $AddValueStock;
                                    echo $HPP;
                                    $HPP = round($HPP,2); 
                                    $sql_update_stok_item = "
                                    update item set
                                    jumlahsatuankecil = jumlahsatuankecil - ".$AddValueStock."                                    where
                                    id = '".$key[0]."'";
                                }
                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {
                                    $TotalDelivery = $TotalDelivery + $key[7];
                                }
                                
                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Error!</strong> Data Sales Order Detail Gagal Disimpan
                                        </div>";
                            }
                        }

                        $sql_update_Delivery = "Update DeliveryOrder Set Total = '".$TotalDelivery."' where id = '".$last_id."'";
                        if ($koneksi->query($sql_update_Delivery) === TRUE)
                        {
                            //insert ke table piutang
                            if ($PaymentType == "2")
                            {
                                $sql_insert_AP="insert into AP
                                (customer_id , delivery_id , date , total , CreatedBy , CreatedDate) 
                                values(
                                    '".$suplier."',
                                    '".$last_id."',
                                    '".$tanggal."',
                                    '".$TotalDelivery."',
                                    '".$Session."' , 
                                    NOW())";
                                if ($koneksi->query($sql_insert_AP) === TRUE) {
                                    $update_status_so = "Update SalesOrder Set Status = 2 where Id = '".$SalesOrderCode."'";
                                    if ($koneksi->query($update_status_po) === TRUE)
                                    {
                                        echo ("<script>location.href='DeliveryMainList.php';</script>");
                                    }
                                }
                            }
                            else 
                            {
                                $update_status_po = "Update PurchaseOrder Set Status = 2 where Id = '".$SalesOrderCode."'";
                                if ($koneksi->query($update_status_po) === TRUE)
                                {
                                    echo ("<script>location.href='DeliveryMainList.php';</script>");
                                }
                            }
                        }
                    }
                    else
                    {
                        echo    "<div class='alert alert-danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Error!</strong> Data Sales Order Gagal Disimpan
                        </div>";
                    }
            }
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Kode</label>
                    <div class="">
                        <input type="text" class="form-control" name="code" id="code"/>
                    </div>
                </div>                
                <div class="form-group">
                    <label for="exampleInputDate">Tanggal</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required>
                    <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "form-label"> Pelanggan </label>
                    <div class>
                    <select class="form-control" style="width: 100%;" name="Pelanggan" id="Pelanggan">
                    <option value="">Pilih Pelanggan :</option>  
                            <?php
                                $sql="SELECT id_pelanggan , nama_pelanggan FROM Pelanggan";
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
                <!-- <div class="form-group">
                    <label class = "form-label">Tipe</label>
                    <div class>
                    <select class="form-control"   style="width: 100%;" name="TipePenerimaan" id="TipePenerimaan">
                        <option value="1">Dengan Purchase Order</option>
                        <option value="2">Tanpa Purchase Order</option>
                    </select>
                    </div>
                </div> -->
                <div class="form-group" id="OptionSalesOrderCode">
                    <label for="">Sales Order</label>
                    <div class>
                        <select class="form-control select2" style="width: 100%;" name="SalesOrderCode" id="SalesOrderCode">
                            <option value="">Pilih Sales Order :</option>    
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Pembayaran</label>
                    <div class>
                        <select class="form-control" style="width: 100%;" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="1">Cash</option>
                            <option value="2">Credit</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="columnTanggalPembayaran">
                    <label for="exampleInputDate">Tangal Pembayaran</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" autocomplete="off" class="form-control pull-right" id="PaymentDate" name="PaymentDate" readonly>
                    </div>
                </div>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
               <div class>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang"  >
                            <input  type="hidden" name="id_barang" id="id_barang" value="" />
                            <input  type="hidden" name="modal" id="modal" value="" />
                            <input  type="hidden" name="konversi" id="konversi" value="" />
                            <input  type="hidden" name="lastunitprice" id="lastunitprice" value="" />
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat" name="tambah">Tambah</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Satuan</label>
                        <div class="">
                            <input type="text" class="form-control" name="Satuan" id="Satuan" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Permintaan Barang</label>
                        <div class="">
                            <input type="text" class="form-control" name="OrderQty" id="OrderQty" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konversi</label>
                        <div class="">
                            <input type="text" class="form-control" name="Konversi" id="Konversi" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Sisa Barang Dalam Satuan Besar</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_besar" id="jumlah_satuan_besar" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sisa Barang Dalam Satuan Kecil</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_kecil" id="jumlah_satuan_kecil" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Barang Dijual</label>
                        <div class="">
                            <input type="number" class="form-control" name="DeliveryQty" id="DeliveryQty"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <div class="">
                            <input type="text" class="form-control" name="UnitPrice" id="UnitPrice"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Harga</label>
                        <div class="">
                            <input type="text" class="form-control" name="TotalPrice" id="TotalPrice"/>
                        </div>
                    </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                </div>
                <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
                <table id="TableDeliveryDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Order Qty</th>
                            <th>Sale Qty</th>
                            <th>Nilai Konversi</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                </table>
                <div class="box-footer">
                    <input type="submit" name="simpanmain" class="btn btn-primary" value="Simpan">
			    </div>
            </form>
        </div>
        </div>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
            var DataItem = [];
            $('#tanggal').datepicker({
                autoclose: true
            });
            var t = 
                    $('#TableDeliveryDetail').DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true
                    });

            $("#Pelanggan").on('change',function(){
                $.ajax({
                        url: 'search_sales_order_by_customer.php',
                        type: 'POST',
                        dataType: "json",
                        data: 
                        {
                            customer_id: this.value
                        }
                    }).success(function(data){
                        for (i = 0; i < data.length; ++i) {
                            $("#SalesOrderCode").append(new Option(data[i]['Code'], data[i]['Id']));
                        }
                    }).error(function(data){
                        alert("Tidak Ada Sales Order Untuk Customer")
                    });
            });

            $("#SalesOrderCode").on('change',function(){
                $.ajax({
                        url: 'search_detail_from_sales_order_to_delivery_order.php',
                        type: 'POST',
                        dataType: "json",
                        data: 
                        {
                            sales_order_id: this.value
                        }
                    }).success(function(data){
                        $("#tipe_pembayaran option[value="+data[0]['Pembayaran']+"]").attr('selected', 'selected'); 
                        $("#PaymentDate").val(data[0]['TanggalPembayaran'])
                    }).error(function(data){
                        alert("Tidak Ada Sales Order Untuk Customer")
                    });
            });


            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_item_from_so_to_do.php", 
                { 
                    term : $("#nama_barang").val() , 
                    soid: $( "#SalesOrderCode option:selected" ).val() 
                }, 
                response)},
                select: function(event, ui) 
                {
                    var e = ui.item;
                    $("#id_barang").val(e.Id);
                    $("#nama_barang").val(e.NamaBarang);
                    $("#Konversi").val(e.Konversi);
                    $("#Satuan").val(e.Satuan);
                    $("#OrderQty").val(e.orderqty);
                    $("#DeliveryQty").val(e.Deliveryqty);
                    $("#jumlah_satuan_besar").val(e.JumlahSatuanBesar);
                    $("#jumlah_satuan_kecil").val(e.JumlahSatuanKecil);
                    $("#UnitPrice").val(e.Modal);
                }
            });


            // 

            $("#DeliveryQty").on('keyup change click', function () {
                var UOM = $('#Satuan').val().toLowerCase();
                if (UOM == "pcs")
                {
                    var SisaSatuanKecil = $("#jumlah_satuan_kecil").val()
                    if (this.value > parseInt(SisaSatuanKecil))
                    {
                        alert("Penjualan Tidak Bisa Melebihi Sisa Stok Satuan Kecil");
                        $("#DeliveryQty").val( SisaSatuanKecil );
                    }
                }
                else
                {
                    var SisaSatuaBesar = $("#jumlah_satuan_besar").val()
                    if (this.value > parseInt(SisaSatuaBesar))
                    {
                        alert("Penjualan Tidak Bisa Melebihi Sisa Stok Satuan Besar");
                        $("#DeliveryQty").val( SisaSatuaBesar );
                    }
                }
                calculcateHPP();
            });

            $("#btnTambahBarang").click(function(e){
                t.row.add(
                [
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    $("#Satuan").val(),
                    $("#OrderQty").val(),
                    $("#DeliveryQty").val(),
                    $("#Konversi").val(),
                    $("#UnitPrice").val(),
                    $("#TotalPrice").val()
                ]).draw( false );

                DataItem.push([ 
                        $("#id_barang").val(),
                        $("#nama_barang").val(),
                        $("#Satuan").val(),
                        $("#OrderQty").val(),
                        $("#DeliveryQty").val(),
                        $("#Konversi").val(),
                        $("#UnitPrice").val(),
                        $("#TotalPrice").val()
                    ]);

                $("#arrayItem").val(JSON.stringify(DataItem))
            })

            $("#UnitPrice").ForceNumericOnly();
            $("#TotalPrice").ForceNumericOnly();
            $('#UnitPrice').keyup(function () { 
                calculcateHPP();
            });
            function calculcateHPP(){
                var BiayaKirim = $("#BiayaKirim").val();
                var BiayaEkstra = $("#BiayaEkstra").val();
                var LastUnitPrice = $("#lastunitprice").val();
                var Konversi = $("#Konversi").val();
                var Satuan = $("#Satuan").val();
                var DeliveryQty = $("#DeliveryQty").val() == "" ? "0" :  $("#DeliveryQty").val() ;
                var NewUnitPrice = "";
                var SmallUnitQty = 0;
                if (Satuan.toLowerCase() == "pcs"){
                    $("#TotalPrice").val( $("#UnitPrice").val() * $("#DeliveryQty").val() );
                }
                else
                {
                    $("#TotalPrice").val( $("#UnitPrice").val() * ( $("#DeliveryQty").val() * $("#Konversi").val() ));
                }
            }
            function financial(x) {
                return Number.parseFloat(x).toFixed(0);
            }
		})
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};
</script>