<?php include "header.php";?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
            <?php
              include "koneksi.php";
           
            ?>
            <style type="text/css">
              div.bord {border: 2px solid grey; padding: 5px; border-radius: 2px; border-s  }

            </style>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penjualan
        <small></small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      
<div class="row">
        <div class="col-md-8">

          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><a href="#">Penjualan</a></h3>
            </div>
            <div class="box-body">
              <!-- Date dd/mm/yyyy -->
               <form action="" method="post">
               
        <div class="form-group">
              <div class="ui-widget">
                <label>Cari Barang</label>
                 <div class="input-group input-group-sm">
                    <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang"  >
                    <input  type="hidden" name="getID" id="result" value="" />
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat" name="tambah">Tambah</button>
                    </span>
                 </div>
               
                
                 </div>
              </div>
                <!-- <div class="col-xs-4">
                  <button type="submit" name="tambah" class="btn btn-primary btn-block btn-flat">Tambah</button>
                </div> 
                 
          
              </form>-->
               <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr> 
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
              <tbody>
        <?php
        error_reporting(0);
        
        $nama_pelanggan="-";
        $hutang_tampil = "Rp.-";
        $saldo_tampil = "Rp.-";
        $id_pelanggan="0";
          /* if(isset($_POST['bayar'])){
           $id_pelanggan=$_POST['id_pelanggan'];
           $bayar=$_POST['bayarr'];
           $kembalian= $bayar - $total;
           $sql_belanja="INSERT INTO transaksi VALUES(NULL,$id_pelanggan,'$total','$bayar','$kembalian',NOW())";
           $exe_bel=mysqli_query($koneksi,$sql_belanja);
           }*/
        if(isset($_POST['tambah']))
        {
          //$id_pel=$_POST['id_pelanggan'];
          $id =$_POST['getID'];
          $x="select * from stok_toko where id_toko='$id'";
          $y=mysqli_query($koneksi,$x);
          while($z=mysqli_fetch_array($y)){
            $hrg=$z['harga_atas_toko'];
            $jum=$z['jumlah_toko'];
            $jum_tot= $jum - 1;
          }
        $id =$_POST['getID'];
        $sid= session_id();
        $sql_p="SELECT jumlah_toko from stok_toko where id_toko='$id'";
        $exe_p=mysqli_query($koneksi,$sql_p);
        while($data_p=mysqli_fetch_array($exe_p))
        {
          $p=$data_p['jumlah_toko'];
        }
        if($p >= 1){
          //di cek dulu apakah barang yang di beli sudah ada di tabel keranjang
          $sql ="SELECT id_barangtoko FROM keranjang WHERE id_barangtoko='$id' AND id_sesion='$sid'";
          $exe=mysqli_query($koneksi,$sql);
          $ketemu=mysqli_num_rows($exe);
          if (!$ketemu)
          {
            // kalau barang belum ada, maka di jalankan perintah insert
            //$sql_0="INSERT INTO keranjang VALUES ('','$id','$id_pelanggan','1','$hrg','$hrg','$hrg','0','$sid',NOW())";
            // $sql_ker="INSERT INTO barang_terjual VALUES (NULL,'$id','$id_pelanggan','$hrg','1',NOW(),'$sid')";
            //  $exe_ker=mysqli_query($koneksi,$sql_ker);
            $sql_0="INSERT INTO keranjang VALUES (NULL,'$id','$id_pelanggan','1','$hrg','$hrg','$hrg','0','$sid',NOW())";
            $exe_0=mysqli_query($koneksi,$sql_0);
            // $sql_ub="UPDATE stok_toko set jumlah_toko=$jum_tot where id_toko=$id";
            // $exe_ub=mysqli_query($koneksi,$sql_ub);
          } 
          else 
          {
            //  kalau barang ada, maka di jalankan perintah update
            $sql_0u="UPDATE keranjang
            SET jumlah_keranjang = jumlah_keranjang WHERE id_sesion ='$sid' AND id_barangtoko='$id'";
            $exe_0u=mysqli_query($koneksi,$sql_0u) ;      
          }   
   // header('Location:penjualan.php');
        }
        else
        {
          echo
          "<div class='alert alert-danger'>
            <a class='close' data-dismiss='alert' href='#'>&times;</a>
            Stok Barang di Toko Sudah Habis
          </div>";
          $sql_delete="DELETE from stok_toko where id_toko='$id'";
          $exe_delete=mysqli_query($koneksi,$sql_delete);
        }
      }?>
      <?php
      $sid = session_id();
      $sql_t="SELECT * FROM keranjang, stok_toko where id_sesion='$sid' AND keranjang.id_barangtoko=stok_toko.id_toko";
      $exe_t=mysqli_query($koneksi,$sql_t);
      while($data=mysqli_fetch_array($exe_t))
      {
        $subtotal = $data['sub_total'] ;
        $subtotalDiskon = $data['sub_totaldiskon'] ;
        $total += $subtotalDiskon;
        $harga_akhir = "Rp. ".number_format($data['harga_akhir'],'0',',','.')."-";
        $tampil_subtotal = "Rp. ".number_format($subtotalDiskon,'0',',','.')."-";
        $totalSemua ="Rp. ".number_format($total,'0',',','.')."-";
        $harga="Rp. ".number_format($data['harga_atas_toko'],'0',',','.')."-";
        $hargaDiskonKirim=$data['total_hargadiskon'];
        $hargaDiskon="Rp. ".number_format($data['total_hargadiskon'],'0',',','.')."-";
        $idBarangTabel =$data['id_barangtoko'];
        $jumlahKeranjangTabel = $data['jumlah_keranjang'];
        //get total harga
        ?>
          <tr>
            <td><?php echo $data['tanggal'];?></td>
            <td><?php echo $data['nama_toko'];?></td>
            <td><a href="#harga_modal" data-toggle="modal" data-target="#harga_dialog" data-id="<?php echo $data['id_keranjang'];?>" data-harga="<?php echo $data['harga_atas_toko'];?>" data-idtoko="<?php echo $data['id_barangtoko'];?>" data-jumlahker="<?php echo $data['jumlah_keranjang'];?>"><?php echo $harga; ?></a></td>
            <td><a href="#qty_modal" data-toggle="modal" data-target="#qty_dialog" data-id="<?php echo $data['id_keranjang'];?>" data-jumlah="<?php echo $data['jumlah_keranjang'];?>" data-idtoko="<?php echo $data['id_barangtoko'];?>" data-hargaakhir="<?php echo $data['harga_akhir'];?>"><?php echo $data['jumlah_keranjang']; ?></a></td>
            <td><?php echo $harga_akhir;?></td>
            <td><a href="#subtotal_modal" data-toggle="modal" data-target="#subtotal_dialog" data-id="<?php echo $data['id_keranjang'];?>" data-harga="<?php echo $subtotalDiskon;?>" data-idtoko="<?php echo $data['id_barangtoko'];?>"><?php echo $tampil_subtotal; ?></a></td>
            <td><a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='keranjang_hapus.php?id=<?php echo $data['id_keranjang']; ?>' }"  class="glyphicon glyphicon-trash">Hapus</a></td>
          </tr>
          <?php } ?>
          </tbody>
          <tfoot>
               <tr >
                <th colspan="5">Total Semua</th>
                  <th><strike></strike><a href="#totalsemua_modal" data-toggle="modal" data-target="#totalsemua_dialog" data-id="<?php echo $sid;?>" data-harga="<?php echo $total;?>" data-idtoko="<?php echo $data['id_barangtoko'];?>"><?php echo $totalSemua; ?></a></th>
              
                
            </tr>
            <tr id="totaldiskon" >
                <th colspan="5">Total Semua (Diskon)</th>
                 
                <th><?php echo $hargaDiskon; ?></th>
                
            </tr>
             <tr  >
                <th colspan="6"></th>
                 
                <th><a class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='keranjang_hapussemua.php?id=<?php echo $sid; ?>' }"  class="glyphicon glyphicon-trash">Hapus semua</a></th>
                
            </tr>

                </tfoot>
              </table>
            </div>
            

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </form> 
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
                             <input  type="hidden" name="jumlah_ker" id="jumlah_ker" value="" />
              
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
                              <input  type="hidden" name="id_toko" id="id_toko" value="" />
                               <input  type="hidden" name="harga_akhir" id="harga_akhir" value="" />
                        </form>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal" id="btnTutup">Close</button>
                        <button type="button" id="submitForm" class="btn btn-default">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Subtotal -->
  
        <div class="modal fade" id="subtotal_dialog" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Subtotal</h4>
                    </div>
                    <div class="modal-body">
                        <form id="subtotal_form" action="" method="POST">
            
                           <input type= "text" id="harga" class="form-control" name="harga"  >
                            <input  type="hidden" name="id_keranjang" id="id_keranjang" value="" />
                            <input  type="hidden" name="subtotal_harga" id="subtotal_harga" value="" />
                            <input  type="hidden" name="id_toko" id="id_toko" value="" />
              
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloses">Close</button>
                        <button type="button" id="submitFormSubtotal" class="btn btn-default">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="totalsemua_dialog" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Total Semua</h4>
                    </div>
                    <div class="modal-body">
                        <form id="totalsemua_form" action="" method="POST">
            
                           <input type= "text" id="harga" class="form-control" name="harga"  >
                            <input  type="hidden" name="id_keranjang" id="id_keranjang" value="" />
                            <input  type="hidden" name="total_harga" id="total_harga" value="" />
                            <input  type="hidden" name="id_toko" id="id_toko" value="" />
              
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClosess">Close</button>
                        <button type="button" id="submitFormtotalsemua" class="btn btn-default">OK</button>
                    </div>
                </div>
            </div>
        </div>

       
        <script>
        $(function(){
    $('#qty_dialog').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var jumlahKeranjang = $(e.relatedTarget).data('jumlah');
  var idtk = $(e.relatedTarget).data('idtoko');
  var hargaAkhir = $(e.relatedTarget).data('hargaakhir');

    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
    $(e.currentTarget).find('input[name="jumlah_barang"]').val(jumlahKeranjang);
  $(e.currentTarget).find('input[name="id_toko"]').val(idtk);
  $(e.currentTarget).find('input[name="harga_akhir"]').val(hargaAkhir);
  });

    $('#harga_dialog').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var harga = $(e.relatedTarget).data('harga');
    var idToko = $(e.relatedTarget).data('idtoko');
  var jumlahKeranjang = $(e.relatedTarget).data('jumlahker');
    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('input[name="id_toko"]').val(idToko);
     $(e.currentTarget).find('input[name="jumlah_ker"]').val(jumlahKeranjang);
  });

     $('#subtotal_dialog').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var harga = $(e.relatedTarget).data('harga');
    var idToko = $(e.relatedTarget).data('idtoko');
    var subtotalHarga = $(e.relatedTarget).data('harga');

    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('input[name="id_toko"]').val(idToko);
    $(e.currentTarget).find('input[name="subtotal_harga"]').val(subtotalHarga);
  });
      $('#totalsemua_dialog').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idKeranjang = $(e.relatedTarget).data('id');
    var harga = $(e.relatedTarget).data('harga');
    var idToko = $(e.relatedTarget).data('idtoko');
    var totalHarga = $(e.relatedTarget).data('harga');

    //populate the textbox
    $(e.currentTarget).find('input[name="id_keranjang"]').val(idKeranjang);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('input[name="id_toko"]').val(idToko);
    $(e.currentTarget).find('input[name="total_harga"]').val(totalHarga);
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
             // location.reload();
        });
        $("#btnTutup").on('click', function() {
            
              location.reload();
            
            
        });
    });


      // NEGO HARGA
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
           
            
        });
        $("#btnClose").on('click', function() {
            
              location.reload();
            
            
        });
    });

//Subtotal
     $(document).ready(function () {
        $("#subtotal_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = "nego_subtotal.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                    $('#subtotal_dialog .modal-header .modal-title').html("Result");
                    $('#subtotal_dialog .modal-body').html(data);
                    $("#submitFormSubtotal").remove();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });
         
        $("#submitFormSubtotal").on('click', function() {
            $("#subtotal_form").submit();
           
            
        });
        $("#btnCloses").on('click', function() {
            
              location.reload();
            
            
        });
    });

    
    //NEGO TOTAL SEMUA
     $(document).ready(function () {
        $("#totalsemua_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            
            var formURL = "nego_totalharga.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                    $('#totalsemua_dialog .modal-header .modal-title').html("Result");
                    $('#totalsemua_dialog .modal-body').html(data);
                    $("#submitFormtotalsemua").remove();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });
         
        $("#submitFormtotalsemua").on('click', function() {
            $("#totalsemua_form").submit();
           
            
        });
        $("#btnClosess").on('click', function() {
            
              location.reload();
              
            
            
        });
    });

     
</script>
          
          <!-- /.box -->

        </div>
        <!-- /.col (left) -->
         

        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pelanggan</h3>
            </div>
            <div class="box-body">

<form action="" method="post">
 <div class="form-group">
               
                 <div class="input-group input-group-sm">
                    <input type= "text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Masukkan Nama Pelanggan"   value="">
                    <input  type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $id_pel;?>"  />
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat" name="tambah_pelanggan">Tambah</button>
                    </span>
                 </div>
               
                
                 </div>
                 </form>
              
              <div class="form-group">
<?php if(isset($_POST['tambah_pelanggan'])){
          $idPelanggan=$_POST['id_pelanggan'];
        $nama_pelanggan=$_POST['nama_pelanggan'];
        $nama_pel=$_POST['nama_pelanggan'];
       

    
    

      if ($idPelanggan == "") {
        
           
                      //  $tambah = "INSERT INTO pelanggan( nama_pelanggan, hutang)VALUES('$nama_pelanggan','0')";
                      // $connecttambah=mysqli_query($koneksi,$tambah);
                     
                      //   $id_pelanggan = mysqli_insert_id($koneksi);
           ?> 
    <form role="form" action="tbh_pel.php" method="post" enctype="multipart/form-data">
      <div>
         
                   
              <div class="box-body">
              <div class="form-group">
                 Nama Pelanggan<br>
                  <label><?php echo $nama_pelanggan ?></label>
                   <input type="hidden" name="nama" class="form-control" id="exampleInputEmail1" value="<?php echo $nama_pelanggan ?>">
              </div>
        <div class="form-group">

                  Alamat :
                  <textarea class="form-control" rows="3" placeholder="Enter ..." name="alamat"></textarea>
                </div>
        <div class="form-group">
               Nomor Handphone :
                  <input type="text" name="hp" class="form-control" id="exampleInputEmail1" placeholder="Nomor Handphone">
                </div>
        
        
        <div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
        <form>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
    </div>
  </div>

  
<script type="text/javascript">
  //TAMBAH PELANGGAN BARU
      $(document).ready(function () {
        $("#pelanggan_form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            
            var formURL = "tbh_pel.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                   document.getElementById('content').value='';
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });
         
        $("#submitFormtotalsemua").on('click', function() {
            $("#totalsemua_form").submit();
           
            
        });
        $("#btnClosess").on('click', function() {
            
              location.reload();
              
            
            
        });
    });
</script>

 
  <?php
        }else{

             $id_pelanggan = $idPelanggan;

         
           $sql_cekpelanggan="SELECT * FROM  pelanggan where id_pelanggan='$id_pelanggan'";
        $connect=mysqli_query($koneksi,$sql_cekpelanggan);
        while($row=mysqli_fetch_assoc($connect))
        {
              $nama_pelanggan = $row['nama_pelanggan'];
              $alamatPel = $row['alamat'];
              $nohp = $row['nohp'];
              $nama_pelanggan = $row['nama_pelanggan'];
              $id_pelanggan = $row['id_pelanggan'];
              $nama_label ="Nama Pelanggan";
              $hutang_tampil="Rp. ".number_format($row['hutang'],'0',',','.')."-";
              $saldo_tampil = "Rp. ".number_format($row['saldo'],'0',',','.')."-";
              $hutangKirim =$row['hutang'];
              $saldoKirim = $row['saldo'];
              $queryUpKer = "UPDATE keranjang SET id_pelanggan = '$id_pelanggan'";
              $connUp = mysqli_query($koneksi,$queryUpKer);
            }
            ?>

                  <p> Detail Pelanggan : </p>
                <label><?php echo $nama_pelanggan ?></label><br>
                  Alamat : <?php echo $alamatPel ?><br>
                   Tlp : <?php echo $nohp ?>
                <!--  <label><?php echo $id_pelanggan ?></label>  -->
                <!-- /.input group -->
              </div>
       

       
          
           <?php }  }else{
             $idPelangganBaru = $_GET['id_pelanggan'];

             if ($idPelangganBaru!=NULL) {

                $id_pelanggan = $idPelangganBaru;


             $sql_cekpelanggan="SELECT * FROM  pelanggan where id_pelanggan='$id_pelanggan'";
        $connect=mysqli_query($koneksi,$sql_cekpelanggan);
        while($row=mysqli_fetch_assoc($connect)){
  
        $nama_pelanggan = $row['nama_pelanggan'];
        $alamatPel = $row['alamat'];
        $nohp = $row['nohp'];
        $id_pelanggan = $row['id_pelanggan'];
        $nama_label ="Nama Pelanggan";
        $hutang_tampil="Rp. ".number_format($row['hutang'],'0',',','.')."-";
         $saldo_tampil = "Rp. ".number_format($row['saldo'],'0',',','.')."-";
        $hutangKirim =$row['hutang'];
        $saldoKirim = $row['saldo'];

        $queryUpKer = "UPDATE keranjang SET id_pelanggan = '$id_pelanggan'";
        $connUp = mysqli_query($koneksi,$queryUpKer);
            }
            ?>

                  <p> Detail Pelanggan : </p>
               <label><?php echo $nama_pelanggan ?></label><br>
                  Alamat : <?php echo $alamatPel ?><br>
                   Tlp : <?php echo $nohp ?>
                <!--  <label><?php echo $id_pelanggan ?></label>  -->
                <!-- /.input group -->
              </div>
             <?php 
            }
            } ?>
              <!-- /.form group -->
             
<div class="row justify">
  <div class="col-sm-5 col-md-5">
    <div class="bord">
     
        Jumlah Hutang <br><br>
   
        <label class="justify" ><font color="#F44336"><label id="hutang" name="huntang" value=""></h3> <?php echo $hutang_tampil ; ?></font></label>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
      
    </div>
  </div>

   <div class="col-sm-5 col-md-5">
    <div class="bord">
     
        Jumlah Saldo <br><br>
   
        <label> <font color="#2196F3"><label id="saldo" name="saldo" value=""></h3> <?php echo $saldo_tampil ; ?></font></label>
        
        <!-- <p><a href="#" class="btn btn-primary" role="button">bayar</a></p> -->
      
    </div>
  </div>
  
  
  </div>
</div>    



         
         
      
          <!-- Custom Tabs -->
         
        <!-- /.col -->

       
        <!-- /.col -->
      </div>
   
     <div class="input-group">
        <ul class="nav nav-pills">
  <li class="active"><a data-toggle="tab" href="#home">Bayar Semua</a></li>
  <li><a data-toggle="tab" href="#menu1">Bayar Hutang</a></li>
  <li><a data-toggle="tab" href="#menu2">Ngutang</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
  <?php 
   if (isset($_POST['tambah_pelanggan'])) {
    if ($hargaDiskonKirim>0) {
     $bayarSemua = "Rp. ".number_format($hutangKirim + $hargaDiskonKirim,'0',',','.')."-";
   $semua= $hutangKirim + $hargaDiskonKirim;
   $totaltambahHutang = $hutangKirim+$hargaDiskonKirim;
   $totalbelanja = $hargaDiskonKirim;
    // $totaltambahHutang =$hargaDiskonKirim;

    }else{
       $bayarSemua = "Rp. ".number_format($hutangKirim + $total,'0',',','.')."-";
   $semua= $hutangKirim + $total;
   $totaltambahHutang = $hutangKirim+$total;
   $totalbelanja = $total;
   // $totaltambahHutang = $total;
    }
     // $totalKirim = $hutangKirim+$total;
    $totalKirim = $total;
     $bayarpakesaldo = $totaltambahHutang - $saldo;
  
  }else{

    if ($hargaDiskonKirim>0) {
     $bayarSemua = "Rp. ".number_format($hutangKirim + $hargaDiskonKirim,'0',',','.')."-";
   $semua= $hutangKirim + $hargaDiskonKirim;
   $totaltambahHutang = $hutangKirim+$hargaDiskonKirim;
   $totalbelanja = $hargaDiskonKirim;
   // $totaltambahHutang = $hargaDiskonKirim;
    }else{
       $bayarSemua = "Rp. ".number_format($hutangKirim + $total,'0',',','.')."-";
   $semua= $hutangKirim + $total;
   $totaltambahHutang = $hutangKirim+$total;
   $totalbelanja = $total;
   $totalBelanjaTampil = "Rp. ".number_format($totalbelanja,'0',',','.')."-";
   // $totaltambahHutang = $total;
    }
     // $totalKirim = $hutangKirim+$total;
    $totalKirim = $total;
     $bayarpakesaldo = $totaltambahHutang - $saldo;
    } ?>
   <br>
     <div class="input-group">
                   <p id="ket">Bayar semua adalah pelanggan membayar total semua belanjaan ditambah hutang, yaitu sebesar :</p>
                    <label id="ketjum"><?php echo $totalBelanjaTampil;?></label>
                    <input type="hidden" name="ss" id="saldonya" value="<?php echo $saldoKirim; ?>">

                
                </div>
                <br>

                
        <form action="detail_pembelian.php" method="post" name="DetailPembelian" id="DetailPembelian">
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="checksaldo" id="checksaldo">
                    Bayar pakai saldo ?
                </label>
            </div>
          <select class="form-control select2"   style="width: 100%;" name="operator">
            <option value="">Pilih Operator :</option>
            <?php
              $sql="SELECT * FROM karyawan";
              $exe=mysqli_query($koneksi,$sql);
              //$nomor =1;
              while($data=mysqli_fetch_array($exe))
              {
              // $nomor++;
            ?>
              <option name="op" value=<?php echo $data['nama'];?>><?php echo $data['nama'];?></option>
            <?php 
              } 
            ?>
        </select>
        </div>  
          <div class="input-group input-group-lg">
            <input type= "text"  name="jum_bayar" class="form-control" placeholder="Masukkan Jumlah" id="jumBayar"  >
            <input  type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $id_pelanggan; ?>" />
            <input  type="hidden" name="total" id="tot" value="<?php echo $totaltambahHutang; ?>" />
            <input  type="hidden" name="totalbelanja" id="totalbelanja" value="<?php echo $totalbelanja; ?>" />
            <input  type="hidden" name="totalmindiskon" id="tota" value="<?php echo $totalKirim; ?>" />
            <input  type="hidden" name="hutang" id="hut" value="<?php echo $hutangKirim; ?>" />
            <input  type="hidden" name="id_barangtabel" id="brgtabel" value="<?php echo $idBarangTabel; ?>" />
            <input  type="hidden" name="jumkertabel" id="jumtabel" value="<?php echo $jumlahKeranjangTabel; ?>" />
            <input  type="hidden" name="sald" id="sald"  />
            <span class="input-group-btn">
              <button type="submit" class="btn btn-info btn-flat" name="btnBayar" onclick='return window.confirm("Anda yakin ingin melanjutkan pembayaran?");' >Bayar</button>
            </span>
          </div>
        <div>
        <label id="totalbayar"></label> 
        </div>
        </form>
                  <br>
                  
  </div>
  <div id="menu1" class="tab-pane fade">

<br>
     <form action="act_byrhutang.php" method="post">
  <div class="input-group input-group-lg">

          
                    <input type= "text"  name="jum_hutang" class="form-control" placeholder="Masukkan Jumlah"  >
                    <input  type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $id_pelanggan; ?>" />
                     <input  type="hidden" name="total" id="tot" value="<?php echo $total; ?>" />
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat" name="btnHutang"  >Bayar</button>
                    </span>
                    
                  
                 </div>
                   </form>
                  <br>
  </div>
  <div id="menu2" class="tab-pane fade">
    <br>
     <form action="detail_hutang.php" method="post">
  <div class="input-group input-group-lg">

          
                    <input type= "text"  value="<?php echo $semua; ?>" name="hutang" class="form-control" placeholder="Masukkan Jumlah" readonly >
                    <input  type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $id_pelanggan; ?>" />
           <input  type="hidden" name="total" id="tot" value="<?php echo $total; ?>" />
                     
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat" name="btnNgutang"  >HUTANG</button>
                    </span>
                    
                  
                 </div>
                   </form>
                  <br>
  </div>
</div>
      </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- iCheck -->
         
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->
      
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php include "footer.php";?>
<script>
$(function () {
   

   $( "#nama_barang" ).autocomplete({
        source: 'search_toko.php',
        select: function(event, ui) {
          var e = ui.item;
          document.getElementById('result').value = e.id;
          // $("#result").append(result);
      //      var result = "<p>label : " + e.label + " - id : " + e.id + "</p>";
      // $("#result").append(result);
    }


    });

   $( "#nama_pelanggan" ).autocomplete({
        source: 'search_pelanggan.php',
        select: function(event, ui) 
        {
          var e = ui.item;
          var rp = toRp(e.hutang);
          document.getElementById('id_pelanggan').value = e.id;
          $("#DetailPembelian #id_pelanggan").val(e.id);////
          console.log(e.hutang);
          console.log(e.id);    
        }
    });


   $("#jumBayar").bind("change paste keyup", function() {
       // alert($(this).val()); 
       var current = document.getElementById("totalbayar");
       var rp = toRp($(this).val());
       current.textContent= rp;
       console.log($(this).val());
    });



function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('') + ',-';
}
$( "#checksaldo" )
  .change(function() {
    var total = $('#totalbelanja').val();
    var saldo = $('#saldonya').val();
    var jum = total - saldo;
    var $input = $( this );
      $( "#ket" ).html( "Bayar semua adalah pelanggan membayar total semua belanjaan ditambah hutang, yaitu sebesar :" );
         $("#ketjum").html(toRp(total));
    // $( "p" ).html( ".attr( 'checked' ): <b>" + $input.attr( "checked" ) + "</b><br>" +
    //   ".prop( 'checked' ): <b>" + $input.prop( "checked" ) + "</b><br>" +
    //   ".is( ':checked' ): <b>" + $input.is( ":checked" ) + "</b>" );
    var ket;
    var ketJum;
    console.log(total+" "+ saldo);
     
    console.log($input.is(":checked"));
    if ($input.is(":checked")) {
     if (parseInt(total) <parseInt(saldo)) {
            $( "#ket" ).html( "Saldo akan dikurangin sebesar  :" );
            $("#ketjum").html(toRp(total));
           $("#sald").val(parseInt(saldo) -parseInt(total) );
          }else {
            $( "#ket" ).html( "Total semua belanjaan dikurangin saldo  :" );
            $("#ketjum").html(toRp(jum));
             $("#sald").val(parseInt(0));
             
          }
          
        
      
      
    }
  })
  .change();
  
  });
</script>
