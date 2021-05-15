<?php
use core\utils\RequestUtil;
?>
<form id="del_category_form" class="form-horizontal" novalidate="novalidate">
	<input name="pageId" type="hidden" value="<?=RequestUtil::get("pageId")?>" />
	<div class="form-body">
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>