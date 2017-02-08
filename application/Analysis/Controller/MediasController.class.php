<?php
/**
 * @author:wangying
 * @creat:2016年8月4日
 * @desc:
 */
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;
use Common\Controller\ExportexcelController;

class MediasController extends AdminbaseController
{
	protected $medias_model;
	protected $pNum='20';
	public function _initialize()
	{
		parent::_initialize();
		$this->medias_model=D('Common/Medias');
	}
	public function index()
	{
	}
	public function showMedias()
	{
		$game_id=$this->getGameId();
		$where=array('game_id'=>$game_id);
		$count=$this->medias_model->where($where)
								  ->count();
		$Page=$this->page($count,$this->pNum);
		$show=$Page->show('Admin');
		$result=$this->medias_model->where($where)
						   ->field('id,name,url,date,title')
						   ->order('date desc')
						   ->limit("$Page->firstRow,$Page->listRows")
						   ->select();
		$medias=array();
		$index=$Page->firstRow;
		foreach ($result as $key =>$item)
		{
			$index++;
			$medias[$index]=$item;
		}
		$this->assign('page',$show);
		$this->assign('medias',$medias);
		$this->assign('count',count($medias));
		$this->display();
	}
	public function showHeats()
	{
		$game_id=$this->getGameId();
		$where=array('game_id'=>$game_id);
		$count=$this->medias_model->where($where)
								   ->count();
		$Page=$this->page($count,$this->pNum);
		$show=$Page->show('Admin');
		$result=$this->medias_model->where($where)
									->field('id,name,view_count,like_count,comment_count,share_count')
									->order('date desc')
									->limit("$Page->firstRow,$Page->listRows")
									->select();
		$medias=array();
		$index=$Page->firstRow;
		foreach ($result as $key =>$item)
		{
			$index++;
			$medias[$index]=$item;
		}
		$this->assign('page',$show);
		$this->assign('medias',$medias);
		$this->display();
	}
	function exportMedias()
	{
		$where=array('game_id'=>$this->getGameId());
		$medias=$this->medias_model->where($where)
								 ->field('id,name,url,date,title')
								->order('date desc')
								->select();
		if(!empty($medias))
		{
			new ExportexcelController('medias', $medias);
		}
	}
	function exportMediasHeats()
	{
		$where=array('game_id'=>$this->getGameId());
		$medias=$this->medias_model->where($where)
								->field('"排名" as "排名",name,view_count,like_count,comment_count,share_count')
								->order('date desc')
								->select();
		if(!empty($medias))
		{
			$index=0;
			foreach ($medias as $key =>$item)
			{
				$index++;
				$item['排名']=$index;
				$medias[$key]=$item;
			}
			new ExportexcelController('mediasHeats', $medias);
		}
	}
}