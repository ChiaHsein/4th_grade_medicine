<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

 

$datetime = date("Ym",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當月的
//$datetime = "201711";
//echo $datetime;
	require_once('Classes/PHPExcel/Writer/CSV.php');
    require_once('Classes/PHPExcel/Writer/Excel2007.php');
  
    session_start();
	//引入函式庫
	include 'Classes/PHPExcel.php';
	require_once 'Classes/PHPExcel/IOFactory.php';
	
$objPHPExcel = new PHPExcel();

/*****************本月進退貨********************/

$stock_clerks=$datetime."_stock_clerks";
$sql3 = "SELECT * FROM `".$stock_clerks."` ORDER BY `dateday` ASC;";           
$clerks=mysqli_query($connect,$sql3);

$row = 1;
$objWorkSheet = $objPHPExcel->createSheet(0);
$objWorkSheet->setTitle("Stock_clerks");

	$objWorkSheet->setCellValue('A'.$row, '日期')
                              ->setCellValue('B'.$row, '收支原因')
                              ->setCellValue('C'.$row, '代碼')
                              ->setCellValue('D'.$row, '藥品品名')
                              ->setCellValue('E'.$row, '數量')
							  ->setCellValue('F'.$row, '批號')
							  ->setCellValue('G'.$row, '備考')
							  ->setCellValue('H'.$row, '廠商')
							  ->setCellValue('I'.$row, '管制藥品登記證號')
							  ->setCellValue('J'.$row, '製造廠')
							  ->setCellValue('K'.$row, '藥品許可證號');
							
							  
$row++;
while ($rec=mysqli_fetch_array($clerks,MYSQLI_ASSOC)) {
	 
    $objWorkSheet->setCellValue('A'.$row, $rec['dateday'])
                              ->setCellValue('B'.$row, $rec['cause'])
                              ->setCellValue('C'.$row, $rec['drug_code'])
                              ->setCellValue('D'.$row, $rec['drug_name'])
                              ->setCellValue('E'.$row, $rec['quantity'])
							  ->setCellValue('F'.$row, $rec['batch_number'])
							  ->setCellValue('G'.$row, $rec['com'])
							  ->setCellValue('H'.$row, $rec['seller'])
							  ->setCellValue('I'.$row, $rec['control_drug_registration_number'])
							  ->setCellValue('J'.$row, $rec['manufacturer'])
							  ->setCellValue('K'.$row, $rec['drug_permit_number']);
							  
 
    $row++;
}


/*************************************/

/*****************本月總結********************/

$last_pre_balance=0;
$now_income=0;
$now_consum=0;
$now_t_balance=0;


$row = 1;
$objWorkSheet = $objPHPExcel->createSheet(1);
$objWorkSheet->setTitle("total");

$objWorkSheet->setCellValue('A'.$row, '項次')
                              ->setCellValue('B'.$row, '院內代碼')
                              ->setCellValue('C'.$row, '藥品品項')
                              ->setCellValue('D'.$row, '公藥')
                              ->setCellValue('E'.$row, '上月結存')
							  ->setCellValue('F'.$row, '本月收入')
							  ->setCellValue('G'.$row, '本月支出')
							  ->setCellValue('H'.$row, '本月理論理論結存')
							  ->setCellValue('I'.$row, '調劑台')
							  ->setCellValue('J'.$row, '抽屜')
							  ->setCellValue('K'.$row, 'UD')
							  ->setCellValue('L'.$row, '保險櫃')
							  ->setCellValue('M'.$row, '目前存量')
							  ->setCellValue('N'.$row, '本月盤盈虧')
							  ->setCellValue('O'.$row, '補充量')
							  ->setCellValue('P'.$row, '備註');
							
							  
$row++;



/*************************************/

$sql2="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '%".$datetime."%%_daily_inventory%';";
$result2=mysqli_query($connect,$sql2);

while($r=mysqli_fetch_array($result2,MYSQLI_NUM)){
		  
$sql = "SELECT * FROM `".$r[0]."` ORDER BY `id` ASC;";           
$result=mysqli_query($connect,$sql);

$str = explode('_', $r[0]);
$title = substr($str[0], 6, 2);

$row = 1;
$objWorkSheet = $objPHPExcel->createSheet($title);
$objWorkSheet->setTitle("$title");

	$objWorkSheet->setCellValue('A'.$row, '項次')
                              ->setCellValue('B'.$row, '院內代碼')
                              ->setCellValue('C'.$row, '藥品品項')
                              ->setCellValue('D'.$row, '公藥')
                              ->setCellValue('E'.$row, '前日結存')
							  ->setCellValue('F'.$row, '收入量')
							  ->setCellValue('G'.$row, '消耗量')
							  ->setCellValue('H'.$row, '理論結存')
							  ->setCellValue('I'.$row, '調劑台')
							  ->setCellValue('J'.$row, '抽屜')
							  ->setCellValue('K'.$row, 'UD')
							  ->setCellValue('L'.$row, '保險櫃')
							  ->setCellValue('M'.$row, '合計')
							  ->setCellValue('N'.$row, '盤盈虧')
							  ->setCellValue('O'.$row, '補充量')
							  ->setCellValue('P'.$row, '備註');
							  
$row++;
while ($rec=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    $objWorkSheet->setCellValue('A'.$row, $rec['id'])
                              ->setCellValue('B'.$row, $rec['drug_code'])
                              ->setCellValue('C'.$row, $rec['drug_name'])
                              ->setCellValue('D'.$row, $rec['public'])
                              ->setCellValue('E'.$row, $rec['pre_balance'])
							  ->setCellValue('F'.$row, $rec['income'])
							  ->setCellValue('G'.$row, $rec['consum'])
							  ->setCellValue('H'.$row, $rec['t_balance'])
							  ->setCellValue('I'.$row, $rec['depen'])
							  ->setCellValue('J'.$row, $rec['drawer'])
							  ->setCellValue('K'.$row, $rec['ud'])
							  ->setCellValue('L'.$row, $rec['safe'])
							  ->setCellValue('M'.$row, $rec['total'])
							  ->setCellValue('N'.$row, $rec['profit_loss'])
							  ->setCellValue('O'.$row, $rec['supplement'])
							  ->setCellValue('P'.$row, $rec['comment']);
 
    $row++;
}
		

}  


 
$name = './Excel/'.$datetime.'_daily_inventory.xlsx';

$objWriter2007 = new PHPExcel_Writer_Excel2007($objPHPExcel); //因為這行可以輸中文
$objWriter2007->save($name); 

echo '<script type="text/javascript">window.location="excel_export_download.php";</script>';


?>