<div class="layuibodycont">
		<div class="tips"><img src="/public/money_ex/images/lc06.png" />提交公司资质后才可投放广告</div>
		<div class="clearfix formblock">
			<form class="layui-form compform" action="promoter" method="post" enctype="multipart/form-data">
				<p class="formtitle">账号信息</p>
				<div class="layui-form-item">
					<label class="layui-form-label">手机号：</label>
					<div class="layui-input-block">
					   <input type="text" name="title" value="<?php echo $user['phone'];?>" disabled class="layui-input putpros"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">邮箱：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" value="<?php echo $user['email'];?>" disabled class="layui-input putpros"/>
					</div>
				  </div>
				  
				  
				<p class="formtitle">公司资质</p> 
				<div class="layui-form-item">
					<label class="layui-form-label idcard">身份类型：</label>
					<div class="layui-input-block">
					  <input type="radio" disabled  name="type" value="1" title="公司企业广告主" <?php echo $compaycheack;?>  lay-filter="idtype" >
					  <input type="radio" disabled name="type" value="2" lay-filter="idtype"  <?php echo $personcheack;?> title="个人广告主" >
					</div>
				  </div>
				  <div class="comtabs tx <?php echo $compaystyle;?>">
				  <div class="layui-form-item">
					<label class="layui-form-label">企业名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="name" disabled placeholder="输入公司名称" value="<?php echo $company['name'];?>" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item" >
					<label class="layui-form-label">营业执照：</label>
					<div class="layui-input-block">
					<!--未传图片之前的样式-->
					  <div class="file-input-wrapper4 layuiitempic">
						<img src="<?php echo $company['bs_license_img'];?>" class="" id="xmTanImg5" />
					  </div>
					  <!--上传图片之后的样式-->
<!--						<div class="file-input-wrapper4 layuiitempic" id="up5">-->
<!--						<img src="" class="" id="xmTanImg5" />-->
<!--					  </div>-->
					</div>
				  </div>
				  
				  <div class="layui-form-item">
					<label class="layui-form-label">法人身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" name="imgsrc2" class="file-input4" value="" />
						<img id="xmTanImg4" src="<?php echo $company['id_card_img_1'];?>" class=""  />
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="imgsrc3" class="file-input4" value="" />
						<img id="xmTanImg3" src="<?php echo $company['id_card_img_2'];?>" class="" />
					  </div>
					</div>
				  </div>
				  </div>
<!--               个人-->
				  <div class="persontabs tx <?php echo $personstyle;?>">
					<div class="layui-form-item">
					<label class="layui-form-label">身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" name="imgsrc4" class="file-input4" value=""  />
						<img  id="xmTanImg2" src="<?php echo $company['id_card_img_1'];?>" class=""  />
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="imgsrc5" class="file-input4" value="" />
						<img id="xmTanImg1" src="<?php echo $company['id_card_img_2'];?>" class=""  />
					  </div>
					</div>
				  </div>
				  </div>
				  
				  
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
                        <button class="layui-btn addbtn"><a href="/myad/index/index" >返回</a></button>
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