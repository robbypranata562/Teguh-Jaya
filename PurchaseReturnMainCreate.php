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
                <h3 class="box-title">Retur Pembelian</h3>
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
                    And Prefix = 'PR'
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
                            And Prefix = 'PR'
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
                            'PR',
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

                    $code = "PR" . (string)date('y') . (string)date('m') . (string)$code . $number;
                    //end select code transaction
                    $tanggal=$_POST['tanggal'];
                    $suplier=$_POST['suplier_name'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    //insert purchase order main dulu
                    $sql_purchase_order_main="insert into PurchaseReturn
                    (
                        Code ,
                        Date ,
                        Supplier ,
                        Pembuat ,
                        Dibuat
                    )
                    values
                    (
                        '".$code."',
                        '".$tanggal."',
                        '".$suplier."',
                        '".$Session."',
                        NOW()
                    )";
                    //$exe_purchase_order_main = mysqli_query($koneksi,$sql_purchase_order_main);
                    if($koneksi->query($sql_purchase_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert purchase order detail
                        $last_id = $koneksi->insert_id;
                        $TotalPR = 0;
                        foreach ($Items as $key)
                        {
                            $sql_purchase_order_detail = "";
                            $sql_purchase_order_detail="insert into PurchaseReturnDetail
                            (PurchaseReturnId , ItemId , Satuan , UnitPrice , Qty , TotalPrice , Pembuat , Dibuat)
                            values('".$last_id."','".$key[0]."','".$key[2]."','".$key[5]."' , '".$key[4]."' , '".$key[6]."' , '".$Session."' , NOW())";
                            //$exe_purchase_order_detail = mysqli_query($koneksi,$sql_purchase_order_detail);
                            if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                            {
                                $TotalPR = $TotalPR + $key[6];
                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data Purchase Return Detail Gagal Disimpan
                                        </div>";
                            }
                        }

                        $sql_update_po = "Update PurchaseReturn Set Total = '".$TotalPR."' where id = '".$last_id."'";
                        if ($koneksi->query($sql_update_po) === TRUE)
                        {
                            //jika true kurangin hutang ke supplier tersebut
                                $insert_ar_payment = "Insert Into ARPayment
                                (
                                    supplier_id,
                                    return_id,
                                    date,
                                    total,
                                    pembuat,
                                    dibuat
                                )
                                values
                                (
                                    '".$suplier."',
                                    '".$last_id."',
                                    '".$tanggal."',
                                    '".$TotalPR."',
                                    '".$Session."',
                                    NOW()
                                )";
                                if ($koneksi->query($insert_ar_payment) === TRUE)
                                {
                                    echo ("<script>location.href='PurchaseReturnMainList.php';</script>");
                                }
                        }
                    }
                    else
                    {
                        echo    "<div class='alert alert-danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Error!</strong> Data Purchase Return Gagal Disimpan
                        </div>";
                    }
            }
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputDate">Tangal</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                </div>
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
                        <label class="form-label">Jumlah Retur</label>
                        <div class="">
                            <input type="number" class="form-control" name="qty" id="qty"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Price</label>
                        <div class="">
                            <input type="text" class="form-control" name="unit_price" id="unit_price"/>
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
                <input type="textarea" value="" name="arrayItem" id="arrayItem"/>
                <div class="col">
                    <hr style="border-top: 25px solid black;" />
                </div>
                <table id="TablePurchaseReturnDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan Retur</th>
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
            var currDate = new Date();
            $('#tanggal').datepicker({
                autoclose: true,
                startDate: currDate,
            });
            var table =  $('#TablePurchaseReturnDetail').DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true
                    });
            $("#btnTambahBarang").click(function(e){
                // <th>ID Barang</th>
                // <th>Nama Barang</th>
                // <th>Satuan Retur</th>
                // <th>Nilai Konversi</th>
                // <th>Qty</th>
                // <th>Harga</th>
                // <th>Sub Harga</th>
                var UnitPrice = "";
                var satuan      = $("#satuan_barang").val();
                var unitprice   = $("#unit_price").val();
                var satuanbesar = $("#satuanbesar").val();
                var satuankecil = $("#satuankecil").val();
                var konversi    = $("#konversi").val();
                var qty         = $("#qty").val();
                table.row.add
                ([
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    satuan,
                    konversi,
                    qty,
                    unitprice,
                    $("#total_price").val()
                ]).draw( false );
                DataItem.push
                ([
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    satuan,
                    konversi,
                    qty,
                    unitprice,
                    $("#total_price").val()
                ]);
                $("#arrayItem").val(JSON.stringify(DataItem))
            });

            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_toko.php", { term : $("#nama_barang").val() , supplier: $( "#suplier_name option:selected" ).text() },
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
                    $("#unit_price_satuan_besar").val(e.modal * e.satuankonversi);
                    $("#satuanbesar").val(e.satuanbesar);
                    $("#satuankecil").val(e.satuankecil);

                }
            });

            $("#qty").on('keyup change click', function () {
                calculate_total_price();
            });

            $("#unit_price").on('keyup change click', function () {
                calculate_total_price();
            });

            function calculate_total_price(){
                var satuan      = $("#satuan_barang").val() == "" ? "0" : $("#satuan_barang").val();
                var unitprice   = $("#unit_price").val() == "" ? "0" : $("#unit_price").val();
                var satuanbesar = $("#satuanbesar").val();
                var satuankecil = $("#satuankecil").val();
                var konversi    = $("#konversi").val();
                var qty         = $("#qty").val() == "" ? "1" : $("#qty").val()
                if (satuan == satuanbesar)
                {
                    var TotalPrice = parseInt( unitprice ) * ( parseInt(qty) * parseInt(konversi) )
                    $("#total_price").val(TotalPrice);
                }
                else
                {
                    var TotalPrice = qty * parseInt(unitprice);
                    $("#total_price").val(TotalPrice);
                }
            }

		})
</script>
