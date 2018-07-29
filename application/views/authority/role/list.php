<style>
.l_tableBox2 .l_table1{width:100%;}
</style>
<div class="l_p30">
    <div class="l_tit d_tit">
        <div class="clearfix">
            <?php $this->load->view('common/menu.php') ?>
        </div>
    </div>
    <div class="d-topmain">
    	<a href="/authority/role/add" class="l_button ylw">添加</a>
    </div>
    <div class="d_tableBox">
        
        <div class="l_tableBox2">
            <table class="l_table1">
                <tbody><tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                <?php foreach ($list as $v){ ?>
                <tr>
                    <td><?=$v['id']?></td>
                    <td><?=$v['name']?></td>
                    <td>
                        <div class="l_tableBtnBox">
                        <a href="/authority/role/edit?id=<?=$v['id']?>">修改</a>
                        <a href="/authority/role/del?id=<?=$v['id']?>" onClick="if(confirm('确认删除？'))returntrue; return false;" >删除</a>
                        <a href="/authority/role/rights?id=<?=$v['id']?>">权限</a>
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