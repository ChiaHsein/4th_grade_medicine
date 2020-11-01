<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));

$category_code=$_POST["category_code"];
if($category_code=="PR" || $category_code=="MR" || $category_code=="Z")
	$balance_reason = "select * from `balance_reason_code_table` where balance_reason_code='103' or balance_reason_code='203';";
else if($category_code=="P")
	$balance_reason = "select * from `balance_reason_code_table` where tag='0' or tag='1' or tag='2' or tag='4';";
else if($category_code=="R")
	$balance_reason = "select * from `balance_reason_code_table` where tag='0';";
else if($category_code=="S")
	$balance_reason = "select * from `balance_reason_code_table` where tag='0' or tag='3';";
else if($category_code=="UM")
	$balance_reason = "select * from `balance_reason_code_table` where tag='0' or tag='4';";	

$balance_reason_rs=mysqli_query($connect,$balance_reason);
echo "<option>-----</option>";
while($row=mysqli_fetch_array($balance_reason_rs,MYSQLI_ASSOC)){
	 echo "<option value='" . $row["balance_reason_code"] . "'>" .$row["balance_reason_code"].":".$row["balance_reason"]."</option>";
}

?>
