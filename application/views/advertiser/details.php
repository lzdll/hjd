<div class="postnav">广告主 - <span class="">广告主详情</span></div>
	<div class="layuibodycont">
		
		<div class="topblock clearfix">
			<dl class="topitemdl topitemdlsep25 topitemdlsepfirst">
				<dd><span class="">账号：</span><?php  echo $user_info['login_name']; ?><a href="/member/index/lists?type=0&user_code=<?php  echo $code; ?>">查看资质</a></dd>
				<dd><span class="">邮箱：</span><?php  echo $user_info['email']; ?></dd>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>广告数量</dd>
				<dt><?php echo $ad_total; ?>个</dt>
			</dl>
			<dl class="topitemdl topitemdlsep25">
				<dd>充值总额(元)</dd>
				<dt>￥<?php echo $list['cz_money']/100; ?></dt>
			</dl>
			<dl class="topitemdl topitemdlsep25 noborder">
				<dd>余额总额(元)</dd>
				<dt>￥<?php echo $list['sy_money']/100; ?></dt>
			</dl>
		</div>
		<div class="clearfix" style="margin-top:20px">
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
				<div class="countnav"><p class="fl countleft"><i><img src="/public/money_ex/images/icon02.png"></i><span>近七天消耗金额</span></p>
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
				  <th>广告名称</th>
				  <th>曝光量</th>
				  <th>点击量</th>
				  <th>点击率</th>
				  <th>点击单价</th>
				  <th>CMP(千人展示价)</th>
				  <th>广告主</th>
				  <th>消耗</th>
				  <th>SDK</th>
				  <th>状态</th>
				  <th>操作</th>
				</tr> 
			  </thead>
			  <tbody>
			  <?php foreach ($list2 as $v){ ?>
				<tr>
				  <td><?=$v['name']?></td>
				  <td><?php echo $v['cpc']+$v['cpm'];  ?></td>
				  <td><?php echo $v['cpc'];  ?></td>
				  <td>
				  <?php 
					$click = round($v['cpc']/($v['cpc']+$v['cpm']), 2)*100;
					echo  $click."%" ?>
					</td>
				  <td>
					<?php 
						$totol=$v['cpc'];
						if($v['ad_price']){
							echo "￥".$v['ad_price']/$totol; 
						}else{
							echo "￥0"; 
						}
					?>
					</td>

				  <td><span class="tdfont01 editjs" onclick="editjs('<?=$v['code']?>','<?=$v['owner']?>')">￥<input type="text" value="<?php echo $v['cmp_price'];  ?>" class="editput" disabled="" id="editput_<?php echo $v['id']; ?>"></span></td>

				  <td><?php echo $v['owner'];  ?></td>
				  <td><?php echo "￥".$v['ad_price'];  ?></td>
				  <td> <?php if($v['sdk_name'] == '' ){?> <a href="/advert/index/binding?code=<?php echo $v['code']; ?>"><span class="tdobtn01 active">绑定</span></a><?php  }else{ echo $v['sdk_name']; }?>
				  </td>
				  <td>
					  <?php if($v['audit_status'] == 0 ){?> 
						<a href="/advert/index/adopt?code=<?php echo $v['code']; ?>&id=<?php echo $v['id']; ?>"><span class="tdstatus active">待审核</span></a>
					  <?php   }else if($v['audit_status'] == 1){ ?> 
						<a href="javascript:void(0)"><span class="tdstatus">通过审核</span></a>
					  <?php }else if($v['audit_status'] == 3){ ?>
						<a href="/advert/index/adopt??code=<?php echo $v['code']; ?>&id=<?php echo $v['id']; ?>"><span class="tdstatus active">未过审核</span></a>	
					  <?php } ?>
				  </td>
				  <td>
					  <?php if($v['status'] == 0 ){?> 
					   <span class="tdoper02 active aduseroper" onclick="upstatus('<?=$v['id']?>')">撤下</span>
					  <?php   }else{ ?> 
						<span class="tdoper02">未投放</span>
					  <?php } ?>
				 </td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
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
   <div class="">
		<p class="editprice">编辑价格</p>
		<div class="adopearbox">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label">价格：</label>
					<div class="layui-input-block" >
					  <span>￥</span><input type="text" name="title" placeholder="请输入新的价格" class="layui-input" id="cmp_price">
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
function editjs(code,owner){
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
				 var cmp_price = $("#cmp_price").val();
				 if(cmp_price == ''){
					alert('价格不能为空');
					return false;
				 }
				//成功输出内容
				$.ajax({
					url: '/advert/index/editcmp',
					dataType: 'json',  
					type: 'post', 
					data: {code:code, owner:owner,cmp_price,cmp_price},
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
}

//更新广告状态
function upstatus(obj){
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
					url: '/advert/index/online',
					dataType: 'json',  
					type: 'post', 
					data: {id:obj},
					success: function(data , textStatus){
						
						if (data.status === false)
					{
						alert(data.msg);
						return false;
					}
					location.reload()
					},
					error: function(jqXHR , textStatus , errorThrown){
					 alert("error");
					}
				});
			}
		});
}


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
            data : [<?php echo $section;?>],
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
            data : [<?php echo $week_arr;?>],
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
            data:[<?php echo $ad_rr;?>]

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