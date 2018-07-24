<div class="postnav">SDK管理</div>
		

	<div class="layuibodycont">
		<div class="clearfix layui-form mt10">
		<form  id ="form" method="post"  enctype="multipart/form-data">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>选择</th>
				  <th>SDK名称</th>
				  <th>URL</th>
				  <th>小程序ID</th>
				  <th>APPID</th>
				  <th>icon</th>
				</tr> 
			  </thead>
			  <tbody>
			   <?php foreach ($list as $v){ ?>
				<tr>
				  <td><input type="checkbox" class="checkbox" name="sdk_code[]" lay-skin="primary" value='<?=$v['code']?>'/></td>
				  <td><?=$v['name']?></td>
				  <td><?=$v['url']?></td>
				  <td><?=$v['sappid']?></td>
				  <td><?=$v['appid']?></td>
				  <td><div class="iconpic"><img src="<?=$v['icon']?>" /></div></td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
			<input type="hidden"  name="ad_code"  value='<?php echo  $ad_code; ?>'/>
				<input type="hidden"  name="sdk_codes"  id="sdk_code" value=''/>
			 </form>
			 <div class="layui-form-item">
				<div class="layui-input-block formopearbtn" style="margin-left:0px;">
				
				  <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/advert/index/lists'">
						取消
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" id="submitBtn">添加</button>
				</div>
			  </div>
			  			

		</div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		var spCodesTemp='';
		$.each($('input:checkbox:checked'),function(){
				if(spCodesTemp==''){
					spCodesTemp = $(this).val();
				}else{
					spCodesTemp += (","+$(this).val());
				}

        });
		$('#sdk_code').val(spCodesTemp);
		if(spCodesTemp == '')
			{
				alert("请至少绑定一个SDK！");
				return false;
			} else {
				$("#form").submit();
			}
	});
});
</script>