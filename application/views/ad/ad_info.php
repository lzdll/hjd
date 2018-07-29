<!-- 内容主体区域 -->
<div class="postnav">广告管理 - <span class="">广告位详情</span></div>
<link rel="stylesheet" type="text/css" href="/public/money_ex/css/globalforplatform.css" media="all"/>
<div class="layuibodycont">
    <div class="clearfix adposbox">
        <div class="clearfix adpostop">
            <img src="/public/money_ex/images/dot003.png" />
            <dl>
                <dt>米家小程序<span>广告主：<?php echo $info['name'];?></span></dt>
                <dd>小程序路径：<?php echo $info['link'];?></dd>
                <dd>广告导语：<?php echo $info['info'];?></dd>
            </dl>
        </div>
        <div class="clearfix topblock">
            <dl class="topitemdl topitemdl30">
                <dd>点击单价</dd>
                <dt>￥<?php if(bccomp($avgamount, 0)===1){echo $avgamount;}else{ echo 0;}?></dt>
            </dl>
            <dl class="topitemdl topitemdl30">
                <dd>点击率</dd>
                <dt><?php echo $point;?>%</dt>
            </dl>
            <dl class="topitemdl topitemdl30 noborder">
                <dd>消耗</dd>
                <dt>￥<?php if(bccomp($st_price, 0)===1){echo $st_price;}else{echo 0;}?></dt>
            </dl>

        </div>
    </div>
    <div class="clearfix navtabs">
        <span class="navpan"><a href="/ad/index/info?id=<?php echo $id;?>&begin_time=<?php echo $date['today']['begin_date'];?>&end_time=<?php echo $date['today']['end_date'];?>" >今日</a></span>
        <span class="navpan"><a href="/ad/index/info?id=<?php echo $id;?>&begin_time=<?php echo $date['yesterday']['begin_date'];?>&end_time=<?php echo $date['yesterday']['end_date'];?>">昨日</a></span>
        <span class="navpan active"><a href="/ad/index/info?id=<?php echo $id;?>&begin_time=<?php echo $date['week']['begin_date'];?>&end_time=<?php echo $date['week']['end_date'];?>">近7天</a></span>
        <span class="navpan"><a href="/ad/index/info?id=<?php echo $id;?>&begin_time=<?php echo $date['month']['begin_date'];?>&end_time=<?php echo $date['month']['end_date'];?>">本月</a></span>
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
            <div class=""   >
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


<script type="text/javascript" src="/public/money_ex/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/public/money_ex/layui/layui.js"></script>
<script type="text/javascript" src="/public/money_ex/js/global.js"></script>
<script type="text/javascript" src="/public/money_ex/js/moment.min.js"></script>
<script type="text/javascript" src="/public/money_ex/js/detect-report.js"></script>
<script type="text/javascript" src="/public/money_ex/js/echarts.common.min.js"></script>

<script>
    layui.use('laydate', function(){
        var id = <?php echo $id;?>;
        var laydate = layui.laydate;
//日期范围
        laydate.render({
            elem: '#test6'
            ,range: true
            ,done: function(value, date, endDate) {
                var a = value.split('-');
                var begin_time = a[0]+"-"+a[1]+"-"+a[2];
                var end_time = a[3]+"-"+a[4]+"-"+a[5];
                window.location.href = '/ad/index/info?id='+id+'&begin_time='+begin_time+"&end_time="+end_time;
            }
            ,choose: function(dates){
                alert(dates);
            }
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
    window.addEventListener("resize", function () {
        myChart.resize();
    });
</script>
</body>
</html>