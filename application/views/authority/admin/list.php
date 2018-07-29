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
    <!--  
    <div class="d-topmain">
    	<a href="/authority/admin/add" class="l_button ylw">添加</a>
    </div>
    -->
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
                    <input class="d-inp" type="text" name="employee_email" value="<?=$filters['default']['employee_email']?>">
                </div>
                <div class="d-box">
                    <label>真实姓名：</label>
                    <input class="d-inp" type="text" name="truename" value="<?=$filters['default']['truename']?>">
                </div>
				<div class="d-box">
                    <label>城市：</label>
                    <select class="d-select select" name="city_en">
                        <option value="">不限</option>
                        <?php foreach($filters['citys'] as $k=>$v): ?>
                        <option value="<?php echo $v['city_en'];?>" <?php if($filters['default']['city_en'] == $v['city_en']){?> selected="selected"<?php } ?>><?php echo $v['city_en'];?> - <?php echo $v['city_cn'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
				<div class="d-box">
                    &nbsp;&nbsp;<button class="l_button ylw" type="button" id="submitBtn">查 询</button>
                </div>
            </li>
        </ul>
        </form>
    </div>
    <div class="d_tableBox">
        
        <div class="l_tableBox2">
            <table class="l_table1">
                <tbody><tr>
                    <th>ID</th>
                    <th>邮箱</th>
                    <th>真实姓名</th>
                    <th>操作</th>
                </tr>
                <?php foreach ($list as $v){ ?>
                <tr>
                    <td><?=$v['id']?></td>
                    <td><?=$v['employee_email']?></td>
                    <td><?=$v['truename']?></td>
                    <td>
                        <div class="l_tableBtnBox">
                        <a href="/authority/admin/edit?id=<?=$v['id']?>">修改</a>
                        <a href="/authority/admin/del?id=<?=$v['id']?>" onClick="if(confirm('确认删除？'))returntrue; return false;" >删除</a>
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
	$('.select').searchableSelect(); // 下拉框支持搜索

	// 搜索
	$("#submitBtn").click(function(){
		$('#myform').attr('action','/authority/admin/index');
        $('#myform').submit();
	});
});
</script>

