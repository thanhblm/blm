<?php
use common\template\extend\FormContainer;
use common\template\extend\Link;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;

$taxShippingZone = RequestUtil::get("taxShippingZone");
$form = new FormContainer ();
$form->id = "taxShippingZoneEditFormId";
$form->attributes = 'class="form-horizontal" ';
$form->renderStart();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->name = "taxShippingZone[id]";
	$text->value = $taxShippingZone->id;
	$text->type = "hidden";
	$text->render();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError("taxShippingZone[name]");
	$text->hasError = RequestUtil::isFieldError("taxShippingZone[name]");
	$text->label = Lang::get("Name");
	$text->required = true;
	$text->name = "taxShippingZone[name]";
	$text->value = $taxShippingZone->name;
	$text->render();
	?>
    <div class="form-group <?= RequestUtil::isFieldError("taxShippingZone[exclusive]") ? "has-error" : "" ?>">
        <label class="control-label col-md-4"><?= Lang::get("Include / Exclude all regions listed below") ?></label>
        <div class="col-md-8 ">
            <div class="mt-radio-inline">
		        <?php
		        foreach (ApplicationConfig::get("tax.shipping.zone.excluse.list") as $key => $value) {
			        ?>
                    <label class="mt-radio mt-radio-outline">
                        <input type="radio" name="taxShippingZone[exclusive]" value="<?= $key ?>" <?php if ($taxShippingZone->exclusive == $key) echo 'checked="checked"'; ?> />
				        <?= $value ?>
                        <span></span>
                    </label>
			        <?php
		        }
		        ?>
            </div>
            <span class="help-block"><?= RequestUtil::getFieldError("taxShippingZone[exclusive]") ?></span>
        </div>
    </div>
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption green-sharp">
                <i class="fa fa-cogs"></i><?= Lang::get("Locations") ?>
            </div>
            <div class="actions">
				<?php
				$link = new Link();
				$link->class = "btn btn-circle blue";
				$link->attributes = "onclick=\"addTaxShippingZoneInfoDialog('0')\"";
				$link->title = "<i class=\"fa fa-plus white\"></i> " . Lang::get("Add new");
				$link->id = "iAddTaxClassInfo";
				$link->render();

				$link = new Link();
				$link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
				$link->render();
				?>
            </div>
        </div>
        <form id="page_form_tax">
            <div class="portlet-body flip-scroll" id="page_result_tax">
				<?php include 'tax_shipping_zone_info/tax_shipping_zone_info_list_data.php'; ?>
            </div>
        </form>
    </div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		var countTaxRateInfo = $("tr.taxClassIndex").length;
		$("#iAddTaxClassInfo").attr("onclick", "addTaxShippingZoneInfoDialog('" + countTaxRateInfo + "')");
	});
</script>
