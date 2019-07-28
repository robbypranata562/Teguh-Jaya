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
                <h3 class="box-title">Receiving</h3>
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
                    //set Code Transaction
                    $number = NULL;
                    $select_code_for_po = "Select
                    Increment + 1 as Increment
                    From
                    CodeTransaction
                    where
                    1=1
                    And Prefix = 'GR'
                    And Year  = ".date('y')."
                    And Month = ".date('m')."
                    ";
                    //die($select_code_for_po);
                    $exe=mysqli_query($koneksi,$select_code_for_po);
                    if(mysqli_num_rows($exe) > 0 )
                    {
                        while($data=mysqli_fetch_array($exe))
                        {
                            $number = $data['Increment'];
                        }

                        $sql_update_incerement = "
                        Update CodeTransaction
                        Set
                            Increment = ".$number."
                        Where
                            1=1
                            And Prefix = 'GR'
                            And Year  = ".date('y')."
                            And Month = ".date('m')."
                        ";
                        if ($koneksi->query($sql_update_incerement) === TRUE)
                        {
                        }
                    }

                    if(is_null($number))
                    {
                        $insert_code_for_po = "Insert Into CodeTransaction
                        (
                            Prefix,
                            Year,
                            Month,
                            Increment
                        )
                        Values
                        (
                            'GR',
                            ".date('y').",
                            ".date('m').",
                            '1'
                            )";
                        if($koneksi->query($insert_code_for_po) === TRUE)
                        {
                            $number = "1";
                        }
                    }

                    $lengthCode = strlen($number);
                    $lengthCode = 4 - $lengthCode;
                    $code = "";
                    for ($i = 1 ; $i <= $lengthCode ; $i++)
                    {
                        $code = (string)$code  . "0";
                    }

                    $code = "GR" . (string)date('y') . (string)date('m') . (string)$code . $number;
                    //end select code transaction
                    //$code = $_POST['code'];
                    $tanggal=$_POST['tanggal'];
                    $tanggal=$_POST['tanggal'];
                    $suplier=$_POST['suplier_name'];
                    $PurchaseOrderCode=$_POST['PurchaseOrderCode'];
                    $BiayaKirim = $_POST['BiayaKirim'];
                    $BiayaEkstra = $_POST['BiayaEkstra'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    $PaymentType = $_POST['tipe_pembayaran'];
                    $PaymentDate = $_POST['PaymentDate'];
                    //insert receiving main dulu
                    $sql_purchase_order_main="insert into Receiving
                    (Code ,
                    Date ,
                    Supplier ,
                    PurchaseOrderId,
                    CostDelivery ,
                    CostExtra ,
                    CreatedBy,
                    CreatedDate,
                    PaymentType,
                    PaymentDate)
                    values(
                    '".$code."',
                    '".$tanggal."',
                    '".$suplier."',
                    '".$PurchaseOrderCode."',
                    '".$BiayaKirim."',
                    '".$BiayaEkstra."',
                    '".$Session."' ,
                    NOW(),
                    '".$PaymentType."',
                    '".$PaymentDate."')";
                    //die($sql_purchase_order_main);
                    //$exe_purchase_order_main = mysqli_query($koneksi,$sql_purchase_order_main);
                    if($koneksi->query($sql_purchase_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert purchase order detail
                        $last_id = $koneksi->insert_id;
                        $TotalReceiving = 0;
                        foreach ($Items as $key)
                        {
                            $sql_purchase_order_detail = "";
                            $sql_purchase_order_detail="insert into ReceivingDetail
                            (
                                ReceivingId ,
                                ItemId ,
                                OrderQty ,
                                ReceivingQty ,
                                UOM ,
                                UnitPrice ,
                                TotalPrice ,
                                CreatedBy ,
                                CreatedDate ,
                                Konversi)
                            values(
                                '".$last_id."',
                                '".$key[0]."',
                                '".$key[3]."',
                                '".$key[4]."',
                                '".$key[2]."' ,
                                '".$key[14]."' ,
                                '".$key[15]."' ,
                                '".$Session."' ,
                                NOW(),
                                '".$key[5]."')";
                            //$exe_purchase_order_detail = mysqli_query($koneksi,$sql_purchase_order_detail);
                            if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                            {
                                if (strtolower($key[2]) == strtolower($key[9])) //satuan kecil
                                {
                                    $satuan_besar = $key[4] / $key[5];
                                    $satuan_besar = round($satuan_besar, 0);
                                    $sql_update_stok_item =
"
                                    update item
                                    set
                                        jumlahsatuanbesar   = jumlahsatuanbesar + ".$satuan_besar.",
                                        jumlahsatuankecil   = jumlahsatuankecil + ".$key[4].",
                                        Modal               = ".round($key[12],2).",
                                        HargaAtas           = ".round($key[10],2).",
                                        HargaBawah          = ".round($key[11],2).",
                                        HargaDefault        = ".round($key[13],2)."
                                    where
                                        id                  = '".$key[0]."'
                                    ";
                                }
                                else
                                {
                                    $AddValueStock = $key[5] * $key[4];
                                    $sql_update_stok_item = "
                                    update item
                                    set
                                        jumlahsatuanbesar   = jumlahsatuanbesar + ".$key[4].",
                                        jumlahsatuankecil   = jumlahsatuankecil + ".$AddValueStock.",
                                        Modal               = ".round($key[12],2).",
                                        HargaAtas           = ".round($key[10],2).",
                                        HargaBawah          = ".round($key[11],2).",
                                        HargaDefault        = ".round($key[13],2)."
                                    where
                                        id                  = '".$key[0]."'
                                    ";
                                    //echo $sql_update_stok_item;
                                }

                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {
                                    $TotalReceiving = $TotalReceiving + $key[15];
                                }

                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data Purchase Order Detail Gagal Disimpan
                                        </div>";
                            }
                        }

                        $sql_update_receiving = "Update Receiving Set Total = '".$TotalReceiving."' where id = '".$last_id."'";
                        if ($koneksi->query($sql_update_receiving) === TRUE)
                        {
                            //insert ke table hutang
                            if ($PaymentType == 2)
                            {
                                $sql_insert_AR="insert into AR
                                (supplier_id , receivingid , date , total , CreatedBy , CreatedDate)
                                values(
                                    '".$suplier."',
                                    '".$last_id."',
                                    '".$tanggal."',
                                    '".$TotalReceiving."',
                                    '".$Session."' ,
                                    NOW())";

                                if ($koneksi->query($sql_insert_AR) === TRUE)
                                {
                                    $update_status_po = "Update PurchaseOrder Set Status = 2 where Id = '".$PurchaseOrderCode."'";
                                    if ($koneksi->query($update_status_po) === TRUE)
                                    {
                                       echo ("<script>location.href='ReceivingMainList.php';</script>");
                                    }
                                }
                            }
                            else
                            {
                                    $update_status_po = "Update PurchaseOrder Set Status = 2 where Id = '".$PurchaseOrderCode."'";
                                    if ($koneksi->query($update_status_po) === TRUE)
                                    {
                                       echo ("<script>location.href='ReceivingMainList.php';</script>");
                                    }
                            }
                        }
                    }
                    else
                    {
                        echo    "<div class='alert alert-danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Error!</strong> Data Purchase Order Gagal Disimpan
                        </div>";
                    }
            }
            ?>
            <form class="form-body" name="formReceiving" id="formReceiving" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputDate">Tangal Penerimaan</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required>
                    <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Suplier</label>
                    <div class>
                        <select class="form-control" style="width: 100%;" name="suplier_name" id="suplier_name" required>
                                <option value="">Pilih Suplier :</option>
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
                <div class="form-group" id="OptionPurchaseCode">
                    <label for="">Purchase Order</label>
                    <div class>
                        <select class="form-control select2" style="width: 100%;" name="PurchaseOrderCode" id="PurchaseOrderCode" required>
                            <option value="">Pilih Purchase Order :</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Biaya Kirim</label>
                    <div class="">
                        <input type="text" class="form-control" name="BiayaKirim" id="BiayaKirim" value="0"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Biaya Ekstra</label>
                    <div class="">
                        <input type="text" class="form-control" name="BiayaEkstra" id="BiayaEkstra" value="0"/>
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

                <div class>



                    <!-- <div class="ui-widget form-group">
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
                        <label class="form-label">Jumlah Barang Diterima</label>
                        <div class="">
                            <input type="number" class="form-control" name="ReceivingQty" id="ReceivingQty"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <div class="">
                            <input type="text" class="form-control" name="UnitPrice" id="UnitPrice" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Harga</label>
                        <div class="">
                            <input type="text" class="form-control" name="TotalPrice" id="TotalPrice" readonly/>
                        </div>
                    </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                </div> -->
                <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                <input type="hidden" value="0" name="simpanmain" id="simpanmain"/>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
                <table id="TableReceivingDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Order Qty</th>
                            <th>Receiving Qty</th>
                            <th>Konversi</th>
                            <th>Jumlah Satuan Besar</th>
                            <th>Satuan Besar</th>
                            <th>Jumlah Satuan Kecil</th>
                            <th>Satuan Kecil</th>
                            <th>Harga Atas</th>
                            <th>Harga Bawah</th>
                            <th>Harga Modal</th>
                            <th>Harga Default</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                </table>
                <div class="box-footer">
                    <!-- <input type="submit" name="simpanmain" class="btn btn-primary" value="Simpan"> -->
                    <input type="button" class="btn btn-primary" name="btnTest" value="simpanmain" id="btnTest">
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
            var currDate = new Date();
            $('#tanggal').datepicker({
                autoclose: true,
                startDate: currDate,
            });

            var table = $('#TableReceivingDetail').dataTable({
                        "Processing": true,
                        "paging":   false,
                        "serverSide": true,
                        "scrollX": true,
                        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            var textSaleQty =   '<input type="text" id=sale-qty-'+aData[0]+' value='+aData[4]+'>';
                            var textUnitPrice = '<input type="text" id=unit-price-'+aData[0]+' value='+aData[14]+'>';
                            var totalPrice = parseInt(aData[4]) * parseInt(aData[14]);
                            var textTotalPrice = '<input type="text" id=total-price-'+aData[0]+' value='+totalPrice+'>';
                            $('td:eq(4)',  nRow).html(textSaleQty);
                            $('td:eq(14)', nRow).html(textUnitPrice);
                            $('td:eq(15)', nRow).html(textTotalPrice);
                            fn_set_price(nRow);
                            fn_check_stock(nRow);
                            return nRow;
                        },
                        "ajax": {
                            "url": "search_item_po_to_gr.php",
                            "type": "POST",
                            "data": function (d)
                            {
                                d.id= $("#PurchaseOrderCode").val()
                            }
                        },
                        "fnInitComplete": function (oSettings, json) {
                            $('#TableReceivingDetail tbody tr:eq(0)').click();
                            //fn_set_price(nRow);
                            //fn_check_stock(nRow);

                        },
                        "fnDrawCallback": function (settings) {
                            //alert("drawCallback");
                            $('#TableReceivingDetail tbody tr:eq(0)').click();
                            //fn_set_price();
                            //fn_check_stock();

                        },
                    });

            $('#TableReceivingDetail').on('click', 'tbody tr', function () {
                table.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            });

            function fn_check_stock(nRow)
            {
                $('td:eq(4) input[type="text"]', nRow).unbind('keyup');
                $('td:eq(4) input[type="text"]', nRow).ForceNumericOnly();
                $('td:eq(4) input[type="text"]', nRow).bind('keyup', function (e) {
                    var qty             = this.value;
                    var LastUnitPrice   = $('#TableReceivingDetail tbody tr.row_selected td:eq(14) input[type="text"]').val();
                    var BiayaKirim      = $("#BiayaKirim").val() == "" ? "0" :  $("#BiayaKirim").val();
                    var BiayaEkstra     = $("#BiayaEkstra").val() == "" ? "0" :  $("#BiayaEkstra").val();
                    var konversi        = $('#TableReceivingDetail tbody tr.row_selected td:eq(5)').html();
                    var uom             = $('#TableReceivingDetail tbody tr.row_selected td:eq(2)').html();

                    var SatuanBesar     = $('#TableReceivingDetail tbody tr.row_selected td:eq(7)').html();
                    var SatuanKecil     = $('#TableReceivingDetail tbody tr.row_selected td:eq(9)').html();
                    var UnitPrice       = 0;
                    var SmallUnitQty    = 0;
                    var NewUnitPrice    = 0;

                    var HargaAtas       = $('#TableReceivingDetail tbody tr.row_selected td:eq(10)').html();
                    var HargaBawah      = $('#TableReceivingDetail tbody tr.row_selected td:eq(11)').html();
                    var HargaModal      = $('#TableReceivingDetail tbody tr.row_selected td:eq(12)').html();
                    var HargaDefault    = $('#TableReceivingDetail tbody tr.row_selected td:eq(13)').html();

                    //bandingkan apakah satuanya besar apa kecil
                    if ( uom == SatuanKecil ) //jika uom adalah satuan kecil
                    {
                        SmallUnitQty = qty;
                        BiayaKirim = (parseInt(BiayaKirim) + parseInt(BiayaEkstra)) / parseInt(konversi);
                        console.log(BiayaKirim)
                        NewUnitPrice = parseInt(LastUnitPrice) + parseInt(BiayaKirim);
                        var KenaikanHarga = financial(NewUnitPrice) - financial(LastUnitPrice)
                        console.log(LastUnitPrice)
                        console.log(KenaikanHarga)
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(10)').html( parseInt(HargaAtas) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(11)').html( parseInt(HargaBawah) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(12)').html( parseInt(HargaModal) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(13)').html( parseInt(HargaDefault) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(14) input[type="text"]').val( financial(NewUnitPrice) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(15) input[type="text"]').val
                        (
                            financial(NewUnitPrice) * SmallUnitQty
                        );
                    }
                    else
                    {
                        BiayaKirim = (BiayaKirim * qty) + (BiayaEkstra * qty);
                        SmallUnitQty = konversi * qty;
                        NewUnitPrice = parseInt(LastUnitPrice) + parseInt((BiayaKirim / SmallUnitQty));
                        var KenaikanHarga = financial(NewUnitPrice) - financial(LastUnitPrice);
                        console.log(KenaikanHarga)
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(10)').html( parseInt(HargaAtas) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(11)').html( parseInt(HargaBawah) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(12)').html( parseInt(HargaModal) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(13)').html( parseInt(HargaDefault) +  parseInt(KenaikanHarga) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(14) input[type="text"]').val( financial(NewUnitPrice) );
                        $('#TableReceivingDetail tbody tr.row_selected td:eq(15) input[type="text"]').val
                        (
                            financial(NewUnitPrice) * SmallUnitQty
                        );
                    }
                })
            }

            function fn_set_price(nRow) {
                //$('td:eq(12) input[type="text"]', nRow).unbind('focusout');
                //$('td:eq(12) input[type="text"]', nRow).ForceNumericOnly();
                //$('td:eq(12) input[type="text"]', nRow).bind('focusout', function (e) {
                    // var HargaBawah = $('#TableReceivingDetail tbody tr.row_selected td:eq(11)').html();
                    // if (this.value <= parseInt(HargaBawah))
                    // {
                    //     $('#TableReceivingDetail tbody tr.row_selected').addClass("red-row-class");
                    //     $('#TableReceivingDetail tbody tr.row_selected').attr("data-need-approval","true");
                    // }
                    // else
                    // {
                    //     $('#TableReceivingDetail tbody tr.row_selected').removeClass("red-row-class");
                    //     $('#TableReceivingDetail tbody tr.row_selected').removeAttr("data-need-approval");
                    // }
                    // fn_set_total_price();
                //})
            }

            function fn_set_total_price(){



                var TotalPrice = qty * UnitPrice;
                $('#TableReceivingDetail tbody tr.row_selected td:eq(13) input[type="text"]').val(TotalPrice);
                var GrandTotal = $("#GrandTotal").val() == "" ? 0 :  $("#GrandTotal").val();
                $("#GrandTotal").val( parseInt(GrandTotal) + parseInt(TotalPrice) )
            }

            $( "#PurchaseOrderCode" ).on('change',function(){
                $.ajax({
                        url: 'search_detail_from_purchase_order_to_good_receive.php',
                        type: 'POST',
                        dataType: "json",
                        data:
                        {
                            purchase_order_id: this.value
                        }
                    }).success(function(data){
                        $("#tipe_pembayaran").val(data[0]['Pembayaran']);
                        $("#PaymentDate").val(data[0]['TanggalPembayaran']);
                    }).error(function(data){
                        //alert("Tidak Ada Sales Order Untuk Customer")
                    });
                $("#TableReceivingDetail").DataTable().draw();

            });

            $("#btnTest").click(function(e){
                var DataItem = [];
                var info = table.api().page.info();
                var length = info.recordsTotal - 1;
                var counterNeedApproval = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableReceivingDetail tbody tr:eq("+i+")");
                    if ($(row).hasClass('red-row-class')){
                        counterNeedApproval++;
                    }
                    DataItem.push([
                        $("td:eq(0)",row).html(),
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html(),
                        $("td:eq(4) input[type='text']",row).val(),
                        $("td:eq(5)",row).html(),
                        $("td:eq(6)",row).html(),
                        $("td:eq(7)",row).html(),
                        $("td:eq(8)",row).html(),
                        $("td:eq(9)",row).html(),
                        $("td:eq(10)",row).html(),
                        $("td:eq(11)",row).html(),
                        $("td:eq(12)",row).html(),
                        $("td:eq(13)",row).html(),
                        $("td:eq(14) input[type='text']",row).val(),
                        $("td:eq(15) input[type='text']",row).val(),
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#formReceiving").submit();
            })


            $("#suplier_name").on('change',function(){
                $.ajax({
                        url: 'search_purchase_order_by_supplier.php',
                        type: 'POST',
                        dataType: "json",
                        data:
                        {
                            supplier_id: this.value
                        }
                    }).success(function(data){
                        for (i = 0; i < data.length; ++i) {
                            console.log(data[i]['Id'])
                            $("#PurchaseOrderCode").append(new Option(data[i]['Code'], data[i]['Id']));
                        }
                    }).error(function(data){
                        alert("Tidak Ada Purchase Order Untuk Suplier")
                    });
            });
            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_item_from_po_to_rc.php",
                {
                    term : $("#nama_barang").val() ,
                    poid: $( "#PurchaseOrderCode option:selected" ).val()
                },
                response)},
                select: function(event, ui)
                {
                    var e = ui.item;
                    $("#id_barang").val(e.Id);
                    $("#nama_barang").val(e.NamaBarang);
                    $("#Konversi").val(e.Konversi);
                    $("#UnitPrice").val(e.UnitPrice);
                    $("#lastunitprice").val(e.UnitPrice);
                    $("#Satuan").val(e.Satuan);
                    $("#OrderQty").val(e.orderqty);
                    $("#ReceivingQty").val(e.receivingqty);
                }
            });
            $("#ReceivingQty").on('keyup change click', function () {
                var OrderQty = $("#OrderQty").val()
                if ( this.value > parseInt( OrderQty ) ){
                    alert("Penerimaan Tidak Boleh Lebih Besar Dari Pembelian");
                    $("#ReceivingQty").val( OrderQty );
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
                    $("#ReceivingQty").val(),
                    $("#Konversi").val(),
                    $("#UnitPrice").val(),
                    $("#TotalPrice").val()
                ]).draw( false );

                DataItem.push([
                        $("#id_barang").val(),
                        $("#nama_barang").val(),
                        $("#Satuan").val(),
                        $("#OrderQty").val(),
                        $("#ReceivingQty").val(),
                        $("#Konversi").val(),
                        $("#UnitPrice").val(),
                        $("#TotalPrice").val()
                    ]);

                $("#arrayItem").val(JSON.stringify(DataItem))
            })
            function calculcateHPP(){
                var BiayaKirim = $("#BiayaKirim").val()     ? "" == "0" : $("#BiayaKirim").val();
                var BiayaEkstra = $("#BiayaEkstra").val()   ? "" == "0" : $("#BiayaEkstra").val();
                var LastUnitPrice = $("#lastunitprice").val();
                var Konversi = $("#Konversi").val();
                var Satuan = $("#Satuan").val();
                var ReceivingQty = $("#ReceivingQty").val() == "" ? "0" :  $("#ReceivingQty").val() ;
                var NewUnitPrice = "";
                var SmallUnitQty = 0;

                $("#UnitPrice").val("0");
                if (Satuan != "pcs"){
                    var BiayaKirim = (BiayaKirim * ReceivingQty) + (BiayaEkstra * ReceivingQty);
                    SmallUnitQty = Konversi * ReceivingQty;
                    NewUnitPrice = parseInt(LastUnitPrice) + parseInt((BiayaKirim / SmallUnitQty));
                    $("#UnitPrice").val(financial(NewUnitPrice));
                    $("#TotalPrice").val( $("#UnitPrice").val() * $("#ReceivingQty").val() );
                }
                else
                {
                    SmallUnitQty = ReceivingQty;
                    NewUnitPrice = parseInt(LastUnitPrice) + parseInt((BiayaKirim / SmallUnitQty));;
                    $("#UnitPrice").val( financial(NewUnitPrice) );
                    $("#TotalPrice").val( $("#UnitPrice").val() * $("#ReceivingQty").val() );
                }
            }
            function financial(x) {
                return Number.parseFloat(x).toFixed(0);
            }

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

		})
</script>
