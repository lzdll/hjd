    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="topblock clearfix">
			<dl class="topitemdl topeditem">
				<dd>每日限额<span class="editpricebtn">编辑</span></dd>
				<dt><?php echo $countinfo['quota']; ?></dt>
			</dl>
			<dl class="topitemdl">
				<dd>账户余额</dd>
				<dt>￥<?php echo $countinfo['money']; ?></dt>
			</dl>
			<dl class="topitemdl">
				<dd>当前投放广告</dd>
				<dt><?php echo $countinfo['ad_num']; ?><span>个</span></dt>
			</dl>
			<dl class="topitemdl noborder">
				<dd>今日消耗</dd>
				<dt>￥<?php echo $totalmoney; ?></dt>
			</dl>
		</div>
		<div class="clearfix navtabs">
			<span class="navpan active"><a href="/ad/index/index?begin_time=<?php echo $date['week']['begin_date'];?>&end_time=<?php echo $date['week']['end_date'];?>">近7天</a></span>
			<span class="navpan"><a href="/ad/index/index?begin_time=<?php echo $date['month']['begin_date'];?>&end_time=<?php echo $date['month']['end_date'];?>">本月</a></span>
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
				<span class="fr countright">均价<i class="">￥<?php echo $avg_price;?></i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->

				</div>
			</div>
			<div class="countitem fr">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon02.png"></i><span>充消池</span></p>
				<span class="fr countright"><i class="">+5%</i></span></div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart2" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
		</div>
		<div class="clearfix" style="margin-top:10px;">
			<div class="countitem fl" style="display: none">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon.png"></i><span>用户画像</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart3" class="report-chart" style="height:400px" data-action="week"></div>
				<!-- ECharts单文件引入 -->
				</div>
			</div>
			<div class="countitem f1" style="display: none">
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon03.png"></i><span>点击排行</span></p>
				</div>
				<div class="">
					<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
				<div id="report-chart4" class="report-chart" style="height:400px" data-action="week"></div>
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
<div class="selectgoodsbox tx" id="layer04">
   <div class="">
		<p class="editprice">编辑每日限额</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,2})?/)"  id="quota" name="quota" placeholder="请输入新限额" class="layui-input">
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
            window.location.href = '/ad/index/index?begin_time='+begin_time+"&end_time="+end_time;
        }
        ,choose: function(dates){
            alert(dates);
        }
    });
});

layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
	$(document).on("click",".editpricebtn",function(){
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
			,yes: function(layero){
                var quota = $('#quota').val();
                if(quota == "") {
                    alert("金额不能为空");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: '/ad/index/editquota',
                        data:{quota:quota},
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

// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('report-chart'));
var myChart2 = echarts.init(document.getElementById('report-chart2'));
//var myChart3 = echarts.init(document.getElementById('report-chart3'));
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
        data:['充值','消耗']
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
            name:'充值',
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
            data:[<?php echo $staticesAdRechage ;?>]

        },
        {
            name:'消耗',
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
            data:[<?php echo $staticesAdPrice ;?>]
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
					value:335,
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
					value:132,
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
					value:93,
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


//myChart3.setOption(option3);

var option4 = {
    title : {
        //text: '世界人口总量',
        //subtext: '数据来自网络'
    },
    tooltip : {
        trigger: 'axis'
    },
	grid: {
        left: '5%',
        right: '3%',
        bottom: '9%',
        containLabel: true
    },
    legend: {
        data:['数量']
    },
    toolbox: {
        show : true,

    },
    calculable : true,
    xAxis : [
        {
            type : 'value',
            boundaryGap : [0, 0.01]
        }
    ],
    yAxis : [
        {
            type : 'category',
            data : ['广告名称1','广告名称2','广告名称3','广告名称4','广告名称5','广告名称6']
        }
    ],
    series : [
        {
            name:'数量',
            type:'bar',
			barWidth : 20,//柱图宽度
			label : {normal:{
                                        show: true,
                                        position: 'right'}
                                        },
			itemStyle:{
                                    normal:{
                                        color:'#27b6c7'
                                    }
                                },
            data:[203, 289, 34, 49, 131, 30]
        }
    ]
};


// 使用刚指定的配置项和数据显示图表。
myChart4.setOption(option4);
window.addEventListener("resize", function () {
    myChart.resize();
	myChart2.resize();
//	myChart3.resize();
	myChart4.resize();
});
</script>
</body>
</html>
