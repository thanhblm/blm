<?php
use common\helper\SettingHelper;
use core\Lang;
?>
<input type="radio" data-value-object=''
	onclick="selectPaymentMethod($(this))" id="payment-method_BankTransfer"
	style="float: left; display: inline-block; margin-right: 10px; vertical-align: top; width: 15px; height: 15px;"
	class="input-radio" name="order[paymentMethod]" <?= $checked?>
	value="<?= $paymentMethod->id ?>">
<label><?= $paymentMethod->name ?></label>
<div class="payment_box payment-method_BankTransfer">
	<p><?=Lang::get("The bank information will be shared in your Order Confirmation Email.")?><br/><?=Lang::get(SettingHelper::getSettingValue("Bank transfer notice")) ?></p>
</div>