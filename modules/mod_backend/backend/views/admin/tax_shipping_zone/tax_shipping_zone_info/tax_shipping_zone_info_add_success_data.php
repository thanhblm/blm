<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$countryList = RequestUtil::get ( "countryList" );
$taxShippingZoneInfo = RequestUtil::get ( "taxShippingZoneInfo" );
$index = RequestUtil::get ( "indexTaxInfo" );
?>
<tr class="gradeX odd taxClassIndex" role="row">
	<td>
		<?php
		$text = new Text ();
		$text->errorMessage = RequestUtil::getFieldError ( "taxShippingZoneInfoList[" . $index . "][id]" );
		$text->hasError = RequestUtil::isFieldError ( "taxShippingZoneInfoList[" . $index . "][id]" );
		$text->name = "taxShippingZoneInfoList[" . $index . "][id]";
		$text->attributes = " readonly ";
		$text->value = $taxShippingZoneInfo->id;
		$text->render ();
		?>
	</td>
	<td>
		<?php
		$select = new SelectInput ( 'select_input_single' );
		$select->errorMessage = RequestUtil::getFieldError ( "taxShippingZoneInfoList[" . $index . "][countryId]" );
		$select->hasError = RequestUtil::isFieldError ( "taxShippingZoneInfoList[" . $index . "][countryId]" );
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
		$select->render ();
		
		$text = new Text ();
		$text->errorMessage = RequestUtil::getFieldError ( "taxShippingZoneInfoList[" . $index . "][countryId]" );
		$text->hasError = RequestUtil::isFieldError ( "taxShippingZoneInfoList[" . $index . "][countryId]" );
		$text->name = "taxShippingZoneInfoList[" . $index . "][countryId]";
		$text->placeholder = Lang::get ( "Country..." );
		$text->value = $taxShippingZoneInfo->countryId;
		// $text->render();
		
		$text = new Text ();
		$text->name = "taxShippingZoneInfoList[" . $index . "][countryId]";
		$text->type = "hidden";
		$text->value = $taxShippingZoneInfo->countryId;
		// $text->render();
		?>
	</td>
	<td>
		<?php
		$select = new SelectInput ( 'select_input_single' );
		$select->errorMessage = RequestUtil::getFieldError ( "taxShippingZoneInfoList[" . $index . "][stateId]" );
		$select->hasError = RequestUtil::isFieldError ( "taxShippingZoneInfoList[" . $index . "][stateId]" );
		$select->name = "taxShippingZoneInfoList[" . $index . "][stateId]";
		$select->headerKey = "";
		$select->class = "form-control input-sm stateSelect";
		$select->headerValue = "Select state";
		$select->collections = array ();
		$select->propertyName = 'id';
		$select->propertyValue = 'name';
		$select->render ();
		?>
	</td>
	<td>
		<?php
		$actionBtn = new ButtonAction ();
		$actionBtn->iconClass = "fa fa-trash-o";
		$actionBtn->color = ButtonAction::COLOR_RED;
		$actionBtn->attributes = "onclick='deleteTaxShippingZoneInfoDialog($(this), " . $index . ")'";
		$actionBtn->title = Lang::get ( "Edit" );
		$actionBtn->render ();
		?>
	</td>
</tr>