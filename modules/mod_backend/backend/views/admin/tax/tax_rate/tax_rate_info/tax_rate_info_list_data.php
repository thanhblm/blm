<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$taxRateInfo = RequestUtil::get("taxRateInfo");
$taxRateInfoList = RequestUtil::get("taxRateInfoList")->getArray();
$zoneMatchs = ApplicationConfig::get("tax.zone.match");
$taxRateDynamicList = ApplicationConfig::get ( "tax.rate.dynamic.list" );
$taxShippingZones = RequestUtil::get("taxShippingZones");
?>
<div class="table-scrollable" style="max-height: 300px; overflow: auto">
    <div id="scroll-div">
        <table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable" id="page_table_tax">
            <thead class="flip-content">
            <tr role="row">
                <th><?= Lang::get('Id'); ?></th>
                <th><?= Lang::get('Name'); ?></th>
                <th><?= Lang::get('Shipping Zone'); ?></th>
                <th><?= Lang::get('Zone Match'); ?></th>
                <th><?= Lang::get('Tax Rate'); ?></th>
                <th><?= Lang::get('Priority'); ?></th>
                <th><?= Lang::get('Actions'); ?></th>
            </tr>
            </thead>
            <tbody id="tbody_list_tax_rate_info">
			<?php
			if (empty ($taxRateInfoList)) {
				?>
                <tr role="row" id="tr_no_data">
                    <td colspan="7"><?= Lang::get("No data available...") ?></td>
                </tr>
				<?php
			} else {
				$index = 0;
				foreach ($taxRateInfoList as $taxRateInfo) {
					?>
                    <tr class="gradeX odd taxClassIndex" role="row">
                        <td>
							<?php
							$text = new TextInput ('text_input_single');
							$text->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][id]");
							$text->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][id]");
							$text->name = "taxRateInfoList[" . $index . "][id]";
							$text->attributes = " readonly ";
							$text->value = $taxRateInfo->id;
							$text->render();
							?>
                        </td>
                        <td>
							<?php
							$text = new TextInput ('text_input_single');
							$text->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][name]");
							$text->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][name]");
							$text->name = "taxRateInfoList[" . $index . "][name]";
							$text->placeholder = Lang::get("Name");
							$text->value = $taxRateInfo->name;
							$text->render();
							?>
                        </td>
                        <td>
							<?php
							$select = new SelectInput ('select_input_single');
							$select->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][taxShippingZoneId]");
							$select->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][taxShippingZoneId]");
							$select->headerKey = "";
							$select->class = "form-control input-sm";
							$select->headerValue = "Select One";
							$select->required = true;
							$select->name = "taxRateInfoList[" . $index . "][taxShippingZoneId]";
							$select->value = $taxRateInfo->taxShippingZoneId;
							$select->collections = $taxShippingZones;
							$select->propertyName = "id";
							$select->propertyValue = "name";
							$select->render();
							?>
                        </td>
                        <td>
							<?php
							$select = new SelectInput ('select_input_single');
							$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
							$select->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][zoneMatch]");
							$select->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][zoneMatch]");
							$select->headerKey = "";
							$select->class = "form-control input-sm";
							$select->headerValue = "Select One";
							$select->name = "taxRateInfoList[" . $index . "][zoneMatch]";
							$select->value = $taxRateInfo->zoneMatch;
							$select->required = true;
							$select->collections = $zoneMatchs;
							$select->render();
							
							?>
                        </td>
                        <td>
							<?php
							if('dynamic' === $taxRateInfo->type ){
								$select = new SelectInput("select_input_single");
								$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
								$select->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][dynamicRate]" );
								$select->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][dynamicRate]" );
								$select->headerKey = "";
								$select->class = "form-control input-sm";
								$select->headerValue = "Select One";
								$select->name = "taxRateInfoList[" . $index . "][dynamicRate]";
								$select->value = $taxRateInfo->dynamicRate;
								$select->required = true;
								$select->collections = $taxRateDynamicList;
								$select->render ();
								
								$text = new Text();
								$text->type = "hidden";
								$text->name = "taxRateInfoList[" . $index . "][type]";
								$text->value = "dynamic";
								$text->render();
							}else{
								$text = new TextInput ('text_input_single');
								$text->type = "number";
								$text->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][rate]");
								$text->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][rate]");
								$text->label = Lang::get("Rate");
								$text->name = "taxRateInfoList[" . $index . "][rate]";
								$text->value = $taxRateInfo->rate;
								$text->required = true;
								$text->placeholder = Lang::get("Rate");
								$text->attributes = ' maxlength="2" ';
								$text->render();
								
								$text = new Text();
								$text->type = "hidden";
								$text->name = "taxRateInfoList[" . $index . "][type]";
								$text->value = "static";
								$text->render();
							}
							
							?>
                        </td>
                        <td>
							<?php
							$text = new TextInput ('text_input_single');
							$text->type = "number";
							$text->errorMessage = RequestUtil::getFieldError("taxRateInfoList[" . $index . "][priority]");
							$text->hasError = RequestUtil::isFieldError("taxRateInfoList[" . $index . "][priority]");
							$text->label = Lang::get("Priority");
							$text->name = "taxRateInfoList[" . $index . "][priority]";
							$text->value = AppUtil::defaultIfEmpty($taxRateInfo->priority,0);
							$text->placeholder = Lang::get("Priority");
							$text->render();
							?>
                        </td>
                        <td>
							<?php
							$actionBtn = new ButtonAction ();
							$actionBtn->iconClass = "fa fa-trash-o";
							$actionBtn->color = ButtonAction::COLOR_RED;
							$actionBtn->attributes = "onclick='deleteTaxRateInfoDialog($(this), " . $index . ")'";
							$actionBtn->title = Lang::get("Edit");
							$actionBtn->render();
							?>
                        </td>
                    </tr>
					<?php
					$index += 1;
				}
			}
			?>
            </tbody>
        </table>
    </div>
</div>
<!-- Max length -->
<script type="text/javascript" src="<?=AppUtil::resource_url("global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js")?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
	    $("input[maxlength]").maxlength({
		    threshold: 2
        });
    });

    var scrollHeight = $("#scroll-div").height();
    gUrlAddTax = "<?=ActionUtil::getFullPathAlias("admin/tax/rate/info/add/view") ?>" + "?rtype=json";
    gUrlAddTaxDynamic = "<?=ActionUtil::getFullPathAlias("admin/tax/rate/info/dynamic/add/view") ?>" + "?rtype=json";

    function addSuccessTax(res) {
        $("#tr_no_data").remove();
        $("#tbody_list_tax_rate_info").append(res.content);
        var countTaxRateInfo = $("tr.taxClassIndex").length;
        $("a#iAddTaxClassInfo").attr("href", "javascript:addTaxRateInfoDialog('" + countTaxRateInfo + "')");
        $("a#iAddTaxClassDynamic").attr("href", "javascript:addTaxRateDynamicDialog('" + countTaxRateInfo + "')");
        $(".table-scrollable").animate({scrollTop: scrollHeight}, 500);
        scrollHeight += $("#scroll-div").height();
    }

    function addActionErrorTax(res) {
        showMessage(res.errorMessage, "error");
        $("#taxRateInfoAddFormId").replaceWith(res.content);
    }

    function addTaxRateInfoDialog(index) {
        simpleAjaxPost(
            uuid,
            gUrlAddTax + "&indexTaxInfo=" + index,
            "",
            addSuccessTax,
            null,
            addActionErrorTax
        );
    }

    function addTaxRateDynamicDialog(index) {
        simpleAjaxPost(
            uuid,
            gUrlAddTaxDynamic + "&indexTaxInfo=" + index,
            "",
            addSuccessTax,
            null,
            addActionErrorTax
        );
    }

    function deleteTaxRateInfoDialog(element, indexTr) {
        var countTaxRateInfo = $("tr.taxClassIndex").length;
        $("a#iAddTaxClassInfo").attr("href", "javascript:addTaxRateInfoDialog('" + (countTaxRateInfo - 1) + "')");
        $("a#iAddTaxClassDynamic").attr("href", "javascript:addTaxRateDynamicDialog('" + (countTaxRateInfo - 1) + "')");
        var trParent = element.parent().parent();
        trParent.nextAll().each(function (index) {
            var inputs = $(this).find(' input,select');
            $(this).find("a").attr("id", "aButtonDel" + (indexTr + index));
            $(this).find("a").attr("onclick", 'deleteTaxRateInfoDialog($(this), ' + (indexTr + index) + ')');
            $.each(inputs, function (obj, v) {
                var id = $(v).attr("id");
                $(v).attr("id", id.replace("taxRateInfoList_" + (indexTr + index + 1), "taxRateInfoList_" + (indexTr + index)));
                var name = $(v).attr("name");
                $(v).attr("name", name.replace("taxRateInfoList[" + (indexTr + index + 1) + "]", "taxRateInfoList[" + (indexTr + index) + "]"));
            });
        });
        trParent.remove();
    }
</script>
