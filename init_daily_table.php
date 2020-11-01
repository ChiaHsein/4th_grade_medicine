<?php

$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

session_start();
 
$datetime = date("Ymd",mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
//$datetime="20170829";
$yes = date("Ymd",strtotime($datetime."-1 day"));

 

echo $yes."點盤紀錄";

$sql="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$yes."_daily_inventory';";
$result=mysqli_query($connect,$sql);

if($row=mysqli_num_rows($result)>0){ 
	$sql2="select * FROM ".$yes."_daily_inventory ORDER BY `id` ASC;";//一開始顯示前一天的
	$result2=mysqli_query($connect,$sql2);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<style>
	@import url(main_style.css); 
	#result tr:nth-child(even) {background: #DDDDDD}
	#result tr:nth-child(odd) {background: #FFF}
	#result thead
		{
			display: inline-block;
			overflow: auto;
			 width:100%;
			 
		}
		#result tbody
		{
			display: block;
			height: 500px;
			width:100%;
			overflow: auto;
		}
		#result th,td
		{
			width:100px;
			padding: .5em 1em;
			text-align: left;
			vertical-align: top;
			border-left: 1px solid #fff; 
		}	
</style>
<body>
<?php	
	
	echo "<table  id='result'>";
	echo "<thead><tr><th>項次</th>
		  <th style='width:200px;'>院內代碼</th>
		  <th style='width:250px;'>藥品品項</th>
		  <th>公藥</th>
		  <th>前日結存</th>
		  <th>收入量</th>
		  <th>消耗量</th><th>理論結存</th>
		  <th>調劑台</th>
		  <th>抽屜</th>
		  <th>UD</th>
		  <th>保險櫃</th>
		  <th>合計</th>
		  <th>盤盈(虧)</th>
		  <th>補充量</th>
		  <th>備註</th>
		  </tr></thead>";

echo "<tbody>";				  
$j=0; 	  
while($row=mysqli_fetch_array($result2,MYSQL_BOTH)){
	

	echo "<tr>";
	for($i=0;$i<mysqli_num_fields($result2)-1;$i++){
			echo "<td>".$row[$i]."</td>";
	}
	echo "</tr>";

$j++;	
}
echo "</table></tbody>";

}else{
	echo '<meta charset="utf-8"><body align="center">';
	echo "無".$yes."點盤紀錄!";
} 
?>


</body>
</html>


 