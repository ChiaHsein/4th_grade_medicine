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
	<meta charset="utf-8">
	<style>
		body{
			background-color:	#CCEEFF;
			text-align:center;
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
		img{
			position:absolute;
			right:10px;
			top:10px;
		}
		div{
			 margin: 0px auto;
			padding:10px 10px 10px 10px;
			background-color:	white;
			border-radius: 60px;
			width:300px;
		}
	</style>

</head>
<body>
<form action="excel_export.php">
	<input type="submit" value="產生當月Excel報表" /> 
</form>

 <?php

date_default_timezone_set( "Asia/Taipei" );
 
$dir = "./Excel/";

// 判斷是否為目錄
if(is_dir($dir)){

if ($dh = opendir($dir)) {
while (($file = readdir($dh)) !== false) {

//只過讀取出php 的檔案
if (strpos( $file, '.php')){
	echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
}
}
closedir($dh);
}



}
 $Vhost_Dir=opendir("./Excel/");
	while($file=readdir($Vhost_Dir)){
		if($file!="." && $file!=".."){
			?><div><a href="download.php?file=<?php echo "$file"; ?>" style="text-decoration:none;font-size:20px;"><?php echo "$file"; ?></a>
			  <p><?php echo date("Y/m/d H:i:s",filemtime($dir.$file));?></p>
			  </div>
			</br><?php
		}
	}
closedir($Vhost_Dir);
 ?>
 
   <a href="main.php"><img id="home" src="home.png"></a>
 
<body>
</html>
<?php	
}		
?>




