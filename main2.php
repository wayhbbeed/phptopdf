
<?php
require('chinese-unicode.php'); 

class PDF extends PDF_Unicode
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header大标题
    // foreach($header as $col)
    $this->SetFont('uni','',13);
    $this->Cell(190,7,'常温库1',1,0,'C');
    // $this->AddUniGBhwFont('uni');
    $this->Ln();

    $this->SetFont('uni','',11);
    //固定栏目
    foreach($header as $col)
    {
    $this->Cell(47.5,6,$col,1,0,'C');
    };
    $this->Ln();

    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(47.5,6,$col,1,0,'C');
        $this->Ln();
    }
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();
// Column headings
$header = array('编号', '记录时间', '℃', '%');
// Data loading
$data = $pdf->LoadData('countries.txt');

// $pdf->Open();
$pdf->AddPage();
$pdf->AddUniGBhwFont('uni');
// $pdf->SetFont('uni','',10);
$pdf->BasicTable($header,$data);

$pdf->AddPage();
$pdf->ImprovedTable($header,$data);

$pdf->AddPage();
$pdf->FancyTable($header,$data);
// $pdf->Output('./pdf/temp.pdf','F','');
$pdf->Output();
?>
