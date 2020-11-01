<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
	  
	 $arr = array();
     $sql="SELECT * FROM `medicine_profile` ORDER BY `id` ASC;";  
     $result=mysqli_query($connect,$sql);
      
     while($obj = mysqli_fetch_object($result)) {
           $arr[] = $obj;
     }
     
     echo json_encode($arr);	
?>