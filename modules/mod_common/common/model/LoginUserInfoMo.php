<?php

namespace common\model;



class LoginUserInfoMo {
	public $userType; // ADMIN|CUSTOMER
	public $userId;
	public $userName;
	public $firstName = "";
	public $lastName = "";
	public $fullName = "";
	public $namespace = "";//FRONTEND
	public $userGroupId;
	public $appId = "";//FRONTEND
	public $backendMenuList;
	public $saleRepId;
	public $accountTypeId;
	public $isSaleRepChild;
	public $saleRepChildName;
	
}