<?php

require "../config/config.php";
require "../config/functions.php";
require('../asset/fpdf/vendor/autoload.php');

$stockBrg = getData("SELECT * FROM tbl_barang");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'Stock Items Report',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'','B',1);
$pdf->Cell(10,10,'No.',0,0,'C');
$pdf->Cell(30,10,'Item Code',0,0);
$pdf->Cell(90,10,'Item Name',0,0);
$pdf->Cell(30,10,'Total Stock',0,0);
$pdf->Cell(30,10,'Unit',0,1);
$pdf->Cell(190,1,'','T',1);

$pdf->SetFont('Arial','',12);
$no = 1;
foreach($stockBrg as $stock){
    $pdf->Cell(10,8,$no++,0,0,'C');
    $pdf->Cell(30,8,$stock['id_barang'],0,0);
    $pdf->Cell(90,8,$stock['nama_barang'],0,0);
    $pdf->Cell(30,8,$stock['stock'],0,0,'C');
    $pdf->Cell(30,8,$stock['satuan'],0,1);
}
$pdf->Cell(190,1,'','T',1);

$pdf->Output();
?>

