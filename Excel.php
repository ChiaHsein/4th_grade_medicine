<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

echo "<meta charset='utf-8'>";

$sql="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '%_daily_inventory%';";
$result=mysqli_query($connect,$sql);

$j=0;
while($row=mysqli_fetch_array($result,MYSQLI_NUM)){
	 echo substr($row[0], 6, 2);
	
}
 


?>