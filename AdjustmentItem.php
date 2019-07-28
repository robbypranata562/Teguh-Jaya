<?php
    include "header.php";
    include "koneksi.php";
?>
<div class="modal fade" id="myModal" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
            <form action="confirmation.php" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username"  id="username" class="form-control" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btnConfirm" name="btnConfirm">Confirmation</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

    </div>
</div>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Adjustment</h3>
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
                        $Session = $_SESSION['nama'];
                        $Items = json_decode($_POST['arrayItem']);
                        foreach ($Items as $key)
                        {
                            $operation = "";
                            if ( (int) $key[3] > (int) $key[4] ) 
                            {
                                $operation = "-";
                            }

                            else 
                            {
                                $operation = "+";
                            }

                            $sql_Adjustment = "";
                            $sql_Adjustment="insert into Adjustment
                            (
                                ItemId ,
                                Date ,
                                LastQty,
                                NewQty,
                                Operation ,
                                CreatedBy ,
                                CreatedDate)
                            values
                            (
                                '".$key[0]."'       ,
                                NOW()               ,
                                '".$key[3]."'       ,
                                '".$key[4]."'       ,
                                '".$operation."'    ,
                                '".$Session."'      ,
                                NOW())";
                                //print_r($sql_Adjustment);
                            if ($koneksi->query($sql_Adjustment) === TRUE)
                            {
                                $konversi   =   $key[2];
                                $LastValue  =   $key[3];
                                $NewValue   =   $key[4];
//                                 if ( $LastValue > $NewValue ) // dikurangin
//                                 {
//                                     $jumlah_satuan_besar = $NewValue / $konversi;
//                                     $satuan_besar = round($jumlah_satuan_besar, 0);
//                                     $sql_update_stok_item =
// "
//                                     update item
//                                     set
//                                         jumlahsatuanbesar   = jumlahsatuanbesar - ".$satuan_besar.",
//                                         jumlahsatuankecil   = jumlahsatuankecil - ".$NewValue."
//                                     where
//                                         id                  = '".$key[0]."'
//                                     ";
//                                 }
//                                 else if ( $LastValue < $NewValue ) //ditambah
//                                 {
                                    $jumlah_satuan_besar = $NewValue / $konversi;
                                    //printf($jumlah_satuan_besar);
                                    $satuan_besar = round($jumlah_satuan_besar, 0);
                                    $sql_update_stok_item = "
                                    update item
                                    set
                                        jumlahsatuanbesar   = ".$satuan_besar.",
                                        jumlahsatuankecil   = ".$NewValue."
                                    where
                                        id                  = '".$key[0]."'
                                    ";

                                // }
                                //print_r($sql_update_stok_item);
                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {

                                }
                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data Adjustment Detail Gagal Disimpan
                                        </div>";
                            }
                        }
                        echo ("<script>location.href='tampil_barang.php';</script>");

            }
            ?>
            <form id="formAdjustment" name="formAdjustment" class="form-body" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
                <div class>
                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang"  >
                            <input  type="hidden" name="id_barang" id="id_barang" value="" />
                            <input  type="hidden" name="jumlahsatuankecil" id="jumlahsatuankecil" value="" />
                            <input  type="hidden" name="konversi" id="konversi" value="" />
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat" name="tambah">Tambah</button>
                            </span>
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
                <table id="TableAdjustment" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Konversi</th>
                            <th>Last Value</th>
                            <th>New Value</th>
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
            var table =     
            $('#TableAdjustment').dataTable
            (
                {
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": true
                }
            );
            $("#btnTambahBarang").click(function(e){
                table.api().row.add
                ([
                    $("#id_barang").val(),
                    $("#nama_barang").val(),
                    $("#konversi").val(),
                    $("#jumlahsatuankecil").val(),
                    "<input type='number' class='form-control' value='" + $("#jumlahsatuankecil").val() + "'/>"  
                ]).draw( false );
            });

            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("search_barang.php", { term : $("#nama_barang").val() },
                response)},
                select: function(event, ui)
                {
                    var e = ui.item;
                    $("#id_barang").val(e.id);
                    $("#nama_barang").val(e.NamaBarang);
                    $("#konversi").val(e.satuankonversi);
                    $("#jumlahsatuankecil").val(e.jumlahsatuankecil);
                }
            });

            $("#btnTest").click(function(e){
                var DataItem = [];
                var info = table.api().page.info();
                var length = info.recordsTotal - 1;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableAdjustment tbody tr:eq("+i+")");
                    DataItem.push([
                        $("td:eq(0)",row).html(),
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html(),
                        $("td:eq(4) input[type='number']",row).val()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#myModal").modal('show');
            });

            $("#btnConfirm").click(function(){
                $.ajax({
                        url: 'confirmation.php',
                        type: 'POST',
                        dataType: "json",
                        data:
                        {
                            username: $("#username").val(),
                            password: $("#password").val()
                        }
                    }).success(function(data){
                        console.log(data)
                       if (data == "OK"){
                        $("#myModal").modal('hide')
                        $("#formAdjustment").submit();
                       }
                       else{
                        alert(data)
                       }

                    }).error(function(data){

                    });
            });
		})
</script>
