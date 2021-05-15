<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use common\template\extend\Select;

$categoryBlog = RequestUtil::get ( "categoryBlog" );
?>
<div class="form-body">
	<?php

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "categoryBlog[name]" );
	$text->required = true;
	$text->hasError = RequestUtil::isFieldError ( "categoryBlog[name]" );
	$text->label = Lang::get ( "Name" );
	$text->name = "categoryBlog[name]";
	$text->value = $categoryBlog->name;
	$text->render ();

	$select = new SelectInput ();
	$select->value = $categoryBlog->status;
	$select->name = "categoryBlog[status]";
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select one" );
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "categoryBlog[status]" );
	$select->hasError = RequestUtil::isFieldError ( "categoryBlog[status]" );
	$select->required = true;
	$select->render ();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "categoryBlog[orderNo]" );
	$text->required = true;
	$text->hasError = RequestUtil::isFieldError ( "categoryBlog[orderNo]" );
	$text->label = Lang::get ( "Order" );
	$text->name = "categoryBlog[orderNo]";
	$text->value = $categoryBlog->orderNo;
	$text->type = 'number';
	$text->attributes = 'min=0';
	$text->render ();

	$image = new ImageInput ();
	$image->label = Lang::get ( "Background image" );
	$image->name = "categoryBlog[bgImg]";
	$image->value = $categoryBlog->bgImg;
	$image->hasImgAction = true;
	$image->id = "bgImg_{$categoryBlog->id}";
	$image->profileId = "category_blog";
	$image->row = 1;
	$image->render ();

	$image = new ImageInput ();
	$image->label = Lang::get ( "Big icon" );
	$image->name = "categoryBlog[bigIcon]";
	$image->value = $categoryBlog->bigIcon;
	$image->hasImgAction = true;
	$image->id = "bigIcon_{$categoryBlog->id}";
	$image->row = 1;
	$image->profileId = "category_blog";
	$image->render ();

	$image = new ImageInput ();
	$image->label = Lang::get ( "Small icon" );
	$image->name = "categoryBlog[smallIcon]";
	$image->value = $categoryBlog->smallIcon;
	$image->hasImgAction = true;
	$image->profileId = "category_blog";
	$image->id = "smallIcon_{$categoryBlog->id}";
	$image->row = 1;
	$image->render ();

	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "categoryBlog[description]" );
	$text->hasError = RequestUtil::isFieldError ( "categoryBlog[description]" );
	$text->label = Lang::get ( "Description" );
	$text->name = "categoryBlog[description]";
	$text->value = $categoryBlog->description;
	$text->class = "ckeditor";
	$text->render ();

	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "categoryBlog[introduction]" );
	$text->hasError = RequestUtil::isFieldError ( "categoryBlog[introduction]" );
	$text->label = Lang::get ( "Introduction" );
	$text->name = "categoryBlog[introduction]";
	$text->value = $categoryBlog->introduction;
	$text->class = "ckeditor";
	$text->render ();
	?>
</div>
