<div class="layuibodycont">
		<div class="tips"><img src="images/lc06.png" />提交公司资质后才可投放广告</div>
		<div class="clearfix formblock">
			<form class="layui-form compform">
				<p class="formtitle">账号信息</p>
				<div class="layui-form-item">
					<label class="layui-form-label">手机号：</label>
					<div class="layui-input-block">
					   <input type="text" name="title" value="18600900254" class="layui-input putpros"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">邮箱：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" value="18600900254@163.com" class="layui-input putpros"/>
					</div>
				  </div>
				  
				  
				<p class="formtitle">公司资质</p> 
				<div class="layui-form-item">
					<label class="layui-form-label idcard">身份类型：</label>
					<div class="layui-input-block">
					  <input type="radio" name="sex" value="01" title="公司企业广告主" checked="" lay-filter="idtype" >
					  <input type="radio" name="sex" value="02" lay-filter="idtype"  title="个人广告主" >
					</div>
				  </div>
				  <div class="comtabs tx on">
				  <div class="layui-form-item">
					<label class="layui-form-label">企业名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" placeholder="输入公司名称" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">营业执照：</label>
					<div class="layui-input-block">
					<!--未传图片之前的样式-->
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="上传营业执照" />
						<input type="file" class="file-input4" value="" />
						<!--<img src="images/m3.jpg" class="" />-->
					  </div>
					  <!--上传图片之后的样式
						<div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="上传营业执照" />
						<input type="file" class="file-input4" value="" />
						<img src="images/m3.jpg" class="" />
					  </div>-->
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">法人身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" class="file-input4" value="" />
						<!--<img src="images/m4.jpg" class="" />-->
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" class="file-input4" value="" />
						<!--<img src="images/m5.jpg" class="" />-->
					  </div>
					</div>
				  </div>
				  </div>
				  <div class="persontabs tx">
					<div class="layui-form-item">
					<label class="layui-form-label">身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" class="file-input4" value="" />
						<!--<img src="images/m4.jpg" class="" />-->
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" class="file-input4" value="" />
						<!--<img src="images/m5.jpg" class="" />-->
					  </div>
					</div>
				  </div>
				  </div>
				  
				  
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <a href="账户资料审核中.html" class="layui-btn addbtn">提交</a>
					</div>
				  </div>
			</form>
		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->

</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form;
	form.on("radio(idtype)",function(data){
		//alert(data.value);//判断单选框的选中值/
		if(data.value == 01){
			$(".comtabs").show();
			$(".persontabs").hide();
		}else if(data.value == 02){
			$(".comtabs").hide();
			$(".persontabs").show();
		}
	});
  });
</script>