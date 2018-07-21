<!-- 内容主体区域 -->
<script type="text/javascript" src="/public/static/js/jquery-3.2.0.min.js"></script>
	<div class="postnav">财务 - 充值列表 - <span class="">为广告主充值</span></div>
	<div class="layuibodycont">
		<div class="clearfix formblock">
			<p class="formtitle">充值</p>
			<form class="layui-form autoform" role="form" id ="form" method="post">
				<div class="layui-form-item">
					<label class="layui-form-label">金额：</label>
					<div class="layui-input-block">
					  <input type="text" name="money"  placeholder="" id="money" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">选择广告主：</label>
					<div class="layui-input-block">
					 <select name="owner" id="owner" lay-filter="aihao">
						<?php foreach($list as $v): ?>
                        <option value="<?php echo $v['code'];?>"><?php echo $v['code'];?></option>
                        <?php endforeach; ?>
					  </select>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">汇款银行：</label>
					<div class="layui-input-block">
					  <input type="text" name="bank"  id="bank" placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">银行卡号：</label>
					<div class="layui-input-block">
					  <input type="text" name="cardid"  id="cardid" placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">汇款单号：</label>
					<div class="layui-input-block">
					  <input type="text" name="tradid"  id="tradid" placeholder="" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">状态：</label>
					<div class="layui-input-block">
					   <select class="t_select" name="status">
							<option value="0">已充值</option>
							<option value="1">未充值</option>
						</select>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">财务备注：</label>
					<div class="layui-input-block">
					  <input type="text" name="comment"  id="comment" placeholder="" class="layui-input"/>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">充值类型：</label>
					<div class="layui-input-block">
					  <span class="typepan">现金</span>
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
						<button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/finance/index/lists'">
						取消
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1" type="button" id="submitBtn">充值</button>

					</div>
				  </div>
			</form>
		</div>
    </div>
  </div>
 <script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		var money = $('#money').val();
		var owner = $('#owner').val();
		var bank = $('#bank').val();
		var cardid = $('#cardid').val();
		var tradid = $('#tradid').val();
		if(money == '')
		{
			alert("金额不能为空！");
			return false;
		} else if(owner == ''){
			alert("选择广告主不能为空！");
			return false;
		} else if(bank == ''){
			alert("汇款银行不能为空！");
			return false;
		} else if(cardid == ''){
			alert("银行卡号不能为空！");
			return false;
		} else if(tradid == ''){
			alert("汇款单号不能为空！");
			return false;
		} else {
			$("#form").submit();
		}
	});
});
</script>
