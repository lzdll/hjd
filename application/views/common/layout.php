<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>运营平台首页</title>
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
	<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script type="text/javascript" src="/public/money_ex/js/moment.min.js"></script>
<script type="text/javascript" src="/public/money_ex/js/detect-report.js"></script>
<script type="text/javascript" src="/public/money_ex/js/echarts.common.min.js"></script>
</head>
<body>
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
		<span class="loginname"><img src="/public/money_ex/images/logobg.png" /></span>
		<span class="layuitoptags"><img src="/public/money_ex/images/logofont.png" /></span>
		<span class="layuitoptags02">广告运营平台</span>
	</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
	<ul class="layui-nav">
	  <li class="layui-nav-item layui-this">
		<a href="javascript:;"><img src="/public/money_ex/images/head.png" class="headerpic" /><span><?php echo $user['username'];?></span></a>
		<dl class="layui-nav-child">
		  <dd><a href="/sign/logout">退出</a></dd>
		</dl>
	  </li>
	</ul>
  </div>

<div class="layui-side layui-bg-black layui-larry-side">
    <div class="layui-side-scroll">
			<ul class="layui-nav layui-nav-tree" lay-filter="test">

			
            	<?php 
              
				?>
            	<?php foreach ($menu as $k=>$v) { ?>
                	<?php if ($v['type'] == 'item') {?>
                        <li class="layui-nav-item <?php if ($c_url == $v['url'] || (isset($v['folder']) && $c_url_d == $v['folder'])) { ?>layui-this<?php } ?>">
						<a href="<?=$v['url']?>">
						<i class="iconfont icon-01"></i>
						<span><?=$v['name']?></span>
						</a>
                        </li>
                    <?php } else {?>
                       

						<li class="layui-nav-item <?php if ($c_url == $v['url'] || (isset($v['folder']) && $c_url_d == $v['folder'])) { ?>layui-this layui-nav-itemed<?php } ?>">
			<a href="#">
				<i class="iconfont icon-06"></i>
				<span><?=$v['name']?></span>
			</a>
			<dl class="layui-nav-child">
				<?php foreach ($v['child'] as $kk=>$vv) { ?>
							<?php if($vv['is_menu']) {?>
							  <dd class="<?php if ((isset($v['folder']) && $c_url == $vv['url'])) { ?>layui-this<?php } ?> ">
								<a href="<?=$vv['url']?>">
								   <?=$vv['name']?>
								</a>
							  </dd>
							  <?php } ?>	
				<?php } ?>
			</dl>
		</li>
            <?php } ?>
            <?php } ?>
			</ul>
		</div>
  </div>
		<div class="layui-body">
			<!-- 内容 -->
            <?php echo $content_for_layout; ?>
		</div>
		
	</div>
</body>
</html>
