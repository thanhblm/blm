<?php
use common\template\extend\ButtonAction;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$shippingMethodList = RequestUtil::get ( "shippingMethodList" );
$type = RequestUtil::get ( "type" );
$index = RequestUtil::get ( "indexDiscountCouponProduct" );
$index = AppUtil::defaultIfEmpty ( $index, 0 );
/*
 * $productList = RequestUtil::get ( "productList" );
 * $categoryList = RequestUtil::get ( "categoryList" );
 */
$selectList = RequestUtil::get ( "selectList" );
?>
<tr class="gradeX odd indexDiscountCouponProduct">
	<td>
		<?php
		$select = new SelectInput ( 'select_input_single' );
		$select->errorMessage = RequestUtil::getFieldError ( "applicableProducts[" . $index . "][itemId]" );
		$select->hasError = RequestUtil::isFieldError ( "applicableProducts[" . $index . "][itemId]" );
		$select->class = "form-control input-sm";
		$select->required = true;
		$select->name = "applicableProducts[" . $index . "][itemId]";
		$select->collections = $selectList;
		$select->propertyName = "id";
		$select->propertyValue = "name";
		$select->render ();
		?>
	</td>
	<td>
		<?php
		// if($type==0){echo 'category';}else{echo 'product';}
		$text = new Text ();
		$text->name = "applicableProducts[" . $index . "][itemType]";
		$text->type = "hidden";
		$text->value = $type;
		$text->render ();
		echo $type;
		?>
	</td>
	<td>
		<?php
		$actionBtn = new ButtonAction ();
		$actionBtn->iconClass = "fa fa-trash-o";
		$actionBtn->color = ButtonAction::COLOR_RED;
		$actionBtn->attributes = "onclick='deleteDiscountCouponProduct($(this), " . $index . ")'";
		$actionBtn->title = Lang::get ( "Delete" );
		$actionBtn->render ();
		?>
	</td>
</tr>