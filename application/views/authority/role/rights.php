<style>
.l_tableBox2 .l_table1{width:100%;}
</style>
<?php

?>
<div class="l_p30">
    <div class="l_tit d_tit">
        <div class="clearfix">
            <?php $this->load->view('common/menu.php') ?>
        </div>
    </div>
	<link rel="stylesheet" href="/public/static/styles/styles.css">
	<script type="text/javascript" src="/public/static/js/jquery-3.2.0.min.js"></script>
    <div class="d_tableBox">
        
        <div class="l_tableBox2">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller"></h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <div id="container">        </div>
                        </div>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-4 col-md-9">
                            <button id="btnSubmit" type="button" class="layui-btn addbtn">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                保存
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- page specific plugin scripts -->
<link rel="stylesheet" href="/public/libs/jstree/themes/default/style.min.css" />
<script src="/public/libs/jstree/jstree.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
$(function() {	
	$('#container').jstree({'plugins':["wholerow","checkbox"], 'core' : {
		'data' : [
			<?php foreach($rights as $k=>$v){ ?>
				<?php if(!empty($v['child'])){?>
				{
					"id" : "<?=$k?>",
					"text" : "<?=$v['name']?>",
					"state" : { "opened" : true, <?php if (in_array($k, $info['operate_rights_arr'])) { ?>"checked" : true<?php }else{ ?>"checked" : false<?php }?> },
					"children" : [
						<?php foreach($v['child'] as $kk=>$vv){ ?>
							<?php if(!empty($vv['child'])){?>
							{ 
								"id" : "<?=$kk?>",
								"text" : "<?=$vv['name']?>", 
								"state" : { "opened" : true,<?php if (in_array($kk, $info['operate_rights_arr'])) { ?>"checked" : true<?php }else{ ?>"checked" : false<?php }?>  },
								"children" : [ 
									<?php foreach($vv['child'] as $kkk=>$vvv){ ?>
									{
										"id" : "<?=$kkk?>",
										"text" : "<?=$vvv['name']?>",
										"state" : {<?php if (in_array($kkk, $info['operate_rights_arr'])) { ?>"selected" : true<?php }else{ ?>"selected" : false<?php }?> },
									},
									<?php } ?>
							 	] 
							},
							<?php } else { ?>
							{
								"id" : "<?=$kk?>",
								"text" : "<?=$vv['name']?>",
								"state" : {<?php if (in_array($kk, $info['operate_rights_arr'])) { ?>"selected" : true<?php }else{ ?>"selected" : false<?php }?> },
							},
							<?php } ?>
						<?php } ?>
					]
				},
				<?php } else { ?>
				{
					"id" : "<?=$k?>",
					"text" : "<?=$v['name']?>",
					"state" : {<?php if (in_array($k, $info['operate_rights_arr'])) { ?>"selected" : true<?php }else{ ?>"selected" : false<?php }?> },
				},
				<?php } ?>
			<?php } ?>
		]
	}});
	$("#btnSubmit").click(function(){
		var selectKey = $('#container').jstree().get_checked();
		//alert(<?=$info['id']?>);
		//alert(selectKey);
		$.ajax({
			url: '/authority/role/rights',
			dataType: 'json',  
			type: 'post', 
			data: {key:selectKey, id:<?=$info['id']?>},
			success: function(data , textStatus){
				if (data.status === false)
				{
					alert(data.msg);
					return false;
				}
				alert('保存成功');
				
			},
			error: function(jqXHR , textStatus , errorThrown){
			  //console.log("error");
			}
		}); 
	});
	

});

</script>