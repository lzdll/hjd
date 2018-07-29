<style>
.l_tableBox2 .l_table1{width:100%;}
</style>
<div class="l_p30">
    <div class="l_tit d_tit">
        <div class="clearfix">
            <?php $this->load->view('common/menu.php') ?>
        </div>
    </div>
    <div class="t_list1 t_borderB">
    		<form class="form-horizontal" role="form" id ="form" method="post">
            <input type="hidden" id="id" name="id" value="<?=$info['id']?>" />
            <ul class="clearfix">
            <!--  
                <li>
                    <b>真实姓名：</b>
                    <input type="text" placeholder="真实姓名" class="t_input t_mr10"  name="real_name"  id="real_name" value="<?=$info['real_name']?>" />
                </li>
                <li>
                    <b>密码：</b>
                    <input type="password" placeholder="密码" class="t_input t_mr10"  name="password"  id="password" />
                </li>
                -->
                <li>
                    <b>角色：</b>
                    <select class="t_select" name="role">
                        <?php foreach($role as $v): ?>
                        <option value="<?php echo $v['id'];?>" <?php if($v['id'] == $info['role_id']){echo 'selected=selected';}?>><?php echo $v['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </li>
                <li>
                    <b>城市权限：</b>
                      <div class="centent">
                      	<?php
						$citysLeft = $citysRight = '';
                        foreach($citys as $v)
						{
							if(in_array($v['city_en'], $user_citys)) {
								$citysRight .= "<option value='{$v['city_en']}'>{$v['city_cn']}</option>";
							} else {
								$citysLeft .= "<option value='{$v['city_en']}'>{$v['city_cn']}</option>";
							}
						}
						?>
                      	<table border="0" width="300">
							<tr><td colspan=2>
							<input type="text" class="t_input t_mr10"  name="searchCity"  id="searchCity" style="width:60px" />
							<button class="l_button ylw" type="button" id="searchBtn">搜索</button>
							</td></tr>
                            <tr>
                        	<td width="40%">
                            <select multiple="multiple" id="select1" style="width:150px;height:300px;" class="t_select">
                                <?php echo $citysLeft?>
                            </select>
                            </td>
                            <td width="20%">
                            <span id="add" class="l_button2">选中&gt;&gt;</span>
                            <span id="add_all" class="l_button2" >全部选中&gt;&gt;</span>
                            <span id="remove" class="l_button2">&lt;&lt;删除</span>
                            <span id="remove_all" class="l_button2">&lt;&lt;全部删除</span>
                            </td>
                            <td width="40%">
                            <select multiple="multiple" id="select2" style="width: 150px;height:300px;" class="t_select">
                                <?php echo $citysRight?>
                            </select>
                            </td>
                        </tr>
                     </table>
                    </div>
                </li>
            </ul>
            <div class="sBtnBox">
            	<input type="hidden" id="citys" name="citys" value="" />
                 <button class="l_button grn t_mr10" type="button" id="submitBtn">
                    保存
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="l_button" type="reset" onclick="location.href='/authority/admin/index'">
                    返回
                </button>
            </div>
            </form>
    </div>
</div>
<script>

$(document).ready(function(){
	$("#submitBtn").click(function(){
		var citys = '';
	    $("#select2 option").each(function(){  //遍历所有option
	          var txt = $(this).val();   //获取option值 
	          if(txt!=''){
	               citys += txt + ',';  //添加到数组中
	          }
	    })
		citys=citys.substring(0,citys.length-1);
		$('#citys').val(citys);
		$("#form").submit();
		
	});

	$("#searchBtn").click(function(){
		var searchCityName = $("#searchCity").val();    
		if (searchCityName == "") {
			$("#select1 option").each(function() {
				$(this).show();
			});
			return ;
		} else {
			$("#select1 option").each(function() {
				var en = $(this).val();            
				var cn = $(this).text(); 
				if (en.indexOf(searchCityName) != -1 || cn.indexOf(searchCityName) != -1) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		}
	});
});

//城市选择
$(function(){
    //移到右边
    $('#add').click(function() {
    //获取选中的选项，删除并追加给对方
        $('#select1 option:selected').appendTo('#select2');
    });
    //移到左边
    $('#remove').click(function() {
        $('#select2 option:selected').appendTo('#select1');
    });
    //全部移到右边
    $('#add_all').click(function() {
        //获取全部的选项,删除并追加给对方
        $('#select1 option').appendTo('#select2');
    });
    //全部移到左边
    $('#remove_all').click(function() {
        $('#select2 option').appendTo('#select1');
    });
    //双击选项
    $('#select1').dblclick(function(){ //绑定双击事件
        //获取全部的选项,删除并追加给对方
        $("option:selected",this).appendTo('#select2'); //追加给对方
    });
    //双击选项
    $('#select2').dblclick(function(){
       $("option:selected",this).appendTo('#select1');
    });
});
</script>
