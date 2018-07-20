<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>运营平台</title>
	<meta name="renderer" content="webkit">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">	
	<meta name="apple-mobile-web-app-capable" content="yes">	
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="/public/money_ex/bootstrap/css/bootstrap.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="/public/money_ex/layui/css/layui.css" media="all"/>
	<!----><link rel="stylesheet" type="text/css" href="/public/money_ex/css/global.css" media="all"/>
	<style>
	.layui-table-cell { height:auto}
	</style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
<div class="layui-tab-item layui-show logindiv">
	<div class="layui-form layui-form-pane">
		<img src="/public/money_ex/images/logo.png" class="loginlogo" />
            <form id="wyccn" name="wyccn" action="/sign/login" method="post" class="form-horizontal">
			<input type='hidden' name='action' value='login' />
			<div class="layui-form-item">
				<label for="L_email" class="layui-form-label">
					登录账号
				</label>
				<div class="layui-input-inline">
					<input type="text" id="L_email" name="login_name" value="" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label">
					密码
				</label>
				<div class="layui-input-inline">
					<input type="password" id="L_pass" name="password" value='' class="layui-input">
				</div>
			</div>
			<div class="layui-form-item" style="padding-right:10px;">
				<button type="submit" class="layui-btn" style="display:block;width:100%">登录</button>
			</div>
		</form>
	</div>
</div>
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
</body>
</html>
