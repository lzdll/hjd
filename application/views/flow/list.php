<div class="postnav">流量主</div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>流量主数量</dd>
				<dt>130个</dt>
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
				<dd><a href="/flow/index/add"><span class="addads">添加流量主</span></a></dd>
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
				<tr>
				  <td>24</td>
				  <td>18600643256</td>
				  <td>hello@e7124.com</td>
				  <td>15</td>
				  <td>￥2345140.00</td>
				  <td>￥2330.00</td>
				  <td><span class="tdstat active">已封号</span></td>
				  <td><a href="重置密码.html" class="tdfont01">重置</a></td>
				  <td><a href="/flow/index/details"><span class="tdfont01">查看详情</span></a></td>
				</tr>
				<tr>
				  <td>24</td>
				  <td>18600643256</td>
				  <td>hello@e7124.com</td>
				  <td>15</td>
				  <td>￥2345140.00</td>
				  <td>￥2330.00</td>
				  <td><span class="tdstat">正常</span></td>
				  <td><a href="#" class="tdfont01">重置</a></td>
				  <td><a href="/flow/index/details"><span class="tdfont01">查看详情</span></a></td>
				</tr>
			  </tbody>
			</table>
			<div id="demo0" class="pages"></div>
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