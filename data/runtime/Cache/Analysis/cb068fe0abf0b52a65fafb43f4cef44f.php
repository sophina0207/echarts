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
		<div class="well form-search" >
			<b>类型：</b><select style="width:120px" class="contentsType" name='type'>
					<?php if(is_array($type)): foreach($type as $key=>$item): ?><option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; ?>
			</select>&nbsp;&nbsp;
			<button id="lastday" class="date-search btn btn-primary" data-value="<?php echo ($lastDay); ?>" >昨天</button>
			<button class="date-search btn " data-value="<?php echo ($today); ?>" >今天</button>
			<button class="date-search btn sevenDate" data-value="<?php echo ($sevenDay); ?>" >最近七天</button>
			<b>From:</b>
			<input class="from-date " type="date" name="start_time"  value="<?php echo ($start_day); ?>" style="width: 180px;" autocomplete="off">
			<b>To:</b>
			<input class="to-date " autocomplete="off" type="date"  name="end_time" value="<?php echo ($end_day); ?>" style="width: 180px;"> 
		</div>
			<div class="orderdiv table-actions" data-value="<?php echo ($checked); ?>">
				<button data-value="view_count" class="order btn btn-primary btn-small js-ajax-submit" type="submit"  data-subcheck="true">浏览量</button>
				<button data-value="like_count" class="order btn   btn-small js-ajax-submit" type="submit"  data-subcheck="true">点赞量</button>
				<button data-value="comment_count" class="order btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">评论量</button>
				<button data-value="share_count" class="order btn   btn-small js-ajax-submit" type="submit"  data-subcheck="true">分享量</button>
				<button data-value="upload_count" class="order btn   btn-small js-ajax-submit" type="submit"  data-subcheck="true">下载量</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
			<!-- 	<button data-value="user_status_in" class="where btn btn-primary  btn-small js-ajax-submit" type="submit"  data-subcheck="true">比赛中</button>
				<button data-value="user_status_out" class="where btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">已淘汰</button> -->
			</div>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th width="50">排名</th>
						<th>内容</th>
						<th >浏览量</th>
						<th>点赞量</th> 	
						<th >分享量</th>
						<th >评论量</th>
						<th >下载量</th>
					</tr>
				</thead>
				<tbody>
					  <?php if($data['status'] == 0): ?><tr><th colspan='7' style="text-align:center"><?php echo ($data["msg"]); ?></th></tr>
					<?php else: ?>
					<?php if(is_array($data['contents'])): foreach($data['contents'] as $key=>$item): ?><tr>
							<td width="50"><?php echo ($key); ?></td>
							<td><a  target="_black" href="<?php echo ($item["url"]); ?>"><?php echo ($item["title"]); ?></a></td>
							<td ><?php echo ($item["view_count"]); ?></td>
							<td ><?php echo ($item["like_count"]); ?></td>
							<td ><?php echo ($item["share_count"]); ?></td>
							<td ><?php echo ($item["comment_count"]); ?></td>
							<td ><?php echo ($item["upload_count"]); ?></td>
						</tr><?php endforeach; endif; endif; ?>  
				</tbody>
			</table>
			<div class="pageShow pagination">
				<?php echo ($data["page"]); ?>
			</div>
	</div>
	<script>
		var getListUrl="<?php echo U('analysis/contents/index');?>";
	</script>
	<script src="/zbigdata/public/js/common.js"></script>
	<script src="/zbigdata/public/analysis/js/contents/contents.js"></script>
</body>
</html>