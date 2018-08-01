<div class="layuibodycont">
		<div class="topblock clearfix">
			<div class="topitemdlfirst">
				<dl>
					<img src="/public/money_ex/images/dot001.png" />
					<dd>上周点击冠军</dd>
					<dt><?php echo $ad_name; ?></dt>
				</dl>
			</div>
			<dl class="topitemdl">
				<dd>流量池金主</dd>
				<dt>￥<?php echo $day_money; ?></dt>
			</dl>
			<dl class="topitemdl">
				<dd>今日点击量(次)/展示数</dd>
				<dt><?php echo $other_list['cpc'] ?>/<?php echo $other_list['cpm'] ?></dt>
			</dl>
			<dl class="topitemdl">
				<dd>交易流水</dd>
				<dt>￥<?php echo $other_list['ad_price'] ?></dt>
			</dl>
			<dl class="topitemdl noborder">
				<dd>流量主总收入</dd>
				<dt>￥<?php echo $other_list['st_price'] ?></dt>
			</dl>
		</div>
		<div class="clearfix navtabs">
			<span class="navpan"><a href="/home/index?begin_time=<?php echo $date['today']['begin_date'];?>&end_time=<?php echo $date['today']['end_date'];?>" >今日</a></span>
			<span class="navpan"><a href="/home/index?begin_time=<?php echo $date['yesterday']['begin_date'];?>&end_time=<?php echo $date['yesterday']['end_date'];?>">昨日</a></span>
			<span class="navpan active"><a href="/home/index?begin_time=<?php echo $date['week']['begin_date'];?>&end_time=<?php echo $date['week']['end_date'];?>">近7天</a></span>
			<span class="navpan"><a href="/home/index?begin_time=<?php echo $date['month']['begin_date'];?>&end_time=<?php echo $date['month']['end_date'];?>">本月</a></span>
			<div class="layui-inline" style="margin-top:4px;">
			  <label class="layui-form-label">时间</label>
			  <div class="layui-input-inline">
				<input type="text" class="layui-input" id="test6" placeholder="开始 到 结束" lay-key="1">
			  </div>
			</div>
		</div>
		<div class="clearfix">
			<div class="countitem fl">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon04.png"></i><span>广告推广量</span></p>
				<span class="fr countright">均价<i class="">￥<?php echo $avgamount;?></i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->

				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon02.png"></i><span>流量池</span></p>
				<span class="fr countright"><i class="">+5%</i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart2" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
		</div>
		<div class="clearfix" style="margin-top:10px;">
			<div class="countitem fl">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon.png"></i><span>用户画像</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart3" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon03.png"></i><span>交易流水</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart4" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
		</div>
    </div>



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
			window.location.href = '/home/index?begin_time='+begin_time+"&end_time="+end_time;
        }
  	,choose: function(dates){
			alert(dates);
  	  	}
  });
 });
// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('report-chart'));
var myChart2 = echarts.init(document.getElementById('report-chart2'));
var myChart3 = echarts.init(document.getElementById('report-chart3'));
var myChart4 = echarts.init(document.getElementById('report-chart4'));
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
        data:['广告展示总数','广告点击总数']
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
            data : [<?php echo $section;?>],
            axisLabel: {
                interval: 0,
                formatter:function(value,index)
                {
                    debugger
                    if (index % 2 != 0) {
                        return '\n\n' + value;
                    }
                    else {
                        return value;
                    }
                }
            }
        }
    ],
    yAxis: {
		'name':'(个)',
        type: 'value'
    },
    series : [
        {
            name:'广告展示总数',
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
            name:'广告点击总数',
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
            data:[<?php echo $staticesCpm;?>]
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
        data:['充值金额总数','消耗金额总数']
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
            name:'充值金额总数',
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
             data:[<?php echo $m2_arr;?>]

        },
        {
            name:'消耗金额总数',
            type:'line',
            itemStyle: {
					normal: {
						color: '#1FCCAF',
						lineStyle: {
							shadowColor : 'rgba(0,0,0,0.4)',
							 type:'dotted'  //'dotted'虚线 'solid'实线
						}
					}
				},
           data:[<?php echo $m1_arr;?>]
        }
    ]
}; 
// 使用刚指定的配置项和数据显示图表。
myChart2.setOption(option2); 

var option3 = {
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
	grid: {
        left: '5%',
        right: '3%',
        bottom: '9%',
        containLabel: true
    },
    legend: {
        orient : 'vertical',
		x: 'left',
		y: 'top', 
        data:['男性用户','女性用户','其他']
    },
	title : {
				//text: '测试成功占比',
				subtext: ''
			},
    calculable : true,
    series : [
        {
            name:'',
            type:'pie',
            radius : ['45%', '30%','25%'],
            itemStyle : {
                normal:{ 
                        label:{ 
                            show: true, 
                            formatter: '{b} : {c} ({d}%)' 
                        }, 
                        labelLine :{show:true} 
                    } ,
                emphasis : {
                    label : {
                        show : true,
                        position : 'center',
                        textStyle : {
                            fontSize : '12',
                            fontWeight : 'bold'
                        }
                    }
                }
            },
            data:[
                {
					value:<?php echo $hxiang['maleCount'];?>,
					name:'男性用户',
					itemStyle: {
						normal: {
							color: '#27b6c7',
							lineStyle: {
								shadowColor : 'rgba(0,0,0,0.4)'
							}
						}
					}
				},
                {
					value:<?php echo $hxiang['femaleCount'];?>,
					name:'女性用户',
					itemStyle: {
						normal: {
							color: '#ff6d56',
							lineStyle: {
								shadowColor : 'rgba(0,0,0,0.4)'
							}
						}
					}
				},
                {
					value:<?php echo $hxiang['otherCount'];?>,
					name:'其他',
					itemStyle: {
						normal: {
							color: '#fed891',
							lineStyle: {
								shadowColor : 'rgba(0,0,0,0.4)'
							}
						}
					}
				}
            ]
        }
    ]
};


myChart3.setOption(option3);
   
var option4 = {
    title : {
       // text: '某楼盘销售情况',
       // subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['金额']
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
		'name':'(元)',
        type: 'value'
    },
	areaStyle:{
        normal:{
           //颜色渐变函数 前四个参数分别表示四个位置依次为左、下、右、上
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ 
                offset: 0,
                color: '#afeff3'
            }, {
                offset: .34,
                color: '#dcf8fa'
            },{
                offset: 1,
                color: '#fff'
            }])

        }
    },
    series : [
        {
            name:'金额',
            type:'line',
            smooth:true,
			itemStyle: {normal: {
			areaStyle: {type: 'default'},
			label : {show:true,position:'top',formatter:'{c}'},color:'#27b6c7'
			}},
            data:[<?php echo $ad_rr;?>]
        }
    ]
};        
// 使用刚指定的配置项和数据显示图表。
myChart4.setOption(option4);
window.addEventListener("resize", function () {
    myChart.resize();
	myChart2.resize();
	myChart3.resize();
	myChart4.resize();
});  
</script>

