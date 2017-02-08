$(function()
{
	
	var selector=$(".wrap");
	//排序
	$(selector).delegate(".order",'click','',oderList);
	//where
//	$(selector).delegate(".where",'click','',whereList);
	//点击搜索
	$(selector).delegate("#search",'change','',search);
	$(selector).delegate("#search",'keyup','',search);
	$(selector).delegate("#search",'keypress','',enterSearch);
	//下载报表
	$(selector).delegate("#exportExcel",'click','',exportExcel);
	/*var params=new Object();
	params.order='vote_count';
//	params.where='user_status_in';
	console.log(params);
	getNetredList(params);*/
	var checkValue=$('.orderdiv').attr('data-value');
	var btnObjs=$('.order');
	$.each(btnObjs,function(index,btn){
		var self=$(btn);
		var value=self.attr('data-value');
		if(value ==checkValue)
		{
			self.addClass('btn-primary');
		}
	});
function enterSearch(e)
{
	var key=e.which;
	if(key == 13)
	{
		search();
	}
}
function exportExcel()
{
	var params=new Object();
	params.order=getValue('.order');
	params.name=getName();
	console.log(params);
	
	var form = $("<form>");   //定义一个form表单
	form.attr('style', 'display:none');   //在form表单中添加查询参数
	form.attr('target', '');
	form.attr('method', 'post');
	form.attr('action',getListUrl);
	$('body').append(form);  //将表单放置在web中 
	$.each(params,function(index,item){
		var input1 = $('<input>');
		input1.attr('type', 'hidden');
		input1.attr('name', index);
		input1.attr('value', item);
		form.append(input1);   //将查询参数控件提交到表单上
	});
      form.submit();
}
//获取网红列表数据
function getNetredList(params)
{
	$.ajax({
		type:'get',
		url:getListUrl,
		data:params,
		success:function(data)
		{
			console.log(data);
			dealAjaxReturn(data);
		}
	})
}
//查询
function search()
{
//	var self=$(this);
	var inputObj=$('.form-search input');
	var value=inputObj.val();
	var params=new Object();
	params.name=value;
	params.order=getValue('.order');
	params.where=getValue('.where');
	getNetredList(params);
}
//排序
function oderList()
{
	var self=$(this);
	var btnObjs=$('.order');
	$.each(btnObjs,function(item){
		$(this).removeClass('btn-primary');
	})
	self.addClass('btn-primary');
	var data=self.attr('data-value');
	var params=new Object();
	params.order=data;
	params.where=getValue('.where');
	var name=getName();
	if(name.length !=0)
	{
		params.name=name;
	}
	getNetredList(params);
}


//where
function whereList()
{
	var self=$(this);
	var btnObjs=$('.orderdiv .where');
	$.each(btnObjs,function(item){
		$(this).removeClass('btn-primary');
	})
	self.addClass('btn-primary');
	var data=self.attr('data-value');
	var params=new Object();
	params.where=data;
	params.order=getValue('.order');
	var name=getName();
	if(name.length !=0)
	{
		params.name=name;
	}
	getNetredList(params);
}
//获取排序值||获取where的值
function getValue(param)
{
	var btnObjs=$(param);
	var data="";
	$.each(btnObjs,function(item){
		var self=$(this)
		if(self.hasClass('btn-primary'))
		{
			data=self.attr('data-value');
		}
	});
	return data;
}
//获取name的值
function getName()
{
	var value=$('#search').val();
	return value;
}
function dealAjaxReturn(data)
{
	if(data.status == 0)
	{
		showNoneList(data);
		
	}else
	{
		showNetredList(data.users);
		pageShow(data.page.show);
	}
}
//显示网红列表
function showNetredList(params)
{
	var tbody=$('table').find('tbody');
	tbody.empty();
	var str="";
	$.each(params,function(item,user){
		if(user.user_status == 1)
		{
			user.user_status='比赛中';
		}else
		{
			user.user_status='已淘汰';
		}
			str +="<tr>" +
				"<td>"+item+"</td>" +
				"<td>"+user.name+"</td>" +
//				"<td>"+user.like_count+"</td>" +
				"<td>"+user.vote_count+"</td>" +
			//	"<td>"+user.user_status+"</td>" +
//				"<td>"+user.share_count+"</td>" +
				"<td>"+user.comment_count+"</td>" +
//				"<td>"+user.appeal+"</td>" +
				"<td><a href='"+userPath+"/id/"+user.id+"'>点击查看</a></td>" +
				"</tr>";
	});
	tbody.append(str);
}
//没有网红时的提示信息
function showNoneList(params)
{
	var tbody=$('table').find('tbody');
	tbody.empty();
	var str="<tr >" +
			"<th colspan=9 style='text-align:center'>"+params.msg+"</th>"+
			"</tr>";
	tbody.append(str);
	pageShow(null);
}
//显示分页信息
function pageShow(params)
{
	console.log(params);
	var divObj=$('.pageShow');
	divObj.empty();
	divObj.append(params);
}
});