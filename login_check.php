<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
session_start();

$json = file_get_contents("php://input"); //接收所有輸入端
$check= json_decode($json) ? 'true' : 'false'; //判斷是否為json格式



if($check=='true'){  //json格式的資料格式
	$data= json_decode($json);
	$account = $data->account;
	$password = $data->password;
	
	$sql = "select name from `inventory_staff` where account = '".$account."' AND password = '".$password."'";
	$result=mysqli_query($connect,$sql);
	
	 
	$name=""; 
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
			$name = $row["name"];		 
	}
	if($name=="")
		echo "no-";
	else {
		$line ="yes-";
		$staff_existed="select * from `daily_staff` where `date`='".$datetime."';";
		$staff_existed_result=mysqli_query($connect,$staff_existed);
		if($row=mysqli_num_rows($staff_existed_result)>0){
			while($row2=mysqli_fetch_array($staff_existed_result,MYSQLI_ASSOC)){
				if($row2["check_code"]==1){//盤完
					$line .="check-".$name."-".$row2["name"];
				}else{
					$line .="login_check-".$name;
				}
			}
		}else{
			$sql2 = "INSERT INTO `daily_staff`(`date`, `name`, `check_code`) VALUES ('".$datetime."','".$name."',0)";
			$result2=mysqli_query($connect,$sql2);
			$line .="uncheck-".$name;
		}
		echo $line;
		$line="";
	}
		

}else{ //一般表單資料格式
	$n=$_POST["n"];
	if($n==1){ //檢查每日盤點者
		$day=$_POST["day"];
		$sql3 = "select name from `daily_staff` where date = '".$day."'";
		$result3=mysqli_query($connect,$sql3);
		while($row=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
			$name = $row["name"];		 
		}
		if(!isset($name)) 
			echo "no";
		else 
			echo $name;
	}
	if($n==2){ //管理者登入	
		$account=$_POST["account"];
		$password=$_POST["password"];
		if($account=="test" && $password=="test"){
			$_SESSION["account"]=$account;
			$_SESSION["in_out"]=1;
			echo "登入成功";
			
		}else{
			echo "輸入錯誤,請重新";
		}
	}

	
	 
	
}
 







?>
