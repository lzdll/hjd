    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form autolayblock">
				<div class="layui-form-item">
					<label class="layui-form-label">广告名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="米家小程序" class="layui-input" disabled />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告导语：</label>
					<div class="layui-input-block">
						<div class="areabox">
						  <textarea class="" disabled>别只看本品价高，若购买便宜的热水器，会使你陷入水深火热之中。</textarea>
						</div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label idcard">选择投放平台：</label>
					<div class="layui-input-block">
					  <input type="radio" name="sex" value="01" title="H5" disabled lay-filter="idtype" >
					  <input type="radio" name="sex" value="02" lay-filter="idtype" disabled  title="android apk" >
					  <input type="radio" name="sex" value="03" lay-filter="idtype" disabled title="小程序" checked >
					</div>
				  </div>
				  <div class="comtabs tx">
				  <div class="layui-form-item">
					<label class="layui-form-label">推广链接：</label>
					<div class="layui-input-block">
						<input type="text" name="title"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  </div>
				  <div class="persontabs tx">
				   <div class="layui-form-item">
					<label class="layui-form-label">下载推广地址：</label>
					<div class="layui-input-block">
						<input type="text" name="title"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  </div>
				  <div class="persontabs02 tx on">
				   <div class="layui-form-item">
					<label class="layui-form-label">小程序路径：</label>
					<div class="layui-input-block">
						<input type="text" name="title" placeholder="" class="layui-input" value="https://www.baidu.com/s" disabled />
					</div>
				  </div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">点击单价：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="" value="0.5" class="layui-input putprice" disabled />
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper">
						<input type="button" class="file_btn" value="" />
						<input type="file" class="file-input" value="" />
						<img src="/public/money_ex/images/dot003.png" class="" />
					  </div>
					 <!--<span class="addfilespro grayfont">建议上传100*100像素的图片</span>--> 
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告图：</label>
					<div class="layui-input-block">
					  <!--上传图片之前的样式
					  <div class="file-input-wrapper3 adbanner">
						<input type="button" class="file_btn3" value="" />
						<input type="file" class="file-input3" value="" />
					  </div>-->
					  <!--上传图片之后的样式-->
					  <div class="file-input-wrapper3 adbanner">
						<input type="button" class="file_btn3" value="" />
						<input type="file" class="file-input3" value="" />
						<img src="/public/money_ex/images/m.jpg" class="" />
					  </div>
					  <!--<span class="addfilespro grayfont">建议上传470*360像素的图片</span>-->
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">banner图：</label>
					<div class="layui-input-block banerwrap">
					  <!--上传图片之前的样式-->
					  <!--<div class="file-input-wrapper5 adbanner">
						<input type="button" class="file_btn5" value="" />
						<input type="file" class="file-input5" value="" />
					  </div>-->
					  <!--上传图片之后的样式-->
					  <div class="file-input-wrapper5 adbanner">
						<input type="button" class="file_btn5" value="" />
						<input type="file" class="file-input5" value="" />
						<img src="/public/money_ex/images/m6.jpg" class="" />
					  </div>
					  <!--<span class="addfilespro grayfont">建议上传750*180像素的图片</span>-->
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <a class="layui-btn addbtn" href="page-1-广告主2广告_1.html">返回</a>
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
  });
</script>
</body>
</html>
