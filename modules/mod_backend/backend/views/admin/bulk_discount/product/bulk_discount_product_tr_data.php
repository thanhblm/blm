<?php 
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\ButtonAction;

$products = RequestUtil::get("products");
$index = RequestUtil::get("index");
?>
<tr class="gradeX odd productDiscountIndex" role="row">
	<td>
		<?php
		$select = new Select();
		$select->name = "bulkDiscountProducts[".$index."][productId]";
		$select->headerKey = "";
		$select->headerValue = Lang::get ( 'Select One' );
		$select->propertyName = "id";
		$select->propertyValue = "name";
		$select->collections = $products;
		$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
		$select->class = "form-control input-sm";
		$select->attributes = "style='width:100%'";
		$select->render ();
		?>
	</td>
	<td>
		<?php
		$text = new Text();
		$text->name = "bulkDiscountProducts[".$index."][quantity]";
		$text->required = true;
		$text->placeholder = "Quantity";
		$text->class = 'form-control input-sm number';
		$text->type = 'number';
		$text->attributes = "min='0'";
		$text->render ();
		?>
	</td>
	<td>
		<?php 
		$actionBtn = new ButtonAction();
		$actionBtn->iconClass = "fa fa-trash-o";
		$actionBtn->color = ButtonAction::COLOR_RED;
		$actionBtn->attributes = "onclick='deleteTaxRateInfoDialog($(this), ".$index.")'";
		$actionBtn->render (); 
		?>
	</td>
</tr>