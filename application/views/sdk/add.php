<div class="postnav">SDK管理 - <span class="">添加SDK</span></div>
<script src="/public/money_ex/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="/public/money_ex/js/ajaxfileupload.js" type="text/javascript"></script>
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
					<!---上传前效果-->
					<div class="layui-input-block" id='uploadfirst'>
					  <div class="file-input-wrapper">
							<input type="button" class="file_btn" value="">
							<input type="file" class="file-input" value="" name='file' id="file" onchange="return fileupload();" >
						</div>
					  <span class="addfilespro">尺寸：100*100像素</span>
					</div>
					<!---上传后效果-->
					<div class="layui-input-block" id='uploadlast' style="display:none">
					      <img src="/public/money_ex/images/main_01.gif" id="loading" style="display: none" />
							 <span id="imgk">
                             <img src="" id="photoImg" style="display:none;width:100px;height:100px;"/>
							 </span>
							 <b class="close" id='close' style="display: none" onclick="del_img();"></b>

							<input type="hidden" value="" id="imgsrc" name="imgsrc">
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
 //ajax 上传图片
 function fileupload(){
		$("#loading").show();
		$("#uploadlast").show();
		$("#uploadfirst").hide();
		$.ajaxFileUpload({
			url: "/sdk/index/setimg",
			secureuri:false,
			fileElementId:"file",
			dataType:"json",
			success:function(data,status) {
				if(data.status==0) {
					$("#loading").hide();
					$("#uploadlast").hide();
					$("#uploadfirst").show();
					alert(data.msg);
					return false;
				}else {
					$("#loading").hide();
					$("#photoImg").show();
					$("#photoImg").attr("src", data.url);
					$("#imgsrc").val(data.url);
					$("#close").show();
				}
			},
			error:function (data,status,e) {
				alert(e);
			}
		})
		return false;
  }

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