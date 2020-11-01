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
	 $data=array();
	
	//設定要被讀取的檔案，經過測試檔名不可使用中文
	//$file = "./files/".$_SESSION["filename"];  //路徑要打對啊QQ
	
	$inputFileType = 'CSV';
	
	//$inputFileName = './files/profile.csv';
	$inputFileName = "./files/".$_SESSION["filename"];
	
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objReader->setInputEncoding('');//QwQ
	$objPHPExcel = $objReader->load($inputFileName);
	
	
$worksheet = $objPHPExcel->getActiveSheet();

$rowindex=0; //列

$get_month=date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
$table_name=$get_month."_daily_inventory";

foreach ($worksheet->getRowIterator() as $row) {
		//echo   $row->getRowIndex() . "\r\n" ."<br>";
	$str="";
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	
	
	if($rowindex>=2){	
	
	foreach ($cellIterator as $cell) {
		 
        if (!is_null($cell)) {
			$str .=$cell->getValue()."#--";
            //echo $cell->getValue() . "\r\n";	
        }	 
		
    }
	$text=explode("#--",$str);
	
	for($i=0;$i<sizeof($text);$i++){
		//某列資料值為空
		if($text[$i]=="")
			echo "";
		else {
			echo " ";
			//echo $text[$i]; 
		}		
	}

	
           
	array_push($data,array($text[1],$text[12]));	 //二維
	
	
	$sql="UPDATE `".$table_name."` SET `pre_balance`=".$text[12].",`t_balance`=`pre_balance`+`income`-`consum`,`profit_loss`=`total`-`t_balance` where `drug_code`='".$text[1]."';";
	$result=mysqli_query($connect,$sql); 
	
	
	echo "<br>";
   }
   $rowindex++;
}

 echo '<script type="text/javascript">alert("success!");history.back();</script>';
	
	
	 

?>