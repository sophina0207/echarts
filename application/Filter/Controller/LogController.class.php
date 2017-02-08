<?php
namespace Filter\Controller;
use Common\Controller\HomebaseController;

class LogController extends HomebaseController
{
	static function info($data){
		 list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
		$usec=(int)($usec*1000);
		$usec=str_pad($usec, 3,"0",STR_PAD_LEFT);
		$time=date("Y-m-d H:i:s",time()).".".$usec;
		file_put_contents("./data/Log/logs.log","[".$time."] [INFO]:". $data.PHP_EOL,FILE_APPEND );
	}
} 