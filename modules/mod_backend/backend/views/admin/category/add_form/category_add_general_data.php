<?php
use common\template\extend\ImageInput;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;

$category = RequestUtil::get ( "category" );
$categoryList = RequestUtil::get("categoryList");
?>
<div class="form-body">
	<?php
	$text = new Text ();
	$text->name = "category[id]";
	$text->value = $category->id;
	$text->type = "hidden";
	$text->render ();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "category[name]" );
	$text->required = true;
	$text->hasError = RequestUtil::isFieldError ( "category[name]" );
	$text->label = Lang::get ( "Name" );
	$text->name = "category[name]";
	$text->value = $category->name;
	$text->render ();


	$select = new SelectInput ();
	$select->value = $category->status;
	$select->name = "category[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select one" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "category[status]" );
	$select->hasError = RequestUtil::isFieldError ( "category[status]" );
	$select->required = true;
	$select->render ();

	$select = new SelectInput ();
	$select->value = $category->parentId;
	$select->name = "category[parentId]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select parent" );
	$select->collections = $categoryList;
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->label = Lang::get ( "Parent menu" );
	$select->errorMessage = RequestUtil::getFieldError ( "category[parentId]" );
	$select->hasError = RequestUtil::isFieldError ( "category[parentId]" );
	$select->required = true;
	$select->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "category[orderNo]" );
	$text->required = true;
	$text->hasError = RequestUtil::isFieldError ( "category[orderNo]" );
	$text->label = Lang::get ( "Order" );
	$text->name = "category[orderNo]";
	$text->value = $category->orderNo;
	$text->type = 'number';
	$text->attributes = 'min=0';
	$text->render ();
	
	?>

	<div class="form-group ">
		<label class="control-label col-md-4"><?= Lang::get("Featured") ?> </label>
		<div class="col-md-8">
			<input type="radio" name="category[featured]" value="yes"><?=Lang::get('Yes')?>&nbsp;
			<input type="radio" name="category[featured]" value="no" checked="checked"><?=Lang::get('No')?>
		</div>
	</div>
	
	<?php
	$image = new ImageInput ();
	$image->label = Lang::get ( "Background image" );
	$image->name = "category[bgImg]";
	$image->value = $category->bgImg;
	$image->hasImgAction = true;
	$image->id = "bgImg_{$category->id}";
	$image->profileId = "category";
	$image->row = 1;
	$image->render ();

	$image = new ImageInput ();
	$image->label = Lang::get ( "Big icon" );
	$image->name = "category[bigIcon]";
	$image->value = $category->bigIcon;
	$image->hasImgAction = true;
	$image->id = "bigIcon_{$category->id}";
	$image->profileId = "category";
	$image->row = 1;
	$image->render ();

	$image = new ImageInput ();
	$image->label = Lang::get ( "Small icon" );
	$image->name = "category[smallIcon]";
	$image->value = $category->smallIcon;
	$image->hasImgAction = true;
	$image->id = "smallIcon_{$category->id}";
	$image->profileId = "category";
	$image->row = 1;
	$image->render ();

	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "category[description]" );
	$text->hasError = RequestUtil::isFieldError ( "category[description]" );
	$text->label = Lang::get ( "Description" );
	$text->name = "category[description]";
	$text->value = $category->description;
	$text->class = "ckeditor";
	$text->render ();

	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "category[introduction]" );
	$text->hasError = RequestUtil::isFieldError ( "category[introduction]" );
	$text->label = Lang::get ( "Introduction" );
	$text->name = "category[introduction]";
	$text->value = $category->introduction;
	$text->class = "ckeditor";
	$text->render ();
	?>
</div>
