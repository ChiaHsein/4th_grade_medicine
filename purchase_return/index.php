<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
session_start();
 
$datetime = date("Ym",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));
echo "<meta charset='utf-8'>";

if (isset($_POST["purchase_return"])) {
	header("location:create_purchase_return.php");
}
if(isset($_POST["pre_balance_data"])){ //手動上傳前日結存
	$upload_dir = "./files/";
	$upload_file = $upload_dir.iconv("UTF-8","Big5",$_FILES["myfile"]["name"]);
	if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$upload_file)){
	$_SESSION['filename']=$_FILES["myfile"]["name"];
		echo "上傳成功";
		header("location:import_pack_standard.php");
	}else{
		echo "上傳失敗";
	}
}
$find_purchase_return_table="select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME LIKE '".$datetime."_stock_clerks';";
$find_purchase_return_table_rs=mysqli_query($connect,$find_purchase_return_table); 

if($row=mysqli_num_rows($find_purchase_return_table_rs)>0){ 
	$get_data="select * from `".$datetime."_stock_clerks`;";
	$get_data_rs=mysqli_query($connect,$get_data);

	echo "<table border='1'>";
	echo "<tr>";
	echo "<th rowspan='2'>收支日期</th>";
	echo "<th rowspan='2'>藥品類別代碼</th>";
	echo "<th rowspan='2'>藥品許可證代碼</th>";
	echo "<th rowspan='2'>證號</th>";
	echo "<th rowspan='2'>藥品批號</th>";
	echo "<th rowspan='2'>收支狀態（本期）</th>";
	echo "<th rowspan='2'>包裝規格</th>";
	echo "<th rowspan='2'>收支原因代碼</th>";
	echo "<th rowspan='2'>包裝數量</th>";
	echo "<th rowspan='2'>收支數量</th>";
	echo "<th rowspan='2'>同意書編號</th>";
	echo "<th colspan='6'>對象機構業者</th>";
	echo "<th colspan='3'>銷燬、減損、減損查獲證明</th>";
	echo "<th colspan='2'>研究計畫</th>";
	echo "<th rowspan='2'>抽驗單位名稱</th>";
	echo "<th colspan='3'>產出之製劑</th>";
	echo "<th rowspan='2'>支方退貨日期</th>";
	echo "<th rowspan='2'>收方簽收日期</th>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>登記證字號</td>";
	echo "<td>名稱</td>";
	echo "<td>地址(縣市)</td>";
	echo "<td>地址(區)</td>";
	echo "<td>地址(詳細地址)</td>";
	echo "<td>對象機構業者電話</td>";

	echo "<td>文號(字)</td>";
	echo "<td>文號(號)</td>";
	echo "<td>發文日期</td>";

	echo "<td>文號</td>";
	echo "<td>核准日期</td>";

	echo "<td>藥品代碼</td>";
	echo "<td>藥品名稱</td>";
	echo "<td>批號</td>";
	echo "</tr>";

	while($row=mysqli_fetch_array($get_data_rs,MYSQLI_BOTH)){
		echo "<tr>";
		echo "<td>".$row["dateday"]."</td>";
		for($j=0;$j<mysqli_num_fields($get_data_rs);$j++){
			if($j==6)
				continue;
			else
				echo "<td>".$row[$j]."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}else{
	echo "無當月進退貨表格";
}



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>
<script type='text/javascript'>
$(function(){
	var w = $("#content").width();
	$('#content').css('height', ($(window).height() - 20) + 'px' ); //將區塊自動撐滿畫面高度
	
	var i=1;
	$("#tab").click(function(){
		if(i%2==1){
			$("#insert_data").animate({ left:'0px' }, 600 ,'swing');
			
		}else{
			$("#insert_data").animate( { left:'-'+w+'px' }, 600 ,'swing');
		}
		i++;
	});
	/*滑入版本
	$("#tab").mouseover(function(){ //滑鼠滑入時
		if ($("#insert_data").css('left') == '-'+w+'px')
		{
			$("#insert_data").animate({ left:'0px' }, 600 ,'swing');
		}
	});

	$("#content").mouseleave(function(){　//滑鼠離開後
		$("#insert_data").animate( { left:'-'+w+'px' }, 600 ,'swing');
	});*/
});

$(document).ready(function(){
	 $('#category_code').change(function(){
            var category_code= $('#category_code').val();
                $.ajax({
                    type: "POST",
                    url: 'pack_standard.php',
                    cache: false,
                    data:'category_code='+category_code,
                    error: function(){
                        alert('Ajax request 發生錯誤');
                    },
                    success: function(data){
                        $('#pack_standard').html(data);
                    }
                });
      });
	   $('#category_code').change(function(){
            var category_code= $('#category_code').val();
                $.ajax({
                    type: "POST",
                    url: 'balance_reason.php',
                    cache: false,
                    data:'category_code='+category_code,
                    error: function(){
                        alert('Ajax request 發生錯誤');
                    },
                    success: function(data){
                        $('#balance_reason').html(data);
                    }
                });
      });
	    $('#license_code').change(function(){
         var license_code=$("#license_code").val().substr(0,1);
		  if(license_code=='A' || license_code=='B' || license_code=='N' || license_code=='D'){
			$("#certificate_number_area").html("<input name='certificate_number' type='text' maxlength=6 placeholder='*6碼' required>");
		  }else if(license_code=='X' || license_code=='S' || license_code=='R'){
			$("#certificate_number_area").html("<input name='certificate_number' type='text' maxlength=10 placeholder='*9碼' required>");
		  }else{
			  $("#certificate_number_area").html("<input name='certificate_number' type='text' maxlength=10 placeholder='*10碼' required>");
		  }
			  
      });
	  $('#balance_reason').change(function(){
            var balance_reason= $('#balance_reason').val();
                $.ajax({
                    type: "POST",
                    url: 'field.php',
                    cache: false,
                    data:'balance_reason='+balance_reason,
                    error: function(){
                        alert('Ajax request 發生錯誤');
                    },
                    success: function(data){
                        $('#field').html(data);
                    }
                });
      });
	  
	
 });

function Round(){
	var number = $("#balance_quantity").val();
	var number_round=Math.round(number * Math.pow(10,5))/Math.pow(10,5);
	$("#balance_quantity").val(number_round);
}
function Round2(){
	var number = $("#pack_quantity").val();
	var number_round=Math.round(number * Math.pow(10,5))/Math.pow(10,5);
	$("#pack_quantity").val(number_round);
}


</script>
<style type="text/css">
	#insert_data
	{
	top: 0;
	left:-500px;
	width:500px;
	position:fixed;
	z-index:9999;
	}

	#content{
	background:#3c5a98;
	text-align:center;
	padding-top:20px;
	}

	#tab {
	position:absolute;
	top:20px;
	right:-24px;
	width:24px;
	background:#3c5a98;
	color:#ffffff;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	padding:9px 0;

	-moz-border-radius-topright:10px;
	-moz-border-radius-bottomright:10px;
	-webkit-border-top-right-radius:10px;
	-webkit-border-bottom-right-radius:10px;
	}
	#tab span {
	display:block;
	height:12px;
	padding:1px 0;
	line-height:12px;
	text-transform:uppercase;
	font-size:12px;
	}
</style>
</head>
<body>
<div id="insert_data">
 <div id="tab">
    <span>進</span>
    <span>退</span>
    <span>貨</span>
</div>
<div id="content">
<form method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
	<input type="file" name="myfile" size="50">
	<input type="submit" value="上傳" name="pack_standard">
</form>
<form align="center" method="post" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">	
	<input type="submit" value="新增當月進退貨表格" name="purchase_return">
</form>

<form action="insert_return_and_purchase.php"  method="post">
<?php

//取藥品類別代碼
$category_code="select * from `category_code_table`;";
$category_code_rs=mysqli_query($connect,$category_code);

$license_code="select * from `license_code_table`;";
$license_code_rs=mysqli_query($connect,$license_code);
?>

<!--2藥品類別代碼-->
2藥品類別代碼</br>
<select id="category_code" name="category" required>
<option></option>
<?php
while($row=mysqli_fetch_array($category_code_rs,MYSQLI_BOTH)){
	echo "<option value='".$row["category_code"]."'>".$row["category"]."(".$row["category_code"].")</option>";
}
?>
</select>
</br>
<!--3藥品許可證代碼-->
3藥品許可證代碼</br>
<select id="license_code" name="license_code" required>
<option></option>
<?php
while($row=mysqli_fetch_array($license_code_rs,MYSQLI_BOTH)){
	echo "<option value='".$row["license_code"]."'>".$row["license"]."(".$row["license_code"].")</option>";
}
?>
</select></br>
<!--3證號-->
3證號</br>
<div id="certificate_number_area">
<input id="certificate_number" name="certificate_number" type="text" maxlength=10 placeholder="*10碼" required/>
</div>
<!--4批號-->
4批號</br>
<input name="batch_number" type="text" required/></br>
<!--5收支狀態-->
5收支狀態</br>
<select name="balance_state" required>
	<option value='Y'>Y</option>
	<option value='N'>N</option>
</select></br>
<!--6包裝規格-->
6包裝規格</br>
<select id="pack_standard" name="pack_standard" required></select></br>
<!--7收支日期-->
7收支日期</br>
<input name="dateday" type="date" required/></br>
<!--8收支原因-->
8收支原因</br>
<select id="balance_reason" name="balance_reason" required><option>-----</option></select></br>
<!--9包裝數量-->
9包裝數量</br>
<input id="pack_quantity" name="pack_quantity" type="text" onblur="Round2()" required/></br>
<!--10收支數量-->
10收支數量</br>
<input id="balance_quantity" name="balance_quantity" type="text" onblur="Round()" required/></br>
<!--11同意書編號-->
11同意書編號</br>
<input name="agree_number_N" type="text" maxlength=3 placeholder="*最多3碼"/>
<input name="agree_number_A" type="text" value="CDP"/>
<!--12-26的欄位-->
<div id="field"></div>
<!--27支方退貨日期-->
27支方退貨日期</br>
<input name="return_date" type="date"/></br>
<!--28收方簽收日期-->
28收方簽收日期</br>
<input name="sign_date" type="date"/></br>

<input type="submit" value="Send"/>
</form>
</div>
</div>
</body>
</html>