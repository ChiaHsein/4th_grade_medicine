<?php

$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

session_start();
$get_month=date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
$table_name=$get_month."_daily_inventory";
//$table_name="20170925_daily_inventory";

//echo $table_name;
$sql="CREATE TABLE ".$table_name." (id INT,
			drug_code varchar(20) PRIMARY KEY,
			drug_name varchar(100),
			public varchar(10) not null default 0,
			pre_balance varchar(10) not null default 0,
			income varchar(10) not null default 0,
			consum varchar(10) not null default 0,
			t_balance varchar(10) not null default 0,
			depen varchar(10) not null default 0,
			drawer varchar(10) not null default 0,
			ud varchar (10) not null default 0,
			safe varchar(10) not null default 0,
			total varchar(10) not null default 0,
			profit_loss varchar(10) not null default 0,
			supplement varchar(10) not null default 0,
			comment varchar(50),
			judge varchar(5) not null default 0)DEFAULT CHARSET=utf8;";
$result=mysqli_query($connect,$sql);

$sql2="select drug_code,drug_name FROM medicine_profile where NOT drug_name LIKE '%(DC)%' ORDER BY `id` ASC;";
$result2=mysqli_query($connect,$sql2);

$j=1;

while($row=mysqli_fetch_row($result2)){
		
		$sql3="INSERT INTO `".$table_name."`(`id`, `drug_code`, `drug_name`) VALUES (".$j.",'".$row[0]."','".$row[1]."');";
		$result3=mysqli_query($connect,$sql3);
		//echo $row[0]." ".$row[1]."</br>";
		$j++;
}


 

echo '<script type="text/javascript">alert("success!");history.back();</script>';

?>