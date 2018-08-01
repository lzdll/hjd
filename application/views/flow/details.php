 <!-- 内容主体区域 -->
	<div class="postnav">流量主 - <span class="">流量主详情</span></div>
	<div class="layuibodycont">
		<div class="topblock topblock02 clearfix">
			<dl class="topitemdl topitemdlsep25">
				<dd>广告位数量</dd>
				<dt><?php echo $slotcount;?>个</dt>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>收益总额(元)</dd>
				<dt>￥<?php echo $accountinfo['total_money'] > 0 ? $accountinfo['total_money'] : 0;?></dt>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>可提现金额(元)</dd>
				<dt>￥<?php echo $accountinfo['money'] > 0 ? $accountinfo['money'] : 0?></dt>
			</dl>
			<dl class="topitemdl topitemdlsep25 topitemdlsepfirst">
				<dd><span class="">账号：</span><?php echo $userinfo['mobile'];?><a href="/member/index/lists?type=1&user_code=<?php echo $user_code;?>">查看资质</a><a class="liuuseropear liuuseropearjs">封号</a></dd>
				<dd><span class="">邮箱：</span><?php echo $userinfo['email'];?></dd>
			</dl>
		</div>
		<div class="clearfix" style="margin-top:20px">
			<div class="countitem fl">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon04.png"></i><span>近七天广告推广量</span></p>
				<span class="fr countright">平均收益<i class="">￥<?php echo $avgamount;?></i></span></div>
				
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->

				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon02.png"></i><span>近七天收益金额</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart2" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>广告位ID</th>
				  <th>icon</th>
				  <th>展示量</th>
				  <th>曝光量</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>均价</th>
				  <th>指导价</th>
				  <th>CMP(千人展示价)</th>
				  <th>收益</th>
				  <th>查看</th>
				  <th>状态</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach($slotlists as $key => $val){?>
				<tr>
				  <td><?php echo $val['name'];?></td>
				  <td><div class="iconpic"><img src="<?php echo $val['icon'];?>"></div></td>
				  <td><?php echo $val['cpm'];?></td>
				  <td><?php echo $val['totalcpc'];?></td>
				  <td><?php echo $val['cpc'];?></td>
				  <td><?php echo $val['rate'];?>%</td>
				  <td>￥<?php echo $val['st_price'];?></td>
				  <td><span class="tdfont01 editjs" value="cpc" stcode="<?php echo $val['code']?>">￥<input type="text" value="<?php echo $val['cpc_price'];?>" class="editput" disabled=""></span></td>
				  <td><span class="tdfont01 editjs" value="cpm" stcode="<?php echo $val['code']?>">￥<input type="text" value="<?php echo $val['cpm_price'];?>" class="editput" disabled /></span></td>
				  <td>￥<?php echo $val['st_price'];?></td>
				  <td><a href="广告位详情.html" class="tdviewbtn">查看</a></td>
				  <td>
				  	<?php if($val['status'] == 0){?>
				  	<span class="opearbtn opearbtnjs2 active" value="<?php echo $val['id'].'_'.$val['status'];?>">关闭</span>
				  	<?php }elseif($val['status'] == 1){?>				  
				  	<span class="opearbtn opearbtnjs"  value="<?php echo $val['id'].'_'.$val['status'];?>">开启</span>
				  	<?php }?>
				  </td>
				</tr>
				<?php }?>
			  </tbody>
			</table>
			<div id="demo0" class="pages"></div>
		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->

</div>
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要封号吗？</div>
</div>
<div class="selectgoodsbox tx" id="layer04">
   <div class="">
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" name="money" id="money" placeholder="请输入新的价格" class="layui-input">
					</div>
				  </div>
			 </form>
		</div>
	</div>
</div>
 <div class="selectgoodsbox tx" id="layer01">
	<div class="adopearbox">确定后将关闭，您确定要关闭吗？</div>
</div>
 <div class="selectgoodsbox tx" id="layer02">
	<div class="adopearbox">确定后将开启，您确定要开启吗？</div>
</div>

<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script type="text/javascript" src="/public/money_ex/js/moment.min.js"></script>
<script type="text/javascript" src="/public/money_ex/js/detect-report.js"></script>
<script type="text/javascript" src="/public/money_ex/js/echarts.common.min.js"></script>

<script>
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".liuuseropearjs",function(){
		var slot_user_id = <?php echo $userinfo['id'];?>;
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer03')
			,yes: function (index, layero) {
			  //成功输出内容
			  $.ajax({
					url: '/flow/index/sealoff',
					dataType: 'json',  
					type: 'post', 
					data: {user_id:slot_user_id},
					success: function(data , textStatus){
					if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });
			}
		});
	});
	$(document).on("click",".editjs",function(){
		var money_type = $('this').attr('class');
		var type = $(this).attr('value');
		var st_code = $(this).attr('stcode');
		var user_code = "<?php echo $user_code;?>";
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '230px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer04')
			,yes: function (index, layero) {
				var money = $('#money').val();
			  //成功输出内容
			  $.ajax({
					url: '/flow/index/setslotmoney',
					dataType: 'json',  
					type: 'post', 
					data: {type:type,money:money,st_code:st_code,user_code:user_code},
					success: function(data , textStatus){
					if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });
			}
		});
	});
	$(document).on("click",".opearbtnjs",function(){
		var param = $(this).attr('value');
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer01')
			,yes: function (index, layero) {
			  //成功输出内容
			  $.ajax({
					url: '/flow/index/updateslotprice',
					dataType: 'json',  
					type: 'post', 
					data: {param:param},
					success: function(data , textStatus){
						
							if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });
			}
		});
	});
	$(document).on("click",".opearbtnjs2",function(){
		var param = $(this).attr('value');
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: ['400px', '130px']
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,btn: ['确定','取消']
			,moveType: 1 //拖拽模式，0或者1
			,content: $('#layer02')
			,yes: function (index, layero) {
			  //成功输出内容
			  $.ajax({
					url: '/flow/index/updateslotprice',
					dataType: 'json',  
					type: 'post', 
					data: {param:param},
					success: function(data , textStatus){
					if (data.status === false)
					{
						alert(222);
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					  //console.log("error");
					}
			 });
			}
		});
	});

});
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  //总页数低于页码总数
  laypage.render({
    elem: 'demo0'
    ,count: 50 //数据总数
  });
  });


// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('report-chart'));
var myChart2 = echarts.init(document.getElementById('report-chart2'));

// 指定图表的配置项和数据
var option = {
    title : {
       // text: '某楼盘销售情况',
       // subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['展示平均收益','点击平均收益']
    },
    toolbox: {
        feature: {
           // saveAsImage: {}//将统计图保存为
        }
        ,right:100
        ,top:0
    },
	grid: {
        left: '3%',
        right: '4%',
        bottom: '9%',
        containLabel: true
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [<?php echo $section ;?>]
        }
    ],
    yAxis: {
		'name':'(个)',
        type: 'value'
    },
    series : [
        {
            name:'展示平均收益',
            type:'line',
           // smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'},label : {
								show:true,
								position:'top',
								formatter:'{c}'
							},
							areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#afeff3'
								}, {
									offset: .34,
									color: '#dcf8fa'
								},{
									offset: 1,
									color: '#fff'
								}])
							},
							color:'#2cc6ad'}},
            data:[<?php echo $staticesCpm;?>]
        },
        {
            name:'点击平均收益',
            type:'line',
           // smooth:true,
			itemStyle: {normal: {
			areaStyle: {type: 'default'},
			label : {show:true,position:'top',formatter:'{c}'},
			areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#ffd280'
								}, {
									offset: .34,
									color: '#ffe7ba'
								},{
									offset: 1,
									color: '#fff'
								}])
							},color:'#ffc400'
			}},
            data:[<?php echo $staticesCpc;?>]
        }
    ]
};
// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);

var option2 = {
    title : {
       // text: '某楼盘销售情况',
       // subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['金额',]
    },
    toolbox: {
        feature: {
           // saveAsImage: {}//将统计图保存为
        }
        ,right:100
        ,top:0
    },
	grid: {
        left: '2%',
        right: '3%',
        bottom: '9%',
        containLabel: true
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [<?php echo $section ;?>]
        }
    ],
    yAxis: {
		'name':'(元)',
        type: 'value'
    },
    series : [
        {
            name:'金额',
            type:'line',
            itemStyle: {normal: {
			areaStyle: {type: 'default'},
			label : {show:true,position:'top',formatter:'{c}'},
			areaStyle:{
								color:new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
									offset: 0,
									color: '#afeff3'
								}, {
									offset: .34,
									color: '#dcf8fa'
								},{
									offset: 1,
									color: '#fff'
								}])
							},color:'#2cc6ad'
			}},
            stack: '总量',
            data:[<?php echo $staticesPrice;?>]

        }
    ]
}; 
// 使用刚指定的配置项和数据显示图表。
myChart2.setOption(option2); 
window.addEventListener("resize", function () {
    myChart.resize();
	myChart2.resize();
});  

</script>