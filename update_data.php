<?php

$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

$datetime = date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當天的
$stock_clerks=$datetime."_stock_clerks";

 $n=$_POST["n"]; //識別

 $comment = $_POST["comment"];
 $day=$_POST["day"];
 $code=$_POST["code"];
 
 $supplement=$_POST["supplement"];
 $seller=$_POST["seller"];
 $cdrn=$_POST["cdrn"];
 $public=$_POST["pub"];
 
 if($n==1){
	$sql="UPDATE `4thgradedrugs`.`".$day."_daily_inventory` set `safe`=`safe`+`supplement`, `supplement`=".$supplement.", `safe`=`safe`-".$supplement." where `drug_code`='".$code."'";
	$result=mysqli_query($connect,$sql); 
	

 }
 if($n==2){
	$sql2="UPDATE `4thgradedrugs`.`".$day."_daily_inventory` set `comment`='".$comment."' where `drug_code`='".$code."'";
	$result2=mysqli_query($connect,$sql2); 
 }
 if($n==3){
	$sql3="UPDATE `4thgradedrugs`.`".$stock_clerks."` set `com`='".$comment."' where `drug_code`='".$code."' AND `dateday`='".$day."'";
	$result3=mysqli_query($connect,$sql3); 
 }
 if($n==4){
	$sql4="UPDATE `4thgradedrugs`.`".$stock_clerks."` set `seller`='".$seller."' where `drug_code`='".$code."' AND `dateday`='".$day."'";
	$result4=mysqli_query($connect,$sql4); 
 }
 if($n==5){
	$sql5="UPDATE `4thgradedrugs`.`".$stock_clerks."` set `control_drug_registration_number`='".$cdrn."' where `drug_code`='".$code."' AND `dateday`='".$day."'";
	$result5=mysqli_query($connect,$sql5); 
 }
 if($n==6){
	$sql6="UPDATE `4thgradedrugs`.`".$day."_daily_inventory` set `total`=`total`-`public`,`public`='".$public."',`total`=`total`+'".$public."',`profit_loss`=`total`-`t_balance` where `drug_code`='".$code."'";
	$result6=mysqli_query($connect,$sql6); 
 }
 
 



?>