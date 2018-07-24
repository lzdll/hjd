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
<!--				<tr>-->
<!--				  <td>2018-06-27</td>-->
<!--				  <td>北京微微生物有限公司</td>-->
<!--				  <td>9135412454561232044</td>-->
<!--				  <td>￥4000.5</td>-->
<!--				  <td>6月23号充值</td>-->
<!--				  <td><span class="tdstatus">已开票</span></td>-->
<!--				</tr>-->
			  </tbody>
			</table>
<!--			<div id="demo0" class="pages"></div>-->
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
