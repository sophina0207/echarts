$(function(){
	var myCharts = echarts.init(document.getElementById('main'));
	var myMapCharts=echarts.init(document.getElementById('map'));
	 myCharts.showLoading({
         animation:false,
         text : 'LOADING',
        textStyle : {fontSize : 20}
     });
	 myMapCharts.showLoading({
         animation:false,
         text : 'LOADING',
        textStyle : {fontSize : 20}
     });
	 getSexData();
	 getMapData();
function getSexData()
{
	$.ajax({
		type:'get',
		url:sexUrl,
		success:function(data){
			if(data.status == 1)
			{
				showSex(data.sex,data.name);
			}else
			{
				console.log(data);
			}
		}
	});
}
function getMapData()
{
	$.ajax({
		type:'get',
		url:mapUrl,
		success:function(data){
			if(data.status == 1)
			{
				showMap(data.data,data.max);
			}else
			{
				console.log(data);
			}
		}
		
	});
}
function showSex(data,name)
{
     var option={
     		title:{
     			text:'用户的性别比例',
     			left: 'center'
     		},
     		tooltip : {
     	        trigger: 'item',
     	        formatter: "{a} <br/>{b} : {c}人 ({d}%)",
     	    },
     	    legend: {
     	        orient: 'vertical',
     	        left: 'right',
     	        top :'bottom',
     	        data: name
     	    },
     		series:[{
     		        name:'用户的性别比例',
     		        type:'pie',
     		        radius: '60%',
     		        data:data,
     		          itemStyle:{
     		        	 
     		        	emphasis:{
     		        		shadowBlur:200,
     		        		shadowColor:'rgba(1,2,4,0.5)',
     		        	}
     		          },
     		          labelLine: {
     		        	    normal: {
     		        	        lineStyle: {
     		        	            color: 'rgba(100, 200, 150, 0.6)'
     		        	        }
     		        	    }
     		        	}
     		        }]
    			 }
     myCharts.hideLoading();
     myCharts.setOption(option);
}
function showMap(data,max)
{
	
	var option = {
		    title: {
		        text: '用户地区分布',
		        left: 'center'
		    },
		    tooltip: {
		        trigger: 'item',
		        formatter: function(item)
		        {
		        	if(isNaN(item.value))
	        		{
		        		item.value=0;
	        		}
		        	return item.seriesName+"<br>"+item.name+":"+item.value+"人";
		        }
		    },
		    legend: {
		        orient: 'vertical',
		        left: 'left',
		        data:['iphone3']
		    },
		    visualMap: {
		        min: 0,
		        max:max,
		        left: 'left',
		        top: 'bottom',
		        text: ['高','低'],           // 文本，默认为数值文本
		        calculable: true
		    },
		    toolbox: {
		        show: true,
		        orient: 'vertical',
		        left: 'right',
		        top: 'center',
		        feature: {
		            dataView: {readOnly: false},
		            restore: {},
		            saveAsImage: {}
		        }
		    },
		    series: [
		        {
		            name: '用户地区分布',
		            type: 'map',
		            mapType: 'china',
		            roam: false,
		            label: {
		                normal: {
		                    show: true
		                },
		                emphasis: {
		                    show: true
		                }
		            },
		            data:data
		        },
		    ]
		};
	$.getJSON("localhost/zbigdata/test.json",function(json){
		console.log(json);
	})
	$.ajax({
		type:'get',
		url:"http://d.zan-xing.com/china.json",
		success:function(chinaJson)
		{
			 echarts.registerMap('china', chinaJson);
			myMapCharts.hideLoading();
			myMapCharts.setOption(option);
		}
	});
	
	
}
});