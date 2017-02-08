<?php
namespace Filter\Controller;
use Common\Controller\HomebaseController;
use Think\Model;
use User\Controller\LoginController;

/**
 * @author:wangying
 * @creat:2016年7月26日
 * @desc:
 */

class FilterController extends HomebaseController
{
	protected $from_db=array(
			'DB_TYPE' => 'mysql',
		    'DB_HOST' => '10.24.38.179',
		    'DB_NAME' => 'weizan',
		    'DB_USER' => 'root',
		    'DB_PWD' => 'Zanxing$2016',
		    'DB_PORT' => '3306',
			'DB_PREFIX' => 'ims_',
	);
	protected $to_db=array(
				'DB_TYPE' => 'mysql',
				'DB_HOST' => '10.24.38.179',
				'DB_NAME' => 'zbigdata',
				'DB_USER' => 'root',
				'DB_PWD' => 'Zanxing$2016',
				'DB_PORT' => '3306',
				'DB_PREFIX' => 'zd_',
	);
	/**
	 * @title:getComments
	 * @param:
	 * @return:return_type
	 * @desc:获取多说的评论条数
	 */
	public function getComments()
	{
		$str="";
		$str2="";
		$datas=$this->getDatasFromDB($this->to_db, 'games_users', array('id'));
		foreach ($datas as $key=>$data)
		{
			$id=$data['id'];
			$url="http://api.duoshuo.com/threads/counts.json?short_name=nsh-supermary2&threads=".$id;
			$json=file_get_contents($url);
			$json=json_decode($json,true);
			$comments=$json['response'][$id]['comments'];
			$str .="update  zd_games_users set comment_count = ".$comments." where id = ".$id.";".PHP_EOL;
		}
		file_put_contents('data.log', $str);
	}
	/**
	 * @title:updateTagField
	 * @param:
	 * @return:return_type
	 * @desc:获取fans的地区信息
	 */
	public function updateTagField()
	{
		$datas=$this->getDatasFromDB($this->from_db, "mc_mapping_fans", array('openid','tag'));
		foreach ($datas as $key=>$field)
		{
			$tag=$field['tag'];
			$tag=base64_decode($tag);
			$tag=unserialize($tag);
			$datas[$key]['subscribe_time']=$tag['subscribe_time'];
			unset($datas[$key]['tag']);
		}
		$this->updateDatasToDB($this->to_db, 'we_users', $datas,"",'openid');
	}
	/**
	 * @title:getRacingTB
	 * @param:
	 * @return:return_type
	 * @desc:导入赛事表
	 */
	public function importRacingTB()
	{
		$fields=array(
				'name',
				"start_time as start_date",
				"end_time as end_date",
				'vote_count',
				'view_count'
		);
		$fromTB="ktv_vote_racing";
		$toTB="games";
		$this->insertDataFilter($fields, $fromTB, $toTB);
	}
	/**
	 * @title:importGameUsersTb
	 * @param:
	 * @return:return_type
	 * @desc:将ktv_vote_user数据导入到games_users表中
	 */
	public function importGameUsersTb()
	{
		$fields=array(
				'id',
				'openid',
				'name',
				"create_time as create_date",
				"create_time as start_date",
				'tel',
				"content as slogan",
				'racing_id as game_id',
				'vote_count',
				'img as potos'
		);
		$fromTB="ktv_vote_user";
		$toTB="games_users";
		$by='openid';
		$datas=$this->getDataFromDb($fields, $fromTB,"0,10000");
		$to_db=$this->to_db;
		$mysql=M($toTB,$to_db['DB_PREFIX'],$to_db);
		$flag=1;
		foreach ($datas as $item)
		{
			$item['create_date']=date('Y-m-d H:i:s',$item['create_date']);
				$result=$mysql->add($item);
				if(!$result)
				{
					$flag=0;
					echo "faild:".json_encode($item)."<br>";
					LogController::info("faild:".json_encode($item));
				}
			
		}
		
	}
	/**
	 * @title:importUsersTb
	 * @param:
	 * @return:return_type
	 * @desc:ims_mc_mapping_fans导入到we_users表---OK
	 */
	public function importUsersTb()
	{
		$fields=array(
				'openid',
				'follow as subscribe',
				'followtime as subscribe_time',
				'nickname',
				'tel',
		);
		$fromTB="mc_mapping_fans";
		$toTB="we_users";
		$by='openid';
		$datas=$this->getDataFromDb($fields, $fromTB,"120000,10000");
		$this->insertDataFilter($datas,$toTB,$by);
	}
	/**
	 * @title:importVoteUserToWeUsers
	 * @param:
	 * @return:return_type
	 * @desc:将vote_user表中的数据导入we_users表中
	 */
	public function importVoteUserToWeUsers()
	{
		$fields=array(
				'openid',
				'create_time as subscribe_time',
				'name as nickname',
				'tel',
				'sex',
				
		);
		$fromTB="ktv_vote_user";
		$toTB="we_users";
		$by='openid';
		$datas=$this->getDataFromDb($fields, $fromTB,"0,10000");
		$this->insertDataFilter($datas,$toTB,$by);
	}
	/**
	 * @title:updateGameUser
	 * @param:
	 * @return:return_type
	 * @desc:修改gameuser表的user_id
	 */
	public function updateGameUser()
	{
		 $fields=array(
		 		'openid'
		);
		$where='id';
		$weUsers="we_users";
		$gamesUsers="games_users";
		$from_db=$this->to_db;
		$weUsers_model=M('weUsers');
		$gamesUsers_model=M('gamesUsers');
		$fromDatas=$gamesUsers_model->getField('openid',true);
		foreach ($fromDatas as $data)
		{
			if(!empty($data))
			{
				$find=$weUsers_model->where(array('openid'=>$data))->getField('id');
				if($find)
				{
					$gamesUsers_model->where(array('openid'=>$data))->save(array('user_id'=>$find));
				}
			}
		}
		
		$this->updateDataFilter($fields, $fromTB, $toTB, $where,$from_db);
	}
	public function importTable()
	{
		$fields=array('openid');
		$datas=$this->getDatasFromDB($this->to_db, "we_users", $fields);
		$this->insertDatas($this->to_db, 'games_fans', $datas);
	}
	/**
	 * @title:updateField
	 * @param:
	 * @return:return_type
	 * @desc:根据某一个字段（id），获取某个数据库中的某张表中的某个字段值，复制给另一数据库中的字段
	 */
	public function updateField()
	{
		$fields=array('openid');
		$fromDatas=$this->getDatasFromDB($this->to_db, "we_users", $fields);
		if(!empty($fromDatas))
		{
			$this->updateDatasToDB($this->to_db, 'games_users', $fromDatas);
		}else
		{
			echo 'data from db is empty';
		}
	}
	private  function getDatasFromDB($from_db,$table,$fields,$where=array(),$limit='100000,20000')
	{
		$from_model=M($table,$from_db['DB_PREFIX'],$from_db);
		$result=$from_model->field($fields)->limit($limit)->select();
		/* if(empty($where))
		{
			$result=$from_model->field($field)->limit($limit)->select();
		}else
		{
			$result=$from_model->where($where)->field($fields)->limit($limt)->select();
		} */
		echo $limit."<br>";
		echo count($result);
		unset($from_model);
		return $result;
	}
	private function updateDatasToDB($to_db,$table,$datas,$dateFields=array(),$where='')
	{
		$to_model=M($table,$to_db['DB_PREFIX'],$to_db);
		$count=0;
		foreach ($datas as $data)
		{
			if(!empty($dateFields))
			{
				$data=$this->setDateField($dateFields, $data);
			}
			if(empty($where))
			{
				$to_model->save($data);
			}else 
			{
				$to_model->where(array($where=>$data[$where]))->save($data);
			}
			$count++;
		}
		echo '<br>'.$count;
	}
	private function setDateField($dateFields,$data)
	{
		foreach ($dateFields as $field)
		{
			$data[$field]=date('Y-m-d H:i:s',$data[$field]);
		}
		return $data;
	}
	private function insertDatas($to_db,$table,$datas,$by='',$dateFields=array())
	{
		$to_model=M($table,$to_db['DB_PREFIX'],$to_db);
		$flag=1;
		$count=0;
		foreach ($datas as $item)
		{
			$find="";
			if(!empty($by))
			{
				$find=$to_model->where(array($by=>$item[$by]))->find();
			}
			if($find)
			{
				$save=$to_model->where(array($by=>$item[$by]))->save($item);
				if(!$save)
				{
					$flag=0;
					echo "faild:".json_encode($item)."<br>";
					LogController::info("faild:".json_encode($item));
				}else 
				{
					$count++;
				}
			}else
			{
				if(!empty($dateFields))
				{
					$item=$this->setDateField($dateFields, $item);
				}
				$result=$to_model->add($item);
				if(!$result)
				{
					$flag=0;
					echo "faild:".json_encode($item)."<br>";
					LogController::info("faild:".json_encode($item));
				}else
				{
					$count++;
				}
			}
		
				
		}
		echo '<br>'.$count;
		return $flag;
	}
	
}