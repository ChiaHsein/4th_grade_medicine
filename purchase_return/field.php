<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));

$balance_reason=$_POST["balance_reason"];
$balance="select * from `field_table` where field not in (select `field` from `field_table` where field LIKE '%date%') and class in (select `class` from `balance_reason_code_table` where balance_reason_code='".$balance_reason."');";
$balance_rs=mysqli_query($connect,$balance);
  
$date_field="select * from `field_table` where field LIKE '%date%' and class in (select `class` from `balance_reason_code_table` where balance_reason_code='".$balance_reason."');";
$date_field_rs=mysqli_query($connect,$date_field);
 

while($row=mysqli_fetch_array($balance_rs,MYSQLI_ASSOC)){//一般欄位
	echo  "<input name='".$row["field"]."' type='text' size='20' placeholder='".$row["id"].$row["name"]."'>"."</br>";
}
while($row=mysqli_fetch_array($date_field_rs,MYSQLI_ASSOC)){ //日期欄位
	echo  $row["id"].$row["name"].$row["field"].":</br><input name='".$row["field"]."' type='date'>"."</br>";
}

?>