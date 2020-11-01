<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

session_start();

//記當天的日期
$datetime = date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));


if (isset($_POST["add_daily"])) {
	header("location:create_table.php");
}else if(isset($_POST["daily_table"])){
	header("location:create_daily_table.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>4th Grade Controlled Drugs Daily Inventory</title>
<script>
function back_home(){
   if (window.top != window.self) {
        window.top.location = "main.php";
    }
}
 
 
 
</script>
<style>
select {
    font-family: Georgia, "Times New Roman", Times, serif;
    background: rgba(255,255,255,.1);
    border: none;
    border-radius: 4px;
    font-size: 16px;
    margin: 0;
    outline: 0;
    padding: 7px;
    box-sizing: border-box; 
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box; 
    background-color: #e8eeef;
    color:#8a97a0;
    -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 30px;
    
}


input[type="submit"]
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

img{
	position:absolute;
	right:10px;
	top:10px;
}
</style>
</head>
<body>
	<div style="float:left">
		<form align="center" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">	
		<input type="submit" value="新增每日盤點表" name="add_daily">
		</form>
     
		<form align="center" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">	
		<input type="submit" value="生產當日報表" name="daily_table">
		</form>
		
    </div>
	<div>
		<?php
 
		$sql="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '%_daily_inventory%';";
		$result=mysqli_query($connect,$sql);
		?>
		<form align="center" method="post" action="show_daily_table.php" enctype="multipart/form-data" target="down">	
		<select name="daily_inventory"> 
		<?php $i=0; while($row=mysqli_fetch_array($result,MYSQLI_NUM)){?>
		<option value="<?php echo $row[$i];?>"><?php echo $row[$i];?></option>
		<?php } ?> 	 
		</select>
		<input type="hidden" name="number" value="1">
		<input type="submit" value="確認">	
		</form>
	</div>
	
	 
     <img id="home" src="home.png" onclick="back_home()"></a>
	 
  
	

	

	

</body>
</html>