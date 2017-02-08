<?php
namespace Analysis\Controller;
use Common\Controller\AdminbaseController;

/**
 * @author:wangying
 * @creat:2016年8月8日
 * @desc:
 */
class SummarizeController extends AdminbaseController
{
	protected $game_id;
	public function _initialize()
	{
		parent::_initialize();
		$this->game_id=$this->getGameId();
	}
	public function overview()
	{
		$summarize=$this->getSummarize();
		$netreds=$this->getNetreds();
		$contents=$this->getContents();
		$this->assign('summarize',$summarize);
		$this->assign('netreds',$netreds);
		$this->assign('contents',$contents);
		$this->display();
	}
	public function reports()
	{
		$summarize=$this->getSummarize();
		$netreds=$this->getNetreds(14);
		$patrons=$this->getPatrons();
		$medias=$this->getMedias();
		$this->assign('summarize',$summarize);
		$this->assign('netreds',$netreds);
		$this->assign('patrons',$patrons);
		$this->assign('medias',$medias);
		$this->display();
	}
	protected function getSummarize()
	{
		$where=array('game_id'=>$this->game_id);
		$view_count=M('pagesViews')->where($where)
								   ->getField('sum(view_count) as view_count');
	    $fans=$this->getActiveCount();
  		$netCount=M('gamesUsers')->where(array('game_id'=>$this->game_id))
  						 		 ->count();
  		$mediaCount=M('medias')->where(array('game_id'=>$this->game_id))
  						 		 ->count();
		$summarize['view_count']=$view_count;
		$summarize['fans_count']=$fans;
		$summarize['net_count']=$netCount;
		$summarize['media_count']=$mediaCount;
		return $summarize;
	}
	/**
	 * @return number
	 * @desc:获取活动概览页面的总参与人次
	 */
	protected function getActiveCount()
	{
		$count=0;
		$where=array('game_id'=>$this->game_id);
		//获取网红投票数、点赞数、评论数
		$field="sum(vote_count) as vote_count,sum(like_count) as like_count,sum(comment_count) as comment_count ,sum(share_count) as share_count";
		$result=M('gamesUsers')->where($where)
								   ->field($field)
								   ->find();
// 		echo M('gamesUsers')->getLastSql();die;
		$count=$result['vote_count']+$result['like_count']+$result['comment_count']+$result['share_count'];
		//内容的评论量、分享量、下载量、点赞量
		$field="comment_count,share_count,upload_count,like_count";
		$result=M('contentsInfos')->where($where)
								   ->field($field)
								   ->find();
		$count += $result['comment_count']+$result['share_count']+$result['upload_count']+$result['like_count'];
		//媒体报道的评论量、点赞量、分享量
		$field="sum(comment_count) as comment_count,sum(like_count) as like_count,sum(share_count) as share_count";
		$result=M('mediasInfos')->where($where)
								->field($field)
								->find();
		$count += $result['comment_count']+$result['like_count']+$result['share_count'];
		return $count;
	}

	/**
	 * @param number $limit
	 * @return string
	 * @desc:
	 */
	protected function getNetreds($limit=4)
	{
		$where=array('game_id'=>$this->getGameId());
		$netreds=M('gamesUsers')->where($where)
								->field('name,potos,vote_count,comment_count')
								->order('vote_count desc')
								->limit('0,'.$limit)
								->select();
		
		$width='700';
		$max=$netreds[0]['vote_count'];
		foreach ($netreds as $key=>$item)
		{
			$vote_count=$item['vote_count'];
			$ratio=round($vote_count/$max,6);
			$netreds[$key]['width']=intval($ratio*$width);
			$potos=unserialize($item['potos']);
			$netreds[$key]['potos']=sp_get_asset_upload_path($potos[0]);
		}
		return $netreds;
	}
	protected function getContents()
	{
		$where=array('game_id'=>$this->getGameId());
		$join="join zd_contents on zd_contents.id = zd_contents_infos.cid";
		$contents=M('contentsInfos')->join($join)
									->where($where)
									->field('title,url,sum(view_count) as view_count,sum(like_count) as like_count,sum(comment_count) as comment_count,sum(share_count) as share_count')
									->order('view_count desc')
									->group('cid')
									->limit('0,5')
									->select();
		return $contents;
	}
	protected function getPatrons()
	{
		$where=array('game_id'=>$this->game_id);
		$patrons=M('patrons')->where($where)
							 ->getField('name',true);
		return $patrons;
	}
	protected function getMedias()
	{
		$where=array('game_id'=>$this->game_id);
		$medias=M('medias')->where($where)
						   ->getField('name',true);
		return $medias;
	}
}