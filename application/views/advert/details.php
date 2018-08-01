<div class="postnav">广告管理 - <span class="">广告位详情</span></div>
	<div class="layuibodycont">
		<div class="clearfix adposbox">
			<div class="clearfix adpostop">
				<img src="<?php  echo $list['image']; ?>" />
				<dl>
					<dt><?php  echo $list['name']; ?><span>广告主：<?php  echo $list['owner']; ?></span></dt>
					<dd>平台类型：<?php if($list['platform'] == 'H5'){ echo "H5";}else if($list['platform'] == 'ios'){ echo "ios";}else if($list['platform'] == 'android'){ echo "android";}else if($list['platform'] == 'wechat'){ echo '小程序';} ?></dd>
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
					<dt><?php echo "￥".$list['ad_price'];  ?></dt>
				</dl>
				<dl class="topitemdl topitemdl25">
					<dd>CPM(千人展示价)</dd>
					<dt>￥<?php echo $v['cmp_price']?$v['cmp_price']:0;  ?></dt>
				</dl>
			</div>
		</div>
		<div class="clearfix navtabs">
			<span class="navpan"><a href="/advert/index/details?id=<?php echo $id;?>&code=<?php echo $code;?>&begin_time=<?php echo $date['today']['begin_date'];?>&end_time=<?php echo $date['today']['end_date'];?>" >今日</a></span>
			<span class="navpan"><a href="/advert/index/details?id=<?php echo $id;?>&code=<?php echo $code;?>&begin_time=<?php echo $date['yesterday']['begin_date'];?>&end_time=<?php echo $date['yesterday']['end_date'];?>">昨日</a></span>
			<span class="navpan active"><a href="/advert/index/details?id=<?php echo $id;?>&code=<?php echo $code;?>&begin_time=<?php echo $date['week']['begin_date'];?>&end_time=<?php echo $date['week']['end_date'];?>">近7天</a></span>
			<span class="navpan"><a href="/advert/index/details?id=<?php echo $id;?>&code=<?php echo $code;?>&begin_time=<?php echo $date['month']['begin_date'];?>&end_time=<?php echo $date['month']['end_date'];?>">本月</a></span>
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
				<span class="fr countright">均价<i class="">￥<?php echo $avgamount;?></i></span></div>
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
	var id = <?php echo $id;?>;
var code = <?php echo $id;?>;
  var laydate = layui.laydate;
//日期范围
  laydate.render({
    elem: '#test6'
    ,range: true
    ,done: function(value, date, endDate) {
        	var a = value.split('-');
        	var begin_time = a[0]+"-"+a[1]+"-"+a[2];
        	var end_time = a[3]+"-"+a[4]+"-"+a[5];
        	window.location.href = '/advert/index/details?id='+id+'&code='+code+'&begin_time='+begin_time+"&end_time="+end_time;
        }
  	,choose: function(dates){
			alert(dates);
  	  	}
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
            data:[<?php echo $staticesCpm;?>]
        }
    ]
};
// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);
window.addEventListener("resize", function () {
    myChart.resize();
});

</script>