
<?php
require('chinese-unicode.php'); 
//设置最大执行时间，如果数据太多，增加执行时间，0表示不限制时间
ini_set('max_execution_time', '100');

class PDF extends PDF_Unicode
{
function LoadDatas(){

    // ODBC方式连接：$cn = odbc_connect($dsn, $user, $pwd);
    $Driver="DRIVER=Microsoft Access Driver (*.mdb);dbq=".realpath("c:/database/tomonitor8.mdb");
    $database_name="";
    $database_password="20121110";
    $cn=odbc_connect($Driver,$database_name,$database_password,SQL_CUR_USE_ODBC ) or die(odbc_errormsg());

    //输入表名
    $tablename='LOGS_HE20102796';
    $logger_sn=substr($tablename, 5);
    //获取库名
    $sql_name="select logger_name from to_logger_info where logger_sn like '%$logger_sn%' ";
    $rs_name=odbc_exec($cn, $sql_name);
    while (odbc_fetch_row($rs_name)) {
        // echo odbc_result($rs_name, 1);
        $title = odbc_result($rs_name, 1); 
    }
    // $title = iconv("UTF-8", "GBK", $title); 
    $title=mb_convert_encoding ($title, "UTF-8", "CP936");
    // echo $title;die();
    $header = array('编号', '记录时间', '℃', '%');
    $this->AddUniGBhwFont('uni');
    // echo $tablename;die();
    //查询所有时间
    $sql_date="SELECT Format([logs_time],'yyyy/mm/dd') AS theDate "
         ." FROM $tablename "
         ." GROUP BY Format([logs_time],'yyyy/mm/dd') "
         ." order by Format([logs_time],'yyyy/mm/dd') ";   
    $rs_date=odbc_exec($cn, $sql_date);
    //循环所有时间
    while (odbc_fetch_row($rs_date)) {
        // echo odbc_result($rs_date, 1).'<br>';
        $date=odbc_result($rs_date, 1);
        echo '已执行：'.$title.'-'.$date.'<br>';
         //取出数据
        $sql="select logs_time,logs_chone,logs_chtwo " 
        ." from $tablename where logs_time like '%$date%' " ;
        $rs = odbc_exec ($cn,$sql);
        $data=array();
        $datas=array();
        while($row=odbc_fetch_row($rs)){
            // $data[]=$tablename;
            $data[]=odbc_num_rows($rs);
            $data[]=odbc_result($rs, 1);
            $data[]=odbc_result($rs, 2);
            $data[]=odbc_result($rs, 3);
            $datas[]=$data;
            $data=array();
            
        }
        //进行PDF循环输出
            $this->AddPage();
            // $pdf->SetFont('uni','',10);
            // $title='常温库XXX';
            $this->BasicTable($title,$header,$datas);
            //对文件名进行编码，符合win的ansi编码
            $pagename = "./pdf/".$title."-".$date.".pdf"; 
            $pagename = iconv("UTF-8", "GBK", $pagename); 
            //输出到文件，F表示输出文件，D表示网页显示并强制下载
            $this->Output($pagename,'F');
    }

//释放资源
    odbc_free_result($rs_date);
    odbc_free_result($rs);
    odbc_close($cn);
    // return $datas;
}

// Simple table
function BasicTable($title,$header, $data)
{
    // 固定栏目：大标题
    // foreach($header as $col)
    $this->SetFont('uni','',13);
    $this->Cell(190,7,$title,1,0,'C');
    // $this->AddUniGBhwFont('uni');
    $this->Ln();

    $this->SetFont('uni','',11);
    //固定栏目:列名（循环一次，只写入一次LN()）
    foreach($header as $col)
    {
    $this->Cell(47.5,6,$col,1,0,'C');
    };
    $this->Ln();

    // 数据内容：数据库查询（循环两次，每次都要LN()写入）
    foreach($data as $row)
    {
        foreach($row as $col)
            //CELL(宽度，高度，内容，border，文本位置，对齐方式)
            $this->Cell(47.5,6,$col,1,0,'C');
        $this->Ln();
    }
}
//END CLASS
}

$pdf=new PDF();
$data = $pdf->LoadDatas();
//直接在页面显示
// $pdf->Output();
?>
