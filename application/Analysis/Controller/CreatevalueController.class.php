<?php
/**
 * @author:wangying
 * @creat:2016年7月19日
 * @desc:
 */
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;

class CreatevalueController extends AdminbaseController
{
protected $weusers_model;
	protected $games_users_model;
	
	function _initialize() {
		parent::_initialize();
		$this->games_model = M('games');
		$this->weusers_model = D("Common/WeUsers");
		$this->games_users_model = D("Common/GamesUsers");
	}
	public function index()
	{
		$games=$this->getGame();
		$gamesInfo=$this->getInfo();
		$this->assign('games',$games);
		$this->assign('data',$gamesInfo);
		$this->display();
	}
	protected function getGame()
	{
		$gameId=$this->getGameId();
		$games=$this->games_model->where(array('id'=>$gameId))
										->find();
		if(empty($games))
		{
			return false;
		}
		$games['netred_count']=$this->games_users_model
									->where(array('game_id'=>$gameId))		
									->count();
		return $games;
	}
	protected function getInfo()
	{
		$pNum=20;
		$gameId=$this->getGameId();
		$sql="select date_format(start_date,'%Y-%m-%d') as `date` ,count(id) as count from zd_games_users where game_id=".$gameId." group by `date`;";
		$result=$this->games_users_model->query($sql);
		$counts=count($result);
		if(empty($counts))
		{
			return false;
		}
		$Page=new \Think\Page($counts,$pNum);
		$data['show']=$Page->show();
		$sql .= "order by date limit ".$Page->firstRow.",".$Page->listRows;
		$data['gamesInfo']=$this->games_users_model->query($sql);
		return $data;
	}
}