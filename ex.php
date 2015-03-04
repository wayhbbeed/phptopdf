<?php
require('chinese.php');


class PDF extends PDF_Chinese{
	function Header(){
		$this->SetTextColor(160,160,160);
		$this->SetFont('GB','',8);
		$this->Cell(0,0,'��ӿ��������'); //д��ҳü����
		
		$this->Ln(20); //����
	}
	function Footer(){
		$this->SetTextColor(160,160,160);
		$this->SetY(-15); //����ҳ������λ��
		$this->SetFont('GB','',8);
		$this->Cell(0,10,'��ǰҳ��-'.$this->PageNo()); //�����ǰҳ����Ϊҳ������
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





$header=array('Name','��Ŷ','Sex','Salary'); //���ñ�ͷ
$data[0] = array('Simon','24','Male','5,000.00');
$data[1] = array('Elaine','25','Female','6,000.00');
$data[2] = array('Susan','25','Female','7,000.00');
$data[3] = array('David','26','Male','8,000.00');
$width=array(40,40,40,40); //����ÿ�п��
for($i=0;$i<count($header);$i++) //ѭ�������ͷ
$pdf->Cell($width[$i],6,$header[$i],1,0,'C');
//$pdf->image("1.jpg",50,50);//�ɲ���ͼƬ
$pdf->Ln();
foreach($data as $row) //ѭ���������
{
$pdf->Cell($width[0],6,$row[0],1,0,"L");
$pdf->Cell($width[1],6,$row[1],1,0,"L");
$pdf->Cell($width[2],6,$row[2],1,0,"L");
$pdf->Cell($width[3],6,$row[3],1,0,"L");
$pdf->Ln();
}
$pdf->Output(); //���PDF �������


?>
