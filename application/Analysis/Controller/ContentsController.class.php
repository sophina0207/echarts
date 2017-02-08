<?php
/**
 * @author:wangying
 * @creat:2016年8月4日
 * @desc:
 */
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;

class ContentsController extends AdminbaseController
{
	protected $contents_model;
	protected $contents_infos_model;
	protected $pNum='20';
	public function _initialize()
	{
		parent::_initialize();
		$this->contents_model=M('contents');
		$this->contents_infos_model=M('contentsInfos');
	}
	public function index()
	{
		$lastDay=date('Y-m-d', strtotime('-1 days'));
		$game_id=$this->getGameId();
		$type=I('get.type','1');
		$order=I('get.order','view_count');
		$where="game_id = $game_id and type = $type ";
		$from=I('get.from');
		if(!empty($from))
		{
			$from=I('get.from');
			$to=I('get.to');
			$where .= "and date >= '$from' ";
			$where .= "and date <= '$to' ";
		}else
		{
			$date=I('get.date',$lastDay);
			$where .= " and date = '$date'";
		}
		$data=$this->getContentsInfos($where, $order);
		
		if(IS_AJAX)
		{
			$this->ajaxReturn($data);
		}elseif(IS_GET)
		{
			$today=date('Y-m-d',time());
			$sevenDay=date('Y-m-d', strtotime('-7 days'));
			$start_day=date('Y-m-01', strtotime(date("Y-m-d")));
			$end_day=$today;
			$type=C('TYPE');
			$this->assign('today',$today);
			$this->assign('lastDay',$lastDay);
			$this->assign('sevenDay',$sevenDay);
			$this->assign('start_day',$start_day);
			$this->assign('end_day',$end_day);
			$this->assign('type',$type);
			$this->assign('data',$data);
			$this->display();
		}
	}
	protected function getContentsInfos($where,$order)
	{
		$join="join zd_contents_infos on zd_contents_infos.cid = zd_contents.id";
		$count=$this->contents_model->join($join)
										  ->where($where)
										  ->group('date')
										  ->count();
		$sql=$this->contents_model->getLastSql();
		if(empty($count))
		{
			$data=array(
					'status'=>'0',
					'msg'=>'暂时没有内容',
					'sql'=>$sql
			);
		}else 
		{
			$fields='title,url,sum(like_count) as like_count,sum(view_count) as view_count,sum(share_count) as share_count,sum(comment_count) as comment_count,sum(upload_count) as upload_count';
			$Page=$this->page($count,$this->pNum);
			$show=$Page->show('Admin');
			$result=$this->contents_model->join($join)
										->where($where)
										->field($fields)
										->group('cid')
										->order($order." desc")
										->limit($Page->firstRow.','.$Page->listRows)
										->select();
			$sql=$this->contents_model->getLastSql();	
			$contents=array();$index=$Page->firstRow;
			foreach ($result as $key =>$item)
			{
				$index++;
				$contents[$index]=$item;
			}
			$data=array(
					'status'=>'1',
					'contents'=>$contents,
					'page'=>$show,
					'sql'=>$sql
			);
		}
		return $data;
	}
}