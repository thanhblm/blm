<?php
use core\utils\RequestUtil;
?>
<form id="del_category_form" class="form-horizontal" novalidate="novalidate">
	<input name="containerId" type="hidden" value="<?=RequestUtil::get("containerId")?>" />
	<div class="form-body">
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>