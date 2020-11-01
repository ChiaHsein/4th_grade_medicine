<?php

$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($conn,"SET NAMES 'UTF8'"); //各種設定
 
$json = file_get_contents("php://input"); //從手機端收到的Json資料
$data = json_decode($json); //JSON解碼

$sql="select `drug_name` from `medicine_profile` where `drug_code`='".$data->drug_code."'";
$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo $row["drug_name"];
	}

//echo $data->drug_code;



?>
