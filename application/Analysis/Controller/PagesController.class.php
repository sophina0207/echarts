<?php
/**
 * @author:wangying
 * @creat:2016年7月19日
 * @desc:
 */
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;

class PagesController extends AdminbaseController
{
	protected $pages_model;
	protected $pages_views_model;
	
	function _initialize() {
		parent::_initialize();
		$this->pages_model = D("Common/Pages");
		$this->pages_views_model = D("Common/PagesViews");
	}
	public function show()
	{
		$today=date('Y-m-d',time());
		$lastDay=date('Y-m-d', strtotime('-1 days'));
		$sevenDay=date('Y-m-d', strtotime('-7 days'));
		$start_day=date('Y-m-01', strtotime(date("Y-m-d")));
		$end_day=$today;
/* 		 $game_id=$this->getGameId();
		$where="game_id = $game_id and date_format(view_date,'%Y-%m-%d') = '$lastDay'";
		$pageLists=$this->getPagesList($where);
		var_dump($pageLists);
		$pageList=array();
		if(isset($pageLists['pagesList']))
		{
			$pageList=$pageLists['pagesList'];
		} die; */
		$this->assign('today',$today);
		$this->assign('lastDay',$lastDay);
		$this->assign('sevenDay',$sevenDay);
		$this->assign('start_day',$start_day);
		$this->assign('end_day',$end_day);
		$this->display();
	}
	public function searchDate()
	{
		$value=I('get.value');
		$game_id=$this->getGameId();
		$where="zd_pages.game_id = $game_id and date_format(view_date,'%Y-%m-%d') = '$value'";
		$data=array('where'=>$where);
		$data=$this->getPagesList($where);
		$this->ajaxReturn($data);
	}
	public function FromToDate()
	{
		$from=I('get.from');
		$to=I('get.to');
		$gameId=$this->getGameId();
		$where ="zd_pages.game_id = $gameId ";
		$where .=" and date_format(view_date,'%Y-%m-%d') >= '$from' ";
		$where .=" and date_format(view_date,'%Y-%m-%d') <= '$to' ";
		$data=$this->getPagesList($where);
		$this->ajaxReturn($data);
	}
	protected function getPagesList($where,$p=1,$pNum=20)
	{
		if( is_array($where) && empty($where['game_id']))
		{
			$where['game_id']=$this->getGameId();
		}
		$join="join zd_pages_views on zd_pages.id = zd_pages_views.page_id";
		$result=$this->pages_model->join($join)
								  ->field('name,sum(view_count) as view_count')
								  ->where($where)
								  ->group('zd_pages.id')
								  ->order('view_count desc')
								  ->limit('0,5')
								  ->select();
		$sql=$this->pages_model->getLastSql();
		if(empty($result))
		{
			$data=array(
					'status'=>0,
					"msg"=>'暂时没有页面链接',
					'sql'=>$sql,
			);
			return $data;
		}
		$width=700;
		$max=$result[0]['view_count'];
		foreach ($result as $key=>$page)
		{
			$view=$page['view_count'];
			$ratio=round($view/$max,6);
			$result[$key]['width']=intval($ratio*$width);
		}
		$data=array(
				'status'=>1,
				'pagesList'=>$result,
				'sql'=>$sql,
		);
		return $data;
	}
}