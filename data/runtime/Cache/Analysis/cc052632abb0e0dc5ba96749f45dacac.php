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
</head>
<body>
	<div class="wrap">
		<div class="row-fluid">
			<div class="span12 well form-search">
			<label>
			<b>指标：</b><select id="target" class="select_2"  name="target">
					<?php if(is_array($target)): foreach($target as $key=>$item): ?><option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; ?>
				</select>
			</label>
			&nbsp;&nbsp;
			<b>From:</b>
			<input class="from-date" type="date" name="start_time"  value="<?php echo ($start_day); ?>" style="width: 180px;" autocomplete="off">
			<b>To:</b>
			<input class="to-date" autocomplete="off" type="date"  name="end_time" value="<?php echo ($end_day); ?>" style="width: 180px;"> 
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div id="main" style="width: 90%;height:300px;"></div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12 ">
				<div style="height:40px">
					<lable><b>数据明细</b></lable>
					<lable class="btn btn-primary" style="float:rigth">下载报表</lable>
				</div>
				<table class="table table-hover table-bordered table-list">
					<thead class='well'>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
	<script>var targetUrl="<?php echo U('analysis/weusers/getTargetDatas');?>"</script>
	<script src="/zbigdata/public/js/common.js"></script>
	<script src="/zbigdata/public/analysis/js/core/echarts.min.js"></script>
	<script src="/zbigdata/public/analysis/js/weusers/increase.js"></script>
</body>
</html>