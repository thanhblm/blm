<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use frontend\service\SelectHelper;
?>
<input type="radio" data-value-object=''
	onclick="selectPaymentMethod($(this))" id="payment-method_authorizenet"
	style="float: left; display: inline-block; margin-right: 10px; vertical-align: top; width: 15px; height: 15px;"
	class="input-radio" name="order[paymentMethod]" <?= $checked?>
	value="<?= $paymentMethod->id ?>">
<label><?= Lang::get('Credit Card') ?></label>
<div class="payment_box payment-method_authorizenet">
	<div style="display: none;"
		id="payment_<?php echo $paymentMethod->id; ?>_desc"
		class="payment_box payment_desc payment-method_authorizenet">
		
	</div>
</div>
