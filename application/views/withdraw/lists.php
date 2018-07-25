    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="/withdraw/index/apply"><span class="addads">提现申请</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>申请时间</th>
				  <th>银行</th>
				  <th>卡号</th>
				  <th>提现金额</th>
				  <th>备注</th>
				  <th>状态</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach($list as $row): ?>
				<tr>
				  <td><?php echo $row['created_time']; ?></td>
				  <td><?php echo $row['bank']; ?></td>
				  <td><?php echo $row['cardid']; ?></td>
				  <td>￥<?php echo $row['money']; ?></td>
				  <td><?php echo $row['comment']; ?></td>
					<?php if($rwo['status']): ?>
						<td><span class="tdstatus">已打款</span> </td>
					<?php else: ?>
						<td><span class="tdstatus active">未打款 </span></td>
					<?php endif; ?>
				</tr>
			  <?php endforeach;?>
			  </tbody>
			</table>
			<div id="demo0" class="pages"><div class="y_tip">共 <?php echo $pager['count'];?> 条 每页 <?php echo $pagesize;?> 条	</div><div class="y_page"><?php echo $pager['links'];?></div></div>
		</div>
   
    </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>

</body>
</html>
