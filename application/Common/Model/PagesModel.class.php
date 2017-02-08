<?php
/**
 * @author:wangying
 * @creat:2016年7月19日
 * @desc:
 */
namespace Common\Model;
use Common\Model\CommonModel;
class PagesModel extends CommonModel{
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
}