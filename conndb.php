<?php 
// ODBC方式连接：$cn = odbc_connect($dsn, $user, $pwd);
$Driver="DRIVER=Microsoft Access Driver (*.mdb);dbq=".realpath("./database/tomonitor8.mdb");
$database_name="";
$database_password="20121110";
$cn=odbc_connect($Driver,$database_name,$database_password,SQL_CUR_USE_ODBC ) or die(odbc_errormsg());
// //执行SQL查询
// $rs = odbc_exec ($cn,'select * from LOGS_HE20100618 order by logs_time asc');
// while(odbc_fetch_row($rs)){
// 	echo odbc_num_rows($rs).'->'.odbc_result($rs, 1).'->'.odbc_result($rs, 2).'->'.odbc_result($rs, 3).'<br>';
// 	// echo odbc_result($rs, 1);
// }
// odbc_free_result($rs);
// odbc_close($cn);


//获取所有表名
   $result = odbc_tables($cn);
   $tables = array();
   while (odbc_fetch_row($result))
   {
     if(odbc_result($result,"TABLE_TYPE")=="TABLE" && strpos(odbc_result($result,"TABLE_NAME"),"OGS") )
       {
       echo odbc_result($result, "TABLE_NAME").'<BR>';die();
       // echo strpos(odbc_result($result,"TABLE_NAME"),"HE");
       }
   }

