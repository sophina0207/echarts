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
.well p
{
	font-size:20px;
	line-height:20px;
}
</style>
</head>
<body>
	<div class="wrap">
		<div class='table-actions'>
			<button id="exportExcel"  class="btn btn-primary" >下载报表</button>
		</div>	
		<div class="">
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th>排名</th>
						<th>报道媒体</th>
						<th>浏览量</th>
						<th>点赞量</th>
						<th>评论量</th>
						<th>分享量</th>
					</tr>
				</thead>
				<tbody>
					  <?php if(empty($medias)): ?><tr><th style="text-align:center;" colspan='6'>暂无媒体报道</th></tr>
					<?php else: ?>
					<?php if(is_array($medias)): foreach($medias as $key=>$item): ?><tr>
							<td><?php echo ($key); ?></td>
							<td><?php echo ($item["name"]); ?></td>
							<td><?php echo ($item["view_count"]); ?></td>
							<td><?php echo ($item["like_count"]); ?></td>
							<td><?php echo ($item["comment_count"]); ?></td>
							<td><?php echo ($item["share_count"]); ?></td>
						</tr><?php endforeach; endif; endif; ?>  
				</tbody>
			</table>
		</div>
		<div class="pageShow pagination">
			<?php echo ($page); ?>
		</div>
	</div>
<script>
	var exportUrl="<?php echo U('analysis/medias/exportMediasHeats');?>";
	$('#exportExcel').click(function(){
		window.open(exportUrl);
	})
</script>
	<script src="/zbigdata/public/js/common.js"></script>
</body>
</html>