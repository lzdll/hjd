<div class="postnav">SDK管理 - <span class="">添加SDK</span></div>
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<p class="formtitle">添加SDK</p>
			<form class="layui-form autoform" role="form" id ="form" method="post"  enctype="multipart/form-data">
				<div class="layui-form-item">
					<label class="layui-form-label">SDK名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="name"  placeholder="" class="layui-input" id='name'/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">URL：</label>
					<div class="layui-input-block">
					  <input type="text" name="url"  placeholder="" class="layui-input" id="url"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">小程序ID：</label>
					<div class="layui-input-block">
					  <input type="text" name="sappid"  placeholder="" class="layui-input" id="sappid"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">APP ID：</label>
					<div class="layui-input-block">
					  <input type="text" name="appid"  placeholder="" class="layui-input" id="appid" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">AppSecret：</label>
					<div class="layui-input-block">
					  <input type="text" name="app_secret"  placeholder="" class="layui-input" id="app_secret" />
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <!--<div class="addfiles">
						<div class="addfilesbtn"><span class=""></span></div>
						<input type="file" class="putfiles" />
					  </div>-->
					  <div class="file-input-wrapper">
							<input type="button" class="file_btn" value="">
							<input type="file" class="file-input" value="" name='file' id="file">
						</div>
					  <span class="addfilespro">尺寸：100*100像素</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/sdk/index/lists'">
						取消
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" id="submitBtn">添加</button>

					</div>
				  </div>
			</form>
		</div>
    </div>
  </div>
 <script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		var name = $('#name').val();
		var url = $('#url').val();
		var sappid = $('#sappid').val();
		var appid = $('#appid').val();
		var app_secret = $('#app_secret').val();
		var file = $('#file').val();
		if(name == '')
		{
			alert("SDK名称不能为空！");
			return false;
		} else if(url == ''){
			alert("url不能为空！");
			return false;
		} else if(sappid == ''){
			alert("小程序ID不能为空！");
			return false;
		} else if(appid == ''){
			alert("APP ID不能为空！");
			return false;
		} else if(app_secret == ''){
			alert("AppSecret不能为空！");
			return false;
		} else if(file == ''){
			alert("icon图标不能为空！");
			return false;
		} else {
			$("#form").submit();
		}
	});
});
</script>