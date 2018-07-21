<div class="postnav">广告主 - <span class="">重置密码</span></div>
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<p class="formtitle">重置密码</p>
			<form class="layui-form autoform" role="form" id ="form" method="post"  enctype="multipart/form-data">
				  <div class="layui-form-item">
					<label class="layui-form-label">新密码：</label>
					<div class="layui-input-block">
					  <input type="text" name="password" id="password" placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">确认密码：</label>
					<div class="layui-input-block">
					  <input type="text" name="password2"  id="password2" placeholder="" class="layui-input" />

					<input type="hidden" name="type"   value="<?php echo $type; ?>" class="layui-input" />
					<input type="hidden" name="id"   value="<?php echo $id; ?>" class="layui-input" />
					<input type="hidden" name="code"   value="<?php echo $code; ?>" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/flow/index/lists'">
						取消
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" id="submitBtn">确认</button>

					</div>
				  </div>
			</form>
		</div>
    </div>
  </div>
  <script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		var password = $('#password').val();
		var password2 = $('#password2').val();
		if(password == '')
		{
			alert("新密码不能为空！");
			return false;
		} else if(password2 == ''){
			alert("确认密码不能为空！");
			return false;
		} else if(password !== password2){
			alert("两次输入密码不一致！");
			return false;
		}else {
			$("#form").submit();
		}
	});
});
</script>