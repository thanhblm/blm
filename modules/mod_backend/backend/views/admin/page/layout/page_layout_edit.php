<?php
use core\utils\RequestUtil;
// get data
$pageId = RequestUtil::get ( "pageId" );
?>
<div id="layout_data">
	<?php include "page_layout_edit_data.php"?>
</div>