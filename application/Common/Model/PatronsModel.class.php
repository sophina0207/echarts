<?php
namespace Common\Model;
use Common\Model\CommonModel;
class PatronsModel extends CommonModel
{
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}

