    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="add_adinvoice"><span class="addads">开发票</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>申请时间</th>
				  <th>发票抬头</th>
				  <th>税号</th>
				  <th>发票金额</th>
				  <th>备注</th>
				  <th>状态</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach($list as $row): ?>
				<tr>
				  <td><?php echo $row['created_time']; ?></td>
				  <td><?php echo $row['title']; ?></td>
				  <td><?php echo $row['taxid']; ?></td>
				  <td>￥<?php echo $row['money']; ?></td>
				  <td><?php echo $row['comment']; ?></td>
					<?php if($rwo['status']): ?>
						<td><span class="tdstatus">已开票</span> </td>
					<?php else: ?>
						<td><span class="tdstatus active">待开票 </span></td>
					<?php endif; ?>
				</tr>
			  <?php endforeach;?>
			  </tbody>
			</table>
			<div id="demo0" class="pages"><?php echo $pager; ?></div>

   
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

</script>
</body>
</html>
