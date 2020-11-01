<?php

$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

session_start();
$get_month=date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
$table_name=$get_month."_stock_clerks";
//$table_name="20170925_daily_inventory";

//echo $table_name;
$create_purchase_return_table="CREATE TABLE `".$table_name."`
		   (category_code varchar(2) not null default 0 , 
			license_code varchar(2) not null default 0,
			certificate_number varchar(10) not null default 0,
			batch_number varchar(20),
			balance_state varchar(1) not null default 0,
			pack_standard varchar(50) not null default 0,
			dateday datetime not null,
			balance_reason_code varchar(3) not null default 0,
			pack_quantity double not null default 0,
			balance_quantity double not null default 0,
			agree_number varchar(14),
			control_register varchar(14),
			seller varchar(60),
			address1 varchar(20),
			address2 varchar(20),
			address3 varchar(20),
			phone_number varchar(23),
			Dtext varchar(20),
			Dnumber varchar(12),
			Ddate datetime,
			Rnumber varchar(10),
			Rdate datetime,
			Sname varchar(100),
			Pcode char(10),
			Pname varchar(180),
			Pnumber varchar(20),
			return_date datetime,
			sign_date datetime,
			PRIMARY KEY (dateday,category_code,license_code,certificate_number))DEFAULT CHARSET=utf8;";
$create_purchase_return_table_rs=mysqli_query($connect,$create_purchase_return_table);
 
 

?>