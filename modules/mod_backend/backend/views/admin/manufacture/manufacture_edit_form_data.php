<?php
use common\template\extend\FormContainer;
use common\template\extend\ImageInput;
use common\template\extend\Link;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
$manufactureMo = RequestUtil::get ( "manufactureMo" );
$form = new FormContainer ();
$statusList = ApplicationConfig::get("common.status.list");
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
	<div class="form-body">
<?php

$text = new TextInput ();
$text->type = "hidden";
$text->value = $manufactureMo->id;
$text->name = "manufactureMo[id]";
$text->render ();

$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "manufactureMo[title]" );
$text->hasError = RequestUtil::isFieldError ( "manufactureMo[title]" );
$text->label = Lang::get ( "Title" );
$text->required = true;
$text->value = $manufactureMo->title;
$text->name = "manufactureMo[title]";
$text->render ();

$image = new ImageInput();
$image->name = "manufactureMo[image]";
$image->label = Lang::get ( "Image" );
$image->hasImgAction = true;
$image->id = "manufacture";
$image->required = true;
$image->profileId = 'manufacture';
$image->value = $manufactureMo->image;
$image->render ();

$text = new TextArea();
$text->errorMessage = RequestUtil::getFieldError ( "manufactureMo[description]" );
$text->hasError = RequestUtil::isFieldError ( "manufactureMo[description]" );
$text->label = Lang::get ( "Description" );
$text->name = "manufactureMo[description]";
$text->class = "form-control";
$text->value = $manufactureMo->description;
$text->render ();


$select = new SelectInput();
$select->headerKey = "";
$select->headerValue = Lang::get ( "Select One" );
$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
$select->hasError = RequestUtil::isFieldError ( "manufactureMo[status]" );
$select->required = true;
$select->name = "manufactureMo[status]";
$select->label = Lang::get ( "Status" );
$select->collections = $statusList;
$select->class = "form-control";
$select->errorMessage = RequestUtil::getFieldError("manufactureMo[status]");
$select->value = $manufactureMo->status;
$select->render();

?>
<?php $form->renderEnd ();?>