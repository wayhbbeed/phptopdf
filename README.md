# phptopdf
php to pdf with utf-8 for chinese

使用FPDF类转换，可以使用utf-8，导出PDF表格;

关系连接是：
使用文件 加载 chinese-unicode.php（把GBK转换成UTF-8）；
chinese-unicode.php 加载  chinese.php（只支持GBK）；
chinese.php 加载 fpdf.php（导出PDF核心类）；


