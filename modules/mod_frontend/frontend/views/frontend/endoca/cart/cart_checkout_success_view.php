<?php 
use core\utils\RequestUtil;

$paymentProcessFile = RequestUtil::get("payment_process_file");
include $paymentProcessFile;
