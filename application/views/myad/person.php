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
					  <input type="radio" name="type" value="1" title="公司企业广告主" checked="" lay-filter="idtype" >
					  <input type="radio" name="type" value="0" lay-filter="idtype"  title="个人广告主" >
					</div>
				  </div>
				  <div class="comtabs tx on">
				  <div class="layui-form-item">
					<label class="layui-form-label">企业名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="name" placeholder="输入公司名称" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">营业执照：</label>
					<div class="layui-input-block">
					<!--未传图片之前的样式-->
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="上传营业执照" />
						<input type="file" name="imgsrc1" class="file-input4" value="" onchange="xmTanUploadImg5(this)" />
						<img src="" class="" id="xmTanImg5" />
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
						<input type="file" name="imgsrc2" class="file-input4" value="" onchange="xmTanUploadImg4(this)" />
						<img id="xmTanImg4" src="" class=""  />
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="imgsrc3" class="file-input4" value="" onchange="xmTanUploadImg3(this)" />
						<img id="xmTanImg3" src="" class="" />
					  </div>
					</div>
				  </div>
				  </div>
<!--               个人-->
				  <div class="persontabs tx">
					<div class="layui-form-item">
					<label class="layui-form-label">身份证：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证正面" />
						<input type="file" name="imgsrc4" class="file-input4" value="" onchange="xmTanUploadImg2(this)" />
						<img  id="xmTanImg2" src="" class=""   />
					  </div>
					  <div class="file-input-wrapper4 layuiitempic">
						<input type="button" class="file_btn4" value="身份证反面" />
						<input type="file" name="imgsrc5" class="file-input4" value="" onchange="xmTanUploadImg1(this)"/>
						<img id="xmTanImg1" src="" class=""  />
					  </div>
					</div>
				  </div>
				  </div>
				  
				  
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
                        <button class="layui-btn addbtn"><a href="javascript:void(0);" >提交</a></button>
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
<script type="text/javascript">
    $("#xmTanImg5").hide();
    $("#xmTanImg4").hide();
    $("#xmTanImg3").hide();
    $("#xmTanImg2").hide();
    $("#xmTanImg1").hide();
    //判断浏览器是否支持FileReader接口
    if (typeof FileReader == 'undefined') {
//		document.getElementById("xmTanDiv").InnerHTML = "<h1>当前浏览器不支持FileReader接口</h1>";
        document.getElementById("xmTanDiv").InnerHTML = "<h1>当前浏览器不支持图片预览</h1>";
        //使选择控件不可操作
        document.getElementById("xdaTanFileImg").setAttribute("disabled", "disabled");
    }

    //选择图片，马上预览
    function xmTanUploadImg5(obj) {
        var file = obj.files[0];
        var reader = new FileReader();

        //读取文件过程方法
        reader.onloadstart = function (e) {
        }
        reader.onprogress = function (e) {
        }
        reader.onabort = function (e) {
        }
        reader.onerror = function (e) {
        }
        reader.onload = function (e) {
            $("#xmTanImg5").show();
            var img = document.getElementById("xmTanImg5");
            img.src = e.target.result;
            //或者 img.src = this.result;  //e.target == this
        }

        reader.readAsDataURL(file)
    }
    function xmTanUploadImg4(obj) {
        var file = obj.files[0];
        var reader = new FileReader();

        //读取文件过程方法
        reader.onloadstart = function (e) {
        }
        reader.onprogress = function (e) {
        }
        reader.onabort = function (e) {
        }
        reader.onerror = function (e) {
        }
        reader.onload = function (e) {
            $("#xmTanImg4").show();
            var img = document.getElementById("xmTanImg4");
            img.src = e.target.result;
            //或者 img.src = this.result;  //e.target == this
        }

        reader.readAsDataURL(file)
    }
    function xmTanUploadImg3(obj) {
        var file = obj.files[0];
        var reader = new FileReader();

        //读取文件过程方法
        reader.onloadstart = function (e) {
        }
        reader.onprogress = function (e) {
        }
        reader.onabort = function (e) {
        }
        reader.onerror = function (e) {
        }
        reader.onload = function (e) {
            $("#xmTanImg3").show();
            var img = document.getElementById("xmTanImg3");
            img.src = e.target.result;
            //或者 img.src = this.result;  //e.target == this
        }

        reader.readAsDataURL(file)
    }
    function xmTanUploadImg2(obj) {
        var file = obj.files[0];
        var reader = new FileReader();

        //读取文件过程方法
        reader.onloadstart = function (e) {
        }
        reader.onprogress = function (e) {
        }
        reader.onabort = function (e) {
        }
        reader.onerror = function (e) {
        }
        reader.onload = function (e) {
            $("#xmTanImg2").show();
            var img = document.getElementById("xmTanImg2");
            img.src = e.target.result;
            //或者 img.src = this.result;  //e.target == this
        }

        reader.readAsDataURL(file)
    }

    function xmTanUploadImg1(obj) {
        var file = obj.files[0];
        var reader = new FileReader();

        //读取文件过程方法
        reader.onloadstart = function (e) {
        }
        reader.onprogress = function (e) {
        }
        reader.onabort = function (e) {
        }
        reader.onerror = function (e) {
        }
        reader.onload = function (e) {
            $("#xmTanImg1").show();
            var img = document.getElementById("xmTanImg1");
            img.src = e.target.result;
            //或者 img.src = this.result;  //e.target == this
        }

        reader.readAsDataURL(file)
    }
</script>