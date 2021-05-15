<?php
use core\utils\RequestUtil;
if (RequestUtil::hasErrors ()) {
	if (RequestUtil::hasFieldErrors ()) {
		echo RequestUtil::getFieldErrors ();
	} else {
		echo RequestUtil::getFieldErrors ();
	}
} else {
	echo RequestUtil::getActionMessage ();
}
?>