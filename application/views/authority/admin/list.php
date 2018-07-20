<style>
.l_tableBox2 .l_table1{width:100%;}
.d-formbox li label{ width:120px}
</style>

<div class="l_p30">
    <div class="l_tit d_tit">
        <div class="clearfix">
            <?php $this->load->view('common/menu.php') ?>
        </div>
    </div>
   

<link rel="stylesheet" href="/public/static/styles/styles.css">
<script type="text/javascript" src="/public/static/js/jquery-3.2.0.min.js"></script>
    <div class="d-topmain">
    	<form method="get" id="myform">
        <ul class="d-formbox d-mt20">
            <li class="clearfix">
                <div class="d-box">
                    <label>ID：</label>
                    <input class="d-inp" type="text" name="id" value="<?=$filters['default']['id']?>" >
                </div>
				<div class="d-box">
                    <label>邮箱：</label>
                    <input class="d-inp" type="text" name="email" value="<?=$filters['default']['email']?>">
                </div>
              
				
				<div class="d-box">
                    &nbsp;&nbsp;<button class="layui-btn addbtn" type="button" id="submitBtn">查 询</button>
					<a href="/authority/admin/add" class="addads" style="margin-left:900px;">添加</a>
                </div>
            </li>
        </ul>
        </form>
    </div>
    <div class="d_tableBox">
        
        <div class="l_tableBox2">
            <table class="layui-table">
				<thead>
					<tr>
					 <th>ID</th>
						<th>登录名</th>
						<th>编码</th>
						<th>手机号</th>
						<th>邮箱</th>
						<th>状态</th>
						<th>操作</th>
					</tr> 
				  </thead>
                <tbody>
                <?php foreach ($list as $v){ ?>
                <tr>
                    <td><?=$v['id']?></td>
					
					<td><?=$v['login_name']?></td>
					<td><?=$v['code']?></td>
					<td><?=$v['phone']?></td>
                    <td><?=$v['email']?></td>
					<td><?php if($v['status'] == 0 ){ echo "有效"; }else{ echo "无效";} ?></td>
                   
                    <td>
                        <div >
                        <a href="/authority/admin/edit?id=<?=$v['id']?>" class="tdfont01">修改</a>
                        <a href="/authority/admin/del?id=<?=$v['id']?>" class="tdfont01" onClick="if(confirm('确认删除？'))returntrue; return false;" >删除</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody></table>
        </div>
        <div class="y_pagebox d-mt20">
        	<?php $this->load->view('common/page.php') ?> 
        </div>
    </div>
</div>
<script>

$(document).ready(function(){
	$("#submitBtn").click(function(){
		$('#myform').attr('action','/authority/admin/index');
        $('#myform').submit();
	});
});
</script>

