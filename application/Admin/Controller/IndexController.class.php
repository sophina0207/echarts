<?php

/**
 * 后台首页
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class IndexController extends AdminbaseController {
	
	function _initialize() {
	    empty($_GET['upw'])?"":session("__SP_UPW__",$_GET['upw']);//设置后台登录加密码	    
		parent::_initialize();
		$this->initMenu();
	}
	
    /**
     * 后台框架首页
     */
    public function index() {
    	if (C('LANG_SWITCH_ON',null,false)){
    		$this->load_menu_lang();
    	}
    	$games=M('games')->field('id,name,status')
    					 ->select();
    	$game_id=session('game_id');
    	if(!$game_id)
    	{
			$game_id=$games[0]['id'];
			session('game_id',$game_id);
    	}
    	foreach ($games as $key=>$game)
    	{
    		$games[$key]['selected']='';
    		if($game_id == $game['id'])
    		{
    			$games[$key]['selected']='selected';
    		}
    	}
    	$this->assign('games',$games);
        $this->assign("SUBMENU_CONFIG", D("Common/Menu")->menu_json());
       	$this->display();
        
    }
    public function setGameId()
    {
    	$game_id=I('id');
    	if($game_id)
    	{
    		session('game_id',$game_id);
    	}
    	$this->success('success');
    }
    private function load_menu_lang(){
    	$apps=sp_scan_dir(SPAPP."*",GLOB_ONLYDIR);
    	$error_menus=array();
    	foreach ($apps as $app){
    		if(is_dir(SPAPP.$app)){
    			$admin_menu_lang_file=SPAPP.$app."/Lang/".LANG_SET."/admin_menu.php";
    			if(is_file($admin_menu_lang_file)){
    				$lang=include $admin_menu_lang_file;
    				L($lang);
    			}
    		}
    	}
    }

}

