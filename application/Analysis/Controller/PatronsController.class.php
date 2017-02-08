<?php
/**
 * @author:wangying
 * @creat:2016年8月4日
 * @desc:
 */
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;
use Common\Controller\ExportexcelController;

class PatronsController extends AdminbaseController
{
	protected $patrons_model;
	public 	function _initialize() {
		parent::_initialize();
		$this->patrons_model=D("Common/Patrons");
	}
	public function index()
	{
		$game_id=$this->getGameId();
		$where=array('game_id'=>$game_id);
		$count=$this->patrons_model->where($where)
							->count();
		$Page=$this->page($count,20);
		$show=$Page->show('Admin');
		$patrons=$this->patrons_model->where($where)
									 ->select();
		$count=0;
		$ratioSum=0;
		foreach ($patrons as $item)
		{
			$count++;
			$ratioSum += $item['ratio'];
		}
		$this->assign('count',$count);
		$this->assign('ratioSum',$ratioSum);
		$this->assign('page',$show);
		$this->assign('patrons',$patrons);
		$this->display();
	}
	public function add_post()
	{
		$posts=$_POST;
		$file=$_FILES['logo'];
		
		foreach ($posts as $key=>$item)
		{
			if(empty($item))
			{
				$this->error($key.'不能为空');
			}
		}
		$posts['game_id']=$this->getGameId();
		//上传log文件
		$config=C('UPLOADLOGO');
		$upload=new \Think\Upload($config);
		$info=$upload->uploadOne($file);
		if(!$info)
		{
			$this->error($upload->getError());
		}
		$posts['logo']=$info['savepath'].$info['savename'];
		$result=$this->patrons_model->add($posts);
		if($result)
		{
			$this->success('添加成功');
		}else
		{
			$this->error('添加失败');	
		}
	}
	public function exportExcel()
	{
		$where=array('game_id'=>$this->getGameId());
		$patrons=$this->patrons_model->where($where)
										->field('"排名",id,name,items,date,ratio')
										->select();
		if(!empty($patrons))
		{
			$index=0;
			foreach ($patrons as $key =>$patron)
			{
				$index++;
				$patrons[$key]['排名']=$index;
			}
			new ExportexcelController('patrons', $patrons);
		}
	}
}