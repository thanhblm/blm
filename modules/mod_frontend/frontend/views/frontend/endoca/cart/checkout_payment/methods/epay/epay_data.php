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
		<div class="_field _wide">
			<div class="_label"><?php echo Lang::get('Full Name on Credit Card:'); ?></div>
		<?php
		$text = new TextInput ();
		$text->type = "text";
		$text->name = "epay_cc_name";
		$text->value = RequestUtil::get ( 'epay_cc_name' );
		$text->required = "required";
		$text->placeholder = "";
		$text->errorMessage = "";
		$text->hasError = RequestUtil::isFieldError ( "epay_cc_name" );
		$text->class = "frm_field frm_text";
		$text->attributes = 'autocomplete="off"';
		$text->render ();
		?>
		</div>
		<div class="_field _wide">
			<div class="_label"><?php echo Lang::get('Credit Card Type:');?></div>
		<?php
		$select = new SelectInput ();
		$select->value = RequestUtil::get ( 'epay_cc_type' );
		;
		$select->name = "epay_cc_type";
		$select->collections = SelectHelper::getCCTypeArr ();
		$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
		// $select->label = Lang::get ( "Credit Card Type:" );
		$select->errorMessage = RequestUtil::getFieldError ( "epay_cc_type" );
		$select->hasError = RequestUtil::isFieldError ( "epay_cc_type" );
		$select->required = true;
		$select->render ();
		?>
		</div>
		<div class="_field _wide">
			<div class="_label"><?php echo Lang::get('Credit Card Number:'); ?></div>
		<?php
		$text = new TextInput ();
		$text->type = "text";
		$text->name = "epay_cc_number";
		$text->value = RequestUtil::get ( 'epay_cc_number' );
		$text->required = "required";
		$text->placeholder = "";
		$text->errorMessage = "";
		$text->hasError = RequestUtil::isFieldError ( "epay_cc_number" );
		$text->class = "frm_field frm_text";
		$text->attributes = 'autocomplete="off"';
		$text->render ();
		?>
		</div>
		<div class="_field _wide">
			<div class="_label"><?php echo Lang::get('Credit Card Expiry Date:');?></div>
		<?php
		$select = new SelectInput ();
		$select->value = RequestUtil::get ( 'epay_cc_month' );
		;
		$select->name = "epay_cc_month";
		$select->collections = SelectHelper::getCCMonthArr ();
		$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
		// $select->label = Lang::get ( "Year" );
		$select->errorMessage = RequestUtil::getFieldError ( "epay_cc_month" );
		$select->hasError = RequestUtil::isFieldError ( "epay_cc_month" );
		$select->required = true;
		$select->render ();
		
		$select = new SelectInput ();
		$select->value = RequestUtil::get ( 'epay_cc_year' );
		;
		$select->name = "epay_cc_year";
		$select->collections = SelectHelper::getCCYearArr ();
		$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
		// $select->label = Lang::get ( "Year" );
		$select->errorMessage = RequestUtil::getFieldError ( "epay_cc_year" );
		$select->hasError = RequestUtil::isFieldError ( "epay_cc_year" );
		$select->required = true;
		$select->render ();
		?>
		</div>
		<div class="_field _wide">
			<div class="_label"><?php echo Lang::get('Credit Card Security Code (CVV):');?></div>
		<?php
		$text = new TextInput ();
		$text->type = "text";
		$text->name = "epay_cc_cvv";
		$text->value = RequestUtil::get ( 'epay_cc_cvv' );
		$text->required = "required";
		$text->placeholder = "CVV";
		$text->errorMessage = "";
		$text->hasError = RequestUtil::isFieldError ( "epay_cc_cvv" );
		$text->class = "_short";
		$text->attributes = 'size="4" maxlength="4" autocomplete="off"';
		$text->render ();
		?>
			</div>
	</div>
</div>
