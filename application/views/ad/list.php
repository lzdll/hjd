<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="add"><span class="addads">添加广告</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>广告名称</th>
				  <th>曝光量</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>点击单价</th>
				  <th>单价</th>
				  <th>消耗</th>
				  <th>状态</th>
				  <th>操作</th>
				  <th>详情</th>
				</tr> 
			  </thead>
			  <tbody>
              <?php foreach($list as $item):?>
				<tr>
				  <td><?php echo $item['name'];?></td>
				  <td><?php echo $item['pv'];?></td>
				  <td><?php echo $item['cpc'];?></td>
				  <td><?php echo $item['rate'];?>%</td>
				  <td><span class="tdfont01 editjs" onclick="edit(<?php echo $item['id'];?>)">￥<input type="text" value=<?php echo $item['price'];?> class="editput" disabled /></span></td>
				  <td>￥0.00</td>
				  <td>￥<?php echo $item['ad_sumprice'];?></td>
				  <td><span class="tdstatus <?php echo $item['active'];?>"><?php echo $item['audit_status'];?></span></td>
				  <td><span class="tdoper02 <?php echo $item['statusac'];?>" value="<?php echo $item['id'];?>" onclick="edit(<?php echo $item['id'];?>)"><?php echo $item['status'];?></span></td>
				  <td><a class="tdfont01" href="details?id=<?php echo $item['id'];?>">查看</a></td>
				</tr>
              <?php endforeach;?>
			  </tbody>
			</table>
			<div id="demo0" class="pages"><?php echo $pager; ?></div>
		</div>
	 </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
</div>
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要撤下此广告吗？</div>
</div>
<div class="selectgoodsbox tx" id="layer04">
	<div class="adopearbox">您确定要发布此广告吗？</div>
</div>
<div class="selectgoodsbox tx" id="layer05">
   <div class="">
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,2})?/)" id="price" name="price" placeholder="请输入新的价格" class="layui-input">
					</div>
				  </div>
			 </form>
		</div>
	</div>
</div>

<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script type="text/javascript" src="/public/money_ex/js/moment.min.js"></script>
<script type="text/javascript" src="/public/money_ex/js/detect-report.js"></script>
<script type="text/javascript" src="/public/money_ex/js/echarts.common.min.js"></script>

<script>
    var adid = '';
    function edit(id){
        adid = id;
    };
layui.use('layer', function(){ //独立版的layer无需执行这一句
    var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
    $(document).on("click",".aduseroper",function(){
        layer.open({
            type: 1
            ,title: false //不显示标题栏
            ,closeBtn: false
            ,area: ['400px', '130px']
            ,shade: 0.8
            ,id: 'LAY_layuipro0' //设定一个id，防止重复弹出
            ,btn: ['确定','取消']
            ,moveType: 1 //拖拽模式，0或者1
            ,content: $('#layer03')
            ,yes: function(layero){
                $.ajax({
                    type: "POST",
                    url: '/ad/index/edit',
                    data:{type:"delete",id:adid},
                    dataType: "json",
                    success: function(data){
                        location.reload();
                        layer.closeAll();
                    }
                });
            }
        });
    });
    $(document).on("click",".aduseroper2",function(){
        layer.open({
            type: 1
            ,title: false //不显示标题栏
            ,closeBtn: false
            ,area: ['400px', '130px']
            ,shade: 0.8
            ,id: 'LAY_layuipro2' //设定一个id，防止重复弹出
            ,btn: ['确定','取消']
            ,moveType: 1 //拖拽模式，0或者1
            ,content: $('#layer04')
            ,yes: function(layero){
                $.ajax({
                    type: "POST",
                    url: '/ad/index/edit',
                    data:{type:"publish",id:adid},
                    dataType: "json",
                    success: function(data){
                        location.reload();
                        layer.closeAll();
                    }
                });
//                location.reload();
            }
        });
    });

    $(document).on("click",".editjs",function(){
        layer.open({
            type: 1
            ,title: false //不显示标题栏
            ,closeBtn: false
            ,area: ['400px', '230px']
            ,shade: 0.8
            ,id: 'LAY_layuipro5' //设定一个id，防止重复弹出
            ,btn: ['确定','取消']
            ,moveType: 1 //拖拽模式，0或者1
            ,content: $('#layer05')
            ,yes: function(layero){
                var price = $('#price').val();
                if(price == "") {
                    alert("金额不能为空");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: '/ad/index/edit',
                        data:{type:"price",price:price,id:adid},
                        dataType: "json",
                        success: function(data){
                            location.reload();
                            layer.closeAll();
                        }
                    });
                }
            }
        });
    });

});








</script>