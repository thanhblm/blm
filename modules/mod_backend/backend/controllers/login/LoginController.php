<?php

namespace backend\controllers\login;

use common\model\LoginUserInfoMo;
use common\model\UserMo;
use common\persistence\base\vo\UserVo;
use common\services\admin\UserService;
use core\config\ApplicationConfig;
use core\Controller;
use core\Lang;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use common\services\backend_menu\BackendMenuService;

/**
 * *
 *
 * @author TANDT
 *
 */
class LoginController extends Controller {
	// Login Params
	public $userMo;
	public $path;
	public $name;

	public function __construct(){
		parent::__construct();
		$this->userMo = new UserMo ();
	}

	public function login(){
		$result = "";
		if ($_SERVER ['REQUEST_METHOD'] === 'POST') {

			if ($this->checkLogin()) {
				$result = "success";
			} else {
				$result = "login";
			}
		} else {
			$loginUserInfoMo = SessionUtil::get(ApplicationConfig::get("session.user.login.name"));
			if (isset ($loginUserInfoMo) && !AppUtil::isEmptyString($loginUserInfoMo->userName) && $loginUserInfoMo->userType == 'ADMIN') {
				$result = "success";
			} else {
				$result = "login";
			}
		}
		return $result;
	}

	public function accessDenied(){
		$rtype = isset ($_REQUEST ['rtype']) ? $_REQUEST ['rtype'] : "";
		$this->addActionError("You don't have permission to access this function !");
		if ($rtype === "json") {
			return "json";
		} else {
			return "web";
		}
	}

	public function logout(){
		SessionUtil::get(ApplicationConfig::get("session.user.login.name"), null);
		session_destroy();
		return "success";
	}

	private function validateLogin(){
		if (AppUtil::isEmptyString($this->userMo->userName)) {
			$this->addFieldError("userMo[userName]", Lang::get("UserName can not be empty"));
		}

		if (AppUtil::isEmptyString($this->userMo->password)) {
			$this->addFieldError("userMo[password]", Lang::get("Password can not be empty!"));
		}

		if ($this->hasErrors()) {
			return false;
		} else {
			return true;
		}
	}

	private function checkLogin(){
		if (!$this->validateLogin()) {
			return false;
		}

		$userService = new UserService ();
		$userVo = new UserVo ();
		$userVo->userName = $this->userMo->userName;
		$userVos = $userService->selectByFilter($userVo);
		if (!empty ($userVos)) {
			$userVo = $userVos [0];
		} else {
			$userVo = null;
		}

		$encryptType = "";
		$password = "";
		if (!is_null($userVo) && !AppUtil::isEmptyString($userVo->password)) {
			foreach (ApplicationConfig::get("encryption.type.list") as $value) {
				if (AppUtil::startsWith($userVo->password, "{" . $value . "}")) {
					$encryptType = $value;
				}
			}
			if (!AppUtil::isEmptyString($encryptType)) {
				$password = "{" . $encryptType . "}" . $encryptType ($this->userMo->password);
			} else {
				$password = $this->userMo->password;
			}
		}

		if ($userVo != null && !empty ($userVo->password) && $userVo->password === $password) {
			if ($userVo->status == 'active') {
				$loginUserInfoMo = new LoginUserInfoMo ();
				$loginUserInfoMo->userGroupId = $userVo->userGroupId;
				$loginUserInfoMo->userId = $userVo->id;
				$loginUserInfoMo->userName = $userVo->userName;
				$loginUserInfoMo->fullName = $userVo->fullName;
				$loginUserInfoMo->userType = "ADMIN";
				SessionUtil::set(ApplicationConfig::get("session.user.login.name"), $loginUserInfoMo);
				$backendMenuService = new BackendMenuService();
				$loginUserInfoMo->backendMenuList = $backendMenuService->getBackendMenuList();
				SessionUtil::set(ApplicationConfig::get("session.user.login.name"), $loginUserInfoMo);
				return true;
			} else {
				$this->addActionMessage(Lang::get("This account had block, please contact Administrator."));
				return false;
			}
		} else {
			$this->addActionMessage(Lang::get("Invalid UserName or Password"));
			return false;
		}
	}
}