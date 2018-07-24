<div class="postnav"> <?php $this->load->view('common/menu.php') ?></div>
	<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="/finance/index/add"><span class="addads">充值</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>充值时间</th>
				  <th>金额</th>
				  <th>广告主</th>
				  <th>汇款银行</th>
				  <th>汇款单号</th>
				  <th>类型</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach ($list as $v){ ?>
				<tr>
				  <td><?php { echo date('Y-m-d H:i', strtotime($v['created_time']));}?></td>
				  <td><?php echo "￥".$v['money']/100;?></td>
				  <td><?=$v['owner']?></td>
				  <td><?=$v['bank']?></td>
				  <td><?=$v['tradid']?></td>
				  <td><span class="opearbtn active"><?php if($v['subject'] == 0){ echo "提现";}else{ echo "充值"; }?></span></td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
			
			<div id="demo0" class="pages">  
			
			<div class="y_tip">共 <?php echo $pager['count'];?> 条 每页 <?php echo $pagesize;?> 条	</div><div class="y_page"><?php echo $pager['links'];?></div>
					
					
					</div>
		</div>
    </div>
  </div>

