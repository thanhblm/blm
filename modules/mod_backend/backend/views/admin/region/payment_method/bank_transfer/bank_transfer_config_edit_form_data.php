<?php
use common\template\extend\FormContainer;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;
use common\template\extend\TextArea;

$paymentMethodSetting = RequestUtil::get("regionPaymentMethodSetting");

$form = new FormContainer ();
$form->id = "edit_payment_method_setting_form";
$form->renderStart();
?>
<div class="form-body">
	<?php
	$select = new SelectInput ("select_input_fluid");
	$select->label = Lang::get("Status");
	$select->name = "regionPaymentMethodSetting[status]";
	$select->errorMessage = RequestUtil::getFieldError("regionPaymentMethodSetting[status]");
	$select->hasError = RequestUtil::isFieldError("regionPaymentMethodSetting[status]");
	$select->required = true;
	$select->collections = ApplicationConfig::get("common.status.list");
	$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
	$select->value = $paymentMethodSetting->status;
	$select->render();
	?>
    <span class="title"><?= Lang::get("Accept Bank Transfer payments?") ?></span>
	<?php
	$select = new SelectInput ("select_input_fluid");
	$select->label = Lang::get("Pending Order Status");
	$select->name = "regionPaymentMethodSetting[pendingOrderStatus]";
	$select->errorMessage = RequestUtil::getFieldError("regionPaymentMethodSetting[pendingOrderStatus]");
	$select->hasError = RequestUtil::isFieldError("regionPaymentMethodSetting[pendingOrderStatus]");
	$select->required = true;
	$select->collections = RequestUtil::get("orderStatuses");
	$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->value = $paymentMethodSetting->pendingOrderStatus;
	$select->render();
	?>
    <span class="title"><?= Lang::get("Status of the Order which didn't (yet) receive successful payment notification") ?></span>
    <div class="form-group">
        <label>Info Text</label>
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <ul class="nav nav-tabs tabs-left">
					<?php
					$isFirst = true;
					if (!empty ($paymentMethodSetting->infoTexts->getArray())) {
						foreach ($paymentMethodSetting->infoTexts->getArray() as $infoText) {
							?>
                            <li <?= $isFirst ? "class='active'" : "" ?>>
                                <a href="#info_text_<?= $infoText->langCode ?>" data-toggle="tab">
                                    <img src="<?= AppUtil::resource_url("global/img/flags/" . strtolower($infoText->flag) . ".png") ?>"/> <?= $infoText->langName ?>
                                </a>
                            </li>
							<?php
							$isFirst = false;
						}
					}
					?>
                </ul>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="tab-content">
					<?php
					$index = 0;
					if (!empty ($paymentMethodSetting->infoTexts->getArray())) {
						foreach ($paymentMethodSetting->infoTexts->getArray() as $infoText) {
							?>
                            <div class="tab-pane fade <?= $index == 0 ? "active in" : "" ?>" id="info_text_<?= $infoText->langCode ?>">
                                <div class="form-body">
                                    <input type="hidden" name="regionPaymentMethodSetting[infoTexts][<?= $index ?>][langCode]" value="<?= $infoText->langCode ?>"/>
                                    <input type="hidden" name="regionPaymentMethodSetting[infoTexts][<?= $index ?>][langName]" value="<?= $infoText->langName ?>"/>
                                    <input type="hidden" name="regionPaymentMethodSetting[infoTexts][<?= $index ?>][flag]" value="<?= $infoText->flag ?>"/>
									<?php
									$text = new TextArea ('textarea_fluid');
									$text->errorMessage = RequestUtil::getFieldError("regionPaymentMethodSetting[infoTexts][" . $index . "][info]");
									$text->hasError = RequestUtil::isFieldError("regionPaymentMethodSetting[infoTexts][" . $index . "][info]");
									$text->value = $infoText->info;
									$text->name = "regionPaymentMethodSetting[infoTexts][" . $index . "][info]";
									$text->class = "ckeditor";
									$text->render();
									?>
                                </div>
                            </div>
							<?php
							$index++;
						}
					}
					?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>