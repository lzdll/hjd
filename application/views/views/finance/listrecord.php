    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix rechargeblock">
		<P class="rechargetitle"><img src="/public/money_ex/images/lc05.png"/>目前仅支持线下充值</p>
			<dl>
				<dt><img src="/public/money_ex/images/lc01.png" /></dt>
				<dd>联系客服</dd>
			</dl>
			<span class="linepan"></span>
			<dl>
				<dt><img src="/public/money_ex/images/lc02.png" /></dt>
				<dd>银行汇款</dd>
			</dl>
			<span class="linepan"></span>
			<dl>
				<dt><img src="/public/money_ex/images/lc03.png" /></dt>
				<dd>客服确认</dd>
			</dl>
			<span class="linepan"></span>
			<dl>
				<dt><img src="/public/money_ex/images/lc04.png" /></dt>
				<dd>充值到账</dd>
			</dl>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>充值时间</th>
				  <th>充值金额</th>
				  <th>类型</th>
				  <th>状态</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach($list as $row): ?>
				<tr>
				  <td><?php echo $row['created_time']; ?></td>
				  <td><?php echo $row['money']; ?></td>
				  <td><span class="opearbtn active">现金</span></td>
				  <td><span class="tdstatus01"><?php echo $row['status']; ?></span></td>
				</tr>
			  <?php endforeach;?>
			  </tbody>
			</table>
			<div id="" class="pages">
			<?php foreach($page as $row): ?>
				<?php echo $row; ?>
			<?php endforeach;?>
			</div>


		</div>
   
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
</div>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<script type="text/javascript" src="js/global.js"></script>
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
