<div class="postnav">流量主</div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>流量主数量</dd>
				<dt><?php echo $total; ?>个</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>充值总额(元)</dd>
				<dt>￥33040.10</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>可提现金额(元)</dd>
				<dt>￥60040.30</dt>
			</dl>
			<dl class="topitemdl topitemdl25 noborder">
				<dd><a href="/authority/admin/add?type=1"><span class="addads">添加流量主</span></a></dd>
			</dl>
		</div>
		
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>手机号</th>
				  <th>邮箱</th>
				  <th>广告数量</th>
				  <th>收益总额</th>
				  <th>可提现金额</th>
				  <th>状态</th>
				  <th>重置密码</th>
				  <th>查看</th>
				</tr> 
			  </thead>
			  <tbody>
			   <?php foreach ($list as $v){ ?>
				<tr>
				  <td><?=$v['id']?></td>
				  <td><?=$v['phone']?></td>
				  <td><?=$v['email']?></td>
				  <td><?=$v['ad_total']?></td>
				  <td>￥2345140.00</td>
				  <td>￥2330.00</td>
				  <td>
				  <?php if($v['status'] == 1 ){?><span class="tdstat active">已封号</span><?php   }else{ ?><span class="tdstat">正常</span><?php } ?>
				  </td>
				  <td><a href="/flow/index/resetpwd?code=<?=$v['code']?>&id=<?=$v['id']?>&type=<?=$v['type']?>" class="tdfont01">重置</a></td>
				  <td><a href="/flow/index/details?code=<?=$v['code']?>&id=<?=$v['id']?>&type=<?=$v['type']?>"><span class="tdfont01">查看详情</span></a></td>
				</tr>
				<?php } ?>
				
			  </tbody>
			</table>
			<div id="demo0" class="pages"><div class="y_tip">共 <?php echo $pager['count'];?> 条 每页 <?php echo $pagesize;?> 条	</div><div class="y_page"><?php echo $pager['links'];?></div></div>
		</div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
//layui.use(['laypage', 'layer'], function(){
  //var laypage = layui.laypage
  //,layer = layui.layer;
  ////总页数低于页码总数
  //laypage.render({
    //elem: 'demo0'
    //,count: 50 //数据总数
  //});
  //});
</script>