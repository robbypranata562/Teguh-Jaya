<?php include "header.php";?>
 <?php 

 include 'koneksi.php';
 $nama_pelanggan = "nama pelanggan";


 $transaksiId = $_GET['id'];
  $sqlhistory="SELECT * FROM transaksi, pelanggan, barang_terjual,stok_toko  WHERE
          transaksi.id_transaksi = '$transaksiId' 
          AND transaksi.id_transaksi = barang_terjual.id_transaksi 
          AND barang_terjual.jual_idpelanggan=pelanggan.id_pelanggan 
          AND barang_terjual.id_barangtoko=stok_toko.id_toko 
          GROUP BY barang_terjual.id_transaksi" ;
          
          $exehis=mysqli_query($koneksi,$sqlhistory);
              while($data=mysqli_fetch_assoc($exehis)){
                  $id_pelanggan = $data['id_pelanggan'];
                  $noFaktur = $data['faktur'];
                  $tgl_transaksi = $data['tgl_transaksi'];
               }

           $sql_pel="SELECT * FROM pelanggan
               where id_pelanggan = '$id_pelanggan'";
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
            <i class="fa fa-globe"></i> History Pembelian
            <small class="pull-right">Tanggal: <?php echo $tgl_transaksi; ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
         Di jual Oleh:
          <address>

            <strong>Teguh jaya</strong><br>
            Jln. Guntur No.209 Garut<br>
            Phone: (0262) 234395<br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Pelanggan:
          <address>
            <strong><?php echo $nama_pelanggan; ?></strong><br>
            <?php echo $alamatPel;?><br>
            Phone: <?php echo $nohpPel;?>
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Faktur #<?php echo $noFaktur; ?></b><br>
          
         
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
	
	
	$sql="SELECT * FROM transaksi, pelanggan, barang_terjual, stok_toko where transaksi.id_transaksi='$transaksiId' AND barang_terjual.id_transaksi = '$transaksiId' and transaksi.id_pelanggan=pelanggan.id_pelanggan AND barang_terjual.jual_idpelanggan=transaksi.id_pelanggan AND barang_terjual.id_barangtoko=stok_toko.id_toko";
	
	$exe_sql=mysqli_query($koneksi,$sql);
	while($lihat=mysqli_fetch_array($exe_sql)){
		$id_pel=$lihat['id_pelanggan'];
    $id_transaksi = $lihat['id_transaksi'];
    $id_barangtoko = $lihat['id_barangtoko'];
    $id_barangtoko = $lihat['id_barangtoko'];
		$tgl = $lihat['tgl_transaksi'];
		$barang = $lihat['nama_toko'];
		$nama_pelanggan = $lihat['nama_pelanggan'];
		$qty = $lihat['jual_jumlah'];
 $tot_belanja = $lihat['tot_belanja'] ;
        $jumlah_bayar = $lihat['jumlah_bayar'];
        $kembali = $lihat['kembalian'];
        if ($kembali <0) {
          $sisa=0;
        
        }else{
          $sisa = $kembali;
        }
		// $subtotal =$lihat['harga_akhir'];
		$harga_akhir = "Rp. ".number_format($lihat['jual_hargaakhir']);
		$hutang_tampil = "Rp. ".number_format($lihat['hutang']);

 //Insert Data to Barang_terjual
    
		?>
              <td><?php echo $barang; ?></td>
              <td><?php echo $qty; ?></td>
              <td><?php echo $harga_akhir; ?></td>
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
       

          <p class="lead">Tanggal Transaksi:<?php echo $tgl_transaksi; ?></p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td><?php echo $tot_belanja; ?></td>
              </tr>
              <tr>
                <th>Tunai</th>
                <td><?php echo $jumlah_bayar; ?></td>
              </tr>
              <tr>
                <th>Kembalian</th>
                <td><?php echo $sisa; ?></td>
              </tr>
              <tr>
                <th>Sisa Hutang</th>
                <td><?php echo $hutang_tampil; ?></td>
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
          <a href="javascript:print()"  class="btn btn-primary pull-right"><i class="fa fa-print"></i> Print</a>
 
         
         
        </div>
      </div>
		
		
    </section>
      <div class="clearfix"></div>
    </div>
    <?php include "footer.php";?>
   
    <script type=application/javascript>document.links[0].href="data:text/html;charset=utf-8,"+encodeURIComponent('<!doctype html>'+document.documentElement.outerHTML)</script>
