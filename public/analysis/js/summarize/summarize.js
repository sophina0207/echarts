$(function(){
	var myCharts=new echarts.init(document.getElementById('rebar'));
	myCharts.showLoading({
         animation:false,
         text : 'LOADING',
        textStyle : {fontSize : 20}
     });
	var option = {
		   /* backgroundColor:'#fff',
		    title: {
		        text: '基础雷达图'
		    },*/
//		    tooltip: {},
		 /*   legend: {
		        data: [{
		            name:'实际开销（Actual Spending）',
		            textStyle: {
		            color: 'red'
		            },
		            shadowBlur :{shadowColor:'#abcdef',shadowOffsetX:'10', shadowOffsetY:'20'},
		        }]
		    },*/
		    radar: {
		        // shape: 'circle',
		        name: {
		            textStyle: {
		                color: 'rgb(125, 125, 125)',
		            }
		        },
		        indicator: [
		           { name: '活动价值', max: 6500},
		           { name: '', max: 16000},
		           { name: '活动评价', max: 30000},
		           { name: '', max: 38000},
		           { name: '媒体影响', max: 52000},
		           { name: '', max: 52000},
		           { name: '网红质量', max: 52000},
		           { name: '', max: 52000},
		           { name: '影响力', max: 52000},
		           { name: '', max: 25000}
		        ],
		        splitLine :false,
		        splitArea :false,
		        scale:false,
		        axisLine:false
		        
		    },
		    series: [{
//		        name: '预算 vs 开销（Budget vs spending）',
		        type: 'radar',
//		        areaStyle: {normal: {}},
		        data : [
		             {
		                value : [5100, 8100, 24100, 18000, 41000, 25000,42000, 25000, 42000, 12000, 42000, 21000],
//		                name : '实际开销（Actual Spending）'
		            },
		        ],
		        markLine:{
		            
		              effect:{
		                  show:true,
		                  scaleSize :3,
		                  shadowColor:'#fedcba',
		                  shadowBlur:0.5},
		        },
		         itemStyle: {
		                normal: {
		                    color: '#B3E4A1',
		                    shadowStyle:{
		                        color: 'rgba(255,255,0,1)',
		                        width: 'auto',
		                        type: 'default'
		                         },
		                }
		            },
		    }]
		};

	myCharts.hideLoading();
	myCharts.setOption(option);
});