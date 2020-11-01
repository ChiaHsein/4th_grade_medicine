<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
//開啟session	
session_start();
header("Cache-control:private");

if (isset($_POST["send"])) {
	
	//指定儲存目錄及檔名
	$upload_dir = "./files/";
	$upload_file = $upload_dir.iconv("UTF-8","Big5",$_FILES["myfile"]["name"]);
	if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$upload_file)){
		$_SESSION['filename']=$_FILES["myfile"]["name"];
		echo "上傳成功";
		header("location:excel_import.php");
	}else{
		//echo "上傳失敗";
	}
}
if (isset($_POST["add"])) {
	
	$code=$_POST["drug_code"]; 
	$name=$_POST["drug_name"]; 
	$se=$_POST["seller"];
	$con=$_POST["control_drug_registration_number"];
	$ma=$_POST["manufacturer"];
	$permit=$_POST["drug_permit_number"];
	
	$s="select * from medicine_profile";
	$r=mysqli_query($connect,$s);
	$n=mysqli_num_rows($r)+1;
	
	//echo $code; 
	//echo $name; 
	//echo $se;
	//echo $con;
	//echo $ma;
	//echo $permit;
	$input = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$code."&choe=UTF-8";
	$sql="INSERT INTO `medicine_profile`(`id`, `drug_code`, `drug_name`, `seller`, `control_drug_registration_number`, `manufacturer`, `drug_permit_number`,`picture`) 
	VALUES ('".$n."','".$code."','".$name."','".$se."','".$con."','".$ma."','衛署藥製字第".$permit."號','".$input."')"; //字串記得加單引號~~~~!!!!
	$result=mysqli_query($connect,$sql);
	
	echo '<script type="text/javascript">alert("success!");</script>';
	
}
 
?>

<!DOCTYPE html>
<html>
<head>
	<title>4th Grade Controlled Drugs</title>
	<meta charset="utf-8">
	<script type="text/javascript">
	
	function back_home(){
   if (window.top != window.self) {
        window.top.location = "main.php";
    }
}
</script>
<style>
	@import url(form.css); 
</style>	
</head>
	<body>
	<img id="home" src="home.png" onclick="back_home()">
<div class="form-style-5">
		
		
		<legend><span class="n">1</span>Medicine Profile</legend>
		 
		<form name="profile" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input type="file" name="myfile" size="50" required/>
			<input type="submit" value="Upload" name="send">
		</form>
	 
		
		<br>
		<legend><span class="n">2</span>New Medicine</legend>
		<fieldset>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input type="text" name="drug_code" placeholder="院內代碼*" required/>
			<input type="text" name="drug_name" placeholder="藥品品項*" required/>
			<input type="text" name="seller" placeholder="廠商*" required/>
			<input type="text" name="control_drug_registration_number" placeholder="管制藥品登記證號*" required/> 
			<input type="text" name="manufacturer" placeholder="製造商*" required/>
			<input type="text" name="drug_permit_number" placeholder="藥品許可證號*" required/> 
			<input type="reset" value="Reset"> 
			<input type="submit" value="Send" name="add"></td>
			</tr>
			<table>
		</form>
		</fieldset>
		
		<br>
		 
</div>		 
	</body>
</html>