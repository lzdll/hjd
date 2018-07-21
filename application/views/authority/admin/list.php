
 <div class="postnav"><?php $this->load->view('common/menu.php') ?></div>
	<div class="layuibodycont">

<div class="clearfix sdktop">
			<a href="/authority/admin/add"><span class="addads">添加</span></a>
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

