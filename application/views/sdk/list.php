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
			  <?php foreach ($list as $v){ ?>
				<tr>
				  <td><?=$v['name']?></td>
				  <td><?=$v['url']?></td>
				  <td><?=$v['sappid']?></td>
				  <td><?=$v['appid']?></td>
				  <td><?=$v['app_secret']?></td>
				  <td><div class="iconpic"><img src="<?=$v['icon']?>" /></div></td>
				  <td><?php if($v['status'] == 0 ){?> <span class="opearbtn opearbtnjs" data-id="<?=$v['id']?>">禁用</span><?php   }else{ ?> <span class="opearbtn  opearbtnjs2 active" data-id="<?=$v['id']?>">启用</span><?php } ?>
				  
				  </td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
			<div id="demo0" class="pages"><div class="y_tip">共 <?php echo $pager['count'];?> 条 每页 <?php echo $pagesize;?> 条	</div><div class="y_page"><?php echo $pager['links'];?></div></div>
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
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".opearbtnjs",function(){
		var id=$(this).data("id");
		layer.open({
			 type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: id //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer03')
			, yes: function (index, layero) {
			  //成功输出内容
			  $.ajax({
					url: '/sdk/index/cancel',
					dataType: 'json',  
					type: 'post', 
					data: {id:id, status:1},
					success: function(data , textStatus){
						
						if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });

			}
		});
	});
	$(document).on("click",".opearbtnjs2",function(){
		var id=$(this).data("id");
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: id//设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer04')
			,yes: function (index, layero) {
			  //成功输出内容
			  $.ajax({
					url: '/sdk/index/cancel',
					dataType: 'json',  
					type: 'post', 
					data: {id:id, status:0},
					success: function(data , textStatus){
						
							if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });
			}
		});
	});
});

</script>