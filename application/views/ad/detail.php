    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form autolayblock">
				<div class="layui-form-item">
					<label class="layui-form-label">广告名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="" value="<?php echo $info['name'] ;?>" class="layui-input" disabled />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告导语：</label>
					<div class="layui-input-block">
						<div class="areabox">
						  <textarea class="" disabled><?php echo $info['info'] ;?></textarea>
						</div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label idcard">选择投放平台：</label>
					<div class="layui-input-block">
					  <input type="radio" name="sex" value="01" title="H5" disabled lay-filter="idtype" <?php echo $info['cheack1'] ;?>  >
					  <input type="radio" name="sex" value="02" lay-filter="idtype" disabled  title="android apk" <?php echo $info['cheack2'] ;?>  >
					  <input type="radio" name="sex" value="03" lay-filter="idtype" disabled title="小程序" <?php echo $info['cheack3'] ;?> >
					</div>
				  </div>
				  <div class="persontabs02 tx on">
				   <div class="layui-form-item">
					<label class="layui-form-label"><?php echo  $info['linkname'];?></label>
					<div class="layui-input-block">
						<input type="text" name="title" placeholder="" class="layui-input" value="<?php echo $info['link'] ;?>" disabled />
					</div>
				  </div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">点击单价：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="" value="￥<?php echo $info['price'] ;?>" class="layui-input " disabled />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper">
						<img src="<?php echo $info['icon'] ;?>" class="" />
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
						<img src="<?php echo $info['image'] ;?>" class="" />
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
						<img src="<?php echo $info['banner'] ;?>" class="" />
					  </div>
					  <!--<span class="addfilespro grayfont">建议上传750*180像素的图片</span>-->
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <a class="layui-btn addbtn" href="lists">返回</a>
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
