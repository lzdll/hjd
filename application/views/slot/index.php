<div class="layuibodycont">
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdl30">
				<dd>今日收益</dd>
				<dt>￥<?php echo $todayProfit['st_price'];?></dt>
			</dl>
			<dl class="topitemdl topitemdl30">
				<dd>总收益金额</dd>
				<dt>￥<?php echo $accountinfo['total_money'];?></dt>
			</dl>
			<dl class="topitemdl topitemdl30 noborder">
				<dd>可提现金额</dd>
				<dt>￥<?php echo $accountinfo['money'];?></dt>
			</dl>
		</div>
		<div class="clearfix navtabs">
			<span class="navpan active"><a href="/slot/index/index?begin_time=<?php echo $date['week']['begin_date'];?>&end_time=<?php echo $date['week']['end_date'];?>">近7天</a></span>
			<span class="navpan"><a href="/slot/index/index?begin_time=<?php echo $date['month']['begin_date'];?>&end_time=<?php echo $date['month']['end_date'];?>">本月</a></span>
			<div class="layui-inline" style="margin-top:4px;">
			  <label class="layui-form-label">时间</label>
			  <div class="layui-input-inline">
				<input type="text" class="layui-input" id="test6" placeholder="开始 到 结束">
			  </div>
			</div>
		</div>
		<div class="clearfix">
			<div class="countitem fl">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon04.png"></i><span>广告推广量</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->

				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon02.png"></i><span>收益</span></p></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
					<div id="report-chart2" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
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
layui.use('laydate', function(){
  var laydate = layui.laydate;
//日期范围
  laydate.render({
    elem: '#test6'
    ,range: true
    ,done: function(value, date, endDate) {
        	var a = value.split('-');
        	var begin_time = a[0]+"-"+a[1]+"-"+a[2];
        	var end_time = a[3]+"-"+a[4]+"-"+a[5];
        	window.location.href = '/slot/index/index?begin_time='+begin_time+"&end_time="+end_time;
        }
  	,choose: function(dates){
			alert(dates);
  	  	}
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
            data : [<?php echo $section;?>]
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
            data:[<?php echo $staticesCpm;?>]
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
        data:['收益']
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
            data : [<?php echo $section;?>]
        }
    ],
    yAxis: {
		'name':'(元)',
        type: 'value'
    },
    series : [
        {
            name:'收益',
            type:'line',
            itemStyle: {
					normal: {
						color: '#27B6C7',
						lineStyle: {
							shadowColor : 'rgba(0,0,0,0.4)'
						}
					}
				},
            stack: '总量',
            data:[<?php echo $staticesStPrice ;?>]

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