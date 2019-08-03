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
                <h3 class="box-title">Sales Order</h3>
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
                    $number = NULL;
                    $select_code_for_po = "Select
                    Increment + 1 as Increment
                    From
                    CodeTransaction
                    where
                    1=1
                    And Prefix = 'SO'
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
                            And Prefix = 'SO'
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
                            'SO',
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

                    $code = "SO" . (string)date('y') . (string)date('m') . (string)$code . $number;
                    //$code=$_POST['code'];
                    $tanggal=$_POST['tanggal'];
                    $customer=$_POST['Pelanggan'];
                    $tipe_pembayaran=$_POST['tipe_pembayaran'];
                    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    //insert Sales order main dulu
                    $sql_Sales_order_main="insert into SalesOrder
                    (Code ,
                    Date ,
                    Customer ,
                    Pembayaran ,
                    TanggalPembayaran ,
                    Pembuat ,
                    Dibuat ,
                    Status)
                    values(
                    '".$code."',
                    '".$tanggal."',
                    '".$customer."',
                    '".$tipe_pembayaran."',
                    '".$tanggal_pembayaran."' ,
                    '".$Session."' ,
                    NOW(),
                    1)";
                    //$exe_Sales_order_main = mysqli_query($koneksi,$sql_Sales_order_main);
                    if($koneksi->query($sql_Sales_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert Sales order detail
                        $last_id = $koneksi->insert_id;
                        foreach ($Items as $key)
                        {
                            $sql_Sales_order_detail = "";
                            $sql_Sales_order_detail="insert into SalesOrderDetail
                            (
                                SalesOrderId ,
                                ItemId ,
                                Qty ,
                                Satuan ,
                                Konversi ,
                                Pembuat ,
                                Dibuat
                            )
                            values
                            (
                                '".$last_id."',
                                '".$key[0]."',
                                '".$key[2]."',
                                '".$key[3]."',
                                '".$key[4]."' ,
                                '".$Session."' ,
                                NOW()
                            )";
                            //$exe_Sales_order_detail = mysqli_query($koneksi,$sql_Sales_order_detail);
                            if ($koneksi->query($sql_Sales_order_detail) === TRUE)
                            {

                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data Sales Order Detail Gagal Disimpan
                                        </div>";
                            }
                        }

                        //$sql_update_po = "Update SalesOrder Set Total = '".$TotalPO."' where id = '".$last_id."'";
                        //$exe_Sales_order_main = mysqli_query($koneksi,$sql_update_po);
                        echo ("<script>location.href='SalesOrderMainList.php';</script>");
                    }
                    else
                    {
                        echo    "<div class='alert alert-Danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Success!</strong> Data Sales Order Gagal Disimpan
                        </div>";
                    }
            }
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputDate">Tangal Order</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "form-label"> Customer </label>
                    <div class>
                    <select class="form-control select2" style="width: 100%;" name="Pelanggan" id="Pelanggan" data-error="Pelanggan Tidak Boleh Kosong" required>
                            <option value="">Pilih Pelanggan:</option>
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
                <div class="form-group">
                    <label for="">Pembayaran</label>
                    <div class>
                        <select class="form-control select2" style="width: 100%;" name="tipe_pembayaran" id="tipe_pembayaran" data-error="Pembayaran Tidak Boleh Kosong" required>
                            <option value="">Pilih Metode Pembayaran :</option>
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
                    <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal_pembayaran" name="tanggal_pembayaran">
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
                            <input  type="hidden" name="konversi" id="konversi" value="" />
                            <input  type="hidden" name="satuanbesar" id="satuanbesar" value="" />
                            <input  type="hidden" name="satuankecil" id="satuankecil" value="" />
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
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Satuan Besar</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_besar" id="jumlah_satuan_besar" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Satuan Kecil</label>
                                <div class="">
                                        <input type="text" class="form-control" name="jumlah_satuan_kecil" id="jumlah_satuan_kecil" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="qty" id="qty"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                </div>
                <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                <input type="hidden" value="1" name="simpanmain" id="simpanmain"/>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
                <table id="TableSalesOrderDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan Pemesanan</th>
                            <th>Nilai Konversi</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="box-footer">
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
            $('#tanggal_pembayaran').datepicker({
                autoclose: true
            });

            $('#tanggal').datepicker({
                autoclose: true
            });

            $("#tipe_pembayaran").on('change',function(e){
                if (this.value == 1)
                {
                    $("#columnTanggalPembayaran").addClass('hide');
                }
                else{
                    $("#columnTanggalPembayaran").removeClass('hide');
                }
            });

            var t =
                    $('#TableSalesOrderDetail').dataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true,
                        "createdRow": function ( nRow, data, index ) {
                          BindClickDelete(nRow)
                        }
                    });


            function BindClickDelete(nRow){
                console.log(nRow)
                $('td:eq(5) input[type="button"]', nRow).unbind('click');
                $('td:eq(5) input[type="button"]', nRow).bind('click', function (e) {
                    t.api().row($(this).parents('tr')).remove().draw( false );
                })
            }

            $("#qty").on('keyup change click', function () {
                var satuankecil = $("#satuankecil").val();
                var satuanbesar = $("#satuanbesar").val();
                var JumlahSatuanKecil = $("#jumlah_satuan_kecil").val();
                var JumlahSatuanBesar = $("#jumlah_satuan_besar").val();
                if ($("#satuan_barang").val() == satuankecil)
                {

                    if ( this.value > parseInt( JumlahSatuanKecil ) )
                    {
                        alert("Jumlah Barang Tidak Mencukupi Permintaan");
                        $("#qty").val( JumlahSatuanKecil );
                    }
                }
                else
                {
                    if ( this.value > parseInt( JumlahSatuanBesar ) )
                    {
                        alert("Jumlah Barang Tidak Mencukupi Permintaan");
                        $("#qty").val( JumlahSatuanBesar );
                    }
                }

            });
            $("#btnTambahBarang").click(function(e){
                jumlahSatuanBesar = $("#jumlah_satuan_besar").val();
                jumlahSatuanKecil = $("#jumlah_satuan_kecil").val();
                qTy = $("#qty").val();
                satuanbesar = $("#satuanbesar").val();
                satuankecil = $("#satuankecil").val();

                var UnitPrice = "";
                if ($("#satuan_barang").val() == satuankecil)
                {
                    UnitPrice = $("#unit_price_satuan_kecil").val()
                }
                else
                {
                    UnitPrice = $("#unit_price_satuan_besar").val()
                }
                var row = t.api().row.add(
                [
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    $("#satuan_barang").val(),
                    $("#konversi").val(),
                    "<input type='number' class='form-control' value='"+$("#qty").val()+"'/>",
                    "<input type='button' class='btn btn-danger' id='" + $("#id_barang").val() + "' name = '"+$("#id_barang").val()+"' value='Delete'/>"
                ]).draw( false );

                row.nodes().to$().attr('id', $("#id_barang").val());
                // var i = table.row.add([
                //     '',
                //     name,
                //     target_l,
                //     details,
                //     panel.html()
                // ]).index();
                // DataItem.push([
                //         $("#id_barang").val(),
                //         $("#nama_barang").val(),
                //         $("#qty").val(),
                //         $("#satuan_barang").val(),
                //         $("#konversi").val()
                //     ]);
                // $("#arrayItem").val(JSON.stringify(DataItem))
            })
            $("#btnTest").click(function(e){
                var DataItem = [];
                var info = t.api().page.info();
                var length = info.recordsTotal - 1;
                var counterNeedApproval = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableSalesOrderDetail tbody tr:eq("+i+")");
                    DataItem.push([
                        $("td:eq(0)",row).html(),
                        $("td:eq(1)",row).html(),
                        $("td:eq(4) input[type='number']",row).val(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                // $("#simpanmain").val("1")
                $("#formSalesOrder").submit();
                })

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
                    $("#satuan_barang").append(new Option(e.satuankecil , e.satuankecil));
                    $("#satuanbesar").val(e.satuanbesar)
                    $("#satuankecil").val(e.satuankecil)
                    $("#jumlah_satuan_kecil").val(e.JumlahSatuanKecil)
                    $("#jumlah_satuan_besar").val(e.JumlahSatuanBesar)

                }
            });
		})
</script>
