<?php
use core\utils\RequestUtil;
?>
<form id="del_discount_coupon_form" class="form-horizontal" novalidate="novalidate">
	<input name="id" type="hidden" value="<?=RequestUtil::get("id")?>" />
	<div class="form-body">
		<p><?=RequestUtil::getActionMessage()?></p>
	</div>
</form>