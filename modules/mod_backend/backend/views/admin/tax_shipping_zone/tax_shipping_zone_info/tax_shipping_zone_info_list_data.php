<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$taxShippingZoneInfoList = RequestUtil::get("taxShippingZoneInfoList")->getArray();
$countryList = RequestUtil::get("countryList");
$stateListArray = RequestUtil::get("stateListArray");
//var_dump($countryList);die;
?>
<div class="table-scrollable" style="max-height: 300px; overflow: auto">
    <table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable" id="page_table_tax">
        <thead>
        <tr role="row">
            <th><?= Lang::get('Id'); ?></th>
            <th><?= Lang::get('Country'); ?></th>
            <th><?= Lang::get('State'); ?></th>
            <th><?= Lang::get('Actions'); ?></th>
        </tr>
        </thead>
        <tbody id="tbody_list_tax_rate_info">
		<?php
		if (empty ($taxShippingZoneInfoList)) {
			?>
            <tr role="row" id="tr_no_data">
                <td colspan="7"><?= Lang::get("No data available...") ?></td>
            </tr>
			<?php
		} else {
			$index = 0;
			foreach ($taxShippingZoneInfoList as $taxShippingZoneInfo) {
				?>
                <tr class="gradeX odd taxClassIndex" role="row">
                    <td>
						<?php
						$text = new TextInput ('text_input_single');
						$text->errorMessage = RequestUtil::getFieldError("taxShippingZoneInfoList[" . $index . "][id]");
						$text->hasError = RequestUtil::isFieldError("taxShippingZoneInfoList[" . $index . "][id]");
						$text->name = "taxShippingZoneInfoList[" . $index . "][id]";
						$text->attributes = " readonly ";
						$text->value = $taxShippingZoneInfo->id;
						$text->render();
						?>
                    </td>
                    <td>
						<?php
						$select = new SelectInput ('select_input_single');
						$select->errorMessage = RequestUtil::getFieldError("taxShippingZoneInfoList[" . $index . "][countryId]");
						$select->hasError = RequestUtil::isFieldError("taxShippingZoneInfoList[" . $index . "][countryId]");
						$select->name = "taxShippingZoneInfoList[" . $index . "][countryId]";
						$select->headerKey = "";
						$select->headerValue = "Select country";
						$select->value = $taxShippingZoneInfo->countryId;
						$select->attributes = "onchange=\"getState(this)\"";
						$select->class = "form-control input-sm";
						$select->required = true;
						$select->collections = $countryList;
						$select->propertyName = "id";
						$select->propertyValue = "name";
						$select->render();
						?>
                    </td>
                    <td>
						<?php
						$select = new SelectInput ('select_input_single');
						$select->errorMessage = RequestUtil::getFieldError("taxShippingZoneInfoList[" . $index . "][stateId]");
						$select->hasError = RequestUtil::isFieldError("taxShippingZoneInfoList[" . $index . "][stateId]");
						$select->name = "taxShippingZoneInfoList[" . $index . "][stateId]";
						$select->headerKey = "";
						$select->class = "form-control input-sm stateSelect";
						$select->headerValue = "Select state";
						$select->value = $taxShippingZoneInfo->stateId;
						$select->collections = $stateListArray [$taxShippingZoneInfo->countryId];
						$select->propertyName = 'id';
						$select->propertyValue = 'name';
						$select->required = true;
						$select->render();
						?>
                    </td>
                    <td>
						<?php
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-trash-o";
						$actionBtn->color = ButtonAction::COLOR_RED;
						$actionBtn->attributes = "onclick='deleteTaxShippingZoneInfoDialog($(this), " . $index . ")'";
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
<script type="text/javascript">
	gUrlAddTax = "<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/info/add/view") ?>" + "?rtype=json";

	function addSuccessTax(res){
		$("#tr_no_data").remove();
		$("#tbody_list_tax_rate_info").append(res.content);
		var countTaxShippingZoneInfo = $("tr.taxClassIndex").length;
		$("#iAddTaxClassInfo").attr("onclick", "addTaxShippingZoneInfoDialog('" + countTaxShippingZoneInfo + "')");
	}

	function addActionErrorTax(res){
		showMessage(res.errorMessage, "error");
		$("#taxShippingZoneInfoAddFormId").replaceWith(res.content);
	}

	function addTaxShippingZoneInfoDialog(index){
		simpleAjaxPost(
			uuid,
			gUrlAddTax + "&indexTaxInfo=" + index,
			"",
			addSuccessTax,
			null,
			addActionErrorTax
		);
	}

	function deleteTaxShippingZoneInfoDialog(element, indexTr){
		var countTaxShippingZoneInfo = $("tr.taxClassIndex").length;
		$("#iAddTaxClassInfo").attr("onclick", "addTaxShippingZoneInfoDialog('" + (countTaxShippingZoneInfo - 1) + "')");
		var trParent = element.parent().parent();
		trParent.nextAll().each(function(index){
			var inputs = $(this).find(' input,select');
			$(this).find("a").attr("id", "aButtonDel" + (indexTr + index));
			$(this).find("a").attr("onclick", 'deleteTaxShippingZoneInfoDialog($(this), ' + (indexTr + index) + ')');
			$.each(inputs, function(obj, v){
				var id = $(v).attr("id");
				$(v).attr("id", id.replace("taxShippingZoneInfoList_" + (indexTr + index + 1), "taxShippingZoneInfoList_" + (indexTr + index)));
				var name = $(v).attr("name");
				$(v).attr("name", name.replace("taxShippingZoneInfoList[" + (indexTr + index + 1) + "]", "taxShippingZoneInfoList[" + (indexTr + index) + "]"));
			});
		});
		trParent.remove();
	}

	function getState(obj){
		var countryId = obj.value;
		var data = "";
		data += "&country_id=" + countryId;
		$.post("<?=ActionUtil::getFullPathAlias("admin/tax/shipping/zone/get/state?rtype=json")?>", data, function(res){
			if (res.errorCode == "SUCCESS") {//alert(res.content);
				var trParent = $(obj).parent().parent();
				trParent.find(".stateSelect").html(res.content);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function(){
			alert("System error.");
		});
	}
</script>
