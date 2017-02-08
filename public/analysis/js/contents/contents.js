$(function(){
	var tbody=$('table tbody');
	//绑定事件
	var selector=$(".wrap");
	$(selector).delegate(".contentsType",'change','',getInfos);//where--type
	$(selector).delegate(".date-search",'click','',clickDate);//where--date
	$(selector).delegate(".from-date",'change','',changeDate);//where--date
	$(selector).delegate(".to-date",'change','',changeDate);//where--date
	$(selector).delegate(".order",'click','',clickOrder);//order

	function getInfos()
	{
		var params=new Object();
		params=getDateValue();
		params.type=getTypeValue();
		params.order=getOrderValue();
		getContentsInfos(params);
	}
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
		getInfos();
	}
	function clickOrder()
	{
		var self=$(this);
		var btnObjs=$('.order');
		$.each(btnObjs,function(item){
			$(this).removeClass('btn-primary');
		})
		self.addClass('btn-primary');
		var orderValue=self.attr('data-value');
		getInfos();
	}
	function changeDate()
	{
		var btnObj=$('.date-search,btn-primary');
		btnObj.removeClass('btn-primary');
		getInfos();
	}
	function getTypeValue()
	{
		return $('.contentsType').val();
	}
	function getDateValue()
	{
		var dateBtns=$('.date-search');
		var flag=0;
		var dateValue='';
		var params=new Object();
		$.each(dateBtns,function(index,item){
			var self=$(item);
			if(self.hasClass('btn-primary'))
			{
				flag=1;
				dateValue=self.attr('data-value');
				if(self.hasClass('sevenDate'))
				{
					params.from=dateValue;
					params.to=self.prev().attr('data-value');
				}else
				{
					params.date=dateValue;
				}
			}
				
		});
		if(flag == 0)
		{
			params.from=$('.from-date').val();
			params.to=$('.to-date').val();
			
		}
		return params;
	}
	function getOrderValue()
	{
		var btnObjs=$('.order');
		var orderValue="";
		$.each(btnObjs,function(index,btn){
			var self=$(btn);
			if(self.hasClass('btn-primary'))
			{
				orderValue=self.attr('data-value');
			}
		});
		return orderValue;
	}
	function getContentsInfos(params)
	{
		console.log(params);
		$.ajax({
			type:'get',
			url:getListUrl,
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
			showList(data.contents);
		}else
		{
			showNoneList(data);
		}
	}
	divObj=$('tbody');
	function showList(data)
	{
		divObj.empty();
		var str="";
		$.each(data,function(index,item){
			str += "<tr>" +
					"<td>"+index+"</td>" +
					"<td><a  target='_black' href='"+item.url+"'>"+item.title+"</a></td>" +
					"<td>"+item.view_count+"</td>" +
					"<td>"+item.like_count+"</td>" +
					"<td>"+item.share_count+"</td>" +
					"<td>"+item.comment_count+"</td>" +
					"<td>"+item.upload_count+"</td>" +
					"</tr>";
		});
		divObj.append(str);
	}
	function showNoneList(data)
	{
		divObj.empty();
		var str="<tr>" +
				"<th colspan='7' style='text-align:center;'>"+data.msg+"</th>" +
				"</tr>" ;
		divObj.append(str);
	}
});