<?php

$hostname="120.105.161.205";
$username="U029";
$password="U029";
$database="4thgradedrugs";
$connect = mysqli_connect($hostname,$username,$password,$database);
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定

//開啟session	
session_start();
//以防返回上一頁表單清空
header("Cache-control:private");


$daily_table = $_POST["daily_inventory"];
//echo $daily_table;


 
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
//$datetime="20170829";

//當天消耗
if (isset($_POST["upload_inventory"])) { 
	
	//指定儲存目錄及檔名
	$upload_dir = "./files/";
	$upload_file = $upload_dir.iconv("UTF-8","Big5",$_FILES["myfile"]["name"]);
	if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$upload_file)){
		$_SESSION['filename']=$_FILES["myfile"]["name"];
		echo "上傳成功";
		header("location:excel_consum_csv.php");
	}else{
		echo "上傳失敗";
	}
}else if(isset($_POST["pre_balance_data"])){ //手動上傳前日結存
	$upload_dir = "./files/";
	$upload_file = $upload_dir.iconv("UTF-8","Big5",$_FILES["myfile"]["name"]);
	if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$upload_file)){
	$_SESSION['filename']=$_FILES["myfile"]["name"];
	$pre=$_POST["pre"];
	$_SESSION['pre_balance']=$pre;
		echo "上傳成功";
		header("location:excel_pre_balance_csv.php");
	}else{
		echo "上傳失敗";
	}
}

/*
//正式
$str = explode('_', $daily_table);
echo $str[0].'<br>';
$yes = date("Ymd",strtotime("-1 day")); 
echo $yes;
$yester_table=$yes."_daily_inventory";
echo $yester_table; //前天的表
*/
//測試用*
$str = explode('_', $daily_table);
//echo $str[0].'<br>';
$yes = date("Ymd",strtotime($str[0]."-1 day")); 
//echo $yes;
$yester_table=$yes."_daily_inventory";
//echo $yester_table; //前天的表


 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>4th Grade Controlled Drugs</title>
	<script src="http://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="layer/layer.js"></script>
	<script type="text/javascript">
	
	var user = "<?php echo $_SESSION["account"]; ?>";
	
	var interval = setInterval(function(){
			  var a = "<?php echo $str[0]; ?>"; //把PHP變數傳入JS
			  var b = "<?php echo $datetime; ?>";
			 
			 if(a==b){
				 $.post('login_check.php',{n:1,day:a},function(data){ 
					  $("#staff").html(data);
					  
				 });
				 $.post('uncheck.php',function(data){ //檢查哪項沒盤到
					var three_type = data.split("?");
					var uncheck_data = three_type[0].split("-");
					var check_data = three_type[1].split("-");
					var excessive_data = three_type[2].split("-");
					
					var table = document.getElementById('result'), 
								rows = table.getElementsByTagName('tr'),
								i, j, cells, customerId;

					for (i = 0 ; i < rows.length; i++) {
						cells = rows[i].getElementsByTagName('td');
						if (!cells.length) {
							continue;
						}
						for(j=0;j<uncheck_data.length;j++){
							if(cells[1].innerHTML==uncheck_data[j]){
								 $(rows[i]).css("background-color","red");
							}
						}
						for(j=0;j<excessive_data.length;j++){
							if(cells[1].innerHTML==excessive_data[j]){
								 $(rows[i]).css("background-color","yellow");
							}
						}
					}
					for (i = 0 ; i < rows.length; i++) {
						cells = rows[i].getElementsByTagName('td');
						if (!cells.length) {
							continue;
						}
						for(j=0;j<check_data.length;j++){
							if(cells[1].innerHTML==check_data[j]){
								if(i%2==1)
									$(rows[i]).css("background-color","#DDDDDD");
								else
									$(rows[i]).css("background-color","#FFF");
							}
						}
					}
					 
					 
					  
				 });
			}else if(a!=b){
				$.post('login_check.php',{n:1,day:a},function(data){  
					  if(data!="no")
						  $("#staff").html(data);
					  else
						  $("#staff").html("無人點盤");
					clearInterval(interval); 
				 });
			}else{
				
			} 			  
			 
	},1000);
	
	
	 
		function supplement(code,id,day){//補充量
			 
			var context=prompt("修改補充量欄位","0");
			if(context!=null){
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"1",code:code,supplement:context,day:day},function(data){ 
			
			});
		}
		
		function comment(code,id,day) {//備註欄
			 
			var context = prompt("修改備註欄位");
			if (context != null) {
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"2",code:code,comment:context,day:day},function(data){ 
					//alert(data); 
			});
		}
			
		function pub(code,id,day) {//公藥欄
			 
			var context = prompt("修改公藥欄位");
			if (context != null) {
				document.getElementById(id).innerHTML =context;
			}
			$.post('update_data.php',{n:"6",code:code,pub:context,day:day},function(data){ 
					//alert(data); 
			});
		}
	 
		
	 
	 function checkConsum(){ //上傳每日消耗
		 var file1=window.document.consum.myfile;
			if(file1.value=='')
			{
				window.alert('請選擇檔案');
				file1.focus
				return false;
			}
			else
				return true;
	}
	 function checkPre(){//上船前日結存
		 var file1=window.document.pre.myfile;
			if(file1.value=='')
			{
				window.alert('請選擇檔案');
				file1.focus
				return false;
			}
			else
				return true;
	}
 
		$(document).ready(function(){ //盤點上傳AJAX
				 var a = "<?php echo $str[0]; ?>"; //把PHP變數傳入JS
			     var b = "<?php echo $datetime; ?>";
				  
				if(a==b){ //當天才有ajax
					setInterval(function(){
						$.ajax({
						type:"POST",
						url:"catch_data.php",
						dataType:"json",
						success:function(msg,string,jqXHR){
							
							var n = msg.length;
							
							var table = document.getElementById('result'), 
								rows = table.getElementsByTagName('tr'),
								i, j, cells;

							for (i = 0 ; i < rows.length; ++i) {
								cells = rows[i].getElementsByTagName('td');
								if (!cells.length) {
									continue;
								}
								for(j =0 ; j < n; ++j){
									if(cells[1].innerHTML==msg[j]["drug_code"]){
										//alert(cells[1].innerHTML+" "+msg[j]["drug_code"] );
										$(cells[4]).html(msg[j]["pre_balance"]);
										$(cells[5]).html(msg[j]["income"]);
										$(cells[6]).html(msg[j]["consum"]);
										$(cells[7]).html(msg[j]["t_balance"]);
										$(cells[8]).html(msg[j]["depen"]);
										$(cells[9]).html(msg[j]["drawer"]);
										$(cells[10]).html(msg[j]["ud"]);
										$(cells[11]).html(msg[j]["safe"]);
										$(cells[12]).html(msg[j]["total"]);
										$(cells[13]).html(msg[j]["profit_loss"]);
										$(cells[14]).html(msg[j]["supplement"]);
									}
										
								}
								 
							  }
							}
						});
					},1000); 
				}else{
					 //...
				}
					
				 
					
 
			}); 
	</script>
	  
	 <script type="text/javascript">
	 
    </script>
	<style type="text/css"> 
		@import url(main_style.css); 
		#result tr:nth-child(even) {background: #DDDDDD}
		#result tr:nth-child(odd) {background: #FFF}
		#red {
			width: 10px;
			height: 10px;
			background: red;
		}
		#yellow {
			width: 10px;
			height: 10px;
			background: yellow;
		}
		#result thead
		{
			display: inline-block;
			overflow: auto;
			 width:100%;
			 
		}
		#result tbody
		{
			display: block;
			height: 350px;
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
</head>
<body>

<?php

$str = explode('_', $daily_table);//今天的日期
echo $str[0]."的盤點表";
?>
</br>
盤點者:</p><p id="staff"></p>
<?php
$yes = date("Ymd",strtotime($str[0]."-1 day")); //前一天的日期
$yester_table=$yes."_daily_inventory";//前一天的表





 
//看有沒有前天的表
$control=0; 
$sql9="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$yester_table."';";
$result9=mysqli_query($connect,$sql9); 

if($row=mysqli_num_rows($result9)>0){ //有前天的表，取前一天盤點數量total(前日結存)、保險櫃
	$control=1;
	
	$sql8="select drug_code,safe,total FROM ".$yester_table." ORDER BY `id` ASC;"; //取前一天的total
	$result8=mysqli_query($connect,$sql8);
	
	$pre=array(); 
	while($row8=mysqli_fetch_array($result8,MYSQL_ASSOC)){ //存入pre陣列
		array_push($pre,array($row8["drug_code"],$row8["safe"],$row8["total"]));
	}
}else{
?>
	<div style="float:left">
	<form name="pre" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return checkPre();">
			<div style="background-color:#FFC8B4;width:300px;padding:1px 2px 1px 2px;">
			<div style="background-color:#FFA488;">無前日盤點表,請提供! </div> 
			<input type="file" name="myfile" size="50">
			<input type="hidden" name="pre" value="<?php echo $daily_table?>">
			<input type="submit" value="上傳" name="pre_balance_data">
			</div>
	</form>
	</div>
<?php	
}



//$sql="select drug_code,drug_name FROM medicine_profile where NOT drug_name LIKE '%(DC)%' ORDER BY `id` ASC;";
$sql="select * FROM ".$daily_table." ORDER BY `id` ASC ;";//找所選取的點盤表
$result=mysqli_query($connect,$sql);
 
?>

<div style="float:left">
<form name="consum" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return checkConsum();">
	    <div style="background-color:#ACD6FF;width:300px;padding:1px 2px 1px 2px;">
		<div style="background-color:#99BBFF;">上傳今日消耗量表:</div>
		<input type="file" name="myfile" size="50">
		<input type="submit" value="上傳" name="upload_inventory" >
	    </div>
</form>
</div>
<div>
	<div id='red' style="float:left"></div><div>未盤點資料</div>
	<div id='yellow' style="float:left"></div><div>盤盈(虧)>0.02</div>
</div>
</br>
<div>
	<a href="download.php?file=example_pre_inventory.csv" style="text-decoration:none;">【前日結存表】上傳範例檔下載</a></br>
	<a href="download.php?file=example_consum.csv" style="text-decoration:none;">【今日消耗量表】上傳範例檔下載</a>
</div>
<?php

echo "<table  id='result' >";

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
while($row=mysqli_fetch_array($result,MYSQL_BOTH)){
	
	if($control==1){
		$sql3="UPDATE `".$daily_table."` SET `pre_balance`=".$pre[$j][2].",`safe`=".$pre[$j][1]."-`supplement` where drug_code='".$pre[$j][0]."';"; 
		$result3=mysqli_query($connect,$sql3);
	}
		$t_bal=$row["pre_balance"]+$row["income"]-$row["consum"]; //理論=前日+收入-消耗
		$sql4="UPDATE `".$daily_table."` SET `t_balance`=".$t_bal.", `profit_loss`=`total`-`t_balance` where drug_code='".$row["drug_code"]."';"; 
		$result4=mysqli_query($connect,$sql4);
	
	 
	echo "<tr>";
	for($i=0;$i<mysqli_num_fields($result)-1;$i++){
		if($i==3){//公藥
			echo "<td id='public".$j."' onclick=pub('".$row["drug_code"]."','public".$j."','".$str[0]."');>".$row[$i]."</td>";
		}else if($i==13){ //盤盈虧
			 echo "<td id='profit_loss'>".$row[$i]."</td>";
		}else if($i==14){//補充量
			 echo "<td id='supplement".$j."' onclick=supplement('".$row["drug_code"]."','supplement".$j."','".$str[0]."');>".$row[$i]."</td>";
		}else if($i==15){//備註
			echo "<td id='comment".$j."' onclick=comment('".$row["drug_code"]."','comment".$j."','".$str[0]."');>".$row[$i]."</td>";
		}else
			echo "<td>".$row[$i]."</td>";
		 
	}
	echo "</tr>";

$j++;	
}
echo "</tbody></table>";

?>


</body>
</html>


 