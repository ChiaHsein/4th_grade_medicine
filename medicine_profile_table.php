<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
					var NumOfJData;
				 
					setInterval(function(){
						$.ajax({
						type:"POST",
						url:"catch_data_profile.php",
						dataType:"json",
						success:function(msg,string,jqXHR){
							
							var old = NumOfJData;
							NumOfJData = msg.length;
							var newd = NumOfJData;
							 
								 if($("#result").children().length == 0){
									 $("#result").append("<tr>" +
															"<th>項次</th>" +
															"<th>院內代碼</th>" +
															"<th>藥品品項</th>" +
															"<th>廠商</th>" +
															"<th>管制藥品登記證號</th>" +
															"<th>製造廠</th>" +
															"<th>藥品許可證號</th>" +
															"<th>QRcode</th>" +
															"</tr>");
									 for(var i = 0;i<NumOfJData;i++){
										$("#result").append("<tr>" +
															"<td>" + msg[i]["id"]   + "</td>" +
															"<td>" + msg[i]["drug_code"]   + "</td>" +
															"<td>" + msg[i]["drug_name"]   + "</td>" +
															"<td>" + msg[i]["seller"]   + "</td>" +
															"<td>" + msg[i]["control_drug_registration_number"]   + "</td>" +
															"<td>" + msg[i]["manufacturer"]   + "</td>" +
															"<td>" + msg[i]["drug_permit_number"]   + "</td>" +
															"<td><a style='text-decoration:none;'href="+msg[i]["picture"]+" target=_blank>開啟</a></td>" +
															"</tr>");	 
									}	
								 }else if(newd < old && $("#result").children().length != 0 ){
										$("#result").empty();
										$("#result").append("<tr>" +
															"<th>項次</th>" +
															"<th>院內代碼</th>" +
															"<th>藥品名稱</th>" +
															"<th>廠商</th>" +
															"<th>管制藥品登記證號</th>" +
															"<th>製造廠</th>" +
															"<th>藥品許可證號</th>" +
															"<th>QRcode</th>" +
															"</tr>");
									 for(var i = 0;i<NumOfJData;i++){
										$("#result").append("<tr>" +
															"<td>" + msg[i]["id"]   + "</td>" +
															"<td>" + msg[i]["drug_code"]   + "</td>" +
															"<td>" + msg[i]["drug_name"]   + "</td>" +
															"<td>" + msg[i]["seller"]   + "</td>" +
															"<td>" + msg[i]["control_drug_registration_number"]   + "</td>" +
															"<td>" + msg[i]["manufacturer"]   + "</td>" +
															"<td>" + msg[i]["drug_permit_number"]   + "</td>" +
															"<td><a style='text-decoration:none;'href="+msg[i]["picture"]+" target=_blank>開啟</a></td>" +
															"</tr>");	 
									}		
											
								 }else if(newd > old && $("#result").children().length != 0 ){
									 
									for(var i = old;i<newd;i++){
										$("#result").append("<tr>" +
															"<td>" + msg[i]["id"]   + "</td>" +
															"<td>" + msg[i]["drug_code"]   + "</td>" +
															"<td>" + msg[i]["drug_name"]   + "</td>" +
															"<td>" + msg[i]["seller"]   + "</td>" +
															"<td>" + msg[i]["control_drug_registration_number"]   + "</td>" +
															"<td>" + msg[i]["manufacturer"]   + "</td>" +
															"<td>" + msg[i]["drug_permit_number"]   + "</td>" +
															"<td><a style='text-decoration:none;'href="+msg[i]["picture"]+" target=_blank>開啟</a></td>" +
															"</tr>");	 
									}
								 }
							}
						});
					},1000);
 
			});   
				
	</script>
	<style type="text/css"> 
		@import url(main_style.css); 
		#result tr:nth-child(even) {background: #DDDDDD}
		#result tr:nth-child(odd) {background: #FFF}
	</style>
</head>
<body>
	<table id="result" align="center"></table> 
</body>
<html>