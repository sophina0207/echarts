<?php
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;
use Common\Controller\ExportexcelController;

/**
 * @author:wangying
 * @creat:2016年7月18日
 * @desc:
 */
class WeusersController extends AdminbaseController
{
	protected $weusers_model;
	protected $games_users_model;
	
	function _initialize() {
		parent::_initialize();
		$this->weusers_model = D("Common/WeUsers");
		$this->games_users_model = D("Common/GamesUsers");
	}
	public function index()
	{
		
	}

	/**
	 * @title:increase
	 * @param:
	 * @return:return_type
	 * @desc:用户增长菜单
	 */
	public function increase()
	{
		$today=date('Y-m-d',time());
		$start_day=date('Y-m-01', strtotime(date("Y-m-d")));
		$end_day=$today;
		$target=C('target');
		$this->assign('target',$target);
		$this->assign('start_day',$start_day);
		$this->assign('end_day',$end_day);
		$this->display();
	}
	/**
	 * @title:getTargetDatas
	 * @param:
	 * @return:return_type
	 * @desc:用户增长页面，返回数据
	 */
	public function getTargetDatas()
	{
		$from=I('get.from','2016-04-01');
		$to=I('get.to','2016-07-29');
		$target=I('get.target','2');
		$timeDate=$this->getTimePeriod($from, $to);
		$game_id=$this->getGameId();
		$targets=C('target');
		$max=0;
		if($target == '1')
		{//用户浏览人次
			$where =" game_id = $game_id ";
				$where .=" and date_format(view_date,'%Y-%m-%d') >= '$from'";
				$where .=" and date_format(view_date,'%Y-%m-%d') <= '$to'";
				$info=M('pagesViews')->where($where)
									  ->group('view_date')
									  ->getField("view_date as date,sum(view_count) as count",true);
		}elseif($target == '2')
		{//新增用户
			$where =" game_id = $game_id ";
			$where .=" and  FROM_UNIXTIME(subscribe_time,'%Y-%m-%d' ) >= '$from'";
			$where .=" and  FROM_UNIXTIME(subscribe_time,'%Y-%m-%d' ) <= '$to'";
			$result=M('gamesFans')->join('join zd_we_users on zd_we_users.openid = zd_games_fans.openid')
								->where($where)
								->group("FROM_UNIXTIME(subscribe_time,'%Y-%m-%d' )")
								->order("FROM_UNIXTIME(subscribe_time,'%Y-%m-%d' ) asc")
								->getField("FROM_UNIXTIME(subscribe_time,'%Y-%m-%d' ) as date ,count(*) as count",true);
			$info=array();
			foreach ($result as $data)
			{
				$info[$data['date']]=$data['count'];
			}
		}
		$ydata=array();
		foreach ($timeDate as $key => $date)
		{
			$count=empty($info[$date])?0:$info[$date];
			$ydata[]=$count;
			if($count >$max)
			{
				$max=$count;
			}
		}
		$data=array(
				'status'=>1,
// 				'max'=>$max+2,
				'timeDate'=>$timeDate,
				'text'=>$targets[$target]."折线图",
				'name'=>$targets[$target],
				'data'=>$ydata
		);
		$this->ajaxReturn($data);
	}
	protected function getTimePeriod($from,$to)
	{
		$from=strtotime($from);
		$to=strtotime($to);
		$timedate=array();
		for($i=$from;$i<=$to;$i=$i+(24*60*60))
		{
			$timedate[]=date("Y-m-d",$i);
		}
		return $timedate;
	}
	public function getMapInfo()
	{
		$game_id=$this->getGameId();
		$where=array('game_id'=>$game_id);
		$where['country']='中国';
		$result=M('gamesFans')->join("join  zd_we_users on zd_games_fans.openid = zd_we_users.openid")
							   ->where($where)
							   ->field('province as name,count(*) as value')
							   ->group('province')
							   ->order('value desc')
							   ->select();
		if(empty($result))
		{
			$data=array(
					'status'=>0,
					'msg'=>'没有数据'
			);
		}else
		{
			$data=array(
					'status'=>1,
					'data'=>$result,
					'max'=>$result[0]['value']
			);
		}
		$this->ajaxReturn($data);
	}
	/**
	 * @title:attribute
	 * @param:
	 * @return:return_type
	 * @desc:show 网红用户列表信息
	 */
	public function attribute()
	{
		$this->display('netred');
	}
	public function userInfo()
	{
		$this->display();
	}
	/**
	 * @title:netred
	 * @param:
	 * @return:return_type
	 * @desc:普通用户信息
	 */
	public function common()
	{
		$json=file_get_contents('china.json');
		$this->assign('json',$json);
		$this->assign('path',$path);
		$this->display('common');
	}
	
	public function search()
	{
		$name=I('get.name');
		$gameId=$this->getGameId();
// 		$where=" game_id = ".$gameId." and nickname like '%".$name."%'";
		$where['nickname']=array('like',"'%'$name'%'");
		$data=$this->getNetreds($where);
		$this->ajaxReturn($data);
	}
	/**
	 * @title:orderNetred
	 * @param:
	 * @return:return_type
	 * @desc:根据表格上的一排按钮，进行返回数据
	 */
	public function getNetredList()
	{
		$getOrder=I('get.order','vote_count');
// 		$condition=I('get.where','user_status_in');
		$name=I('get.name');
		$order =array($getOrder=>'desc');
		$where=array();
/* 		if($condition == 'user_status_in')
		{
			$where['user_status'] = '1';
		}elseif($where == '')
		{
			$where['user_status'] = '0';
		} */
		if($name)
		{
			$where['name']= array('like','%'.$name.'%');
		}
		if(IS_POST)
		{
			$users=$this->exportExcel($where,$order);
			if(empty($users))
			{
				return ;
			}
			//exportExcel数据
			new ExportexcelController('users', $users);
		}elseif(IS_AJAX)
		{
			$data=$this->getNetreds($where,$order);
			$this->ajaxReturn($data);
		}else
		{
			$data=$this->getNetreds($where,$order);
			$data['users']=$data['users']?$data['users']:array();
			$this->assign('status',$data['status']);
			$this->assign('users',$data['users']);
			$this->assign('checked',$getOrder);
			$this->assign('page',@$data['page']);
			$this->display('netred');
		}
	}
	/**
	 * @title:getNetred
	 * @param:
	 * @return:return_type
	 * @desc:返回网红列表
	 */
	protected  function getNetreds($where,$order=array(),$p=1,$pNum=20)
	{
		if(!isset($where['game_id']))
		{
			$where['game_id']=$this->getGameId();
		}
		$counts=$this->games_users_model->join('join zd_we_users on zd_we_users.openid = zd_games_users.openid ')
										->where($where)
										->count();
		if(empty($counts))
		{
			$data=array(
					'status'=>0,
					'msg'=>'没有网红'
			);
			$this->ajaxReturn($data);
		}
		$Page=$this->page($counts,$pNum);
		$show=$Page->show('Admin');
		if(empty($order))
		{
			$order='id desc';
		}
		$users=$this->games_users_model->join('join zd_we_users on zd_we_users.openid = zd_games_users.openid')
										->where($where)
										->field('zd_games_users.id as id,name,nickname,like_count,vote_count,user_status,share_count,comment_count,appeal')
										->order($order)
										->limit($Page->firstRow.','.$Page->listRows)
										->select();
		if(empty($users))
		{
			$data=array(
					'status'=>0,
					'msg'=>'当前比赛没有网红'
			);
		}else
		{
			$index=$Page->firstRow;
			$index++;
			$result=array();
			foreach ($users as $key=>$user)
			{
				$result[$index]=$user;
				if(empty($user['name']))
				{
					$result[$index]['name']=$user['nickname'];
				}
				unset($result[$index]['nickname']);
				$index++;
			}
			$data=array(
					'status'=>1,
					'users'=>$result,
					'page'=>array(
							'p'=>$p,
							'show'=>$show,
							'pTotals'=>$Page->totalPages
					)
			);
		}
		return $data;
	}
	/**
	 * @title:getUserInfo
	 * @param:
	 * @return:return_type
	 * @desc:显示网红的具体信息
	 */
	public function getUserInfo()
	{
		$id=I('get.id');
		if(empty($id))
		{
			$this->error('访问的页面不存在');
		}
		$where['zd_games_users.id']=$id;
		$join='join zd_we_users on zd_we_users.openid = zd_games_users.openid';
		$user=$this->games_users_model->join($join)
								->where($where)
								->find();
		if(!empty($user['potos']))
		{
			$user['potos']=unserialize($user['potos']);
		}
		if(empty($user['openid']))
		{
			$user['nickname']=$user['name'];
		}
		if(empty($user['name']))
		{
			$user['name']=$user['nickname'];
		}
		if(empty($user['headimgurl']))
		{
			$user['headimgurl']=sp_get_asset_upload_path($user['potos'][0]);
		}
		$this->assign('id',$id);
		$this->assign('user',$user);
		$this->display('userInfo');
		
	}
	/**
	 * @title:getSexData
	 * @param:
	 * @return:return_type
	 * @desc:返回性别饼图的数据
	 */
	public function getSexData()
	{
		$game_id=$this->getGameId();
		$where=array('game_id'=>$game_id);
		$result=M('gamesFans')->join("join  zd_we_users on zd_games_fans.openid = zd_we_users.openid")
							   ->where($where)
							   ->field('sex as name,count(*) as value')
							   ->group('sex')
							   ->select();
	   $sex=array(0=>'保密','1'=>'男','2'=>'女');
		if(empty($result))
		{
			$data=array(
					'status'=>0,
					'msg'=>'没有数据'
			);
		}else
		{
			 foreach ($result as $key=>$item)
			{
				$result[$key]['name']=$sex[$item['name']];
				$name[]=$sex[$item['name']];
			} 
			$data=array(
					'status'=>1,
					'sex'=>$result,
					'name'=>$name
			);
		}
		
		$this->ajaxReturn($data);
	}
	/**
	 * @title:getNetredInfo
	 * @param:
	 * @return:return_type
	 * @desc:ajax返回网红的详细信息
	 */
	public function getNetredInfo()
	{
		$id=I('get.id');
		if(empty($id))
		{
			$data=array(
					'status'=>0,
					'msg'=>'id不能为空'
			);
			$this->ajaxReturn($data);
		}
		$user=$this->games_users_model->join("zd_we_users on zd_games_users.user_id = zd_we_users.id")
										->where(array('id'=>$id))
									    ->find();
		if(empty($user))
		{
			$data=array(
					'status'=>0,
					'msg'=>'该用户不存在'
			);
		}else 
		{
			$data=array(
					'status'=>1,
					'user'=>$user
			);
		}
		$this->ajaxReturn($data);
	}
	public function netredIncrease()
	{
		$today=date('Y-m-d',time());
		$start_day=date('Y-m-01', strtotime(date("Y-m-d")));
		$end_day=$today;
		$this->assign('start_day',$start_day);
		$this->assign('end_day',$end_day);
		$this->display('netincreas');
	}
	public function getNetIncrease()
	{
		$from=I('get.from','2016-04-01');
		$to=I('get.to','2016-07-29');
		$target=I('get.target','2');
		$timeDate=$this->getTimePeriod($from, $to);
		$game_id=$this->getGameId();
		$max=0;
		//新增用户
		$where =" game_id = $game_id ";
		$where .=" and  date_format(create_date,'%Y-%m-%d' ) >= '$from'";
		$where .=" and  date_format(create_date,'%Y-%m-%d' ) <= '$to'";
		$result=M('gamesUsers')->where($where)
								->group("date_format(create_date,'%Y-%m-%d' )")
								->order("date_format(create_date,'%Y-%m-%d' ) asc")
								->getField("date_format(create_date,'%Y-%m-%d' ) as date ,count(*) as count",true);
		$info=array();
		foreach ($result as $data)
		{
			$info[$data['date']]=$data['count'];
		}
		$ydata=array();
		foreach ($timeDate as $key => $date)
		{
			$count=empty($info[$date])?0:$info[$date];
			$ydata[]=$count;
			if($count >$max)
			{
				$max=$count;
			}
		}
		$data=array(
				'status'=>1,
				// 				'max'=>$max+2,
				'timeDate'=>$timeDate,
				'text'=>"网红增长折线图",
				'name'=>"网红增长",
				'data'=>$ydata
		);
		$this->ajaxReturn($data);
	}
	protected function exportExcel($where,$order)
	{
			$users=$this->games_users_model->join('join zd_we_users on zd_we_users.openid = zd_games_users.openid')
											->where($where)
											->field('"order" as "order",zd_games_users.id as id,name,vote_count,comment_count')
											->order($order)
											->select();
			if(!empty($users))
			{
				$index=0;
				foreach ($users as $key=>$user)
				{
					$index++;
					$users[$key]['order']=$index;
				}
			}
			return $users;
	}
	
}