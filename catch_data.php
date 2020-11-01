<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
	 $datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當天的
	//$datetime="20170829";
	 $arr = array();
     $sql="SELECT * FROM ".$datetime."_daily_inventory";  
     $result=mysqli_query($connect,$sql);
      
     while($obj = mysqli_fetch_object($result)) {
           $arr[] = $obj;
     }
     
     echo json_encode($arr);	
?>