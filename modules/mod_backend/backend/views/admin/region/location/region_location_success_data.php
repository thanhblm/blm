<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$countryList = RequestUtil::get ( "countryList" );
$index = RequestUtil::get ( "indexRegionCountry" );
$index = AppUtil::defaultIfEmpty ( $index, 0 );
?>

<tr class="gradeX odd indexRegionCountry" role="row">
	<td>
		<?php
		$select = new SelectInput ( 'select_input_single' );
		$select->errorMessage = RequestUtil::getFieldError ( "regionCountries[" . $index . "][countryId]" );
		$select->hasError = RequestUtil::isFieldError ( "regionCountries[" . $index . "][countryId]" );
		$select->headerKey = "";
		$select->class = "form-control input-sm";
		$select->headerValue = "Select One";
		$select->name = "regionCountries[" . $index . "][countryId]";
		$select->value = "";
		$select->collections = $countryList;
		$select->propertyName = "id";
		$select->propertyValue = "name";
		$select->attributes = "onChange=\"getState(this);\"";
		$select->render ();
		?>
	</td>
	<td>
		<?php 
		include 'region_location_state_add_res_data.php';
		?>
	</td>
	<td>
		<?php
		$actionBtn = new ButtonAction ();
		$actionBtn->iconClass = "fa fa-trash-o";
		$actionBtn->color = ButtonAction::COLOR_RED;
		$actionBtn->attributes = "onclick='deleteRegionCountry($(this), " . $index . ")'";
		$actionBtn->title = Lang::get ( "Delete" );
		$actionBtn->render ();
		?>
	</td>
</tr>