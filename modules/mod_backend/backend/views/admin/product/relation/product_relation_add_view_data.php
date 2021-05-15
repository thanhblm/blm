<?php 
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\Lang;
use common\template\extend\Select;

$allProducts = RequestUtil::get ( 'allProducts' );
$productRelations = RequestUtil::get('productRelations');
?>
<div class="form-body">
	<?php
	$select = new Select ();
	$select->id = "productRelate";
	$select->name = "productRelate";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( 'Select a Product' );
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->collections = $allProducts;
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->class = "form-control";
	$select->attributes = "style='width:100%'";
	$select->render ();
	?>
</div>
<br>
<div id="listProductRelations" class="form-body">
<?php 
if(count($productRelations->getArray())>0){
	$i=0;
	foreach ($productRelations->getArray() as $relate){
?>
	<div class="product-relate-row" data-productId="<?=$relate->relateProductId?>" style="border-bottom: solid 1px #ccc;padding : 5px 0px 5px 0px">
		<input class="product-relate-name-hidden" type="hidden" name="productRelations[<?=$i?>][name]" value="<?=$relate->name?>">
		<input class="product-relate-id" type="hidden" name="productRelations[<?=$i?>][relateProductId]" value="<?=$relate->relateProductId?>">
		<a class="delete-product-relate" href="javascript:void(0)" onclick="delProductRelate(<?=$relate->relateProductId?>)"><i class="fa fa-trash-o"></i></a>
		<span class="product-relate-name"><?=$relate->name?></span>
	</div>
<?php
		$i++;
	}
}?>
</div>
<?php include_once 'product_relation_form_data.php';?>
