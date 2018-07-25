    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form compform" method="post" action="/myad/index/intercalate">
				<p class="formtitle">设置广告位</p>
				<div class="layui-form-item">
					<label class="layui-form-label">广告位ID：</label>
					<div class="layui-input-block">
					  <p class="fl inputtips"><?php echo $info['code']?></p>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">服务器地址：</label>
					<div class="layui-input-block">
					  <input type="text" name="serviceUrl" value="<?php echo $info['serviceUrl']; ?>" placeholder="" class="layui-input" lay-verify="required"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">密钥：</label>
					<div class="layui-input-block">
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <input type="text" name="secretkey"  value="<?php echo $info['serviceUrl']; ?>" id="secretkey" placeholder="" class="layui-input miyaoput" lay-verify="required"/>
					  <span class="layui-btn layui-btn-primary" id='reset'>重置</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">保存</button>
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
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  //总页数低于页码总数
  laypage.render({
    elem: 'demo0'
    ,count: 50 //数据总数
  });
  });
  </script>
<script type="text/javascript">
    $(document).ready(function(e){
        /*点击删除 清空输入框的内容*/
        $('#reset').click(function(){
            $('#secretkey').val('');
        });
    });
</script>