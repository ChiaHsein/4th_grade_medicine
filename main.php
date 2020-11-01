<?php

session_start();
if(!isset($_SESSION['account'])){
	echo "<script type='text/javascript'>";
			echo "alert('尚未登入');";
			echo "history.back();";
			echo "</script>";
	
}else{

?>


<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="pill.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="pill.ico" type="image/x-icon" />
	<title>4th Grade Controlled Drugs</title>
	<meta charset="utf-8">
	
	<link rel="stylesheet" href="//ku.shouce.ren/libs/layer/js/skin/layer.css" media="all">
	<script type="text/javascript" src="//apps.bdimg.com/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="//ku.shouce.ren/libs/layer/js/layer.js"></script>
	<script>
		 
			function logout(){
				  $.post('logout.php',function(data){ 
					  alert(data);  
					  location.href = "index.html";
				 });
					 
				
			} 
		</script>
		
	<style type="text/css"> 
		 @import url(index.css); 
	</style>
	<script>
  
 
	</script>
</head>
<body align="center"  >
	<img src="APP_download.png"><br/>
	<p>1/4 APP計算機更新，網頁盤盈虧檢查更新</p>
	 
			
			<div>hi, <?php echo $_SESSION['account']?></div>
			<input class="action-button shadow animate logout" type="button" value="登出" onclick="logout();"></button>
	 
			<form action="stock_clerks.php">
				<input class="action-button shadow animate stock_clerks" type="submit" value="進退貨" /> 
			</form>
			<form action="medicine_profile.php">
				<input class="action-button shadow animate medicine_profile" type="submit" value="藥品資料" /> 
			</form>
			<form action="inventory.php">
				<input class="action-button shadow animate inventory" type="submit" value="盤點" /> 
			</form>
			<form action="excel_export_download.php">
				<input class="action-button shadow animate PHPToExcel_0824" type="submit" value="匯出Excel" /> 
			</form>
			 
			<form action="account_manager.php">
					<input class="action-button shadow animate account" type="submit" value="帳戶管理" /> 
				</form>
			<?php
			
		 
		?>
	
</body>
</html>
<?php
}

?>