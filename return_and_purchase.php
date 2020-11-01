<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

 
?>

<!DOCTYPE html>
<html>
<head>
	<title>進退貨</title>
	<meta charset="utf-8">
<script>
function back_home(){
   if (window.top != window.self) {
        window.top.location = "main.php";
    }
}
 

 
</script>
<style type="text/css"> 
	@import url(form.css); 
</style>
</head>
<body onload="check_login()">

<img id="home" src="home.png" onclick="back_home()">

<div class="form-style-5">

<form method="post" action="insert_return_and_purchase.php" target="right">	
<input type="hidden" name="number" value="5" />
<input type="submit" value="新增本月進退貨表格">
</form>

<legend><span class="n">1</span> Stock Clerks</legend>
<form method="post" action="insert_return_and_purchase.php" target="right">
	<input type="hidden" name="number" value="1" />
	收支日期<br>
	<input type="date" name="date" required/><br>
	收支原因<br>
	<select name="cause">
		<option>購買</option>
		<option>受讓</option>
		<option>退藥</option>
		<option>減損查獲</option>
		<option>減損</option>
		<option>轉讓</option>
		<option>退貨</option>
		<option>銷毀</option>
	</select>
	 	
	<?php
	$sql="select id,drug_name from medicine_profile ORDER BY `id` ASC";
	$result=mysqli_query($connect,$sql);
	?>
	藥品品名<br>
	<select name="drug_name"   > 
		<?php while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){?>
		<option value="<?php echo $row["drug_name"];?>"><?php echo $row["drug_name"];?></option>
		<?php } ?> 	 
	</select>
 
	<input type="text" name="quantity" placeholder="數量*" required/>
	<input type="text" name="batch_number" placeholder="批號*" required/>
	<input type="reset" value="Reset">
	<input type="submit" value="Send">
</form>

<br>

<legend><span class="n">2</span> Delete Records</legend>
<form method="post" action="insert_return_and_purchase.php" target="right">
	<input type="hidden" name="number" value="2" />
	日期
	<input type="date" name="date" required/></td>
	<input type="text" name="drug_code" placeholder="代碼*" required/></td>
 
	<input type="reset" value="Reset">
	<input type="submit" value="Send">
<form>

</div>	
</body>
</html>