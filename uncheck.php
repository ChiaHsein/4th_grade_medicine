<?php

$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($conn,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));


$uncheck=""; //還沒盤的
$check="";//已盤
$excessive=""; //超過0.02

$find_finished="select `drug_code` from `".$datetime."_daily_inventory` where judge=2";
$find_finished_result=mysqli_query($conn,$find_finished);
while($row=mysqli_fetch_array($find_finished_result,MYSQLI_ASSOC)){
	if(empty($uncheck))
		$uncheck .= $row["drug_code"];
	else
		$uncheck .= "-".$row["drug_code"];
}
$find_ok="select `drug_code` from `".$datetime."_daily_inventory` where judge=1";
$find_ok_result=mysqli_query($conn,$find_ok);
while($row=mysqli_fetch_array($find_ok_result,MYSQLI_ASSOC)){
	if(empty($check))
		$check .= $row["drug_code"];
	else
		$check .= "-".$row["drug_code"];
}


$excessive_check="select `drug_code` from `".$datetime."_daily_inventory` where judge=3";
$excessive_check_result=mysqli_query($conn,$excessive_check);
while($row=mysqli_fetch_array($excessive_check_result,MYSQLI_ASSOC)){
	if(empty($excessive))
		$excessive .= $row["drug_code"];
	else
		$excessive .= "-".$row["drug_code"];
}
 

echo $uncheck."?".$check."?".$excessive;

$uncheck="";
$check="";
$excessive="";	


?>