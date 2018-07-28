<div class="postnav">广告主 - <span class="">添加广告主</span></div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>广告数量</dd>
				<dt><?php echo $total; ?>个</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>充值总额(元)</dd>
				<dt>￥<?php echo $account['total_money']/100; ?></dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>余额总额(元)</dd>
				<dt>￥<?php echo $account['money']/100; ?></dt>
			</dl>
			<dl class="topitemdl topitemdl25 noborder">
				<dd><a href="/authority/admin/add?type=0" class="addads">添加广告主</a></dd>
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
			   <?php foreach ($list as $v){ ?>
				<tr>
				  <td><?=$v['id']?></td>
				  <td><?=$v['phone']?></td>
				  <td><?=$v['email']?></td>
				  <td><?=$v['ad_total']?></td>
				  <td><?=$v['cz_total']?></td>
				  <td>￥<?php echo $v['cz_money']; ?></td>
				  <td>￥<?php echo $v['sy_money']; ?></td>
				  <td><span class="tdfont01 editjs" onclick="editjs('<?=$v['code']?>')">￥<input type="text" value="<?php echo $v['credit']/100; ?>" class="editput" disabled=""></span></td>
				  <td><a href="/advertiser/index/resetpwd?code=<?=$v['code']?>&id=<?=$v['id']?>&type=<?=$v['type']?>" class="tdfont01">重置</a></td>
				  <td><a class="tdfont01" href="/advertiser/index/details?code=<?=$v['code']?>&id=<?=$v['id']?>&type=<?=$v['type']?>">查看详情</a></td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
			
			<div id="demo0" class="pages"><?php echo $page; ?></div>
		</div>
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
					  <span>￥</span><input type="text" name="title" placeholder="请输入授信额价格" class="layui-input" id="credit">
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
function editjs(code){
	alert(code);
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
			,yes: function (index, layero) {
				 var credit = $("#credit").val();
				 if(credit == ''){
					alert('授信额价格不能为空');
					return false;
				 }
				//成功输出内容
				$.ajax({
					url: '/advertiser/index/credit',
					dataType: 'json',  
					type: 'post', 
					data: {code:code,credit:credit},
					success: function(data , textStatus){
					if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					 
					}
				});
			}
		});
}


</script>