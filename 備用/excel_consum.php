<?php
$hostname="localhost";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定



    session_start();
	$get_month=date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
	$table_name=$get_month."_daily_inventory";
	
	//引入函式庫
	include 'Classes/PHPExcel.php';
	header("Content-Type:text/html; charset=utf-8");
	//設定要被讀取的檔案，經過測試檔名不可使用中文
	$file = "./files/".$_SESSION["filename"];  //路徑要打對啊QQ
	
	try {
	    $objPHPExcel = PHPExcel_IOFactory::load($file);
	} catch(Exception $e) {
	    die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
	} 
	$data=array();  //放每一行的數值用，我自己加的。
	
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	//echo "<h2>列印每一行的資料</h2>";
	//欄與列的index
	$colindex=0; //欄
	$rowindex=0; //列
	//某行完全沒有值的判斷變數
	$rownull=true;
	//資料對應的欄位標題，有時標題也有利用的空間，完整版我是有用到。
	$title = array(); //放標題的陣列
	foreach($sheetData as $key => $col){  //讀取每一列
		//讀取標題
		if($rowindex == 0){
			foreach ($col as $colkey => $colvalue){
				array_push($title,$colvalue);
			}
			
		}
		//前面1行不讀入,可更改值設定前幾行不讀取
		if($rowindex>=5){ //前面武行不讀取
			//echo "行{$key}: "."<br>";
			$temp="";
			foreach ($col as $colkey => $colvalue){
			
				//#--為後面使用字串切割的key
				//為第二列資料並且不為最後一列資料，增加切割時用的字串(可更改為不常使用的符號或文字)。輸出格式會變成: 資料1#--資料2#--資料3#--資料4....資料n，每筆資料中間會有#--
				if($colindex > 0 && $colindex != sizeof($col))
					$temp.="#--";
				//前面0列不讀入,可更改值，設定前幾列不讀取，或是為n+1列開始讀取。
				if($colindex >= 0){
					//某列值不為空，判斷該行就算有資料。
					if($colvalue!="")
						$rownull=false;
					//將資料暫存下來，繼續讀取下一列。
					$temp.=$colvalue;
				}
				//列的index遞增
				$colindex++;
			}
			//如果設定保護工作表會讀取整份文件Excel,所以$rownull來判斷讀取到的某一行是否完全沒有輸入值
			if($rownull)
				//continue;
				//echo "行".$key."沒有值<br>";
			//if($rownull && $rowindex > 0)//如果某行完全沒有值，並且讀取到的是內容(標題為第一行,$rowindex=0)，就不在繼續讀取，節省資源。
				//break;
			//某行完全沒有值的"判斷變數"，改回預設值
			$rownull=true;
		
			$text=explode("#--",$temp); //explode() 把字符串打散為陣列。
			//某一行的所有資料
			for($i=0;$i<sizeof($text);$i++){
				//某列資料值為空
				if($text[$i]=="")
					continue;
					//echo "此儲存格資料為空!";
				else {
					echo " ";
					//echo $title[$i].":";
					//echo $text[$i];
					
					 
				}		
			}
			array_push($data,array($text[3],$text[12]));	 //二維
			//列的index歸零
			
			$colindex=0;
			//輸出換行
			//echo $rowindex;
			//echo "<br/>";
		}
		if($rowindex>=1)
			echo " ";
		//行的index遞增
		$rowindex++;
	}
	for($Key=count($data)-1;$Key>=0;$Key--) { 
		 
		//echo $data[$Key][0]." ".$data[$Key][1];
		 
		$sql="UPDATE `".$table_name."` SET `consum`=".$data[$Key][1].",`t_balance`=`pre_balance`+`income`-`consum`,`profit_loss`=`total`-`t_balance` where `drug_code`='".$data[$Key][0]."';";
		$result=mysqli_query($connect,$sql); 
  }
  echo '<script type="text/javascript">alert("success!");history.back();</script>';
  
?>
 