<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定


$table_existed="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE 'medicine_profile';";
$table_existed_result=mysqli_query($connect,$table_existed);

$sql =  "SELECT `drug_code`,`picture` FROM `4thgradedrugs`.`medicine_profile`";
$result=mysqli_query($connect,$sql);

if($row=mysqli_num_rows($table_existed_result)>0){ //有表
	while($obj = mysqli_fetch_object($result)) {
	$arr[] = array('drug_code' => $obj->drug_code, 'picture' => $obj->picture);
	}
	$a = json_encode($arr);
	echo $a;
}else{ //沒表
	echo "no";
}




?>