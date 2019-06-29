<?php
	include "koneksi.php";
	require('pdf/fpdf.php');
	
	$pdf = new FPDF ("L","cm", "A4");
	
	$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
//$pdf->Image('../logo/malasngoding.png',1,1,2,2);
$pdf->SetX(4);            
$pdf->MultiCell(19.5,0.5,'TEGUH JAYA',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'Telpon : 0038XXXXXXX',0,'L');    
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'JL. ALAMAT TEGUH JAYA',0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'website : tegujaya.com : teguhjaya@gmail.com',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'BUKTI PEMBELIAN',0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
//$pdf->Cell(6,0.7,"Laporan Penjualan pada : ".$_GET['tanggal'],0,0,'C');
$pdf->ln(1);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'harga', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Sub harga', 1, 0, 'C');
//$pdf->Cell(4, 0.8, 'laba', 1, 1, 'C');
	
	
	$no=1;
	
	$ql_trans="SELECT * from transaksi order by id_transaksi DESC limit 0,1";
	$exe_trans=mysqli_query($koneksi,$ql_trans);
	while($row=mysqli_fetch_array($exe_trans)){
		
		$id_trans=$row['id_transaksi'];
	}
	
	
	$sql="SELECT * FROM transaksi, pelanggan, keranjang, barang, stok_toko where transaksi.id_transaksi='$id_trans' AND transaksi.id_pelanggan=pelanggan.id_pelanggan AND keranjang.id_pelanggan=transaksi.id_pelanggan AND keranjang.id_barangtoko=stok_toko.id_toko AND stok_toko.id_gudang=barang.id_gudang";
	
	$exe_sql=mysqli_query($koneksi,$sql);
	while($lihat=mysqli_fetch_array($exe_sql)){
		$pdf->Cell(1, 0.8, $no , 1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['tgl_transaksi'],1, 0, 'C');
	$pdf->Cell(6, 0.8, $lihat['nama'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['jumlah_keranjang'], 1, 0,'C');
	$pdf->Cell(4, 0.8, "Rp. ".number_format($lihat['harga_akhir'])." ,-", 1, 0,'C');
	//$pdf->Cell(4.5, 0.8, "Rp. ".number_format($lihat['total_harga'])." ,-",1, 0, 'C');
	//$pdf->Cell(4, 0.8, "Rp. ".number_format($lihat['laba'])." ,-", 1, 1,'C');	
	
	$no++;
		
	}
	
	$pdf->Output("cetak_struk.pdf","I");
?>