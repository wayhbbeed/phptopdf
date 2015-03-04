<?php
require('chinese.php');


class PDF extends PDF_Chinese{
	function Header(){
		$this->SetTextColor(160,160,160);
		$this->SetFont('GB','',8);
		$this->Cell(0,0,'金涌博发名单'); //写入页眉文字
		
		$this->Ln(20); //换行
	}
	function Footer(){
		$this->SetTextColor(160,160,160);
		$this->SetY(-15); //设置页脚所在位置
		$this->SetFont('GB','',8);
		$this->Cell(0,10,'当前页面-'.$this->PageNo()); //输出当前页码作为页脚内容
	}
}





$pdf=new PDF('L', 'mm', 'A4'); 
$pdf->AddGBFont();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);
$pdf->AddPage();
$pdf->SetFont('GB','B',14);





$header=array('Name','啊哦','Sex','Salary'); //设置表头
$data[0] = array('Simon','24','Male','5,000.00');
$data[1] = array('Elaine','25','Female','6,000.00');
$data[2] = array('Susan','25','Female','7,000.00');
$data[3] = array('David','26','Male','8,000.00');
$width=array(40,40,40,40); //设置每列宽度
for($i=0;$i<count($header);$i++) //循环输出表头
$pdf->Cell($width[$i],6,$header[$i],1,0,'C');
//$pdf->image("1.jpg",50,50);//可插入图片
$pdf->Ln();
foreach($data as $row) //循环输出表体
{
$pdf->Cell($width[0],6,$row[0],1,0,"L");
$pdf->Cell($width[1],6,$row[1],1,0,"L");
$pdf->Cell($width[2],6,$row[2],1,0,"L");
$pdf->Cell($width[3],6,$row[3],1,0,"L");
$pdf->Ln();
}
$pdf->Output(); //输出PDF 到浏览器


?>
