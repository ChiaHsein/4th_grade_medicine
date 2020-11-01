<?php
session_start();
if(!isset($_SESSION['account'])){
	echo '<script type="text/javascript">alert("尚未登入");history.back();</script>';
}else{
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="pill.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="pill.ico" type="image/x-icon" />
	<title>4th Grade Controlled Drugs</title>
	
	
</head>
 
 <frameset rows="15%, *" border="0">
    <frame name="top" noresize scrolling="no" src="choose_daily_table.php">
    <frame name="down" noresize src="init_daily_table.php">
  </frameset>	
</html>
<?php	
}		
?>

