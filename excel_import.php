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

foreach ($worksheet->getRowIterator() as $row) {
		//echo   $row->getRowIndex() . "\r\n" ."<br>";
	$str="";
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	
	if($rowindex == 0){
			 
			$sql="CREATE TABLE medicine_profile (id INT,drug_code varchar(20) PRIMARY KEY,
			drug_name varchar(100),seller varchar(20),
			control_drug_registration_number varchar(30),
			manufacturer varchar(20),
			drug_permit_number varchar(30),
			picture varchar(100))DEFAULT CHARSET=utf8;";
			$result=mysqli_query($connect,$sql);
			
		}
	
	if($rowindex>=1){
    
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
	$input = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$text[1]."&choe=UTF-8";
	
           
	array_push($data,array($text[0],$text[1],$text[2],$text[4],$text[5],$text[6],$text[7]));	 //二維
    $sql="INSERT INTO `medicine_profile`(`id`, `drug_code`, `drug_name`, `seller`, `control_drug_registration_number`, `manufacturer`, `drug_permit_number`,`picture`) VALUES ('".$text[0]."','".$text[1]."','".$text[2]."','".$text[4]."','".$text[5]."','".$text[6]."','".$text[7]."','".$input."');";
	$result=mysqli_query($connect,$sql);
	
	echo "<br>";
   }
   $rowindex++;
}

 echo '<script type="text/javascript">alert("success!");history.back();</script>';
	
	
	

?>