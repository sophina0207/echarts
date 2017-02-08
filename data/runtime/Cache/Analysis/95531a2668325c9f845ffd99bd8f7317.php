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
 <link href="/zbigdata/public/analysis/css/summarize/summarize.css"  rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrap">
	<div class="row-fluid">
		<div class="row-head">活动概述</div>
		<div class="row-body">
			<div class="body-span">
				<p><img src="/zbigdata/public/analysis/images/1.png" /></p>
				<p><span>总浏览人次</span><span><?php echo ($summarize["view_count"]); ?>人次</span></p>
			</div>
			<div class="body-span">
					<p><img src="/zbigdata/public/analysis/images/2.png" /></p>
					<p><span>总参与人次</span><span><?php echo ($summarize["fans_count"]); ?>人次</span></p>
			</div>
			<div class="body-span">
				<p><img src="/zbigdata/public/analysis/images/3.png" /></p>
				<p><span>报名人数</span><span><?php echo ($summarize["net_count"]); ?>人</span></p>
			</div>
			<div class="body-span">
				<p><img src="/zbigdata/public/analysis/images/4.png" /></p>
				<p><span>产生媒体报道</span><span><?php echo ($summarize["media_count"]); ?>篇</span></p>
			</div>
		</div>
	</div>
	<div class='row-fluid'>
		<div class="row-head">活动综合评分</div>
		<div class="row-body row-body-active">
			<div class="active-left" id="rebar"></div>
			<div class="active-right">
				<div><span>活动价值：</span>
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start2.png" />
	            </div>
				<div><span>活动评价：</span>
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start2.png" />
				</div>
				<div><span>媒体影响：</span>
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start2.png" />
				</div>
				<div><span>网红质量：</span>
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start2.png" />
				</div>
				<div><span>影响力：</span>
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start1.png" />
					<img src="/zbigdata/public/analysis/images/start2.png" />
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="row-head">产生优质网红</div>
		<div class='row-body'>
			<?php if(is_array($netreds)): foreach($netreds as $key=>$item): ?><img class="netredImg img-circle" src="<?php echo ($item["potos"]); ?>" /><?php endforeach; endif; ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="row-head">合作赞助商</div>
		<div class='row-body row-body-patrons'>
			<?php if(is_array($patrons)): foreach($patrons as $key=>$item): ?><div class="patrons">
					<?php echo ($item); ?>
				</div><?php endforeach; endif; ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="row-head">影响媒体</div>
		<div class='row-body row-body-patrons'>
			<?php if(is_array($medias)): foreach($medias as $key=>$item): ?><div class="patrons">
					<?php echo ($item); ?>
				</div><?php endforeach; endif; ?>
		</div>
	</div>
</div>
<script type="text/javascript" src="/zbigdata/public/js/common.js"></script>
<script type="text/javascript" src="/zbigdata/public/analysis/js/core/echarts.min.js"></script>
<script type="text/javascript" src="/zbigdata/public/analysis/js/summarize/summarize.js"></script>
<script>
	setCookie('refersh_time', 0);
	function refersh_window() {
		var refersh_time = getCookie('refersh_time');
		if (refersh_time == 1) {
			window.location.reload();
		}
	}
	setInterval(function() {
		refersh_window()
	}, 2000);
</script>
<script src=""></script>
</body>
</html>