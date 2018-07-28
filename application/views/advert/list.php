<div class="postnav">广告管理</div>
	<div class="layuibodycont">
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl25">
				<dd>广告数量</dd>
				<dt><?php echo $advert_num;  ?>个</dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>消耗金额(元)</dd>
				<dt><?php echo "￥".$consume['st_price']/100;  ?></dt>
			</dl>
			<dl class="topitemdl topitemdl25">
				<dd>点击率</dd>
				<dt>
				<?php 
				$click = round($consume['cpc']/($consume['cpc']+$consume['cpm']), 2)*100;
				echo  $click."%" ?></dt>
			</dl>
			<dl class="topitemdl topitemdl25" style="border:none">
				<dd>曝光量</dd>
				<dt><?php echo $consume['cpc']+$consume['cpm'];  ?></dt>
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
			  <?php foreach ($list as $v){ ?>
				<tr>
				  <td><a href="/advert/index/details?id=<?php echo $v['id']; ?>&code=<?=$v['code']?>" class="tdviewbtn"><?=$v['name']?></a></td>
				  <td><?php echo $v['cpc']+$v['cpm'];  ?></td>
				  <td><?php echo $v['cpc'];  ?></td>
				  <td>
				  <?php 
					$click = round($v['cpc']/($v['cpc']+$v['cpm']), 2)*100;
					echo  $click."%" ?>
					</td>
				  <td>
					<?php 
						$totol=$v['cpc']*100;
						if($v['ad_price']){
							echo "￥".$v['ad_price']/$totol; 
						}else{
							echo "￥0"; 
						}
					?>
					</td>

				  <td><span class="tdfont01 editjs" onclick="editjs('<?=$v['code']?>','<?=$v['owner']?>')">￥<input type="text" value="<?php echo $v['cmp_price'];  ?>" class="editput" disabled="" id="editput_<?php echo $v['id']; ?>"></span></td>

				  <td><?php echo $v['owner'];  ?></td>
				  <td><?php echo "￥".$v['ad_price']/100;  ?></td>
				  <td> <?php if($v['sdk_name'] == '' ){?> <a href="/advert/index/binding?code=<?php echo $v['code']; ?>"><span class="tdobtn01 active">绑定</span></a><?php  }else{ echo $v['sdk_name']; }?>
				  </td>
				  <td>
					  <?php if($v['audit_status'] == 0 ){?> 
						<a href="/advert/index/adopt?code=<?php echo $v['code']; ?>&id=<?php echo $v['id']; ?>"><span class="tdstatus active">待审核</span></a>
					  <?php   }else if($v['audit_status'] == 1){ ?> 
						<a href="javascript:void(0)"><span class="tdstatus">通过审核</span></a>
					  <?php }else if($v['audit_status'] == 3){ ?>
						<a href="/advert/index/adopt??code=<?php echo $v['code']; ?>&id=<?php echo $v['id']; ?>"><span class="tdstatus active">未过审核</span></a>	
					  <?php } ?>
				  </td>
				  <td>
					  <?php if($v['status'] == 0 ){?> 
					   <span class="tdoper02 active aduseroper" onclick="upstatus('<?=$v['id']?>')">撤下</span>
					  <?php   }else{ ?> 
						<span class="tdoper02">未投放</span>
					  <?php } ?>
				 </td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
 <div id="demo0" class="pages"><?php echo $page; ?></div>		</div>
    </div>
  </div>
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
					  <span>￥</span><input type="text" name="title" placeholder="请输入新的价格" class="layui-input" id="cmp_price">
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
function editjs(code,owner){
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
				 var cmp_price = $("#cmp_price").val();
				 if(cmp_price == ''){
					alert('价格不能为空');
					return false;
				 }
				//成功输出内容
				$.ajax({
					url: '/advert/index/editcmp',
					dataType: 'json',  
					type: 'post', 
					data: {code:code, owner:owner,cmp_price,cmp_price},
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
}
//更新广告状态
function upstatus(obj){
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
			,yes: function (index, layero) {
				//成功输出内容
				$.ajax({
					url: '/advert/index/online',
					dataType: 'json',  
					type: 'post', 
					data: {id:obj},
					success: function(data , textStatus){
						
						if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					 alert("error");
					}
				});
			}
		});
}

 
</script>