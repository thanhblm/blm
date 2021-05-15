<?php
use core\utils\RequestUtil;
?>
<form id="del_backend_menu_form" class="form-horizontal" novalidate="novalidate">
	<input name="id" type="hidden" value="<?=RequestUtil::get("id")?>" />
	<div class="form-body">
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>