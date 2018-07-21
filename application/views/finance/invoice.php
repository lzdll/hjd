<div class="postnav">开具发票</div>
	<div class="layuibodycont">
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>申请时间</th>
				  <th>发票抬头</th>
				  <th>税号</th>
				  <th>发票金额</th>
				  <th>广告主</th>
				  <th>备注</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td>2018-06-27</td>
				  <td>润叶生物有限公司</td>
				  <td>36961381595231</td>
				  <td>￥3000.00</td>
				  <td>18600523652</td>
				  <td>6月23号充值</td>
				  <td><span class="blibtn blibtnjs">开票</span></td>
				</tr>
				<tr>
				  <td>2018-06-27</td>
				  <td>润叶生物有限公司</td>
				  <td>36961381595231</td>
				  <td>￥3000.00</td>
				  <td>18600523652</td>
				  <td>6月23号充值</td>
				  <td><span class="viewbtn viewbtnjs">查看发票</span></td>
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
 <div class="selectgoodsbox tx" id="layer01">
	<p class="selectnav">上传发票凭证</p>
	<div class="file-input-wrapper2">
		<input type="button" class="file_btn2" value="" />
		<input type="file" class="file-input2" value="" />
	</div>
	<span class="fbpic">发票照片</span>
</div>
 <div class="selectgoodsbox tx" id="layer02">
	<div class="viewpicbox"><img src="/public/money_ex/images/m2.jpg" /></div>
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
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".blibtnjs",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['427px', '350px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['上传','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer01')
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
	$(document).on("click",".viewbtnjs",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['500px', '480px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['关闭']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer02')
			//,success: function(layero){
			  //成功输出内容
			//}
		});
	});
});
</script>
