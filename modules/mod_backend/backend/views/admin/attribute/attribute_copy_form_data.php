<?php
use common\template\extend\FormContainer;
use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$attributeVo = RequestUtil::get ( "attributeVo" );
$categories = RequestUtil::get ( "categoryList" );
$attrGroupList = RequestUtil::get ( "attrGroupList" );
$form = new FormContainer ();
$form->id = "attributeCopyFormId";
$form->attributes = 'class="form-horizontal" enctype="multipart/form-data" method="post"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$select = new SelectInput ();
	$select->id = "category";
	$select->name = "attributeVo[categoryId]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = $categories;
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->value = $attributeVo->categoryId;
	$select->label = Lang::get("Category");
	$select->errorMessage = RequestUtil::getFieldError("attributeVo[categoryId]");
	$select->hasError = RequestUtil::isFieldError("attributeVo[categoryId]");
	$select->required = true;
	$select->class = "form-control input-sm";
	$select->render();
	
	$select = new SelectInput ();
	$select->id = "attr_group";
	$select->name = "attributeVo[attrGroupId]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collections = $attrGroupList;
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->value = $attributeVo->attrGroupId;
	$select->label = Lang::get("Attribute Group");
	$select->errorMessage = RequestUtil::getFieldError("attributeVo[attrGroupId]");
	$select->hasError = RequestUtil::isFieldError("attributeVo[attrGroupId]");
	$select->required = true;
	$select->class = "form-control input-sm";
	$select->render();
	
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attributeVo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "attributeVo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "attributeVo[name]";
	$text->value = $attributeVo->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attributeVo[type]" );
	$text->hasError = RequestUtil::isFieldError ( "attributeVo[type]" );
	$text->label = Lang::get ( "Type" );
	$text->required = false;
	$text->name = "attributeVo[type]";
	$text->value = $attributeVo->type;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attributeVo[description]" );
	$text->hasError = RequestUtil::isFieldError ( "attributeVo[description]" );
	$text->label = Lang::get ( "Description" );
	$text->required = false;
	$text->name = "attributeVo[description]";
	$text->value = $attributeVo->description;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attributeVo[order]" );
	$text->hasError = RequestUtil::isFieldError ( "attributeVo[order]" );
	$text->label = Lang::get ( "Order" );
	$text->required = false;
	$text->type= "number";
	$text->name = "attributeVo[order]";
	$text->value = $attributeVo->order;
	$text->render ();
	
	$image = new ImageInput();
	$image->errorMessage = RequestUtil::getFieldError ( "attributeVo[image]" );
	$image->hasError = RequestUtil::isFieldError ( "attributeVo[image]" );
	$image->label = Lang::get("Image");
	$image->id = "image";
	$image->hasImgAction = true;
	$image->name = "attributeVo[image]";
	$image->value = $attributeVo->image;
	$image->profileId = "attribute";
	$image->render();
	
	?>

</div>
<?php $form->renderEnd(); ?>
