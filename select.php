<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($conn,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

 
$arr = array();
/* 
$sql =  "SELECT * FROM `4thgradedrugs`.`medicine_profile`";
$result = $conn->query($sql);
*/
$table_existed="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$datetime."_daily_inventory';";
$table_existed_result=mysqli_query($conn,$table_existed);

$sql =  "SELECT `drug_code`,`drug_name`,`safe` FROM `4thgradedrugs`.`".$datetime."_daily_inventory`";
$result = $conn->query($sql);

if($row=mysqli_num_rows($table_existed_result)>0){ //有表
	while($obj = mysqli_fetch_object($result)) {
		$arr[] = array('drug_code' => $obj->drug_code, 'drug_name' => $obj->drug_name , 'safe' => $obj->safe);
	}
		$a = json_encode($arr);
		echo $a;
}else{ //沒表
	echo "no";
}

 
 
 
?>
