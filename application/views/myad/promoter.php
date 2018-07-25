 <!-- 内容主体区域 -->
 <script src="/public/money_ex/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="/public/money_ex/js/ajaxfileupload.js" type="text/javascript"></script>
	<div class="layuibodycont">
		<div class="tips"><img src="images/lc06.png" />提交公司资质后才可投放广告</div>
		<div class="clearfix formblock">
			<form class="layui-form compform" id ="form" method="post"  enctype="multipart/form-data">
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
					  <input type="radio" name="type" value="0" title="公司企业广告主" checked="" lay-filter="idtype" >
					  <input type="radio" name="type" value="1" lay-filter="idtype"  title="个人广告主" >
					</div>
				  </div>
				  <div class="comtabs tx on">
				  <div class="layui-form-item">
					<label class="layui-form-label">企业名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="name" placeholder="输入公司名称" disabled class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">营业执照：</label>
					<div class="layui-input-block">
					<!--未传图片之前的样式-->
					  <div class="file-input-wrapper4 layuiitempic" id='uploadfirst1'>
						<input type="button" class="file_btn4" value="上传营业执照" />
						<input type="file" name="file" id="file" class="file-input4" value=""  onchange="return fileupload(1);" />
						<!--<img src="images/m3.jpg" class="" />-->
					  </div>
					<!---上传后效果-->
					<div class="layui-input-block" id='uploadlast1' style="display:none">
                        <img src="/public/money_ex/images/main_01.gif" id="loading1" style="display: none" />
                        <span id="imgk">
                        	<img src="" id="photoImg1" style="display:none;width:100px;height:100px;"/>
                        </span>
                        <b class="close" id='close1' style="display: none" onclick="del_img();"></b>
                        <input type="hidden" value="" id="imgsrc1" name="imgsrc">
					</div>
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">法人身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" name="frontId" class="file-input4" value=""  onchange="return fileupload(2);" />
						<!--<img src="images/m4.jpg" class="" />-->
					  </div>
					  <div class="layui-input-block" id='uploadlast2' style="display:none">
                        <img src="/public/money_ex/images/main_01.gif" id="loading2" style="display: none" />
                        <span id="imgk">
                        	<img src="" id="photoImg2" style="display:none;width:100px;height:100px;"/>
                        </span>
                        <b class="close" id='close2' style="display: none" onclick="del_img();"></b>
                        <input type="hidden" value="" id="imgsrc2" name="imgsrc">
					  </div>
					  
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="backId" class="file-input4" value="" onchange="return fileupload(3);" />
						<!--<img src="images/m5.jpg" class="" />-->
					  </div>
					  <div class="layui-input-block" id='uploadlast3' style="display:none">
                        <img src="/public/money_ex/images/main_01.gif" id="loading3" style="display: none" />
                        <span id="imgk">
                        	<img src="" id="photoImg3" style="display:none;width:100px;height:100px;"/>
                        </span>
                        <b class="close" id='close3' style="display: none" onclick="del_img();"></b>
                        <input type="hidden" value="" id="imgsrc3" name="imgsrc">
					  </div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <a href="javascript:void(0);" id="submitBtn" class="layui-btn addbtn">提交</a>
					</div>
				  </div>
				  
				  
				  </div>
				  <div class="persontabs tx">
					<div class="layui-form-item">
					<label class="layui-form-label">身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" name="frontId" class="file-input4" value="" onchange="return fileupload(4);" />
						<!--<img src="images/m4.jpg" class="" />-->
					  </div>
					  <div class="layui-input-block" id='uploadlast4' style="display:none">
                        <img src="/public/money_ex/images/main_01.gif" id="loading4" style="display: none" />
                        <span id="imgk">
                        	<img src="" id="photoImg4" style="display:none;width:100px;height:100px;"/>
                        </span>
                        <b class="close" id='close4' style="display: none" onclick="del_img();"></b>
                        <input type="hidden" value="" id="imgsrc4" name="imgsrc">
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="backId" class="file-input4" value=""  onchange="return fileupload(5);"/>
						<!--<img src="images/m5.jpg" class="" />-->
					  </div>
					  <div class="layui-input-block" id='uploadlast5' style="display:none">
                        <img src="/public/money_ex/images/main_01.gif" id="loading5" style="display: none" />
                        <span id="imgk">
                        	<img src="" id="photoImg5" style="display:none;width:100px;height:100px;"/>
                        </span>
                        <b class="close" id='close5' style="display: none" onclick="del_img();"></b>
                        <input type="hidden" value="" id="imgsrc5" name="imgsrc">
					  </div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <a href="javascript:void(0);" id="submitBtn2"  class="layui-btn addbtn">提交</a>
					</div>
				  </div>
				  </div>
				  
			</form>
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
  var form = layui.form;
	form.on("radio(idtype)",function(data){
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
<script>
$(document).ready(function(){
	var flag = false;
	$("#submitBtn").click(function(){
		if($(":radio:checked").val() == 1){
    		var imgsrc1 = $('#imgsrc1').val();
    		var imgsrc2 = $('#imgsrc2').val();
    		var imgsrc3 = $('#imgsrc3').val();
    		if(imgsrc1 == ''){
        		alert("营业执照照片不能为空");
        		return false;
        	}else if(imgsrc2 == ''){
        		alert("身份证正面照不能为空");
        		return false;
            }else if(imgsrc3 == ''){
            	alert("身份证背面照不能为空");
        		return false;
             }
            flag = true;
		}else{
    		var imgsrc4 = $('#imgsrc4').val();
    		var imgsrc5 = $('#imgsrc5').val();
			if(imgsrc4 == ''){
        		alert("身份证正面照不能为空");
        		return false;
            }else if(imgsrc5 == ''){
            	alert("身份证背面照不能为空");
        		return false;
             }
			flag = true;
		}
		if(flag){
    		$("#form").submit();
		}
	});
});
</script>
 <script type="text/javascript">
 //ajax 上传图片
 function fileupload(i){
	 var loaning = 
		$("#loading"+i).show();
		$("#uploadlast"+i).show();
		$("#uploadfirst"+i).hide();
		$.ajaxFileUpload({
			url: "/sdk/index/setimg",
			secureuri:false,
			fileElementId:"file",
			dataType:"json",
			success:function(data,status) {
				if(data.status==0) {
					$("#loading"+i).hide();
					$("#uploadlast"+i).hide();
					$("#uploadfirst"+i).show();
					return false;
				}else {
					$("#loading"+i).hide();
					$("#photoImg"+i).show();
					$("#photoImg"+i).attr("src", data.url);
					$("#imgsrc"+i).val(data.url);
					$("#close"+i).show();
				}
			},
			error:function (data,status,e) {
				alert(e);
			}
		})
		return false;
  }
 </script>