
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
			    <?php foreach ($list as $v){ ?>
					<tr>
					  <td><?php { echo date('Y-m-d H:i', strtotime($v['created_time']));}?></td>
					  <td><?=$v['title']?></td>
					  <td><?=$v['taxid']?></td>
					  <td><?php echo "￥".$v['money']/100;?></td>
					  <td><?=$v['owner']?></td>
					  <td><?=$v['comment']?></td>
					  <td><?php if($v['status'] == 1 ){?> <span class="viewbtn " onclick="viewimgs('<?=$v['img']?>')">查看发票</span><?php   }else{ ?> <span class="blibtn" data-id="<?=$v['id']?>" onclick="kaipiao('<?=$v['id']?>')">开票</span><?php } ?>
					  </td>
					</tr>
				<?php } ?>
			  </tbody>
			</table>
			<div id="demo0" class="pages">
			<?php $this->load->view('common/page.php') ?> 
			</div>
		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->

</div>
 <div class="selectgoodsbox tx" id="layer01">
 <form class="layui-form autoform" role="form" id ="form" method="post"  enctype="multipart/form-data">
	<p class="selectnav">上传发票凭证</p>
	<div class="file-input-wrapper2" id='uploadfirst'>
		<input type="button" class="file_btn2" value="" />
		<input type="file" class="file-input2" value="" name='file' id="file" onchange="return setimg();" >
	</div>

	<div class="file-input-wrapper" id='uploadlast' style="display:none;">
		    <img src="" id="photoImg" style="display:none;"/>
			<input type="hidden" id="zygw_id" value=0 name="id"/>	</div>
	<br/>
	<span class="fbpic">发票照片</span>
</form>
</div>

 <div class="selectgoodsbox tx" id="layer02">
	<div class="viewpicbox"><img src="/public/money_ex/images/m2.jpg" id='imgsrc' /></div>
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
function setimg(){
	$("#uploadlast").show();
	$("#uploadfirst").hide();
	$("#photoImg").show();
	$("#photoImg").attr("src",'/public/money_ex/images/m2.jpg');
}
function kaipiao(obj){
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
			,yes: function (index, layero) {
				$("#zygw_id").val(obj);
			  //成功输出内容
				$('#form').attr('action','/finance/index/add_invoice');
				$('#form').submit();
			}
		});
}

function viewimgs(obj){
	$('#imgsrc').attr('src',obj);
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
	});
}
</script>
