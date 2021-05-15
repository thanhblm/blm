<?php
use core\utils\RequestUtil;
?>
<form id="del_language_form" class="form-horizontal" novalidate="novalidate">
	<input name="code" type="hidden" value="<?=RequestUtil::get("code")?>" />
	<div class="form-body">
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>