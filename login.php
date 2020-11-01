<?php
$dbhost = 'localhost';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($conn,"SET NAMES 'UTF8'"); //各種設定

session_start();

$account=$_POST["account"];
$password=$_POST["password"];



$sql = "SELECT * FROM `inventory_staff` Where account = '".$account."' AND password = '".$password."'";
$result=mysqli_query($conn,$sql);

if($account=="manager" && $password=="100100010111"){
		echo "yes";
		$_SESSION['account'] = $account;
		$_SESSION['password']= $password;
		header("Location: main.php"); 
		//確保重定向後，後續代碼不會被執行 
		exit;
}else{
	if (mysqli_num_rows($result) == 0){
		echo "no";
	}else{
		echo "yes";
		$_SESSION['account'] = $account;
		$_SESSION['password']= $password;
		header("Location: main.php"); 
	}
}



 


?>