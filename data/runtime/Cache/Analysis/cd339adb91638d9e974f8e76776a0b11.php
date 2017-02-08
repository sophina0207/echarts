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
	<div class="row-fluid">
		<div class="row-head">网红排行</div>
		<div class='row-body'>
			<?php if(is_array($netreds)): foreach($netreds as $key=>$item): ?><div class="body-span2">
					<div class='body-span2-left'><img class="img-circle" src="<?php echo ($item["potos"]); ?>" /><p><?php echo ($item["name"]); ?></p></div>
					<div class='body-span2-right urlImg overtips' data-value="投票:<?php echo ($item["vote_count"]); ?>票；评论:<?php echo ($item["comment_count"]); ?>条" style="width:<?php echo ($item["width"]); ?>px"></div>
				</div><?php endforeach; endif; ?>
		</div>
		<div class="row-foot"><a href="<?php echo U('weusers/getNetredList');?>">查看更多</a></div>
	</div>
	<div class="row-fluid">
		<div class="row-head">内容排行</div>
		<div class='row-body'>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<th>排名</th>
					<th>内容</th>
					<th>浏览量</th>
					<th>点赞量</th>
					<th>评论量</th>
					<th>分享量</th>
				</thead>
				<tbody>
					<?php if(is_array($contents)): foreach($contents as $key=>$item): ?><tr>
							<td><?php echo ($key+1); ?></td>
							<td><a href="<?php echo ($item["url"]); ?>"><?php echo ($item["title"]); ?></a></td>
							<td><?php echo ($item["view_count"]); ?></td>
							<td><?php echo ($item["like_count"]); ?></td>
							<td><?php echo ($item["comment_count"]); ?></td>
							<td><?php echo ($item["share_count"]); ?></td>
						</tr><?php endforeach; endif; ?>
					
				</tbody>
			</table>
		</div>
		<div class="row-foot"><a href="<?php echo U('contents/index');?>">查看更多</a></div>
	</div>
	<div class="row-fluid">
	</div>
</div>
<script type="text/javascript" src="/zbigdata/public/js/common.js"></script>
<script type="text/javascript" src="/zbigdata/public/analysis/js/summarize/overview.js"></script>
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