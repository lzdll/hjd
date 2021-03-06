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
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="layui/css/layui.css" media="all"/>
	<!----><link rel="stylesheet" type="text/css" href="css/global.css" media="all"/>
	<style>
	.layui-table-cell { height:auto}
	</style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
		<span class="loginname"><img src="images/logobg.png" /></span>
		<span class="layuitoptags"><img src="images/logofont.png" /></span>
		<span class="layuitoptags02">流量主</span>
	</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
	<ul class="layui-nav">
	  <li class="layui-nav-item layui-this">
		<a href="javascript:;"><img src="images/head.png" class="headerpic" /><span>18600904754</span></a>
		<dl class="layui-nav-child">
		  <dd><a href="">退出</a></dd>
		</dl>
	  </li>
	</ul>
  </div>
  <div class="layui-side layui-bg-black layui-larry-side">
    <div class="layui-side-scroll">
       <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item">
			<a href="index.html">
				<i class="iconfont icon-01"></i>
				<span>首页</span>
			</a>
        </li>
        <li class="layui-nav-item layui-this">
          <a href="我的广告位.html">
				<i class="iconfont icon-04"></i>
				<span>我的广告位</span>
			</a>
        </li>
        <li class="layui-nav-item">
			<a href="提现管理.html">
				<i class="iconfont icon-06"></i>
				<span>提现管理</span>
			</a>
		</li>
		<li class="layui-nav-item layui-nav-itemed">
			<a>
				<i class="iconfont icon-07"></i>
				<span>个人中心</span>
			</a>
			<dl class="layui-nav-child">
			  <dd class="">
				<a href="账户资料.html">
				  账户资料
				</a>
			  </dd>
			  <dd class="">
				<a href="修改密码.html">
				  修改密码
				</a>
			  </dd>
			</dl>
		</li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form compform">
				<p class="formtitle">设置广告位</p>
				<div class="layui-form-item">
					<label class="layui-form-label">广告位ID：</label>
					<div class="layui-input-block">
					  <p class="fl inputtips">3561dfdf6</p>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">服务器地址：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">密钥：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="" class="layui-input miyaoput" />
					  <span class="layui-btn layui-btn-primary">重置</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">保存</button>
					</div>
				  </div>
			</form>
		</div>
   
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  //总页数低于页码总数
  laypage.render({
    elem: 'demo0'
    ,count: 50 //数据总数
  });
  });

  </script>
</body>
</html>
