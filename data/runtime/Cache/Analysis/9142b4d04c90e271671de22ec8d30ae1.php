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
.pageShow
{
	width:100%;
	height:40px;
	position:relative;
	margin:10px;
}
.urlText{
	display:inline-block;
	position:absolute;
	height:40px;

	overflow:hidden;
	width:130px;
	text-align:center;
}
.urlText b
{
	line-height:40px;
}
.urlImg{
	display:inline-block;
	width:70%;
	height:40px;
	background-color:#abcdef;
	border-radius:10px;
	margin-left:150px;
	cursor:pointer;
}
</style>
</head>
<body>
	<div class="wrap js-check-wrap">
		<div class="well form-search" >
			<b>时间选择:&nbsp;&nbsp;</b>
			<button id="lastday" class="date-search btn btn-primary" data-value="<?php echo ($lastDay); ?>" >昨天</button>
			<button class="date-search btn " data-value="<?php echo ($today); ?>" >今天</button>
			<button class="date-search btn sevenDate" data-value="<?php echo ($sevenDay); ?>" >最近七天</button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>From:</b>
			<input class="from-date " type="date" name="start_time"  value="<?php echo ($start_day); ?>" style="width: 180px;" autocomplete="off">
			<b>To:</b>
			<input class="to-date " autocomplete="off" type="date"  name="end_time" value="<?php echo ($end_day); ?>" style="width: 180px;"> 
		</div>
		<div></div>
		<div class='pageList'>
			<!-- <div class='pageShow'>
				<span class='urlText'><b>Url1:</b></span>
				<span class='urlImg'></span>
			</div>
 -->		</div>
	</div>
	<script src="/zbigdata/public/js/common.js"></script>
	<script src="/zbigdata/public/analysis/js/pages/page.js"></script> 
	<script>var fromToUrl="<?php echo U('analysis/pages/FromToDate');?>";</script>
	<script>var searchUrl="<?php echo U('analysis/pages/searchDate');?>";</script>
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
</body>
</html>