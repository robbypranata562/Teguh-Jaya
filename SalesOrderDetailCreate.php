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
                   
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    print_r($Items);
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
                            '".$_GET['id']."',
                            '".$key[0]."',
                            '".$key[2]."',
                            '".$key[3]."',
                            '".$key[4]."' , 
                            '".$Session."' , 
                            NOW()
                        )";
                        //$exe_Sales_order_detail = mysqli_query($koneksi,$sql_Sales_order_detail);
                        //print_r($sql_Sales_order_detail);
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
                    //echo ("<script>location.href='SalesOrderDetailList.php';</script>");
                }
            ?>
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang"  >
                            <input  type="hidden" name="id_barang" id="id_barang" value="" />
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
                    $('#TableSalesOrderDetail').DataTable({
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
                        $("#qty").val(),
                        $("#satuan_barang").val(),
                        $("#konversi").val()
                    ]);
                $("#arrayItem").val(JSON.stringify(DataItem))
            })

            $("#btnTambahBarang2").click(function(e){
                console.log(DataItem)
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
                    $("#satuan_barang").append(new Option("Pcs", "Pcs"));
                    $("#jumlah_satuan_kecil").val(e.JumlahSatuanKecil)
                    $("#jumlah_satuan_besar").val(e.JumlahSatuanBesar)
                    
                }
            });
		})
</script>