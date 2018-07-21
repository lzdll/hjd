<div class="postnav">广告主 - <span class="">添加广告主</span></div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>广告数量</dd>
				<dt>130个</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>充值总额(元)</dd>
				<dt>￥33040.10</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>余额总额(元)</dd>
				<dt>￥60040.30</dt>
			</dl>
			<dl class="topitemdl topitemdl25 noborder">
				<dd><a href="/advertiser/index/add" class="addads">添加广告主</a></dd>
			</dl>
		</div>
		
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>ID </th>
				  <th>手机号</th>
				  <th>邮箱</th>
				  <th>广告数量</th>
				  <th>充值次数</th>
				  <th>充值总额</th>
				  <th>余额</th>
				  <th>授信额</th>
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
				  <td>5</td>
				  <td>￥2345140.00</td>
				  <td>￥2330.00</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="0" class="editput" disabled=""></span></td>
				  <td><a href="重置密码.html" class="tdfont01">重置</a></td>
				  <td><a class="tdfont01" href="/advertiser/index/details">查看详情</a></td>
				</tr>
				<tr>
				  <td>24</td>
				  <td>18600643256</td>
				  <td>hello@e7124.com</td>
				  <td>15</td>
				  <td>5</td>
				  <td>￥2345140.00</td>
				  <td>￥2330.00</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="0" class="editput" disabled=""></span></td>
				  <td><a href="重置密码.html" class="tdfont01">重置</a></td>
				  <td><a class="tdfont01" href="/advertiser/index/details">查看详情</a></td>
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
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" name="title" placeholder="请输入授信额价格" class="layui-input">
					</div>
				  </div>
			 </form>
		</div>
	</div>
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
  
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
		$(document).on("click",".editjs",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '230px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
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