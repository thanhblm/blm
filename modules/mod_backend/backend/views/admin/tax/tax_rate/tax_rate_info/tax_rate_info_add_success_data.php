<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;
use core\utils\AppUtil;

$taxRateInfo = RequestUtil::get ( "taxRateInfo" );
$zoneMatchs = ApplicationConfig::get ( "tax.zone.match" );
$taxShippingZones = RequestUtil::get ( "taxShippingZones" );
$index = RequestUtil::get ( "indexTaxInfo" );
?>
<tr class="gradeX odd taxClassIndex" role="row">
	<td>
		<?php
		$text = new Text ();
		$text->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][id]" );
		$text->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][id]" );
		$text->name = "taxRateInfoList[" . $index . "][id]";
		$text->attributes = " readonly ";
		$text->value = $taxRateInfo->id;
		$text->render ();
		?>
	</td>
	<td>
		<?php
		$text = new Text ();
		$text->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][name]" );
		$text->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][name]" );
		$text->name = "taxRateInfoList[" . $index . "][name]";
		$text->placeholder = Lang::get ( "Name" );
		$text->value = $taxRateInfo->name;
		$text->render ();
		?>
	</td>
	<td>
		<?php
		$select = new Select ();
		$select->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][taxShippingZoneId]" );
		$select->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][taxShippingZoneId]" );
		$select->headerKey = "";
		$select->class = "form-control input-sm";
		$select->headerValue = "Select One";
		$select->required = true;
		$select->name = "taxRateInfoList[" . $index . "][taxShippingZoneId]";
		$select->value = $taxRateInfo->taxShippingZoneId;
		$select->collections = $taxShippingZones;
		$select->propertyName = "id";
		$select->propertyValue = "name";
		$select->render ();
		
		?>
	</td>
	<td>
		<?php
		$select = new Select ();
		$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
		$select->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][zoneMatch]" );
		$select->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][zoneMatch]" );
		$select->headerKey = "";
		$select->class = "form-control input-sm";
		$select->headerValue = "Select One";
		$select->name = "taxRateInfoList[" . $index . "][zoneMatch]";
		$select->value = $taxRateInfo->zoneMatch;
		$select->required = true;
		$select->collections = $zoneMatchs;
		$select->render ();
		
		$text = new Text();
		$text->type = "hidden";
		$text->name = "taxRateInfoList[" . $index . "][type]";
		$text->value = "static";
		$text->render();
		
		?>
	</td>
	<td>
		<?php
		$text = new Text ();
		$text->type = "number";
		$text->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][rate]" );
		$text->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][rate]" );
		$text->label = Lang::get ( "Rate" );
		$text->name = "taxRateInfoList[" . $index . "][rate]";
		$text->value = $taxRateInfo->rate;
		$text->placeholder = Lang::get ( "Rate" );
		$text->attributes = ' maxlength="2" ';
		$text->render ();
		?>
	</td>
	<td>
		<?php
		$text = new Text ();
		$text->type = "number";
		$text->errorMessage = RequestUtil::getFieldError ( "taxRateInfoList[" . $index . "][priority]" );
		$text->hasError = RequestUtil::isFieldError ( "taxRateInfoList[" . $index . "][priority]" );
		$text->label = Lang::get ( "Priority" );
		$text->name = "taxRateInfoList[" . $index . "][priority]";
		$text->value = AppUtil::defaultIfEmpty($taxRateInfo->priority,0);
		$text->placeholder = Lang::get ( "Priority" );
		$text->render ();
		?>
	</td>
	<td>
		<?php
		$actionBtn = new ButtonAction ();
		$actionBtn->iconClass = "fa fa-trash-o";
		$actionBtn->color = ButtonAction::COLOR_RED;
		$actionBtn->attributes = "onclick='deleteTaxRateInfoDialog($(this), " . $index . ")'";
		$actionBtn->title = Lang::get ( "Edit" );
		$actionBtn->render ();
		?>
	</td>
</tr>

