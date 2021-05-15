<?php
namespace common\filter\user;

use core\database\BaseVo;

class UserFilter extends BaseVo{
	public $userName;
	public $ugName;
	public $status;
	public $phone;
	public $fullName;
	public $email;
	public $userGroupId;
}
