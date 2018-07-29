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
			  <?php foreach ($list as $v){ ?>
				<tr>
				  <td><?php { echo date('Y-m-d H:i', strtotime($v['created_time']));}?></td>
				  <td><?=$v['bank']?></td>
				  <td><?=$v['cardid']?></td>
				  <td><?php echo "￥".$v['money'];?></td>
				  <td><?=$v['owner']?></td>
				  <td><?=$v['comment']?></td>
				  <td>
					  <?php if($v['status'] == 0 ){?> 
					  <span class="opearbtn" >已打款</span>
					  <?php   }else{ ?> 
					  <span class="opearbtn opearbtnjs active" onclick="editjs('<?=$v['id']?>')">未打款</span>
					  <?php } ?>
				  </td>
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
		<p class="editprice">财务备注</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<div class="layui-input-block opeareablock" >
					  <textarea class="opearea" placeholder="建议输入流水号" id="opearea"></textarea>
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

function editjs(obj){
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
				 var opearea = $("#opearea").val();
				//成功输出内容
				$.ajax({
					url: '/finance/index/unexecuted',
					dataType: 'json',  
					type: 'post', 
					data: {id:obj, opearea:opearea},
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
</script>