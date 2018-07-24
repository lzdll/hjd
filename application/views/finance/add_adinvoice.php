    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<p class="formtitle">开发票</p>
			<form class="layui-form autolayblock" action="add_adinvoice" method="post">
				<div class="layui-form-item">
					<label class="layui-form-label">公司抬头：</label>
					<div class="layui-input-block">
					  <input lay-verify="required" type="text" name="title"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">税号：</label>
					<div class="layui-input-block">
					  <input type="text" lay-verify="required" name="invoiceid"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">发票金额：</label>
					<div class="layui-input-block">
					  <input type="text" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,2})?/)" lay-verify="required" name="amount"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">备注：</label>
					<div class="layui-input-block">
					  <input type="text" lay-verify="required" name="contact"  placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/finance/index/adinvoice'" >取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">确认</button>
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
</body>
</html>
