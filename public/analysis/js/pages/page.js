$(function(){
	var tbody=$('table tbody');
	//绑定事件
	var selector=$(".wrap");
	$(selector).delegate(".date-search",'click','',clickDate);
	$(selector).delegate(".from-date",'change','',searchFromTo);
	$(selector).delegate(".to-date",'change','',searchFromTo);
//	$(selector).delegate('.urlImg',"mousemove","",moveTip);
	$(selector).delegate('.urlImg',"mouseover","",overTip);
	$(selector).delegate('.urlImg',"mouseout","",outTip);
	
	searchDate();
	function clickDate()
	{
		var self=$(this);
		var btnObjs=$('.date-search');
		var btnObj=new Object();
		$.each(btnObjs,function(index,item){
			btnObj=$(item);
			if(btnObj.hasClass('btn-primary'))
			{
				btnObj.removeClass('btn-primary');
			}
		});
		self.addClass('btn-primary');
		searchDate();
	}
	function searchDate()
	{
		var dateObj=$('.date-search,btn-primary');
		var dateValue=dateObj.attr('data-value');
		var params=new Object();
		if(dateObj.hasClass('sevenDate '))
		{
			todayObj=dateObj.pre();
			params.from=dateValue;
			params.to=todayObj.attr('data-value');
			console.log(params);
			getPageList(params,fromToUrl);
		}else
		{
			params.value=dateValue;
			console.log(params);
			getPageList(params,searchUrl);
		}
		
	}
	function searchFromTo()
	{
		var self=$(this);
		var dateObj=$('.date-search,btn-primary');
		dateObj.removeClass('btn-primary');
		var params=getFromToValue();
		console.log(params);
		getPageList(params,fromToUrl);
	}
	function overTip(e)
	{
		var self=$(this);
		var value=self.attr('data-value');
		var toolTip = "<div id='tooltip' width='100px' height='12px' style='position:absolute;border:solid #aaa 1px;background-color:#F9F9F9'><b>浏览量：" + value + "人/次</b></div>";
		$("body").append(toolTip);
        $("#tooltip").css({
            "top" :e.pageY + "px",
            "left" :e.pageX + "px"
       });
		
	}
	function outTip()
	{
		$("#tooltip").remove();
	}
	function moveTip(e)
	{
		 $("#tooltip").css({
	            "top" :e.pageY + "px",
	            "left" :e.pageX + "px"
	       });
	}
	function getFromToValue()
	{
		var toValue=$('.to-date').val();
		var fromValue=$('.from-date').val();
		var params=new Object();
		params.from=fromValue;
		params.to=toValue;
		return params;
	}
	function getPageList(params,url)
	{
		$.ajax({
			type:'get',
			url:url,
			data:params,
			success:function(data)
			{
				console.log(data);
				dealAjaxReturn(data);
			},
			error:function(data)
			{
				console.log(data);
			}
		});
	}
	function dealAjaxReturn(data)
	{
		if(data.status == 1)
		{
			showList(data.pagesList);
		}else
		{
			showNoneList(data);
		}
	}
	divObj=$('.pageList');
	function showList(data)
	{
		
		divObj.empty();
		var str="";
		$.each(data,function(item,page){
			str += "<div class='pageShow'>"+
						"<span class='urlText'><b>"+page.name+":</b></span>"+
						"<span class='urlImg' data-value='"+page.view_count+"' style='width:"+page.width+"px'></span>"+
			       "</div>";
		})
		divObj.append(str);
	}
	function showNoneList(data)
	{
		divObj.empty();
		var str="<b>暂无数据</b>" ;
		divObj.append(str);
	}
});