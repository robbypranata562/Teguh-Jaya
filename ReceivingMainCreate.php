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
                    $code=$_POST['code'];
                    $tanggal=$_POST['tanggal'];
                    $tanggal=$_POST['tanggal'];
                    $suplier=$_POST['suplier_name'];
                    $PurchaseOrderCode=$_POST['PurchaseOrderCode'];
                    $BiayaKirim = $_POST['BiayaKirim'];
                    $BiayaEkstra = $_POST['BiayaEkstra'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
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
                    Type) 
                    values(
                    '".$code."',
                    '".$tanggal."',
                    '".$suplier."',
                    '".$PurchaseOrderCode."',
                    '".$BiayaKirim."',
                    '".$BiayaEkstra."',
                    '".$Session."' , 
                    NOW(),
                    '1')";
                    //die($sql_purchase_order_main);
                    //$exe_purchase_order_main = mysqli_query($koneksi,$sql_purchase_order_main);
                    if($koneksi->query($sql_purchase_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert purchase order detail
                        $last_id = $koneksi->insert_id;
                        $TotalReceiving = 0;
                        foreach ($Items as $key) 
                        {

                            // $("#id_barang").val(),
                            // $("#nama_barang").val(),
                            // $("#Satuan").val(),
                            // $("#OrderQty").val(),
                            // $("#ReceivingQty").val(),
                            // $("#Konversi").val(),
                            // $("#UnitPrice").val(),
                            // $("#TotalPrice").val()

                            $sql_purchase_order_detail = "";
                            $sql_purchase_order_detail="insert into ReceivingDetail
                            (ReceivingId , ItemId , OrderQty , ReceivingQty , UOM , UnitPrice , TotalPrice , CreatedBy , CreatedDate , Konversi) 
                            values(
                                '".$last_id."',
                                '".$key[0]."',
                                '".$key[3]."',
                                '".$key[4]."',
                                '".$key[2]."' , 
                                '".$key[6]."' , 
                                '".$key[7]."' , 
                                '".$Session."' , 
                                NOW(),
                                '".$key[5]."')";
                            //$exe_purchase_order_detail = mysqli_query($koneksi,$sql_purchase_order_detail);
                            if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                            {
  
                                if ($key[2] == 'Pcs' || $key[2] == 'pcs'){
                                    $sql_update_stok_item = "
                                    update item set
                                    jumlahsatuankecil = jumlahsatuankecil + ".$key[4].",
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
                                    jumlahsatuankecil = jumlahsatuankecil + ".$AddValueStock.",
                                    Modal = ".$HPP."
                                    where
                                    id = '".$key[0]."'
                                    ";
                                    //echo $sql_update_stok_item;
                                }
                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {
                                    $TotalReceiving = $TotalReceiving + $key[7];
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
                            $sql_insert_AR="insert into AR
                            (supplier_id , receivingid , date , total , CreatedBy , CreatedDate) 
                            values(
                                '".$suplier."',
                                '".$last_id."',
                                '".$tanggal."',
                                '".$TotalReceiving."',
                                '".$Session."' , 
                                NOW())";

                            if ($koneksi->query($sql_insert_AR) === TRUE){
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
            <form class="form-body" ata-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Kode Penerimaan</label>
                    <div class="">
                        <input type="text" class="form-control" name="code" id="code"/>
                    </div>
                </div>                
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
                        <select class="form-control" style="width: 100%;" name="suplier_name" id="suplier_name">
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
                <!-- <div class="form-group">
                    <label class = "form-label">Tipe</label>
                    <div class>
                    <select class="form-control"   style="width: 100%;" name="TipePenerimaan" id="TipePenerimaan">
                        <option value="1">Dengan Purchase Order</option>
                        <option value="2">Tanpa Purchase Order</option>
                    </select>
                    </div>
                </div> -->
                <div class="form-group" id="OptionPurchaseCode">
                    <label for="">Purchase Order</label>
                    <div class>
                        <select class="form-control select2" style="width: 100%;" name="PurchaseOrderCode" id="PurchaseOrderCode">
                            <option value="">Pilih Purchase Order :</option>    
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Biaya Kirim</label>
                    <div class="">
                        <input type="text" class="form-control" name="BiayaKirim" id="BiayaKirim"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Biaya Ekstra</label>
                    <div class="">
                        <input type="text" class="form-control" name="BiayaEkstra" id="BiayaEkstra"/>
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
                </div>
                <input type="textarea" value="" name="arrayItem" id="arrayItem"/>
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
                    $('#TableReceivingDetail').DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true
                    });

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
                var BiayaKirim = $("#BiayaKirim").val();
                var BiayaEkstra = $("#BiayaEkstra").val();
                var LastUnitPrice = $("#lastunitprice").val();
                var Konversi = $("#Konversi").val();
                var Satuan = $("#Satuan").val();
                var ReceivingQty = $("#ReceivingQty").val() == "" ? "0" :  $("#ReceivingQty").val() ;
                var NewUnitPrice = "";
                var SmallUnitQty = 0;

                $("#UnitPrice").val("0");
                if (Satuan.toLowerCase() != "pcs"){
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

		})
</script>