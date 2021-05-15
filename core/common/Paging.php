<?php

namespace core\common;

class Paging {
	public $currentPage;
	public $firstPage;
	public $lastPage;
	public $totalPage;
	public $records;
	public $totalRecords;
	public $nlinks;
	public $pageSize;
	public $pageRange;
	public $hasNext;
	public $hasPrev;
	public $startRecord;
	public $endRecord;
	public function __construct($totalRecords = 0, $pageSize = 10, $nLinks = 10, $currentPage = 1) {
		// Initial values.
		$this->records = array ();
		$this->totalRecords = $totalRecords;
		$this->pageSize = $pageSize;
		$this->nlinks = $nLinks;
		$this->currentPage = $currentPage;
		$this->firstPage = 1;
		$this->lastPage = 1;
		$this->hasPrev = true;
		$this->hasNext = true;
		// Do paging.
		$this->doPaging ();
	}
	private function doPaging() {
		// Get total page.
		$this->totalPage = ceil ( $this->totalRecords / $this->pageSize );
		// Check if the current page is last page?
		if ($this->currentPage >= $this->totalPage) {
			$this->currentPage = $this->totalPage;
			$this->hasNext = false;
			$this->lastPage = $this->totalPage;
		} else {
			$this->hasNext = true;
			$this->lastPage = $this->currentPage + $this->nlinks;
			if ($this->lastPage >= $this->totalPage) {
				$this->lastPage = $this->totalPage;
			}
		}
		// Check if the current page is first page.
		if ($this->currentPage <= 1) {
			$this->currentPage = 1;
			$this->hasPrev = false;
			$this->firstPage = 1;
		} else {
			$this->hasPrev = true;
			$this->firstPage = $this->currentPage - $this->nlinks;
			if ($this->firstPage <= 1) {
				$this->firstPage = 1;
			}
		}
		// Create page range.
		$this->pageRange = array ();
		for($i = $this->firstPage; $i <= $this->lastPage; $i ++) {
			$this->pageRange [] = $i;
		}
		// Determine start, end record.
		$this->startRecord = ($this->currentPage - 1) * $this->pageSize + 1;
		$endRecord = $this->currentPage * $this->pageSize;
		if ($endRecord > $this->totalRecords) {
			$endRecord = $this->totalRecords;
		}
		$this->endRecord = $endRecord;
	}
}