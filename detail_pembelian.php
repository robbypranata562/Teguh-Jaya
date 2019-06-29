<?php include "header.php";?>
 <?php 

 include 'koneksi.php';
 $nama_pelanggan = "nama pelanggan";
 $jum_bayar = 0;
 $totHargaDiskon =0;
 $hutang_tampil =0;
  $id_pelanggan=0;
 $total=0;
 $kembali=0;
 $kode_otomatis=0;
 $tambahHutang=0;
 $kurangBayar=0;
 $totalBelanja=0;

if (isset($_POST['btnBayar'])) {

    	      $oper= $_POST['operator'];
            $id_pelanggan = $_POST['id_pelanggan'];
            $jum_bayar=$_POST['jum_bayar'];
            $total = $_POST['total'];
            $totalBelanja = $_POST['totalbelanja'];
            $totalmindiskon = $_POST['totalmindiskon'];
            $hutang = $_POST['hutang'];
            $kembali = $jum_bayar - $totalBelanja ;


            if ($jum_bayar< $totalmindiskon) {
                $kurangBayar = $totalmindiskon-$jum_bayar;
            }
            if($kembali<0){
				$kembali='0';
			}
            $sald = $_POST['sald'];
            $idBarangTabel = $_POST['id_barangtabel'];
            $jumkertabel = $_POST['jumkertabel'];
            if ($jum_bayar!="") {
               $tunai = "Rp. ".number_format($jum_bayar);
            }else{
              $tunai = "Rp. ".number_format('0');
            }
            $totalPembelian = "Rp. ".number_format($total);
            $totalmindiskonTampil= "Rp. ".number_format($totalmindiskon);
            $totalBelanjaKirim =  $totalBelanja;
           
            
$sql_hut="SELECT saldo FROM pelanggan where id_pelanggan='$id_pelanggan'";
$exe_hut=mysqli_query($koneksi,$sql_hut);
$data=mysqli_fetch_assoc($exe_hut);
$saldoo=$data['saldo'];

            //Update saldo
            if (isset($_POST['checksaldo'])) {
				$saldd= $jum_bayar + $saldoo;
				$hutt= $total + $hutang;
				$sald1= $jum_bayar + $saldoo;
				$sald2 = $sald1 - $total;
				if($sald2<0){
					$sald2='0';
				}
            $tot_hut= $hutt - $saldd;
        if ($tot_hut<0){
          $tot_hut='0';
        }
            $sql_sald="UPDATE pelanggan
            SET saldo = '$sald2', hutang ='$tot_hut' where id_pelanggan = '$id_pelanggan'";
            $exe_sald=mysqli_query($koneksi,$sql_sald) ; 
             $sisa = "Rp. ".number_format(0);
			// $sisa = "Rp. 0-";

            }else{
               if ($jum_bayar < $total) {
                $tambahHutang = $total-$jum_bayar;
            $sql_0u="UPDATE pelanggan
            SET hutang = '$tambahHutang' where id_pelanggan = '$id_pelanggan'";
            $exe_0u=mysqli_query($koneksi,$sql_0u) ;  
            $sisa = "Rp. 0-";
         }else{
        //   $tambahHutang=0;
        //     //Kalau bayar semua otomatis hutang juga dibayar
          $sisa = "Rp. ".number_format($kembali);
        // $sql_0u="UPDATE pelanggan
        // SET hutang = '0' where id_pelanggan = '$id_pelanggan'";
        // $exe_0u=mysqli_query($koneksi,$sql_0u) ;  
         }
            }
            


            
         $carikode = mysqli_query($koneksi, "SELECT faktur from transaksi") or die (mysqli_error());
          // menjadikannya array
          $datakode = mysqli_fetch_array($carikode);
          $jumlah_data = mysqli_num_rows($carikode);
          // jika $datakode
          if ($datakode) {
           // membuat variabel baru untuk mengambil kode barang mulai dari 1
           $nilaikode = substr($jumlah_data[0], 1);
           // menjadikan $nilaikode ( int )
           $kode = (int) $nilaikode;
           // setiap $kode di tambah 1
           $kode = $jumlah_data + 1;
           // hasil untuk menambahkan kode 
           // angka 3 untuk menambahkan tiga angka setelah B dan angka 0 angka yang berada di tengah
           // atau angka sebelum $kode
           $kode_otomatis = "TJ".str_pad($kode, 4, "0", STR_PAD_LEFT);
          } else {
           $kode_otomatis = "TJ0001";
          }


 	if ($kembali<0) {
            $kembali=0;
         }
          $sql_trans="INSERT INTO transaksi (id_pelanggan,tot_belanja,jumlah_bayar,Kembalian,faktur,hutang_pertgl) VALUES('$id_pelanggan','$totalBelanjaKirim','$jum_bayar','$kembali','$kode_otomatis', '$tambahHutang')";
$exe_trans=mysqli_query($koneksi,$sql_trans);


        
          
           } 

           $sql_pel="SELECT * FROM pelanggan
               where id_pelanggan = '$id_pelanggan'";
               //die($sql_pel);
        $exe_pel=mysqli_query($koneksi,$sql_pel) ; 
        while($row=mysqli_fetch_assoc($exe_pel)){
		
		$nama_pelanggan=$row['nama_pelanggan'];
    $alamatPel = $row['alamat'];
    $nohpPel = $row['nohp'];
	}
         









 ?>
  <div class="content-wrapper" id="printableArea">
<style type="text/css">
	@page {
  size: auto;  /* auto is the initial value */
  margin: 2mm; /* this affects the margin in the printer settings */
}
html {
  
}
body {
  
  
}
</style>
  <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Detail Pembelian
            <small class="pull-right">Tanggal: <?php echo date("d/m/Y "); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
         <img src="dist/img/icon_teguhjaya.png" class="img-circle" alt="User Image" width="100" height="100"><br>
         Di jual Oleh
          <address>

            <strong>Teguh jaya</strong><br>
            Jln. Guntur no. 209 Garut<br>
            Tlp: (0262) 234395<br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Pelanggan:
          <address>
            <strong><?php echo $nama_pelanggan; ?></strong><br>
            <?php echo $alamatPel;?><br>
            Tlp: <?php echo $nohpPel;?>
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Faktur #<?php echo $kode_otomatis ?></b><br>
          Pelayan:<br><?php echo $oper;?>

          
         
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
             
              <th>Barang</th>
             <th>Qty</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>

             <?php 
           $no=1;
	
	$ql_trans="SELECT * from transaksi order by id_transaksi DESC limit 0,1";
	$exe_trans=mysqli_query($koneksi,$ql_trans);
	while($row=mysqli_fetch_array($exe_trans)){
		
		$id_trans=$row['id_transaksi'];
	}
	
	
	$sql="SELECT * FROM transaksi, pelanggan, keranjang, stok_toko where transaksi.id_transaksi='$id_trans' AND transaksi.id_pelanggan=pelanggan.id_pelanggan AND keranjang.id_pelanggan=transaksi.id_pelanggan AND keranjang.id_barangtoko=stok_toko.id_toko";
	
	$exe_sql=mysqli_query($koneksi,$sql);
	while($lihat=mysqli_fetch_array($exe_sql)){
		$id_pel=$lihat['id_pelanggan'];
    $id_transaksi = $lihat['id_transaksi'];
    $id_barangtoko = $lihat['id_barangtoko'];
    $id_barangtoko = $lihat['id_barangtoko'];
		$tgl = $lihat['tgl_transaksi'];
		$barang = $lihat['nama_toko'];
		$nama_pelanggan = $lihat['nama_pelanggan'];
		$qty = $lihat['jumlah_keranjang'];
		$subtotal =$lihat['sub_total'];
    $subtotalDiskon = $lihat['sub_totaldiskon'];
    $totHargaDiskon = $lihat['total_hargadiskon']; 
		$harga_akhir = "Rp. ".number_format($lihat['harga_akhir']);
    $harga_kirim = $lihat['harga_akhir'];
		$hutang_tampil = "Rp. ".number_format($lihat['hutang']);
    if ($subtotalDiskon!=0) {
     $subTampil = "Rp. ".number_format($lihat['sub_totaldiskon']);
    }else{
      $subTampil = $harga_akhir;
    }

 //Insert Data to Barang_terjual
     $sql_ker="INSERT INTO barang_terjual VALUES (NULL,'$id_barangtoko','$id_pelanggan','$harga_kirim','$qty',NOW(),'$id_transaksi')";
     $exe_ker=mysqli_query($koneksi,$sql_ker);
		?>
              <td><?php echo $barang; ?></td>
              <td><?php echo $qty; ?></td>
              <td><?php echo $subTampil; ?></td>
            </tr>
            <?php }?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Tanggal Transaksi:<?php echo date("d/m/Y "); ?></p>

          <div class="table">
            <table class="table">
              
              <?php if($totHargaDiskon!=0) {
                $totTam = "Rp. ".number_format($totHargaDiskon);
                ?>
                <tr>
                <th style="width:50%">Total Belanja</th>
                <td><strike><?php echo $totalmindiskonTampil; ?></strike></td>
              </tr>
              <tr>
                <th style="width:50%">Total Belanja Setelah Diskon:</th>
                <td><?php echo $totTam; ?></td>
              </tr>
              <?php }else{

                 ?>
                 <tr>
                <th style="width:50%">Total Belanja</th>
                <td><?php echo $totalmindiskonTampil; ?></td>
              </tr>
                <?php }?>
              <tr>
                <th>Hutang</th>
                <td><?php echo $kurangBayar; ?></td>
              </tr>
               <tr>
                <th>Tunai</th>
                <td><?php echo $tunai; ?></td>
              </tr>
              <tr>
                <th>Kembalian</th>
                <td><?php echo $sisa; ?></td>
              </tr>
              <tr>
                <th>Sisa Hutang</th>
                <td><?php echo $hutang_tampil; ?></td>
              </tr>
              <tr>
                <th>Sisa Saldo</th>
                <td><?php echo $sald; ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
     

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
        
  <form action="" method="post ">
            <a class="btn btn-success pull-right" href="act_selesai.php?id_pel=<?php echo $id_pel;?>&id_transaksi=<?php echo $id_transaksi;?>&id_barangtabel=<?php echo $idBarangTabel;?>&jumkertabel=<?php echo $jumkertabel;?>" style="margin-right: 5px;">Selesaikan Transaksi</a>
          <form>
  <a href="javascript:print()"  class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-print"></i> Print</a>
         

        <form id="form_simpan" action="" method="POST">
            <input type="hidden" name="id_pelanggan" id="idpel" value="<?php echo $id_pel; ?>">
            <input type="hidden" name="sisa" id="sisa" value="<?php echo $kembali; ?>">  
        </form>

          <?php if ($kembali >0) {
          ?>
           <button  class="btn btn-primary pull-right" style="margin-right: 5px;" id="simpanUangDetPembelian">Simpan Kembalian </button>
          <?php } ?>
           
           
        </div>
      </div>
		
		
    </section>
      <div class="clearfix"></div>
    </div>
    <script type="text/javascript"></script>
    <?php include "footer.php";?>
   
    <script type=application/javascript>document.links[0].href="data:text/html;charset=utf-8,"+encodeURIComponent('<!doctype html>'+document.documentElement.outerHTML)</script>
    <script type="text/javascript">
       $(document).ready(function () {
         
        $("#simpanUangDetPembelian").on('click', function() {

          var idpel = $("#idpel").val();
          var sisa = $("#sisa").val();

          var postData = 'id_pelanggan='+idpel+'&sisa='+sisa;
          var formURL = "act_simpansisa.php";
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                   alert(data);
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            console.log(postData);
            e.preventDefault();
           
             // location.reload();
        });
       
    });

    </script>

<!--  -->