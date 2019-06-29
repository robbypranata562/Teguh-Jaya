 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Teguh Jaya</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- Sugestt -->
  <script type="text/javascript" src="js/jquery.js"></script>
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
   
   <!-- Data Table -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
   <!-- daterange picker -->
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

 
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
				error_reporting(0);
				
	
				 
			  
			  $sid = session_id();
					$sql_t="SELECT * FROM keranjang, stok_toko, barang where id_sesion='$sid' AND keranjang.id_barangtoko=stok_toko.id_toko AND stok_toko.id_gudang=barang.id_gudang";
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
			  
			  
			  
			  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="dist/js/demo.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script src="plugins/select2/select2.full.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
 $('select').select2();

  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

     //Date picker
    $('#datepicker').datepicker({
     
      autoclose: true
    });

	 // $( "#nama_barang" ).autocomplete({
  //       source: 'search_toko.php',
  //       select: function (a, b) {
  //         var number = document.getElementById('item_id');
  //       alert("selected");
  //   }

  //   });

	
  });


</script>