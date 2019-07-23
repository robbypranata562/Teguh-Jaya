<?php
require("pdf/fpdf.php");

class PDF extends FPDF
{
    protected $ProcessingTable=false;
    protected $aCols=array();
    protected $TableX;
    protected $HeaderColor;
    protected $RowColors;
    protected $ColorIndex;
function Header()
{
    // Logo
    include 'koneksi.php';
    $id = $_GET['id'];
    if ( $this->PageNo() === 1 ) {
        $Code = "";
        $Nama = "";
        $Alamat = "";
        $NoHP = "";
        $this->Image('dist/img/icon_teguhjaya.png',10,6,30);
        $this->SetFont('Arial','',9);
        $this->Ln(30);
        $sql="
        SELECT
        a.Code,
        b.nama_pelanggan,
        b.alamat,
        b.nohp
        FROM
        deliveryorder AS a
        LEFT JOIN pelanggan AS b ON a.Customer = b.id_pelanggan
        WHERE
        a.Id = ".$id."";
        $exe = mysqli_query($koneksi,$sql);
        // print_r($sql);
        while($data=mysqli_fetch_array($exe))
        {
            $Code = $data["Code"];
            $Nama = $data["nama_pelanggan"];
            $Alamat = $data["alamat"];
            $NoHP = $data["nohp"];

        }
        //mysql_close($exe);
        $this->Cell(30,10,'Dijual Oleh','C');
        $this->Cell(80);
        $this->Cell(30,10,"No Penjualan : " . $Code,'C');
        $this->Ln(9);
        $this->SetFont('Arial','B',9);
        $this->Cell(30,10,'Teguh Jaya','C');
        $this->Cell(80);
        $this->Cell(30,10,"Pelanggan : " . $Nama,'C');
        $this->Ln(9);
        $this->SetFont('Arial','',9);
        $this->Cell(30,10,'Jln. Guntur no. 209 Garut','C');
        $this->Cell(80);
        $this->SetFont('Arial','',9);
        $this->Cell(30,10,"Alamat : " . $Alamat,'C');
        $this->Ln(9);
        $this->SetFont('Arial','',9);
        $this->Cell(30,10,'Tlp: (0262) 234395','C');
        $this->Cell(80);
        $this->Cell(30,10,"No Telp : " . $NoHP,'C');
        $this->Ln(9);
    }
   
}

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        // $this->SetY(-15);
        // // Arial italic 8
        // $this->SetFont('Arial','I',8);
        // // Page number
        // if($this->isFinished){
        //     $this->Cell(0,10,'Footer');
        //     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        // }
        // else{
        //     $this->Cell(0,10,'No Footer');
        // }

    }

    function TableHeader()
{
    $this->SetFont('Arial','',9);
    $this->SetX($this->TableX);
    $fill=!empty($this->HeaderColor);
    if($fill)
        $this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
    foreach($this->aCols as $col)
        $this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
    $this->Ln();
}

function Row($data)
{
    $this->SetX($this->TableX);
    $ci=$this->ColorIndex;
    $fill=!empty($this->RowColors[$ci]);
    if($fill)
        $this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
    foreach($this->aCols as $col)
        $this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
    $this->Ln();
    $this->ColorIndex=1-$ci;
}

function CalcWidths($width, $align)
{
    // Compute the widths of the columns
    $TableWidth=0;
    foreach($this->aCols as $i=>$col)
    {
        $w=$col['w'];
        if($w==-1)
            $w=$width/count($this->aCols);
        elseif(substr($w,-1)=='%')
            $w=$w/100*$width;
        $this->aCols[$i]['w']=$w;
        $TableWidth+=$w;
    }
    // Compute the abscissa of the table
    if($align=='C')
        $this->TableX=max(($this->w-$TableWidth)/2,0);
    elseif($align=='R')
        $this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
    else
        $this->TableX=$this->lMargin;
}

function AddCol($field=-1, $width=-1, $caption='', $align='L')
{
    // Add a column to the table
    if($field==-1)
        $field=count($this->aCols);
    $this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
}

function Table($link, $query, $prop=array())
{
    // Execute query
    $res=mysqli_query($link,$query) or die('Error: '.mysqli_error($link)."<br>Query: $query");
    // Add all columns if none was specified
    if(count($this->aCols)==0)
    {
        $nb=mysqli_num_fields($res);
        for($i=0;$i<$nb;$i++)
            $this->AddCol();
    }
    // Retrieve column names when not specified
    foreach($this->aCols as $i=>$col)
    {
        if($col['c']=='')
        {
            if(is_string($col['f']))
                $this->aCols[$i]['c']=ucfirst($col['f']);
            else
                $this->aCols[$i]['c']=ucfirst(mysqli_fetch_field_direct($res,$col['f'])->name);
        }
    }
    // Handle properties
    if(!isset($prop['width']))
        $prop['width']=0;
    if($prop['width']==0)
        $prop['width']=$this->w-$this->lMargin-$this->rMargin;
    if(!isset($prop['align']))
        $prop['align']='C';
    if(!isset($prop['padding']))
        $prop['padding']=$this->cMargin;
    $cMargin=$this->cMargin;
    $this->cMargin=$prop['padding'];
    if(!isset($prop['HeaderColor']))
        $prop['HeaderColor']=array();
    $this->HeaderColor=$prop['HeaderColor'];
    if(!isset($prop['color1']))
        $prop['color1']=array();
    if(!isset($prop['color2']))
        $prop['color2']=array();
    $this->RowColors=array($prop['color1'],$prop['color2']);
    // Compute column widths
    $this->CalcWidths($prop['width'],$prop['align']);
    // Print header
    $this->TableHeader();
    // Print rows
    $this->SetFont('Arial','',9);
    $this->ColorIndex=0;
    $this->ProcessingTable=true;
    while($row=mysqli_fetch_array($res))
        $this->Row($row);
    $this->ProcessingTable=false;
    $this->cMargin=$cMargin;
    $this->aCols=array();
}

}
include 'koneksi.php';
$id = $_GET['id'];
$sql="
SELECT
b.NamaBarang as `Nama Barang`,
a.UOM as Satuan,
a.DeliveryQty as Qty,
Format(a.UnitPrice,2) as Harga,
Format(a.TotalPrice,2) as Total
FROM
deliveryorderdetail AS a
LEFT JOIN item AS b ON a.ItemId = b.id
WHERE
a.DeliveryId = ".$id."";
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Table($koneksi,$sql);
$pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
$pdf->Output();
?>