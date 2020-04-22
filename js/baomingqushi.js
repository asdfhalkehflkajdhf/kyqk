// 基于准备好的dom，初始化echarts实例
var myChartBaoMingQuShi = echarts.init(document.getElementById('baomingqushi'));
var myChartBaoMingQuShiOption = {
	title: {
		text: '报名录取比',
		left: 'center'

	},
	grid: {
		left: '0%',
		right: '3%',//右边空白大小
		containLabel: true
	},
	tooltip: {
		trigger: 'axis',
		axisPointer: {
			type: 'cross',
			label: {
				backgroundColor: '#283b56'
			}
		}
	},
	toolbox: {
		show: true,
		feature: {

			saveAsImage: {}
		}
	},
	legend: {
		//工学-a类，b类
		top: 'bottom',
		left: 'center',
		data:[]
	},
	xAxis: [
		{
			type: 'category',
			boundaryGap: true,
            axisTick: {
                alignWithLabel: true
            },
			data: []
		}
	],
	yAxis: [

		{
			type: 'value',
			scale: true,
			name: '人数（万）',
			position: 'left',
			min: 0,
			boundaryGap: [0.2, 0.2]
		},
		{
			type: 'value',
			scale: true,
			name: '增长率',
			position: 'right',			
			boundaryGap: [0.2, 0.2],
			axisLabel: {
				formatter: '{value} %'
			}
		},
		{
			type: 'value',
			scale: true,
			name: '录取比',
			position: 'right',
			offset: 60,
			axisLabel: {
				formatter: '{value} %'
			}
		}
		
	],
	series: [
	]
	
};	

jQuery.ajax({
	url:"api/getBaoMingQuShi.php",
	//url:"js/baomingqushi.json",
	async:true,
	dataType:"JSON",
	type:"POST", 
	success: function(result){

		myChartBaoMingQuShiOption.legend.data=result.legendData;
		myChartBaoMingQuShiOption.xAxis[0].data=result.xAxisData;
		//myChartBaoMingQuShiOption.series=result.series;
		
		myChartBaoMingQuShiOption.series=result.series.map(function(obj){
			if(obj.yAxisIndex==0){
				obj.data=obj.data.map(function(n){
					return n/10000;
				});
			}
			return obj;
		});

		console.log(myChartBaoMingQuShiOption);
		
		// 使用刚指定的配置项和数据显示图表。
		myChartBaoMingQuShi.setOption(myChartBaoMingQuShiOption);

	},
	error:function(a){
		console.log(a)
	}
});


// 使用刚指定的配置项和数据显示图表。
myChartBaoMingQuShi.setOption(myChartBaoMingQuShiOption);
//事件
myChartBaoMingQuShi.on('legendselectchanged', function (obj) {
});
window.onresize = myChartBaoMingQuShi.resize; 
