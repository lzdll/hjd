<div class="postnav">提现管理</div>
	<div class="layuibodycont">
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>申请时间</th>
				  <th>银行</th>
				  <th>卡号</th>
				  <th>提现金额</th>
				  <th>流量主</th>
				  <th>备注</th>
				  <th>标记</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td>2018-06-27</td>
				  <td>北京银行</td>
				  <td>9214563245852632</td>
				  <td>￥3000.00</td>
				  <td>1862330256</td>
				  <td>6月23号充值</td>
				  <td><span class="opearbtn opearbtnjs active">未打款</span></td>
				</tr>
				<tr>
				  <td>2018-06-27</td>
				  <td>北京银行</td>
				  <td>9214563245852632</td>
				  <td>￥3000.00</td>
				  <td>1862330256</td>
				  <td>6月23号充值</td>
				  <td><span class="opearbtn">已打款</span></td>
				</tr>
				<tr>
				  <td>2018-06-27</td>
				  <td>北京银行</td>
				  <td>9214563245852632</td>
				  <td>￥3000.00</td>
				  <td>1862330256</td>
				  <td>6月23号充值</td>
				  <td><span class="opearbtn">已打款</span></td>
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
<div class="selectgoodsbox tx" id="layer04">
   <div class="">
		<p class="editprice">财务备注</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<div class="layui-input-block opeareablock" >
					  <textarea class="opearea" placeholder="建议输入流水号"></textarea>
					</div>
				  </div>
			 </form>

		</div>
	</div>
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
	$(document).on("click",".opearbtnjs",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '250px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定已打款','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer04')
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
});

</script>