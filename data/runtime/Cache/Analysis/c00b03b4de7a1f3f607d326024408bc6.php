<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/zbigdata/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/zbigdata/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/zbigdata/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/zbigdata/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/zbigdata/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/zbigdata/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/zbigdata/public/js/jquery.js"></script>
    <script src="/zbigdata/public/js/wind.js"></script>
    <script src="/zbigdata/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<style>
.well
{
	height:90px;
}
.patronTop div
{
	display:inline-block;
	margin-left:50px;
	padding:10px;
	width:120px;
	height:90px;
	text-align:center;
	
}
.patronTop div p:first-child
{
	font-size:20px;
	font-weight:blod;
}
.patronModel{
	width:400px;
	margin:auto;
	margin-top:20px;
}
.patronModel label b
{
	display:inline-block;
	width:100px;
}
</style>
</head>
<body>
	<div class="wrap">
		<div class="patronTop well" >
			<div>
				<p><b>赞助商</b></p>
				<p><?php echo ($count); ?>家</p>
			</div>			
			<div>
				<p><b>赞助比</b></p>
				<p><?php echo ($ratioSum); ?>%</p>
			</div>		
		</div>
		<div class='table-actions'>
			<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
				添加赞助商
				</button>
			<button id="exportExcel"  class="btn btn-primary" >下载报表</button>
			</div>	
			<div></div>
		<div class="">
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th>赞助商名</th>
						<th>赞助商LOGO</th>
						<th>赞助项</th>
						<th>赞助时间</th>
						<th>活动赞比</th>
					</tr>
				</thead>
				<tbody>
					  <?php if(empty($patrons)): ?><tr><th style="text-align:center;" colspan='4'>暂无赞助</th></tr>
					<?php else: ?>
					<?php if(is_array($patrons)): foreach($patrons as $key=>$item): ?><tr>
							<td><?php echo ($item["name"]); ?></td>
							<td><a target="_blank" href="<?php echo ($item["logo"]); ?>">查看</a></td>
							<td><?php echo ($item["items"]); ?></td>
							<td><?php echo ($item["date"]); ?></td>
							<td><?php echo ($item["ratio"]); ?>%</td>
						</tr><?php endforeach; endif; endif; ?>  
				</tbody>
			</table>
		</div>
		<div class="pageShow pagination">
			<?php echo ($page); ?>
		</div>
	</div>
<div class="modal fade" id="myModal" tabindex="-8" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo U('patrons/add_post');?>" method='post' enctype="multipart/form-data">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
	</button>
	<h4 class="modal-title" id="myModalLabel" style="text-align:center;">添加赞助商</h4></div>
		<div class="modal-body patronModel">
				<label><b>赞助商名：</b><input type='text' required name='name' placeholder='添加赞助商名称'/></label>
				<label><b>赞助商logo：</b><input type='file' required name='logo' /></label>
				<label><b>赞助时间：</b><input type='date' required name='date' value=''/></label>
				<label><b>赞助比：</b><input type='text' min='0' max='100' required name='ratio' placeholder='添加赞助比,如：20'/>%</label>
				<label><b>赞助项目：</b><textarea name='items' required style="resize: none;"></textarea></label>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭
		</button>
		<button type="submit" class="btn btn-primary">添加</button>
	</div>
	</div>
	</div>
	</form>
</div>
<script>
		var exportUrl="<?php echo U('analysis/patrons/exportExcel');?>";
</script>
	<script src="/zbigdata/public/js/common.js"></script>
	<script src="/zbigdata/public/analysis/js/patrons/patrons.js"></script>
</body>
</html>