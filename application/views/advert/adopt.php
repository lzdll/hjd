 <!-- 内容主体区域 -->
	<div class="postnav">广告管理 - <span class="">广告审核</span></div>
	<script src="/public/money_ex/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="/public/money_ex/js/ajaxfileupload.js" type="text/javascript"></script>
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form autoform" role="form" id ="form" method="post"  enctype="multipart/form-data">
				<div class="layui-form-item">
					<label class="layui-form-label">广告名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" placeholder="<?=$list['name']?>" disabled class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告导语：</label>
					<div class="layui-input-block">
						<div class="areabox">
						  <textarea disabled class="" ><?=$list['info']?></textarea>
						</div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">平台类型：</label>
					<div class="layui-input-block">
					  <input type="radio" name="sex" value="01" title="H5" <?php if($list['platform']=='H5'){ echo "checked='checked'";} ?>disabled />

					  <input type="radio" name="sex" value="02" title="android APK" <?php if($list['platform']=='wechat'){ echo "checked='checked'";} ?>disabled />

					  <input type="radio" name="sex" value="04" title="ios" <?php if($list['platform']=='wechat'){ echo "checked='checked'";} ?>  disabled />
					  <input type="radio" name="sex" value="03" title="小程序" <?php if($list['platform']=='wechat'){ echo "checked='checked'";} ?>  disabled />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">小程序路径：</label>
					<div class="layui-input-block">
						<input type="text" name="title"  placeholder="<?=$list['link']?>" disabled class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">点击单价：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" placeholder="" value="<?=$list['price']?>" class="layui-input putprice" disabled>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">CMP：</label>
					<div class="layui-input-block">
					  <input type="text" name="title" placeholder="￥<?=$list['cmp_price']?>" class="layui-input" disabled />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper">
						<img src="<?=$list['icon']?>" />
					  </div>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">广告图：</label>
					<div class="layui-input-block">
					  <div class="adbanner">
						<img src="<?=$list['image']?>" />
					  </div>
					</div>
				  </div>
				   
				  <hr class="line"/>
				  <?php  if($bdinfo['name']){ ?>
				  <div class="layui-form-item">
					<label class="layui-form-label" style="color:#666666;">SDK：</label>
					<div class="layui-input-block">
					  <span class="bindbtn">绑定</span>
					</div>
				  </div>
				  <div class="hidebox on">
				  <div class="layui-form-item">
					<label class="layui-form-label">SDK名称：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="name" disabled class="layui-input"  value="<?php  echo $bdinfo['name'];?>"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">URL：</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="<?php  echo $bdinfo['url'];?>" disabled class="layui-input" value="<?php  echo $bdinfo['url'];?>"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">小程序ID</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="小程序ID" disabled class="layui-input" value="<?php  echo $bdinfo['sappid'];?>"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">APP ID</label>
					<div class="layui-input-block">
					  <input type="text" name="title"  placeholder="APP ID" disabled class="layui-input" value="<?php  echo $bdinfo['appid'];?>"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">icon：</label>
					<div class="layui-input-block">
					  <div class="file-input-wrapper">
						<img src="<?php  echo $bdinfo['icon'];?>" />
					  </div>
					</div>
				  </div>
				  </div>
				  <?php }else{ ?>
					  <div class="layui-form-item">
						<label class="layui-form-label" style="color:#666666;">SDK：</label>
						<div class="layui-input-block">
						  <a href="/advert/index/binding?code=<?php echo $list['code'] ?>&id=<?php echo $list['id'] ?>"><span class="bindbtn">绑定</span></a>
						</div>
					  </div>
				 <?php } ?>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					<button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/advert/index/lists'">
						取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" onclick="location.href='/advert/index/adopts?id=<?php echo $list['id'] ?>'">通过审核</button>
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

<script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		$("#form").submit();
			
	});
});
</script>