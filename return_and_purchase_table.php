<?php
$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

$datetime = date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); //當天的
$stock_clerks=$datetime."_stock_clerks";

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
	
		function comment(id,day,code){
			var context=prompt("填寫備考欄位");
			if(context!=null){
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"3",code:code,comment:context,day:day},function(data){ 
				
			});
		}
		function seller(id,day,code){
			var context=prompt("修改廠商欄位");
			if(context!=null){
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"4",code:code,seller:context,day:day},function(data){ 
				
			});
		}
		function cdrn(id,day,code){
			var context=prompt("修改管制藥品登記證號");
			if(context!=null){
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"5",code:code,cdrn:context,day:day},function(data){ 
				
			});
		}
	
		
				
	</script>
	<style type="text/css"> 
		@import url(main_style.css); 
		#result tr:nth-child(even) {background: #DDDDDD}
		#result tr:nth-child(odd) {background: #FFF}
	</style>
</head>
<body>
 
<?php
	$sql="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$stock_clerks."';";
	$result=mysqli_query($connect,$sql);

if($row=mysqli_num_rows($result)>0){
?>	
<table id="result" align="center">
	<tr>
			<th>日期</th>
			<th>收支原因</th>
			<th>代碼</th>
			<th>藥品名稱</th>
			<th>數量</th>
			<th>批號</th>
			<th>備考</th>
			<th>廠商</th>
			<th>管制藥品登記證號</th>
			<th>製造廠</th>
			<th>藥品許可證號</th>
		</tr>
	<?php
		$sql="SELECT * FROM `".$stock_clerks."`";  
		$result=mysqli_query($connect,$sql);
		$j=0;
		
		while($row=mysqli_fetch_array($result,MYSQL_BOTH)){
			echo "<tr>";
			for($i=0;$i<mysqli_num_fields($result);$i++){
				if($i==6){//備考欄
					echo "<td id='comment".$j."' onclick=comment('comment".$j."','".$row[0]."','".$row[2]."')>".$row[$i]."</td>";
				}else if($i==7){//廠商
					echo "<td id='seller".$j."' onclick=seller('seller".$j."','".$row[0]."','".$row[2]."')>".$row[$i]."</td>";
				}else if($i==8){
					echo "<td id='cdrn".$j."' onclick=cdrn('cdrn".$j."','".$row[0]."','".$row[2]."')>".$row[$i]."</td>";
				}
				else
					echo "<td>".$row[$i]."</td>";
			}
			echo "</tr>";
		$j++;
		}
	?>
	</table> 
<?php
}else{ //沒有的話建表格
	echo "無本月表格";
}
?>
	
</body>
<html>