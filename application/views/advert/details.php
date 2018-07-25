<div class="postnav">广告管理 - <span class="">广告位详情</span></div>
	<div class="layuibodycont">
		<div class="clearfix adposbox">
			<div class="clearfix adpostop">
				<img src="<?php  echo $list['image']; ?>" />
				<dl>
					<dt><?php  echo $list['name']; ?><span>广告主：<?php  echo $list['owner']; ?></span></dt>
					<dd>平台类型：小程序</dd>
					<dd>小程序路径：<?php  echo $list['link']; ?></dd>
					<dd>广告导语：<?php  echo $list['info']; ?></dd>
				</dl>
			</div>
			<div class="clearfix topblock">
				<dl class="topitemdl topitemdl25">
					<dd>点击单价</dd>
					<dt><?php 
						$totol=$list['cpc']*100;
						if($list['ad_price']){
							echo "￥".$list['ad_price']/$totol; 
						}else{
							echo "￥0"; 
						}
					?></dt>
				</dl>
				<dl class="topitemdl topitemdl25">
					<dd>点击率</dd>
					<dt><?php 
					$click = round($list['cpc']/($list['cpc']+$list['cpm']), 2)*100;
					echo  $click."%" ?></dt>
				</dl>
				<dl class="topitemdl topitemdl25">
					<dd>消耗</dd>
					<dt><?php echo "￥".$list['ad_price']/100;  ?></dt>
				</dl>
				<dl class="topitemdl topitemdl25">
					<dd>CPM(千人展示价)</dd>
					<dt>￥<?php echo $v['cmp_price'];  ?></dt>
				</dl>
			</div>
		</div>
		<div class="clearfix navtabs">
			<span class="navpan">今日</span>
			<span class="navpan">昨日</span>
			<span class="navpan active">近7天</span>
			<span class="navpan">本月</span>
			<div class="layui-inline" style="margin-top:4px;">
			  <label class="layui-form-label">时间</label>
			  <div class="layui-input-inline">
				<input type="text" class="layui-input" id="test6" placeholder="开始 到 结束" lay-key="1">
			  </div>
			</div>
		</div>
		<div class="clearfix mt10">
			<div class="countitem countitemone">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon04.png"></i><span>广告推广量</span></p>
				<span class="fr countright">均价<i class="">￥0.3</i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>

		</div>
    </div>
  </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->

</div>
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要撤下吗？</div>
</div>

<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;
//日期范围
  laydate.render({
    elem: '#test6'
    ,range: true
  });
 });

layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".tdopearbtnjs",function(){
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
			,success: function(layero){
			  //成功输出内容
			  console.log(11);
			}
		});
	});
});

// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('report-chart'));
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
        data:['展示','点击']
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
            data : ['6.21','6.22','6.23','6.24','6.25','6.26','6.27']
        }
    ],
    yAxis: {
		'name':'(个)',
        type: 'value'
    },
    series : [
        {
            name:'展示',
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
            data:[10, 12, 21, 54, 260, 830, 710]
        },
        {
            name:'点击',
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
            data:[30, 182, 434, 791, 390, 30, 10]
        }
    ]
};
// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);
window.addEventListener("resize", function () {
    myChart.resize();
});
</script>