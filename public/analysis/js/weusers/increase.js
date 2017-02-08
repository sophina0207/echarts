$(function(){
	var selector=$(".wrap");
	//点击搜索
	$(selector).delegate("#target",'change','',changeTarget);
	$(selector).delegate(".from-date",'change','',changeTarget);
	$(selector).delegate(".to-date",'change','',changeTarget);
	var params=new Object();
	params=getFromToDate();
	params.target=getTargetValue();
	console.log(params);
	getTargetDatas(params);
	
function changeTarget()	
{
	var params=getFromToDate();
	params.target=getTargetValue();
	console.log(params);
	getTargetDatas(params);
}
function getFromToDate()
{
	var from=$('.from-date').val();
	var to=$('.to-date').val();
	var pramas=new Object();
	pramas.from=from;
	pramas.to=to;
	return pramas;
}
function getTargetValue()
{
	var value=$('#target').val()
	return value;
}
function getTargetDatas(params)
{
	$.ajax({
		type:'get',
		url:targetUrl,
		data:params,
		success:function(data)
		{
			console.log(data);
			if(data.status == 1)
			{
				showLine(data.timeDate,data.data,data.text,data.name,data.max)
				showTable(data.timeDate,data.data,data.name);
			}else
			{
				console.log(data);
			}
		}
	});
}
function showTable(timeDate,data,text)
{
	console.log('table');
	var headObj=$('table').find('thead');
	var tbody=$('table').find('tbody');
	headObj.empty();
	tbody.empty();
	var headStr="<tr>" +
			"<th>日期</th>" +
			"<th>"+text+"</th>" +
			"</tr>";
	headObj.append(headStr);
	var str="";
	var viewCount=0;
	$.each(timeDate,function(item,value){
		viewCount=data[item];
		str +="<tr>" +
				"<td>"+value+"</td>" +
				"<td>"+viewCount+"</td>" +
				"</tr>";
	});
	tbody.append(str);
}
function showLine(timeData,data,text,name,max)	
{
	var myCharts = echarts.init(document.getElementById('main'));
        option = {
            title: {
                text: text,
                x: 'center'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    animation: false
                }
            },
            legend: {
                data:[name],
                x: 'left'
            },
            toolbox: {
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                            },
                            restore: {},
                            saveAsImage: {}
                        }
                    },
 
                    grid: [{
                        left: 50,
                        right: 50,
                        height: '60%'
            }, {
                left: 50,
                right: 50,
                top: '55%',
                height: '100%'
            }],
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    axisLine: {onZero: true},
                    data: timeData
                }
            ],
            yAxis : [
                {
                    name : name,
                    type : 'value',
                    max : max
                }
            ],
            series : [
                {
                    name:name,
                    type:'line',
                    symbolSize: 8,
                    hoverAnimation: false,
                    data:data
                }
            ]
        };
    myCharts.setOption(option);
}
	
});