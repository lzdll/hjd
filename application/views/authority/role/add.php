<style>
.l_tableBox2 .l_table1{width:100%;}
</style>
<link rel="stylesheet" href="/public/static/styles/styles.css">
<script type="text/javascript" src="/public/static/js/jquery-3.2.0.min.js"></script>
<div class="l_p30">
    <div class="l_tit d_tit">
        <div class="clearfix">
            <?php $this->load->view('common/menu.php') ?>
        </div>
    </div>
    <div class="t_list1 t_borderB">
    		<form class="form-horizontal" role="form" id ="form" method="post">
            <ul class="clearfix">
                <li>
                    <b>角色名称：</b>
                    <input type="text" placeholder="名称" class="t_input t_mr10"  name="name"  id="name" />
                </li>
            </ul>
            <div class="layui-input-block formopearbtn">
                 <button class="layui-btn addbtn" type="button" id="submitBtn">
                    保存
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="layui-btn layui-btn-primary resetbtn" type="reset" onclick="location.href='/authority/role/index'">
                    返回
                </button>
            </div>
            </form>
    </div>
</div>
<script>

$(document).ready(function(){
	$("#submitBtn").click(function(){
		var name = $('#name').val();
		if(name == '')
		{
			alert("请添加名称！");
			return false;
		}
		else
		{
			// 对群组名进行js校验
			len = getStrLen(name);
			if (len > 20)
			{
				alert('名长度超过最大限制！');
				return false;
			}
			var reg = /[^a-zA-Z0-9\u4E00-\u9FA5\-\_]/g;
			if (reg.test(name))
			{
				alert('名称只能输入字母、汉字、数字、"-"、"_"');
				return false;
			}
		} 	
		$("#form").submit();
	});
});
</script>