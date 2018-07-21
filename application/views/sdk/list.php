<div class="postnav">SDK管理</div>
	<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="/sdk/index/add"><span class="addads">添加SDK</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>SDK名称</th>
				  <th>URL</th>
				  <th>小程序ID</th>
				  <th>APPID</th>
				  <th>AppSecret</th>
				  <th>icon</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
				  <td>name</td>
				  <td>https://www.baidu.com/</td>
				  <td>xiaochegnxuid</td>
				  <td>appid</td>
				  <td>AppSecret</td>
				  <td><div class="iconpic"><img src="/public/money_ex/images/dot003.png" /></div></td>
				  <td><span class="opearbtn opearbtnjs2 active">禁用</span></td>
				</tr>
				<tr>
				  <td>name</td>
				  <td>https://www.baidu.com/</td>
				  <td>xiaochegnxuid</td>
				  <td>appid</td>
				  <td>AppSecret</td>
				  <td><div class="iconpic"><img src="/public/money_ex/images/dot003.png" /></div></td>
				  <td><span class="opearbtn opearbtnjs2 active">禁用</span></td>
				</tr>
				<tr>
				  <td>name</td>
				  <td>https://www.baidu.com/</td>
				  <td>xiaochegnxuid</td>
				  <td>appid</td>
				  <td>AppSecret</td>
				  <td><div class="iconpic"><img src="/public/money_ex/images/dot003.png" /></div></td>
				  <td><span class="opearbtn opearbtnjs">启用</span></td>
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
	<div class="adopearbox">确定后将禁用SDK，您确定要禁用吗？</div>
</div>
 <div class="selectgoodsbox tx" id="layer04">
	<div class="adopearbox">确定后将启用SDK，您确定要启用吗？</div>
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
/**
$(document).on("click",".opearbtn",function(){
	if($(this).hasClass("active")){
		$(this).removeClass("active");
		$(this).html("启用");
	}else{
		$(this).addClass("active");
		$(this).html("禁用");
	}
});**/
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".opearbtnjs",function(){
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
	$(document).on("click",".opearbtnjs2",function(){
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
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