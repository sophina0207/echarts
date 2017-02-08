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
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('weusers/getNetredList');?>">网红用户</a></li>
			<li ><a href="<?php echo U('weusers/common');?>">普通用户</a></li>
		</ul>
		<div class="well form-search" >
			网红名称： 
			<input id="search" type="text" name="name" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="输入网红名称搜索">
			<!-- <input id="search" type="submit" class="btn btn-primary" value="搜索" /> -->
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="exportExcel" type="submit" class="btn btn-primary" value="下载报表" />
		</div>
			<div class="orderdiv table-actions" data-value="<?php echo ($checked); ?>">
				<button data-value="vote_count" class="order btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">投票</button>
				<button data-value="comment_count" class="order btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">评论</button>
			<!-- 	<button data-value="appeal" class="order btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">粉丝号召力</button> 
				<button data-value="share_count" class="order btn   btn-small js-ajax-submit" type="submit"  data-subcheck="true">分享</button>
				<button data-value="like_count" class="order btn btn-primary  btn-small js-ajax-submit" type="submit"  data-subcheck="true">点赞数</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<button data-value="user_status_in" class="where btn btn-primary  btn-small js-ajax-submit" type="submit"  data-subcheck="true">比赛中</button>
				<button data-value="user_status_out" class="where btn  btn-small js-ajax-submit" type="submit"  data-subcheck="true">已淘汰</button> -->
			</div>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th width="50">排序</th>
						<th>网红名称</th>
					<!-- <th>点赞</th> -->	
						<th width="45">投票</th>
						<!--  <th width="120">当前状态</th>
						<th width="120">分享</th>-->
						<th width="120">评论</th>
						<!--  <th width="120">粉丝号召力</th>-->
						<th width="120">网红资料</th>
					</tr>
				</thead>
				<tbody>
					  <?php if($status == 0): ?><tr><td><?php echo ($data["msg"]); ?></td></tr>
					<?php else: ?>
					<?php if(is_array($users)): foreach($users as $key=>$user): ?><tr>
							<td width="50"><?php echo ($key); ?></td>
							<td><?php echo ($user["name"]); ?></td>
							<!-- <td><?php echo ($user["like_count"]); ?></td> -->
							<td width="45"><?php echo ($user["vote_count"]); ?></td>
						 	<!-- <td width="120"><?php empty($user['user_status'])?'已淘汰':'比赛中' ?></td> -->
						<!-- 	<td width="120"><?php echo ($user["share_count"]); ?></td> -->
							<td width="120"><?php echo ($user["comment_count"]); ?></td>
							<td width="120"><a href="<?php echo U('analysis/weusers/getUserInfo',array('id'=>$user['id']));?>">点击查看</a></td>
						
						</tr><?php endforeach; endif; endif; ?>  
				</tbody>
			</table>
			<div class="pageShow pagination">
				<?php echo ($page["show"]); ?>
			</div>
	</div>
	<script>
		var getListUrl="<?php echo U('analysis/weusers/getNetredList');?>";
		var userPath="<?php echo U('analysis/weusers/getUserInfo');?>";
		var exportExcelUrl="<?php echo U('analysis/weusers/exportExcel');?>";
	</script>
	<script src="/zbigdata/public/js/common.js"></script>
	<script src="/zbigdata/public/analysis/js/weusers/netuser.js"></script>
</body>
</html>