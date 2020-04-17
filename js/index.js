        // 基于准备好的dom，初始化echarts实例
        var myChartGuoJiaXianQuShi = echarts.init(document.getElementById('qushi'));
        var option = {
            title: {
                //text: '国家线趋势'
            },
			dataZoom: [	{
					type: 'slider',
					xAxisIndex: 0,
					start: 0,
					end: 100
				},
				{
					type: 'inside',
					xAxisIndex: 0,
					start: 0,
					end: 100
				},
				{
					type: 'slider',
					yAxisIndex: 0,
					start: 0,
					end: 100
				},
				{
					type: 'inside',
					yAxisIndex: 0,
					start: 0,
					end: 100
				}
			],
			tooltip: {},
			legend: {
				//工学-a类，b类
				data:[]
			},
			xAxis: {
				//year
				data: []
			},
			yAxis: {
				type:"value",
				min:0,
				//max:700
			}
			
        };	
	
		var gGJXQUSeriesDict=new Array();
		new Vue({
			el: '#selectCondition',
			data: {
				degreeType: "学硕",
				subject:[],
				region:["A类"],
				gradeClass:["总分"],
				subjectList:{},
				curSubjectList:[],
				
				
				viewTimes:0
			},	
			methods:{
				getSubjectList:function(){
					var _vueThis = this;
					jQuery.ajax({
						url:"api/getAllSubjectList.php",
						async:true,
						
						dataType:"json",
						type:"post", 
						success: function(result){
							_vueThis.subjectList = result;
							_vueThis.upSubjectSelectOpt();
							_vueThis.query();

							console.log(result);
						}
					});
				},
				query:function(){
					var _vueThis = this;
					
					let postData={
							"degreeType": _vueThis.degreeType,
							"subject":_vueThis.subject,
							"region":_vueThis.region,
							"gradeClass":_vueThis.gradeClass
						};
						
						
					console.log(postData)
					myChartGuoJiaXianQuShi.showLoading();
					jQuery.ajax({
						url:"api/guoJiaXianQuery.php",
						async:true,
						data:JSON.stringify(postData),
						dataType:"JSON",
						type:"POST", 
						success: function(result){
							if(result.code){
								console.log(result.msg);
							}else{
								//成功
								myChartGuoJiaXianQuShi.hideLoading();
								_vueThis.upViewTimes(result.data.viewTimes);
								
								
								option.legend.data =result.data.legendData;
								option.xAxis.data =result.data.xAxisData;
								option.series =result.data.series;
								//每个折点都显示数值
								option.series.label= {show: true};
								option.yAxis.min = 700;
								//option.yAxis.max = 0;
								//更新，是为了方便查找
								gGJXQUSeriesDict={};
								for( i in option.series){
									let tt = option.series[i];
									gGJXQUSeriesDict[tt.name]=tt;
									//option.yAxis.max = option.yAxis.max<tt.max?tt.max:option.yAxis.max;
									option.yAxis.min = option.yAxis.min>tt.min?tt.min:option.yAxis.min;
								}
								option.yAxis.min -= 20;
								//option.yAxis.max += 20;
								
								if(option.series.length){
									myChartGuoJiaXianQuShi.clear();
									myChartGuoJiaXianQuShi.setOption(option);
								}
							}
						}
					});
				},
				upSubjectSelectOpt:function(){
					var _vueThis = this;
					_vueThis.curSubjectList=_vueThis.subjectList[_vueThis.degreeType];
					var itemLen=_vueThis.curSubjectList.length;
					if(itemLen){
						_vueThis.subject.push(_vueThis.curSubjectList[0]);
					}
					console.log(_vueThis.degreeType);
					console.log(_vueThis.subjectList[_vueThis.degreeType]);
					//Vue.set(_vueThis.curSubjectList, itemLen, _vueThis.subjectList[_vueThis.degreeType]);
				},
				upViewTimes:function(vt){
					var _vueThis = this;
					_vueThis.viewTimes=vt;
				}
				
			},
			mounted: function(){
				// 初始化子页面
				var _vueThis = this;
				_vueThis.getSubjectList();

				
			},
			created:function(){
			}

			
		})
		

        // 使用刚指定的配置项和数据显示图表。
        myChartGuoJiaXianQuShi.setOption(option);
		myChartGuoJiaXianQuShi.on('legendselectchanged', function (obj) {
			option.yAxis.min = 700;
			//option.yAxis.max = 0;
			for(let n in obj.selected){
				if(obj.selected[n]){
					//option.yAxis.max = option.yAxis.max<gGJXQUSeriesDict[n].max?gGJXQUSeriesDict[n].max:option.yAxis.max;
					option.yAxis.min = option.yAxis.min>gGJXQUSeriesDict[n].min?gGJXQUSeriesDict[n].min:option.yAxis.min;
				}
			}
			if(option.yAxis.max!=0){
				option.yAxis.min -= 20;
				//option.yAxis.max += 20;
				myChartGuoJiaXianQuShi.setOption(option);
			}
		});
		window.onresize = myChartGuoJiaXianQuShi.resize; 
