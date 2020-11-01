<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

$get_month=date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
$table_name=$get_month."_stock_clerks";

$find_purchase_return_table="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$table_name."';";
$find_purchase_return_table_rs=mysqli_query($connect,$find_purchase_return_table); 

if($row=mysqli_num_rows($find_purchase_return_table_rs)>0){ 
	
$category=$_POST["category"]; //*2藥品類別代碼
$license_code=$_POST["license_code"];//*3許可證號碼
$certificate_number=$_POST["certificate_number"];//*3證號
$batch_number=$_POST["batch_number"];//4批號
$balance_state=$_POST["balance_state"];//*5收支狀態(本期)
$pack_standard=$_POST["pack_standard"];//*6包裝規格
$dateday=$_POST["dateday"];//*7日期
$balance_reason=$_POST["balance_reason"];//*8收支原因
$pack_quantity=$_POST["pack_quantity"];//*9包裝數量
$balance_quantity=$_POST["balance_quantity"];//*10收支數量

if(isset($_POST["agree_number_N"])){
	$agree_number=$_POST["agree_number_N"].$_POST["agree_number_A"];//11同意編號
}else
	$return_date="";

if(isset($_POST["return_date"])){
	$return_date=$_POST["return_date"];
}else
	$return_date="";

if(isset($_POST["sign_date"])){
	$sign_date=$_POST["sign_date"];
}else
	$sign_date="";


$insert_data="INSERT INTO `".$table_name."`
(`category_code`, `license_code`, `certificate_number`, `batch_number`, `balance_state`, `pack_standard`, `dateday`, `balance_reason_code`, `pack_quantity`, `balance_quantity`, `agree_number`, `return_date`, `sign_date`) VALUES(
'".$category."','".$license_code."','".$certificate_number."','".$batch_number."','".$balance_state."','".$pack_standard."','".$dateday."','".$balance_reason."','".$pack_quantity."','".$balance_quantity."','".$agree_number."','".$return_date."','".$sign_date."')";
$insert_data_rs=mysqli_query($connect,$insert_data);

echo $dateday;

if(isset($_POST["control_register"])){
	$control_register=$_POST["control_register"];//12對象機構業者登記證號
	$seller=$_POST["seller"];//13對象機構業者名稱
	$address1=$_POST["address1"];//14
	$address2=$_POST["address2"];//15
	$address3=$_POST["address3"];//16
	$phone_number=$_POST["phone_number"];//17
	$update_data="UPDATE `".$table_name."` SET `control_register`='".$control_register."',`seller`='".$seller."',`address1`='".$address1."',`address2`='".$address2."',`address3`='".$address3."',`phone_number`='".$phone_number."' where dateday='".$dateday."' and category_code='".$category."' and license_code='".$license_code."' and certificate_number='".$certificate_number."';";
	 
}
if(isset($_POST["Dtext"])){
	$Dtext=$_POST["Dtext"];//18
	$Dnumber=$_POST["Dnumber"];//19
	$Ddate=$_POST["Ddate"];//20
	$update_data="UPDATE `".$table_name."` SET `Dtext`='".$Dtext."',`Dnumber`='".$Dnumber."',`Ddate`='".$Ddate."' where dateday='".$dateday."' and category_code='".$category."' and license_code='".$license_code."' and certificate_number='".$certificate_number."';";
	
}
if(isset($_POST["Rnumber"])){
	$Rnumber=$_POST["Rnumber"];
	$Rdate=$_POST["Rdate"];
	$update_data="UPDATE `".$table_name."` SET `Rnumber`='".$Rnumber."',`Rdate`='".$Rdate."' where dateday='".$dateday."' and category_code='".$category."' and license_code='".$license_code."' and certificate_number='".$certificate_number."';";
	
 
}
if(isset($_POST["Sname"])){
	$Sname=$_POST["Sname"];
	$update_data="";
	$update_data="UPDATE `".$table_name."` SET `Sname`='".$Sname."' where dateday='".$dateday."' and category_code='".$category."' and license_code='".$license_code."' and certificate_number='".$certificate_number."';";
	
	
}
if(isset($_POST["Pcode"])){
	$Pcode=$_POST["Pcode"];
	$Pname=$_POST["Pname"];
	$Pnumber=$_POST["Pnumber"];
	$update_data="UPDATE `".$table_name."` SET `Pcode`='".$Pcode."',`Pname`='".$Pname."',`Pnumber`='".$Pnumber."' where dateday='".$dateday."' and category_code='".$category."' and license_code='".$license_code."' and certificate_number='".$certificate_number."';";
	
}
$update_data_rs=mysqli_query($connect,$update_data);

echo '<script type="text/javascript">alert("success!");history.back();</script>';

}else{
	echo '<meta charset="utf-8"><script type="text/javascript">alert("無當月進退貨表格");history.back();</script>';

}


?>