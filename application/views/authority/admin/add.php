<style>
.l_tableBox2 .l_table1{width:100%;}
</style>
<script type="text/javascript" src="/public/static/js/jquery-3.2.0.min.js"></script>
		<div class="clearfix formblock">
			<form class="layui-form compform" role="form" id ="form" method="post">
				<p class="formtitle">  <?php $this->load->view('common/menu.php') ?></p>
				 <div class="layui-form-item">
					<label class="layui-form-label">登录名：</label>
					<div class="layui-input-block">
						 <input type="text" placeholder="登录名" class="layui-input"  name="login_name"  id="login_name" />
					</div>
				  </div>
				   <div class="layui-form-item">
					<label class="layui-form-label">用户身份：</label>
					<div class="layui-input-block">
					   <select class="t_select" name="type">
                       <option value="0">广告</option>
					   <option value="1">流量主</option>
                    </select>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">邮箱：</label>
					<div class="layui-input-block">
					  <input type="text" placeholder="邮箱" class="layui-input"   name="emial"  id="email" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">手机号：</label>
					<div class="layui-input-block">
					 <input type="text" placeholder="手机号" class="layui-input"   name="phone"  id="phone" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">密码：</label>
					<div class="layui-input-block">
					   <input type="password" placeholder="密码" class="layui-input"  name="password"  id="password" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">确认密码：</label>
					<div class="layui-input-block">
					   <input type="password" placeholder="确认密码：" class="layui-input"  name="password2"  id="password2" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">角色：</label>
					<div class="layui-input-block">
					   <select class="t_select" name="role">
                        <?php foreach($role as $v): ?>
                        <option value="<?php echo $v['id'];?>" <?php if($role_id == $v['id']){ echo "selected='selected'";} ?>><?php echo $v['name'];?></option>
                        <?php endforeach; ?>
                    </select>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">角色：</label>
					<div class="layui-input-block">
					   <select class="t_select" name="status">
                      
                        <option value="0">有效</option>
						<option value="1">无效</option>
                      
                    </select>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" id="submitBtn">保存</button>
					  <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/authority/role/index'">
                    返回
                </button>
					</div>
				  </div>
			</form>
		</div>
<script>
$(document).ready(function(){
	$("#submitBtn").click(function(){
		var login_name = $('#login_name').val();
		var password = $('#password').val();
		var emial = $('#emial').val();
		var phone = $('#phone').val();
		var password2 = $('#password2').val();
		if(login_name == '')
		{
			alert("登录名不能为空！");
			return false;
		} else if(password == ''){
			alert("密码不能为空！");
			return false;
		} else if(emial == ''){
			alert("邮箱不能为空！");
			return false;
		} else if(phone == ''){
			alert("手机号不能为空！");
			return false;
		}else if(password !== password2){
			alert("两次输入密码不一致！");
			return false;
		} else {
			
			var reg = /[^a-zA-Z0-9\u4E00-\u9FA5\-\_]/g;
			if (reg.test(name))
			{
				alert('名称只能输入字母、汉字、数字、"-"、"_"');
				return false;
			}
			$("#form").submit();
		}
	});
});

</script>
