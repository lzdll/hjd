    <!-- 内容主体区域 -->
	<div class="layuibodycont">
		<div class="clearfix sdktop">
			<a href="/myad/index/add"><span class="addads">添加广告位</span></a>
		</div>
		<div class="clearfix mt10">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>广告位ID</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>收益</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach ($list as $key => $val){ ?>
				<tr>
				  <td><?php echo $val['name'];?></td>
				  <td><?php if(bccomp($val['cpc'], 0)===1){ echo $val['cpc'];}else { echo 0;}?></td>
				  <td><?php if(bccomp($val['rate'], 0)===1){ echo $val['rate'];}else { echo 0;}?>%</td>
				  <td>￥<?php if(bccomp($val['sc_price'], 0)===1){ echo $val['sc_price'];}else { echo 0;}?></td>
				  <td><a class="tdfont01" href="/myad/index/details?id=<?php echo $val['id']?>">查看</a><a class="tdfont01" href="/myad/index/intercalate?id=<?php echo $val['id']?>">设置</a></td>
				</tr>
			  <?php } ?>
			  </tbody>
			</table>
			<div class="pages"><div class="y_tip">共 <?php echo $pager['count'];?> 条 每页 <?php echo $pagesize;?> 条	</div><div class="y_page"><?php echo $pager['links'];?></div></div>
		</div>
	 </div>
  <!--<div class="site-tree-mobile layui-hide">
	  <i class="layui-icon layui-icon01"></i>
  </div>-->
 <div class="selectgoodsbox tx" id="layer03">
	<div class="adopearbox">您确定要撤下此广告吗？</div>
</div>
<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script type="text/javascript" src="/public/money_ex/js/moment.min.js"></script>
<script type="text/javascript" src="/public/money_ex/js/detect-report.js"></script>
<script type="text/javascript" src="/public/money_ex/js/echarts.common.min.js"></script>

<script>
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
            data : ['周一','周二','周三','周四','周五','周六','周日']
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
            data : ['周一','周二','周三','周四','周五','周六','周日']
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
            data:[120, 132, 101, 134, 90, 230, 210]

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