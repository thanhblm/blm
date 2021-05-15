<?php

namespace backend\controllers\block_email;

use common\persistence\base\vo\BlockEmailVo;
use common\services\block_email\BlockEmailService;
use core\common\Paging;
use core\config\ApplicationConfig;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

class BlockEmailController extends PagingController {
	public $blockEmail;
	public $blockEmails;
	public $id;
	private $blockEmailService;
	public function __construct() {
		parent::__construct ();
		$this->filter = new BlockEmailVo ();
		$this->blockEmail = new BlockEmailVo ();
		$this->blockEmails = new Paging ();
		
		$this->blockEmailService = new BlockEmailService ();
		$this->pageTitle = ApplicationConfig::get ( "site.name" ) . " - Block Emails Management";
	}
	public function listView() {
		$this->getBlockEmails ();
		return "success";
	}
	public function search() {
		$this->getBlockEmails ();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Add to the database.
		$this->blockEmailService->addBlockEmail ( $this->blockEmail );
		$this->addActionMessage ( Lang::get ( "The Block Email added successfully" ) );
		return "success";
	}
	public function copyView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Block Email for cloning" ) );
		}
		// Load language.
		$filter = new BlockEmailVo ();
		$filter->id = $this->id;
		$this->blockEmail = $this->blockEmailService->getBlockEmailByKey ( $filter );
		return "success";
	}
	public function copy() {
		$this->validate ();
		if ($this->hasErrors ()) {
			return "success";
		}
		// Copy to the database.
		$this->blockEmailService->addBlockEmail ( $this->blockEmail );
		$this->addActionMessage ( Lang::get ( "The Block Email cloned successfully" ) );
		return "success";
	}
	public function editView() {
		$filter = new BlockEmailVo ();
		$filter->id = $this->id;
		$this->blockEmail = $this->blockEmailService->getBlockEmailByKey ( $filter );
		return "success";
	}
	public function edit() {
		$this->validate (false);
		if ($this->hasErrors ()) {
			return "success";
		}
		// Save to the database.
		$this->blockEmailService->updateBlockEmail ( $this->blockEmail );
		$this->addActionMessage ( Lang::get ( "The Block Email updated successfully" ) );
		return "success";
	}
	public function delView() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Block Email for deleting" ) );
		}
		// Load system setting group.
		$filter = new BlockEmailVo ();
		$filter->id = $this->id;
		$this->blockEmail = $this->blockEmailService->getBlockEmailByKey ( $filter );
		return "success";
	}
	public function del() {
		if (AppUtil::isEmptyString ( $this->id )) {
			throw new \Exception ( Lang::get ( "No Block Email for deleting" ) );
		}
		// Delete the system setting group.
		$blockEmail = new BlockEmailVo ();
		$blockEmail->id = $this->id;
		$this->blockEmailService->deleteBlockEmail ( $blockEmail );
		$this->addActionMessage ( Lang::get ( "The Block Email deleted successfully" ) );
		return "success";
	}
	private function getBlockEmails() {
		$filter = $this->buildFilter ();
		// Get total records of languages.
		$count = $this->blockEmailService->countBlockEmailByFilter ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get languages.
		$blockEmailVos = $this->blockEmailService->getBlockEmailByFilter ( $filter );
		$paging->records = $blockEmailVos;
		$this->blockEmails = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
	protected function validate($isAdding = true) {
		if (AppUtil::isEmptyString ( $this->blockEmail->email )) {
			$this->addFieldError ( "blockEmail[email]", Lang::get ( "Email is required" ) );
		} else {
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
			if(preg_match($regex, $this->blockEmail->email)==false){
				$this->addFieldError ( "blockEmail[email]", "Email is not email format" );
			}else{
				if ($isAdding) {
					$filter = new BlockEmailVo();
					$filter->email = $this->blockEmail->email;
					$voResult = $this->blockEmailService->getBlockEmailByEmail( $filter );
					if(count ( $voResult ) > 0) {
						$this->addFieldError ( "blockEmail[email]", Lang::getWithFormat ( "{0} has already existed", $this->blockEmail->email ) );
					}
				} else {
					$filter = new BlockEmailVo();
					$filter->id = $this->blockEmail->id;
					$blockEmailOld = $this->blockEmailService->getBlockEmailByKey( $filter );
					if ($blockEmailOld->email != $this->blockEmail->email) {
						$filter = new BlockEmailVo();
						$filter->email = $this->blockEmail->email;
						$voResult = $this->blockEmailService->getBlockEmailByEmail ( $filter );
						if (count ( $voResult ) > 0) {
							$this->addFieldError ( "blockEmail[email]", Lang::getWithFormat ( "{0} has already existed", $this->blockEmail->email ) );
						}
					}
				}
			}
		}
	}
}