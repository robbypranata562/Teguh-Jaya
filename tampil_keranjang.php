

<div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
        
                <tr>
                  <th>Nama Barang</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
          <th>Harga Beli</th>
                  <th>Sub Total</th>
          <th>Tanggal</th>
          <th>Action</th>
          
              
                </tr>
                </thead>
                <tbody>
       
        <?php
		include"koneksi.php";
        $sid = session_id();
          $sql_t="SELECT * FROM keranjang, stok_toko, barang where keranjang.id_barangtoko=stok_toko.id_toko AND stok_toko.id_gudang=barang.id_gudang";
          $exe_t=mysqli_query($koneksi,$sql_t);
        
          while($data=mysqli_fetch_array($exe_t)){
            $subtotal = $data['harga_akhir'] * $data['jumlah_keranjang'];
             $total += $subtotal;
            
             $totalSemua ="Rp. ".number_format($total,'0',',','.')."-";
             $harga="Rp. ".number_format($data['harga_atas_toko'],'0',',','.')."-";

        
        ?>
                <tr>
                  <td><?php echo $data['nama'];?></td>
                 <td><a href="#harga_modal" data-toggle="modal" data-target="#harga_dialog" data-id="<?php echo $data['id_keranjang'];?>" data-harga="<?php echo $data['harga_atas_toko'];?>" data-idtoko="<?php echo $data['id_barangtoko'];?>"><?php echo $harga; ?></a></td>

                   <td><a href="#qty_modal" data-toggle="modal" data-target="#qty_dialog" data-id="<?php echo $data['id_keranjang'];?>" data-jumlah="<?php echo $data['jumlah_keranjang'];?>"><?php echo $data['jumlah_keranjang']; ?></a></td>
                  <td><?php echo $data['harga_akhir'];?></td>
          <td><?php echo $subtotal;?></td>
          
          <td><?php echo $data['tanggal'];?></td>
          <td><a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='keranjang_hapus.php?id=<?php echo $data['id_keranjang']; ?>' }"  class="glyphicon glyphicon-trash">Hapus</a></td>
          
                </tr>
          <?php } ?>
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
            </div>
			
            

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      
       <!-- Modal HARGA -->
        <div class="modal fade" id="harga_dialog" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Harga</h4>
                    </div>
                    <div class="modal-body">
                        <form id="harga_form" action="" method="POST">
            
                           <input type= "text" id="harga" class="form-control" name="harga"  >
                            <input  type="hidden" name="id_keranjang" id="id_keranjang" value="" />
                            <input  type="hidden" name="id_toko" id="id_toko" value="" />
              
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
                        <button type="button" id="submitFormHarga" class="btn btn-default">OK</button>
                    </div>
                </div>
            </div>
        </div>
    
        
<!-- Modal QTY -->
        <div class="modal fade" id="qty_dialog" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Jumlah Barang</h4>
                    </div>
                    <div class="modal-body">
          
                        <form id="qty_form" action="" method="POST">
                           <input type= "text" id="jumlah_barang" class="form-control" name="jumlah_barang"  >
                            <input  type="hidden" name="id_keranjang" id="id_keranjang" value="" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="submitForm" class="btn btn-default">OK</button>
                    </div>
                </div>
            </div>
        </div>

       </form>
        <script>
        $(function(){
    $('#qty_dialog').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var jumlahKeranjang = $(e.relatedTarget).data('jumlah');

    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
      $(e.currentTarget).find('input[name="jumlah_barang"]').val(jumlahKeranjang);
  });

    $('#harga_dialog').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var harga = $(e.relatedTarget).data('harga');
    var idToko = $(e.relatedTarget).data('idtoko');

    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('input[name="id_toko"]').val(idToko);
  });

   

  });
    /* must apply only after HTML has loaded */
    $(document).ready(function () {
        $("#qty_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = "update_jumlahkeranjang.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                    $('#qty_dialog .modal-header .modal-title').html("Result");
                    $('#qty_dialog .modal-body').html(data);
                    $("#submitForm").remove();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });
         
         
        $("#submitForm").on('click', function() {
            $("#qty_form").submit();
            location.reload();
        });
    });


      // NEGO HARGA
     $(document).ready(function () {
        $("#harga_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = "nego_harga.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                    $('#harga_dialog .modal-header .modal-title').html("Result");
                    $('#harga_dialog .modal-body').html(data);
                    $("#submitFormHarga").remove();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });
         
        $("#submitFormHarga").on('click', function() {
            $("#harga_form").submit();
            if (data!= "Maaf Tidak bisa") {
              location.reload();
            }
            
        });
        $("#btnClose").on('click', function() {
            
              location.reload();
            
            
        });
    });
</script>