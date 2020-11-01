<?php
session_start();
if(!isset($_SESSION['account'])){
	echo '<script type="text/javascript">alert("尚未登入");history.back();</script>';
}else{
$hostname="localhost";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

if (isset($_POST["create_account_table"])) { //新增帳戶表格、每日盤點人紀錄
	$staff_table="CREATE TABLE `inventory_staff` (account varchar(20) PRIMARY KEY,
			password varchar(20) ,
			name varchar(20))DEFAULT CHARSET=utf8;";
	$daily_staff_table="CREATE TABLE `daily_staff` (date varchar(20) PRIMARY KEY,
			name varchar(20) ,
			check_code int(10))DEFAULT CHARSET=utf8;";
			
	$staff_table_result=mysqli_query($connect,$staff_table);
	$daily_staff_table_result=mysqli_query($connect,$daily_staff_table);
	
	echo '<script type="text/javascript">alert("建立帳戶資料表成功!");</script>';
} 
if(isset($_POST["create_account"])){ //建立帳戶
	$account = $_POST["account"];
	$password = $_POST["password"];
	$password_twice = $_POST["password_twice"];
	$name = $_POST["name"];
	
	$existed_table_add="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE 'inventory_staff';";
		$existed_table_add_result=mysqli_query($connect,$existed_table_add); 
		if($row=mysqli_num_rows($existed_table_add_result)>0){
			if($password!=$password_twice){
				echo '<script type="text/javascript">alert("密碼輸入錯誤，請重新輸入!");history.back();</script>';
			}else{
				//帳號是否已被建立?
				$account_existed="SELECT `account` from `inventory_staff` WHERE account = '".$account."';";
				$account_existed_result=mysqli_query($connect,$account_existed);
				if($row=mysqli_num_rows($account_existed_result)>0){
					echo '<script type="text/javascript">alert("此帳號已被註冊，請重新輸入!");history.back();</script>';
				}else{
					$create_account="INSERT INTO `inventory_staff`(`account`,`password`,`name`) VALUES('".$account."','".$password."','".$name."');";
					$create_account_result=mysqli_query($connect,$create_account);
					echo '<script type="text/javascript">alert("新增帳號成功!");</script>';
				}
			}
		}else{
				echo '<script type="text/javascript">alert("請建立帳戶資料表後建立帳號!");history.back();</script>';
		}	
}
if(isset($_POST["update_account"])){ //更新帳號資料
	$account = $_POST["account"];
	$password = $_POST["password"];
	$password_twice = $_POST["password_twice"];
	$name = $_POST["name"];
	
	if($password!=$password_twice){
		echo '<script type="text/javascript">alert("密碼輸入錯誤，請重新輸入!");history.back();</script>';
	}else{
		$account_update="UPDATE `inventory_staff` set `password`='".$password."', `name`='".$name."' WHERE `account`='".$account."';";
		$account_update_result=mysqli_query($connect,$account_update);
		echo '<script type="text/javascript">alert("修改帳號成功!");</script>';
	}
	
}
?>
<!DOCTYPE html>
<html>
</head>
	<meta charset="utf-8">
	<title>4th Grade Controlled Drugs</title>
	<style>
	img{
		position:absolute;
		right:10px;
		top:10px;
	}
	body{
		background-color:#CCEEFF;
		text-align:center;
	}
	table{
		text-align:center;
		width:300px;
	}
	th{
		background-color:#0066FF;
		color:white;
	}
	td{
		background-color:white;
	}
	
	input[type="submit"],input[type="reset"]
	{
		 font-family: Georgia, "Times New Roman", Times, serif;
		padding: 5px 10px 5px 10px;
		color: #FFF;
		margin: 0 auto;
		background: #1abc9c;
		font-size: 18px;
		text-align: center;
		font-style: normal;
		border: 1px solid #16a085;
		border-width: 1px 1px 3px;
		margin-bottom: 10px;
	}
	 
	input[type="submit"]:hover
	{
		background: #109177;
	}
	@import url(form.css); 
	</style>
</head>
 
<body>

<a href="main.php"><img id="home" src="home.png"></a>

<form  method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">	
	<input type="submit" value="新增帳戶資料表" name="create_account_table">
</form>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
	<input type="submit" value="新增帳號" name="create_account_btn"/> 
</form>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
	<input type="submit" value="顯示所有帳號" name="show_account_btn"/> 
</form>

 
<div align="center">
<?php
	$show_account="select * FROM `inventory_staff`;";//找所選取的點盤表
	$show_account_result=mysqli_query($connect,$show_account);

	if(isset($_POST["create_account_btn"])) { //建立帳號表單
	?>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input placeholder="帳號*" type="text" name="account" required /><br>
			<input placeholder="密碼*" type="password" name="password" required /><br>
			<input placeholder="請再輸入一次密碼*" type="password" name="password_twice" required /><br>
			<input placeholder="姓名*" type="text" name="name" required /><br>
			<input type="reset" value="重新輸入"/>
			<input type="submit" value="送出" name="create_account">
		</form>
	<?php
	}else if(isset($_POST["show_account_btn"])){ //顯示所有帳號
		
		$existed_table="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE 'inventory_staff';";
		$existed_table_result=mysqli_query($connect,$existed_table); 
		if($row=mysqli_num_rows($existed_table_result)>0){
			echo "<table>";
			echo "<tr><th>帳號</th>
				 <th>密碼</th>
				 <th>姓名</th>
				 <th colspan='2'></th>
			</tr>";
			$j=0; 	
			while($row=mysqli_fetch_array($show_account_result,MYSQL_BOTH)){
				echo "<tr>";
				for($i=0;$i<mysqli_num_fields($show_account_result);$i++){
					echo "<td>".$row[$i]."</td>";
				}
				
				echo "<td>
					  <form method='post' action=".$_SERVER['PHP_SELF']." enctype='multipart/form-data'>
						<input type='hidden' name='account' value='".$row["account"]."'>
						<input type='hidden' name='name' value='".$row["name"]."'>
						<input type='submit' value='修改' name='update'>
					  </form>
					  </td>";
				echo "<td>
					  <form method='post' action=".$_SERVER['PHP_SELF']." enctype='multipart/form-data'>
						<input type='hidden' name='account' value='".$row["account"]."'>
						<input type='submit' value='刪除' name='delete'>
					  </form>
					  </td>";
				echo "</tr>";
				$j++; 	
			}
			echo "</table>";
		}else{
			echo "無帳戶資料表，請建立!";
		}
		
	}else if(isset($_POST["update"])) { //修改帳號資料
		$account = $_POST["account"];
		$name = $_POST["name"];
	?>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<input placeholder="帳號*" type="hidden" name="account" value="<?php echo $account; ?>"><?php echo $account; ?><br>
			<input placeholder="新密碼*" type="password" name="password" required /><br>
			<input placeholder="請再輸入一次新密碼*" type="password" name="password_twice" required /><br>
			<input placeholder="姓名*" type="text" name="name" value="<?php echo $name ?>"required /><br>
			<input type="reset" value="重新輸入"/>
			<input type="submit" value="送出" name="update_account">
		</form>
	
	<?php 
	}else if(isset($_POST["delete"])) { //刪除帳號
		$account = $_POST["account"];
		$account_delete="DELETE FROM `inventory_staff` WHERE `account`='".$account."';";
		$account_delete_result=mysqli_query($connect,$account_delete);
		echo '<script type="text/javascript">alert("刪除帳號成功!");</script>';
		 
	}
	?>
</div>
</body>
<?php	
}		
?>
