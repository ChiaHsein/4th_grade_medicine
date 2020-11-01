<?php

$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($conn,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));

$data = file_get_contents("php://input"); //從手機端收到的Json資料
$state = substr($data,0,1);
$day =substr($data,1,8);
$json = substr($data,9); 

$number = json_decode($json); //JSON解碼

$feedback=""; //新的盤點
$existed=""; //已存在的
$uncheck=""; //還沒盤的

$table_existed="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$day."_daily_inventory';";
$table_existed_result=mysqli_query($conn,$table_existed);

if($row=mysqli_num_rows($table_existed_result)>0){  //有資料表
	if($state=="F"){ //完成盤點
		$not_yet="select `drug_code`,`drug_name` from `".$day."_daily_inventory` where judge=0";
		$not_yet_result=mysqli_query($conn,$not_yet);
		while($row=mysqli_fetch_array($not_yet_result,MYSQLI_ASSOC)){
			$change_state="UPDATE `".$day."_daily_inventory` SET `judge`=2 where `drug_code`='".$row["drug_code"]."'";
			$change_state_result=mysqli_query($conn,$change_state);
			
			if(empty($uncheck))
				$uncheck .= $row["drug_code"]."/".$row["drug_name"];
			else
				$uncheck .= "-".$row["drug_code"]."/".$row["drug_name"];
		}
		$staff_existed="select `name` from `daily_staff` where `date`='".$day."' and `check_code`=1";
		$staff_existed_result=mysqli_query($conn,$staff_existed);
		if($row=mysqli_num_rows($staff_existed_result)>0){
			echo "existed";
		}else{
			$staff_check="UPDATE `daily_staff` SET `name`='".$json."',`check_code`=1 where `date`='".$day."'";
			$staff_check_result=mysqli_query($conn,$staff_check);
		
			if(empty($uncheck)) 
				echo "complete";
			else 
				echo $uncheck;
		}
		$uncheck="";
	}
	if($state=="N"){ //盤點
		if(empty($number)){
			echo "5";
		}else{
			foreach($number as $obj){ //用foreach走訪取值"->"
				$total=$obj->depen+$obj->drawer+$obj->ud+$obj->safe;
					
				$isset = "select * from `".$day."_daily_inventory` where drug_code='".$obj->drug_code."';"; 
				$isset_result = mysqli_query($conn,$isset);
					while($row=mysqli_fetch_array($isset_result,MYSQLI_ASSOC)){
						$judge = $row["judge"];
						if($judge==0 || $judge==2 ||$judge==3){ //還沒盤過
							$t_balance=$row["t_balance"]; //理論結存
						
							$profit_loss=$total-$t_balance;
						/*
							if($profit_loss==0)
								$percentage=0;
							else
								$percentage = abs($profit_loss/$row["consum"]);
							
							if($percentage>0.02){
								$sql="UPDATE `".$day."_daily_inventory` SET `depen`='".$obj->depen."',`drawer`='".$obj->drawer."',`ud`='".$obj->ud."',`safe`='".$obj->safe."',`total`='".$total."',`profit_loss`='".$profit_loss."', `judge`=3 where drug_code='".$obj->drug_code."';"; 
								$result=mysqli_query($conn,$sql);
							}else{*/
								$sql="UPDATE `".$day."_daily_inventory` SET `depen`='".$obj->depen."',`drawer`='".$obj->drawer."',`ud`='".$obj->ud."',`safe`='".$obj->safe."',`total`='".$total."',`profit_loss`='".$profit_loss."', `judge`=1 where drug_code='".$obj->drug_code."';"; 
								$result=mysqli_query($conn,$sql);
							//}
							$feedback .= $obj->drug_code ."-".$obj->depen ."-".$obj->drawer ."-".$obj->ud ."-".$obj->safe ."-".$total ."-".$profit_loss;
								
						}else{ //已盤過
							if(empty($existed))
								$existed .= $row["drug_code"];
							else
								$existed .= "-".$row["drug_code"];
						}
						$percentage="";
					}
			}
			if(!empty($feedback) && empty($existed)){ //都沒盤過
				echo "1".$feedback;
				$feedback="";
			}
			if(empty($feedback) && !empty($existed)){ //都盤過
				echo "2".$existed;
				$existed="";
			}
			if(!empty($feedback) && !empty($existed)){
				echo "3".$feedback."&".$existed; //有未盤過的和盤過的
				$feedback="";
				$existed ="";
			}
		}	
	} 
	if($state=="R"){ //覆寫
		foreach($number as $obj){ //用foreach走訪取值"->"
		$total=$obj->depen+$obj->drawer+$obj->ud+$obj->safe;
		
		$isset = "select * from `".$day."_daily_inventory` where drug_code='".$obj->drug_code."';"; 
		$isset_result = mysqli_query($conn,$isset);
			while($row=mysqli_fetch_array($isset_result,MYSQLI_ASSOC)){
				$t_balance=$row["t_balance"]; //理論結存
				$profit_loss=$total-$t_balance;
				$sql="UPDATE `".$day."_daily_inventory` SET `depen`='".$obj->depen."',`drawer`='".$obj->drawer."',`ud`='".$obj->ud."',`safe`='".$obj->safe."',`total`='".$total."',`profit_loss`='".$profit_loss."', `judge`=1 where drug_code='".$obj->drug_code."';"; 
				$result=mysqli_query($conn,$sql);
						
				$feedback .= $obj->drug_code ."-".$obj->depen ."-".$obj->drawer ."-".$obj->ud ."-".$obj->safe ."-".$total ."-".$profit_loss;
			}
		}
		echo "rewrite";
	}

}else{ //沒有資料表
	echo "4";
	
}



?>
