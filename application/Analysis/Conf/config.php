<?php
return  array(
		// 开启路由
// 		'URL_ROUTER_ON'   => true,
		'URL_MODEL'=>1,
		'target'=>array(
				'2'=>'用户增长人数',
				'1'=>'浏览人次',
		),
		//内容的类型
		"TYPE"=>array(
				'1'=>'文章',	
				'2'=>'图片',	
				'3'=>'视频',	
		),
		//上传logo
		'UPLOADLOGO'=>array(
				'maxSize'    => 1024*1024*200,
				"rootPath"	 =>		"./",
				'savePath'   =>'data/upload/logo/',
				'saveName'   =>    array('uniqid',''),
				'exts'       =>    array('jpeg', 'png', 'jpg'),
				'autoSub'    =>    false,
				'subName'    =>    array('date','Ymd'),
		),
);

