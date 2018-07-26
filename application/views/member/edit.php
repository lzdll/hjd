<div class="layuibodycont">
		<div class="clearfix formblock">
			<p class="formtitle">修改密码</p>
			<form class="layui-form autolayblock" action="edit" method="post">
				  <div class="layui-form-item">
					<label class="layui-form-label">新密码：</label>
					<div class="layui-input-block">
					  <input type="password" name="pwd" id="pwd" required lay-verify="pwd"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">确认密码：</label>
					<div class="layui-input-block">
					  <input type="password" name="repwd" id="repwd" required lay-verify="repwd"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn" type="reset">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">确认</button>
					</div>
				  </div>
			</form>
		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
	layui.use(['form', 'layedit', 'laydate'], function(){
		var form = layui.form
				,layer = layui.layer
				,layedit = layui.layedit
				,laydate = layui.laydate;
		//自定义验证规则
		form.verify({
			pwd: function(value){
				if(value.length < 1 ){
					return '请输入密码';
				}
			},
			 repwd: function(value){
				 var pass = $('#pwd').val();
				 if(value != pass){
					 return '两次输入的密码不一致!';
				 }
				if(value.length < 1 ){
					return '请输入密码';
				}
			}
		});
	});
</script>