<div class="layuibodycont">
		<div class="clearfix formblock">
			<form class="layui-form compform" action="/withdraw/index/apply" method="post" id="withdraw_apply_from">
				<p class="formtitle">提现申请</p>
				<div class="layui-form-item">
					<label class="layui-form-label">提现金额：</label>
					<div class="layui-input-block">
					  <input type="text" name="money"  placeholder="请输入金额" class="layui-input fl" lay-verify="required|validateMoney" style="width:50%;" />
					  <p class="fl inputtips">可提现金额 <?php echo $accountinfo['money'];?>元</p>
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">银行卡号：</label>
					<div class="layui-input-block">
					  <input type="text" name="bank_card"  placeholder="银行卡号"  lay-verify="required|validateCard" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">银行：</label>
					<div class="layui-input-block">
					  <input type="text" name="bank_name"  placeholder="银行名称"  lay-verify="required"  autocomplete="off" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<label class="layui-form-label">备注：</label>
					<div class="layui-input-block">
					  <input type="text" name=remarks  placeholder="备注" class="layui-input" />
					</div>
				  </div>
				  <div class="layui-form-item">
					<div class="layui-input-block formopearbtn">
					  <button class="layui-btn layui-btn-primary resetbtn">取消</button>
					  <button class="layui-btn addbtn" lay-submit="" lay-filter="demo1">确认</button>
					</div>
				  </div>
			</form>
		</div>
   
    </div>

<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script>
	layui.use(['form', 'layedit', 'laydate'], function(){
		var form = layui.form
				,layer = layui.layer
				,layedit = layui.layedit
				,laydate = layui.laydate;
		//自定义验证规则
			form.verify({
	          validateMoney: function (value) {
	              var result = validateMoney(value);
	              if (result != "Y") {
	                  return result;
	              }
	          },
	          validateCard:function(value) {
	              var resultcard = validateCard(value)
	          	if (resultcard != "Y") {
	                  return resultcard;
	              }
	          }
	        });
	});
</script>
<script>
	layui.use(['form', 'layedit', 'laydate'], function(){
      var form = layui.form()
              ,layer = layui.layer
              ,layedit = layui.layedit
              ,laydate = layui.laydate;
    //自定义验证规则
        form.verify({
          validateMoney: function (value) {
              var result = validateMoney(value);
              if (result != "Y") {
                  return result;
              }
          },
          validateCard:function(value) {
              var resultcard = validateCard(value)
          	if (resultcard != "Y") {
                  return resultcard;
              }
          }
        });
        //监听提交
        form.on('submit(demo1)', function (data) {
          layer.alert(JSON.stringify(data.field), {
              $('#withdraw_apply_from').submit();
          })
          return false;
        });
    });
 </script>
<script>
/**
 * 金额校验
 * @param money
 * @returns {*}
 */
function validateMoney(money) {
	
	var withdraw_money = <?php echo $accountinfo['money'];?>;
    var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
    if (reg.test(money) && money*100 <= withdraw_money) {
        return "Y";
    }else if(!reg.test(money)){
    	return "请输入正确的金额,且最多两位小数!";
    }else{
    	return "金额大于可提现金额!";
    }
    
}
/**
 * 银行卡号效验
 */
function validateCard(card){
	var reg = /^([1-9]{1})(\d{14}|\d{18})$/;
    if (reg.test(card)) {
        return "Y";
    }
    return "请输入正确的银行卡号";
}
</script>


