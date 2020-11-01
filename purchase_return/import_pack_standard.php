<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

 
 
    require_once('Classes/PHPExcel/Reader/CSV.php');
	header("Content-Type:text/html; charset=utf-8");
    session_start();
	//引入函式庫
	include 'Classes/PHPExcel.php';
 
	
	//設定要被讀取的檔案，經過測試檔名不可使用中文
	//$file = "./files/".$_SESSION["filename"];  //路徑要打對啊QQ
	
	$inputFileType = 'CSV';
	
	//$inputFileName = './files/profile.csv';
	$inputFileName = "./purchase_return/".$_SESSION["filename"];
	
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objReader->setInputEncoding('');//QwQ
	$objPHPExcel = $objReader->load($inputFileName);
	
	
$worksheet = $objPHPExcel->getActiveSheet();

$rowindex=0; //列

/*
$get_month=date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
$table_name=$get_month."_daily_inventory";
*/

foreach ($worksheet->getRowIterator() as $row) {
		//echo   $row->getRowIndex() . "\r\n" ."<br>";
	$str="";
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	
	
	if($rowindex>=1){	
	
 
	foreach ($cellIterator as $index=>$cell) { //走訪每一欄位
		 
        if (!is_null($cell)) { //欄位不等於空
			if($cell->getValue()=="V"){
				$str .="1#--";
			}else{
				$str .=$cell->getValue()."#--"; //ex.101#--毫升#--毫升#--注射劑#--V#--#--#--
				//echo $cell->getValue() . "\r\n";	
			}
        }
		 
	}
	$text=explode("#--",$str);
	
	for($i=0;$i<sizeof($text);$i++){
		//某列資料值為空
		if($text[$i]=="")
			echo "";
		else {
			echo " ";
			echo $text[$i]; 
		}		
	}

	
           
	//array_push($data,array($text[1],$text[12]));	 //二維
 
	$insert_pack_standard="INSERT INTO `pack_standard_table`(`pack_standard_code`, `pack_standard`, `pack_standard_name`, `type`, `P`, `S`, `R`) VALUES ('".$text[0]."','".$text[1]."','".$text[2]."','".$text[3]."','".$text[4]."','".$text[5]."','".$text[6]."')";
	$insert_pack_standard_rs=mysqli_query($connect,$insert_pack_standard); 
	
 
	
	echo "<br>";
   }
   $rowindex++;
}

// echo '<script type="text/javascript">alert("success!");history.back();</script>';
	
	
	 

?>


 