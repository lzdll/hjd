<div class="postnav">广告管理</div>
	<div class="layuibodycont">
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>广告数量</dd>
				<dt>130个</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>消耗金额(元)</dd>
				<dt>￥33040.10</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>点击率</dd>
				<dt>73%</dt>
			</dl>
			<dl class="topitemdl topitemdl25" style="border:none">
				<dd>曝光量</dd>
				<dt>123649</dt>
			</dl>
		</div>
		
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>广告名称</th>
				  <th>曝光量</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>点击单价</th>
				  <th>CMP(千人展示价)</th>
				  <th>广告主</th>
				  <th>消耗</th>
				  <th>SDK</th>
				  <th>状态</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td><a href="广告位详情.html" class="tdviewbtn">米加小程序</a></td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="70" class="editput" disabled=""></span></td>
				  <td>186****3625</td>
				  <td>￥0.00</td>
				  <td><a href="绑定SDK.html"><span class="tdobtn01 active">绑定</span></a></td>
				  <td><a href="/advert/index/adopt"><span class="tdstatus active">待审核</span></a></td>
				  <td><span class="tdoper02">未投放</span></td>
				</tr>
				<tr>
				  <td><a href="/advert/index/add" class="tdviewbtn">米加小程序</a></td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="70" class="editput" disabled=""></span></td>
				  <td>186****3625</td>
				  <td>￥0.00</td>
				  <td><span class="tdobtn01">小玩家</span></td>
				  <td><a href="page-1-运营平台2广告主_4广告审核2.html"><span class="tdstatus">通过审核</span></a></td>
				  <td><span class="tdoper02 active aduseroper">撤下</span></td>
				</tr>
				<tr>
				  <td><a href="广告位详情.html" class="tdviewbtn">米加小程序</a></td>
				  <td>32654</td>
				  <td>1354</td>
				  <td>35%</td>
				  <td>￥4.5</td>
				  <td><span class="tdfont01 editjs">￥<input type="text" value="70" class="editput" disabled=""></span></td>
				  <td>186****3625</td>
				  <td>￥0.00</td>
				  <td><span class="tdobtn01">小玩家</span></td>
				  <td><a href="page-1-运营平台2广告主_4广告审核2.html"><span class="tdstatus">通过审核</span></a></td>
				  <td><span class="tdoper02">未投放</span></td>
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
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要撤下此广告吗？</div>
</div>
<div class="selectgoodsbox tx" id="layer04">
   <div class="">
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" name="title" placeholder="请输入新的价格" class="layui-input">
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
	$(document).on("click",".aduseroper",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer03')
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
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