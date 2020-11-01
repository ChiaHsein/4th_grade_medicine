<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

 

$datetime = date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當日的
//echo $datetime;
	require_once('Classes/PHPExcel/Writer/CSV.php');
    require_once('Classes/PHPExcel/Writer/Excel2007.php');
  
    session_start();
	//引入函式庫
	include 'Classes/PHPExcel.php';
	require_once 'Classes/PHPExcel/IOFactory.php';
	
$objPHPExcel = new PHPExcel();



$sql2="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '%".$datetime."_daily_inventory%';";
$result2=mysqli_query($connect,$sql2);

if($row=mysqli_num_rows($result2)>0){ //有當天的表
 

	$sql = "SELECT * FROM `".$datetime."_daily_inventory` ORDER BY `id` ASC;";           
	$result=mysqli_query($connect,$sql);

	
	$title = $datetime."_daily_inventory";

	
	$objWorkSheet = $objPHPExcel->createSheet($title);
	$objWorkSheet->setTitle("$title");

	//合併儲存格
	$objWorkSheet->mergeCells('A1:C1')
				 ->setCellValue('A1','國軍台中總醫院4級管制藥品收支結存簿') //合併後的
				 ->mergeCells('D1:E1')
				 ->setCellValue('D1','登錄時間:')
	             ->setCellValue('F1',$datetime)
				 ->setCellValue('O1','清點人');
	
	$n = 2;
	$objWorkSheet->setCellValue('A'.$n, '項次')
                              ->setCellValue('B'.$n, '院內代碼')
                              ->setCellValue('C'.$n, '藥品品項')
                              ->setCellValue('D'.$n, '公藥')
                              ->setCellValue('E'.$n, '前日結存')
							  ->setCellValue('F'.$n, '收入量')
							  ->setCellValue('G'.$n, '消耗量')
							  ->setCellValue('H'.$n, '理論結存')
							  ->setCellValue('I'.$n, '調劑台')
							  ->setCellValue('J'.$n, '抽屜')
							  ->setCellValue('K'.$n, 'UD')
							  ->setCellValue('L'.$n, '保險櫃')
							  ->setCellValue('M'.$n, '合計')
							  ->setCellValue('N'.$n, '盤盈虧')
							  ->setCellValue('O'.$n, '補充量')
							  ->setCellValue('P'.$n, '備註');
							  
$n++;
while ($rec=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    $objWorkSheet->setCellValue('A'.$n, $rec['id'])
                              ->setCellValue('B'.$n, $rec['drug_code'])
                              ->setCellValue('C'.$n, $rec['drug_name'])
                              ->setCellValue('D'.$n, $rec['public'])
                              ->setCellValue('E'.$n, $rec['pre_balance'])
							  ->setCellValue('F'.$n, $rec['income'])
							  ->setCellValue('G'.$n, $rec['consum'])
							  ->setCellValue('H'.$n, $rec['t_balance'])
							  ->setCellValue('I'.$n, $rec['depen'])
							  ->setCellValue('J'.$n, $rec['drawer'])
							  ->setCellValue('K'.$n, $rec['ud'])
							  ->setCellValue('L'.$n, $rec['safe'])
							  ->setCellValue('M'.$n, $rec['total'])
							  ->setCellValue('N'.$n, $rec['profit_loss'])
							  ->setCellValue('O'.$n, $rec['supplement'])
							  ->setCellValue('P'.$n, $rec['comment']);
 
    $n++;
	}
}else{ //沒有當天的表
	echo '<script type="text/javascript">alert("have no today\'s table!");window.location="choose_daily_table.php";</script>';
}


$file_name = $datetime.'_daily_inventory.xlsx';
$file_dir2 = "./Daily_Excel/";

$objWriter2007 = new PHPExcel_Writer_Excel2007($objPHPExcel); //因為這行可以輸中文
$objWriter2007->save($file_dir2.$file_name); 

header("Content-type:application/vnd.ms-excel");
header("Content-Type: application/force-download");//强制下载
//给下载的内容指定一个中文名字
header('Content-Disposition: attachment; filename="' . $file_name . '";');
ob_clean();

readfile($file_dir2.$file_name);  
 
 
?>



 