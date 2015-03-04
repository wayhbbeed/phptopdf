<?
	require('chinese-unicode.php'); 

    $pdf=new PDF_Unicode();

    $pdf->Open();
    $pdf->AddPage();
    $pdf->AddUniGBhwFont('uni');
    $pdf->SetFont('uni','',20);
	
    $pdf->Write(10, '简体没问题，繁體也沒問題！我的名字叫徐华德阿拉山口地');
    $pdf->Output();


?>
