 <?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

//當月
$datetime = date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當天的
$stock_clerks=$datetime."_stock_clerks";

if(isset($_POST['number']))
	$n=$_POST['number'];
else
	$n=5;


$sql7="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$stock_clerks."';";
$result7=mysqli_query($connect,$sql7); 

if($row=mysqli_num_rows($result7)>0){ //有前天的表，取前一天點盤數量total
if($n==1){ //新增
	$date=$_POST["date"];
	$cause=$_POST["cause"];
	$drug_name=$_POST["drug_name"];
	$quantity=$_POST["quantity"];
	$batch_number=$_POST["batch_number"];
	
	$sql="select `drug_code`, `seller`, `control_drug_registration_number`, `manufacturer`, `drug_permit_number` FROM `medicine_profile` where `drug_name`='".$drug_name."'";
	$result=mysqli_query($connect,$sql);
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$drug_code=$row["drug_code"];
		$seller=$row["seller"];
		$cdrn=$row["control_drug_registration_number"];
		$manufacturer=$row["manufacturer"];
		$dpn=$row["drug_permit_number"];
	}

	$sql2="INSERT INTO `".$stock_clerks."`(`dateday`, `cause`, `drug_code`, `drug_name`, `quantity`, `batch_number`, `com`, `seller`, `control_drug_registration_number`, `manufacturer`, `drug_permit_number`) VALUES ('".$date."','".$cause."','".$drug_code."','".$drug_name."','".$quantity."','".$batch_number."','','".$seller."','".$cdrn."','".$manufacturer."','".$dpn."')";
	$result2=mysqli_query($connect,$sql2); 
	
	//插入該日的點盤表
	$s = explode('-', $date);
	$daily=$s[0].$s[1].$s[2];
	echo $daily; //進貨日->再插入該日的點盤表
	if($cause=="購買" || $cause=="受讓" || $cause=="退藥" || $cause=="減損查獲"){
		$sql3="UPDATE `".$daily."_daily_inventory` SET `income`=`income`+".$quantity.", `t_balance`=`t_balance`+".$quantity.", `profit_loss`=`total`-`t_balance` WHERE `drug_code`='".$drug_code."'";
		$result3=mysqli_query($connect,$sql3); 
	}else{
		$sql9="UPDATE `".$daily."_daily_inventory` SET `income`=`income`-".$quantity.", `t_balance`=`t_balance`-".$quantity.", `profit_loss`=`total`-`t_balance` WHERE `drug_code`='".$drug_code."'";
		$result9=mysqli_query($connect,$sql9); 
	}
	
	
}else if($n==2){//刪除
	$date=$_POST["date"];
	$drug_code=$_POST["drug_code"];
	$sql4="DELETE FROM `".$stock_clerks."` WHERE `dateday`='".$date."' AND `drug_code`='".$drug_code."'";
	$result4=mysqli_query($connect,$sql4); 
	
	$s = explode('-', $date);
	$daily=$s[0].$s[1].$s[2];
	echo $daily; //進貨日->再插入該日的點盤表
	
	$sql5="UPDATE `".$daily."_daily_inventory` SET `t_balance`=`t_balance`-`income`, `profit_loss`=`total`-`t_balance` WHERE `drug_code`='".$drug_code."'";
	$result5=mysqli_query($connect,$sql5); 
	$sql6="UPDATE `".$daily."_daily_inventory` SET `income`=0 WHERE `drug_code`='".$drug_code."'";
	$result6=mysqli_query($connect,$sql6);
	
	}
}else{

	$sql8="CREATE TABLE `".$stock_clerks."` (
			dateday varchar(10),
			cause varchar(10),
			drug_code varchar(10),
			drug_name varchar(50),
			quantity varchar(10) not null default 0,
			batch_number varchar(20),
			com varchar(10),
			seller varchar(30),
			control_drug_registration_number varchar(30),
			manufacturer varchar (30),
		    drug_permit_number varchar(30),
			PRIMARY KEY(dateday ,cause ,drug_code)
			)DEFAULT CHARSET=utf8;";
	$result8=mysqli_query($connect,$sql8);
	
 
}

echo '<script type="text/javascript">alert("success");window.location.replace("return_and_purchase_table.php");</script>';	
	


	
?>