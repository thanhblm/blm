<?php
use common\template\extend\FormContainer;
use common\template\extend\Link;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$taxRate = RequestUtil::get("taxRate");
$form = new FormContainer ();
$form->id = "taxRateAddFormId";
$form->attributes = 'class="form-horizontal" ';

$form->renderStart();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError("taxRate[name]");
	$text->hasError = RequestUtil::isFieldError("taxRate[name]");
	$text->label = Lang::get("Name");
	$text->required = true;
	$text->name = "taxRate[name]";
	$text->value = $taxRate->name;
	$text->render();
	?>
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption font-green-sharp">
                <i class="fa fa-cogs"></i><?= Lang::get("Rate list") ?>
            </div>
            <div class="actions">
                <?php
                    $link = new Link();
                    $link->class = "btn btn-circle blue";
                    $link->link = "javascript:addTaxRateInfoDialog(\"0\");";
                    $link->title = "<i class=\"fa fa-plus white\"></i> ".Lang::get("Add new tax rate");
                    $link->id = "iAddTaxClassInfo";
                    $link->render();
                
                    $link = new Link();
                    $link->class = "btn btn-circle blue";
                    $link->link = "javascript:addTaxRateDynamicDialog(\"0\");";
                    $link->title = "<i class=\"fa fa-plus white\"></i> ".Lang::get("Add new dynamic tax rate");
                    $link->id = "iAddTaxClassDynamic";
                    $link->render();
                    
                    $link = new Link();
                    $link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
                    $link->render();
                ?>

            </div>
        </div>
        <form id="page_form_tax">
            <div class="portlet-body" id="page_result_tax">
				<?php include 'tax_rate_info/tax_rate_info_list_data.php'; ?>
            </div>
        </form>
    </div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var countTaxRateInfo = $("tr.taxClassIndex").length;
        $("a#iAddTaxClassInfo").attr("href", "javascript:addTaxRateInfoDialog('" + countTaxRateInfo + "')");
        $("a#iAddTaxClassDynamic").attr("href", "javascript:addTaxRateDynamicDialog('" + countTaxRateInfo + "')");
    });
</script>
