<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use frontend\service\SelectHelper;
use frontend\service\PaymentHelper;

?>
<input type="radio" data-value-object=''
       onclick="selectPaymentMethod($(this))" id="payment-method_authorizenet"
       style="float: left; display: inline-block; margin-right: 10px; vertical-align: top; width: 15px; height: 15px;"
       class="input-radio" name="order[paymentMethod]" <?= $checked ?>
       value="<?= $paymentMethod->id ?>">
<label><?= Lang::get('Credit Card') ?></label>
<div class="payment_box payment-method_authorizenet">
    <div style="display: none;"
         id="payment_<?php echo $paymentMethod->id; ?>_desc"
         class="payment_box payment_desc payment-method_authorizenet">
        <div class="_field _wide">
            <div class="_label"><?php echo Lang::get('Full Name on Credit Card:'); ?></div>
            <div class="row">
                <div class="col-xs-6">
					<?php
					$text = new TextInput ();
					$text->type = "text";
					$text->name = "authorizenet_cc_name";
					$text->value = RequestUtil::get('authorizenet_cc_name');
					$text->required = "required";
					$text->placeholder = "";
					$text->errorMessage = RequestUtil::getFieldError("authorizenet_cc_name");
					$text->hasError = RequestUtil::isFieldError("authorizenet_cc_name");
					$text->class = "frm_field frm_text";
					$text->attributes = 'autocomplete="off"';
					$text->render();
					?>
                </div>
            </div>
        </div>
        <div class="_field _wide">
            <div class="_label"><?php echo Lang::get('Credit Card Type:'); ?></div>
            <div class="row">
                <div class="col-xs-6">
					<?php
					$select = new SelectInput ();
					$select->value = RequestUtil::get('authorizenet_cc_type');;
					$select->name = "authorizenet_cc_type";
					$select->collections = SelectHelper::getCCTypeArr();
					$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
					// $select->label = Lang::get ( "Credit Card Type:" );
					$select->errorMessage = RequestUtil::getFieldError("authorizenet_cc_type");
					$select->hasError = RequestUtil::isFieldError("authorizenet_cc_type");
					$select->required = true;
					$select->class = " ";
					$select->render();
					?>
                </div>
            </div>
        </div>
        <div class="_field _wide">
            <div class="_label"><?php echo Lang::get('Credit Card Number:'); ?></div>
            <div class="row">
                <div class="col-xs-6">
					<?php
					$text = new TextInput ();
					$text->type = "text";
					$text->name = "authorizenet_cc_number";
					$text->value = RequestUtil::get('authorizenet_cc_number');
					$text->required = "required";
					$text->placeholder = "";
					$text->errorMessage = RequestUtil::getFieldError("authorizenet_cc_number");
					$text->hasError = RequestUtil::isFieldError("authorizenet_cc_number");
					$text->class = "frm_field frm_text";
					$text->attributes = 'autocomplete="off"';
					$text->render();
					?>
                </div>
            </div>
        </div>
        <div class="_field _wide">
            <div class="_label"><?php echo Lang::get('Credit Card Expiry Date:'); ?></div>
            <div class="row">
                <div class="col-xs-4">
					<?php
					$select = new SelectInput ();
					$select->value = RequestUtil::get('authorizenet_cc_month');
					$select->name = "authorizenet_cc_month";
					$select->collections = SelectHelper::getCCMonthArr();
					$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
					// $select->label = Lang::get ( "Year" );
					$select->errorMessage = RequestUtil::getFieldError("authorizenet_cc_month");
					$select->hasError = RequestUtil::isFieldError("authorizenet_cc_month");
					$select->required = true;
					$select->class = "_short";
					$select->render();
					?>
                </div>
                <div class="col-xs-2">
					<?php
					$select = new SelectInput ();
					$select->value = RequestUtil::get('authorizenet_cc_year');
					$select->name = "authorizenet_cc_year";
					$select->collections = SelectHelper::getCCYearArr();
					$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
					// $select->label = Lang::get ( "Year" );
					$select->errorMessage = RequestUtil::getFieldError("authorizenet_cc_year");
					$select->hasError = RequestUtil::isFieldError("authorizenet_cc_year");
					$select->required = true;
					$select->class = "_short";
					$select->render();
					?>
                </div>
            </div>
        </div>
        <div class="_field _wide">
            <div class="_label"><?php echo Lang::get('Credit Card Security Code (CVV):'); ?></div>
            <div class="row">
                <div class="col-xs-3">
					<?php
					$text = new TextInput ();
					$text->type = "text";
					$text->name = "authorizenet_cc_cvv";
					$text->value = RequestUtil::get('authorizenet_cc_cvv');
					$text->required = "required";
					$text->placeholder = "CVV";
					$text->errorMessage = RequestUtil::getFieldError("authorizenet_cc_cvv");
					$text->hasError = RequestUtil::isFieldError("authorizenet_cc_cvv");
					$text->class = "_short";
					$text->attributes = 'size="4" maxlength="4" autocomplete="off"';
					$text->render();
					?>
                </div>
            </div>
        </div>
        <div class="_field _wide" style="color: #81ad00;">
        	<?=Lang::get("Payments are processed by Connor-Nolan, Inc., a third party processor. Your credit card statement will reflect Connor-Nolan, Inc as well.") ?>
        </div>
    </div>
</div>
