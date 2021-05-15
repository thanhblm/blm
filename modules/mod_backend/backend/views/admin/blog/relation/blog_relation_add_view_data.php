<?php 
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\Lang;
use common\template\extend\Select;

$allProducts = RequestUtil::get ( 'allProducts' );
$blogRelations = RequestUtil::get('blogRelations');
?>
<div class="form-body">
	<?php
	$select = new Select ();
	$select->id = "blogRelate";
	$select->name = "blogRelate";
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
if(count($blogRelations->getArray())>0){
	$i=0;
	foreach ($blogRelations->getArray() as $relate){
?>
	<div class="blog-relate-row" data-blogId="<?=$relate->relateProductId?>" style="border-bottom: solid 1px #ccc;padding : 5px 0px 5px 0px">
		<input class="blog-relate-name-hidden" type="hidden" name="blogRelations[<?=$i?>][name]" value="<?=$relate->name?>">
		<input class="blog-relate-id" type="hidden" name="blogRelations[<?=$i?>][relateProductId]" value="<?=$relate->relateProductId?>">
		<a class="delete-blog-relate" href="javascript:void(0)" onclick="delProductRelate(<?=$relate->relateProductId?>)"><i class="fa fa-trash-o"></i></a>
		<span class="blog-relate-name"><?=$relate->name?></span>
	</div>
<?php
		$i++;
	}
}?>
</div>
<?php include_once 'blog_relation_form_data.php';?>
