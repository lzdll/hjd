    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form autolayblock " id="addsubmit" action="add" enctype="multipart/form-data" method="post">
				<div class="layui-form-item">
					<label class="layui-form-label">广告名称：</label>
					<div class="layui-input-block">
					  <input lay-verify="required" type="text" name="title"  placeholder="请输入广告名称：比如米家小程序" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告导语：</label>
					<div class="layui-input-block">
						<div class="areabox">
						  <textarea  class="" name="contact" lay-verify="required" placeholder="请输入广告导语"></textarea>
						</div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label idcard">选择投放平台：</label>
					<div class="layui-input-block">
					  <input type="radio"  name="platform" value="1"   title="H5" lay-filter="idtype" >
					  <input type="radio"  name="platform" value="2" lay-filter="idtype"  title="android apk" >
					  <input type="radio" name="platform" value=" 3" lay-filter="idtype"  title="小程序" >
					</div>
				  </div>
				  <div class="comtabs tx" style="display: block;">
				  <div class="layui-form-item">
					<label class="layui-form-label">推广链接：</label>
					<div class="layui-input-block">
						<input type="text"  name="link1"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  </div>
				  <div class="persontabs tx">
				   <div class="layui-form-item">
					<label class="layui-form-label">下载推广地址：</label>
					<div class="layui-input-block">
						<input type="text"  name="link2"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  </div>
				  <div class="persontabs02 tx">
				   <div class="layui-form-item">
					<label class="layui-form-label">小程序路径：</label>
					<div class="layui-input-block">
						<input type="text"  name="link3"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">点击单价：</label>
					<div class="layui-input-block">
					  <input type="text" name="price" lay-verify="required"  placeholder="" value="0.50" class="layui-input putprice" />
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					<!--上传图片之前的样式-->
					  <div class="file-input-wrapper">
						<input type="button" name="file1" class="file_btn" value="" />
						<input type="file"  lay-verify="required" name="file1" class="file-input" value="" />
					  </div>
					  <!--上传图片之后的样式
					  <div class="file-input-wrapper">
						<input type="button" class="file_btn" value="" />
						<input type="file" class="file-input" value="" />
						<img src="images/dot003.png" class="" />
					  </div>-->
					  <span class="addfilespro grayfont">建议上传100*100像素的图片</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告图：</label>
					<div class="layui-input-block">
					  <!--上传图片之前的样式-->
					  <div class="file-input-wrapper3">
						<input type="button" class="file_btn3" value="" />
						<input type="file" lay-verify="required" name="file2" class="file-input3" value="" />
					  </div>
					  <!--上传图片之后的样式
					  <div class="file-input-wrapper3 adbanner">
						<input type="button" class="file_btn3" value="" />
						<input type="file" class="file-input3" value="" />
						<img src="images/m.jpg" class="" />
					  </div>-->
					  <span class="addfilespro grayfont">建议上传470*360像素的图片</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">banner图：</label>
					<div class="layui-input-block banerwrap">
					  <!--上传图片之前的样式-->
					  <div class="file-input-wrapper5 ">
						<input type="button" class="file_btn5" value="" />
						<input type="file" lay-verify="required" name="file3"  class="file-input5" value="" />
					  </div>
					  <!--上传图片之后的样式-->
					 <!-- <div class="file-input-wrapper4 adbanner">
						<input type="button" class="file_btn4" value="" />
						<input type="file" class="file-input4" value="" />
						<img src="images/m.jpg" class="" />
					  </div>-->
					  <span class="addfilespro grayfont">建议上传750*180像素的图片</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">提交</button>
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
			$(".persontabs02").hide();
		}else if(data.value == 02){
			$(".comtabs").hide();
			$(".persontabs").show();
			$(".persontabs02").hide();
		}else if(data.value == 03){
			$(".comtabs").hide();
			$(".persontabs").hide();
			$(".persontabs02").show();
		}
	});
	form.verify({
		 file: function(value){
			if(value.length < 0){
				return '上传icon图';
			}
		}
	});
  });

</script>
</body>
</html>
