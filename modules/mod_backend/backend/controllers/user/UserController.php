<?php

namespace backend\controllers\user;

use common\filter\user\UserFilter;
use common\model\LoginUserInfoMo;
use common\model\UserMo;
use common\persistence\base\vo\UserGroupVo;
use common\persistence\base\vo\UserVo;
use common\services\admin\UserService;
use common\services\user_group\UserGroupService;
use common\utils\StringUtil;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

/**
 *
 * @author TANDT
 *        
 */
class UserController extends PagingController {
	// Data request
	public $filter;
	public $userMo;
	public $cPassword;
	// Data response
	public $userVo;
	public $userVos;
	public $userList;
	public $listUserGroup;
	//
	private $userService;
	private $loginUserInfoMo;
	public function __construct() {
		parent::__construct ();
		$this->userVo = new UserVo ();
		$this->userService = new UserService ();
		$this->userMo = new UserMo ();
		$this->filter = new UserFilter ();
		$this->loginUserInfoMo = $this->getUserInfo ();
	}
	public function listView() {
		$this->getAllUserGroup();
		$this->getList ();
		return "success";
	}
	public function search() {
		$this->getAllUserGroup();
		$this->getList ();
		return "success";
	}
	public function addView() {
		$this->getAllUserGroup ();
		return "success";
	}
	public function add() {
		$this->getAllUserGroup ();
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userService->createUser ( $this->userVo );
		return "success";
	}
	public function editView() {
		$this->getAllUserGroup ();
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->getAllUserGroup ();
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userVo->crDate = null;
		$this->userVo->crBy = null;
		$this->userService->updateUser ( $this->userVo );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->userService->deleteUser ( $this->userMo );
		return "success";
	}
	public function copyView() {
		$this->getAllUserGroup ();
		$this->detail ();
		return "success";
	}
	public function copy() {
		$this->getAllUserGroup ();
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->userService->createUser ( $this->userVo );
		return "success";
	}
	private function getAllUserGroup() {
		$ugSv = new UserGroupService ();
		$ugVo = new UserGroupVo ();
		$ugVo->status = "active";
		$this->listUserGroup = $ugSv->selectByFilter ( $ugVo );
	}
	private function preapareData() {
		AppUtil::copyProperties ( $this->userMo, $this->userVo );
		if (! AppUtil::isEmptyString ( $this->userVo->password )) {
			$encryptedType =  ApplicationConfig::get("encryption.type.default");
			if (!AppUtil::isEmptyString($encryptedType)){
				$this->userVo->password = "{".$encryptedType."}".($encryptedType($this->userVo->password ));
			}
		}else{
			$this->userVo->password = null;
		}
		$this->userVo->crBy = $this->getUserInfo ()->userId;
		$this->userVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->userVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->userVo->mdBy = $this->getUserInfo ()->userId;
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			// Valid UserName already existed/
			$filter = new UserVo ();
			$filter->userName = $this->userMo->userName;
			$userVoResult = $this->userService->selectByFilter ( $filter );
			if (count ( $userVoResult ) > 0 && $userVoResult [0]->userName == $this->userMo->userName) {
				$this->addFieldError ( "userMo[userName]", Lang::getWithFormat ( " {0} has already existed!", $this->userMo->userName ) );
			}
			
			// Valid UserName already existed/
			$filter = new UserVo ();
			$filter->email = $this->userMo->email;
			$userVoResult = $this->userService->selectByFilter ( $filter );
			if (count ( $userVoResult ) > 0 && $userVoResult [0]->email == $this->userMo->email) {
				$this->addFieldError ( "userMo[email]", Lang::getWithFormat ( "{0} has already existed!", $this->userMo->email ) );
			}
		}
	}
	private function validEditData() {
		$this->validFormEdit ();
		if (! $this->hasErrors ()) {
			$filterOld = new UserVo ();
			$filterOld->id = $this->userMo->id;
			$filterOld->userName = $this->userMo->userName;
			$userVoOldResult = $this->userService->selectByFilter ( $filterOld );
			if (count ( $userVoOldResult ) == 1) {
				if ($userVoOldResult [0]->email != $this->userMo->email) {
					$checkEmailVo = new UserVo ();
					$checkEmailVo->email = $this->userMo->email;
					$checkEmailVo = $this->userService->selectByFilter ( $checkEmailVo );
					if (count ( $checkEmailVo ) > 0) {
						$this->addFieldError ( "userMo[email]", Lang::getWithFormat ( "{0} has already existed!", $this->userMo->email ) );
					}
				}
			} else {
				$this->addFieldError ( "userMo[userName]", Lang::get ( "Not matched infomation" ) );
			}
		}
	}
	private function validFormEdit() {
		if (AppUtil::isEmptyString ( $this->userMo->userName )) {
			$this->addFieldError ( "userMo[userName]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (strlen($this->userMo->userName) <= 3) {
				$this->addFieldError ( "userMo[userName]", Lang::getWithFormat ( "{0} is invalid username, the username must be longer than or equals 3 chars", $this->userMo->userName ) );
			}
		}
		if (AppUtil::isEmptyString ( $this->userMo->email )) {
			$this->addFieldError ( "userMo[email]", Lang::get ( "Email can not be empty" ) );
		} else {
			if (filter_var ( $this->userMo->email, FILTER_VALIDATE_EMAIL ) === false) {
				$this->addFieldError ( "userMo[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->userMo->email ) );
			}
		}
		if (! AppUtil::isEmptyString ( $this->userMo->fullName ) && ! StringUtil::validName ( $this->userMo->fullName )) {
			$this->addFieldError ( "userMo[fullName]", Lang::getWithFormat ( "{0} is name can't use special character!", $this->userMo->fullName ) );
		}
		
		if (! AppUtil::isEmptyString ( $this->userMo->phone ) && ! StringUtil::validPhone ( $this->userMo->phone )) {
			$this->addFieldError ( "userMo[phone]", Lang::getWithFormat ( "{0} is phone not valid!", $this->userMo->phone ) );
		}
		if (AppUtil::isEmptyString ( $this->userMo->userGroupId )) {
			$this->addFieldError ( "userMo[userGroupId]", Lang::get ( "Please select UserGroup !" ) );
		} else {
			if (! is_int ( intval ( $this->userMo->userGroupId ) )) {
				$this->addFieldError ( "userMo[userGroupId]", Lang::getWithFormat ( " {0} is not a valid Integer", $this->userMo->userGroupId ) );
			}
		}
		if (! AppUtil::isEmptyString ( $this->userMo->password ) && strlen ( $this->userMo->password ) < 3) {
			$this->addFieldError ( "userMo[password]", Lang::get ( "Your Password Must Contain At Least 3 Characters!" ) );
		} else if (! AppUtil::isEmptyString ( $this->userMo->password ) && $this->userMo->password != $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Please Check You've Entered Or Confirmed Your Password!" ) );
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->userMo->userName )) {
			$this->addFieldError ( "userMo[userName]", Lang::get ( "Name can not be empty" ) );
		} else {
			if (strlen($this->userMo->userName ) <= 3) {
				$this->addFieldError ( "userMo[userName]", Lang::getWithFormat ( "{0} is invalid username, the username must be longer than or equals 3 chars", $this->userMo->userName ) );
			}
		}
		if (! AppUtil::isEmptyString ( $this->userMo->fullName ) && ! StringUtil::validName ( $this->userMo->fullName )) {
			$this->addFieldError ( "userMo[fullName]", Lang::getWithFormat ( "{0} is name can't use special character!", $this->userMo->fullName ) );
		}
		
		if (! AppUtil::isEmptyString ( $this->userMo->phone ) && ! StringUtil::validPhone ( $this->userMo->phone )) {
			$this->addFieldError ( "userMo[phone]", Lang::getWithFormat ( "{0} is phone not valid!", $this->userMo->phone ) );
		}
		if (AppUtil::isEmptyString ( $this->userMo->status )) {
			$this->addFieldError ( "userMo[status]", Lang::get ( "Status is required" ) );
		}
		
		if (AppUtil::isEmptyString ( $this->userMo->email )) {
			$this->addFieldError ( "userMo[email]", Lang::get ( "Email can not be empty" ) );
		} else {
			if (filter_var ( $this->userMo->email, FILTER_VALIDATE_EMAIL ) === false) {
				$this->addFieldError ( "userMo[email]", Lang::getWithFormat ( "{0} is not a valid email address", $this->userMo->email ) );
			}
		}
		if (AppUtil::isEmptyString ( $this->userMo->userGroupId )) {
			$this->addFieldError ( "userMo[userGroupId]", Lang::get ( "Please select UserGroup !" ) );
		} else {
			if (! is_int ( intval ( $this->userMo->userGroupId ) )) {
				$this->addFieldError ( "userMo[userGroupId]", $this->userMo->userGroupId . " " . Lang::get ( " is not a valid Integer" ) );
			}
		}
		if (AppUtil::isEmptyString ( $this->userMo->password )) {
			$this->addFieldError ( "userMo[password]", Lang::get ( "Password can not be empty" ) );
		} elseif (strlen ( $this->userMo->password ) < 3) {
			$this->addFieldError ( "userMo[password]", Lang::get ( "Your Password Must Contain At Least 3 Characters!" ) );
		} else if ($this->userMo->password != $this->cPassword) {
			$this->addFieldError ( "cPassword", Lang::get ( "Please Check You've Entered Or Confirmed Your Password!" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->userMo->id )) {
			$this->addFieldError ( "userMo[id]", Lang::get ( "Invalid not valid." ) );
		} else {
			$this->userMo = $this->userService->selectBykey ( $this->userMo );
		}
	}
	private function getList() {
		$filter = $this->buildFilter ();
		$count = $this->userService->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$filter->order_by = $this->orderBy;
		$this->userVos = $this->userService->search ( $filter );
		$paging->records = $this->userVos;
		$this->userList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ("cr_date desc");
		StringUtil::clearObject ( $filter );
		return $filter;
	}
}