<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="//ku.shouce.ren/libs/layer/js/skin/layer.css" media="all">
	<script type="text/javascript" src="//apps.bdimg.com/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="//ku.shouce.ren/libs/layer/js/layer.js"></script>
	</head>
	<body>
		<div class="clear box layer-main">
			<a href="javascript:;" onclick="test();">点我弹窗
			</a>
		</div>
		<script>
			function test(){
				//在这里面输入任何合法的js语句
			layer.open({
						title: '管理者登入',
						type: 1,
						skin: 'layui-layer-rim', //加上边框
						area: ['420px', '210px'], //宽高
						content: '<div align="center" ><form name="login_form">帳號:<input id="account" size="20" type="text"/></br>密碼:<input id="password" size="20" type="password"/></br><input type="button" onclick="check_manager();" value="確認"/></form></div><p align="right"><img src="drugs.png"/></p>'
					});
			
				 
				
			}
		</script>
	</body>
</html>
