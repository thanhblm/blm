<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use common\template\extend\ImageInput;

//get data
$gridVo = RequestUtil::get("gridVo");

$form = new FormContainer();
$form->id = "grid_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
<?php
	//gridId
	echo "<input type='hidden' name='gridVo[id]' value='{$gridVo->id}'>";
	
	$select = new SelectInput ();
	$select->value = $gridVo->width;
	$select->name = "gridVo[width]";
	$select->collections = ApplicationConfig::get('layout.width.list');
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Width" );
	$select->render ();
	
	$select = new SelectInput ();
	$select->value = $gridVo->align;
	$select->name = "gridVo[align]";
	$select->collections = ApplicationConfig::get ( "layout.grid.align.list");
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Content alignment" );
	$select->render ();
	
	$select = new SelectInput ();
	$select->value = $gridVo->fluidContainer;
	$select->name = "gridVo[fluidContainer]";
	$select->collections = ApplicationConfig::get ( "layout.yn.list");
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Fluid container" );
	$select->render ();
	
	$image = new ImageInput();
	$image->name = "gridVo[bgImage]";
	$image->label = Lang::get ( "Backgroud image" );
	$image->hasImgAction = true;
	$image->id = "bgImage";
	$image->profileId = 'layout';
	$image->value = $gridVo->bgImage;
	$image->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Backgroud color" );
	$text->name = "gridVo[bgColor]";
	$text->value = $gridVo->bgColor;
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = $gridVo->bgSize;
	$select->name = "gridVo[bgSize]";
	$select->collections = ApplicationConfig::get ( "layout.grid.background.size.list");
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Backgroud size" );
	$select->render ();

    $select = new SelectInput ();
    $select->value = $gridVo->bgRepeat;
    $select->name = "gridVo[bgRepeat]";
    $select->collections = ApplicationConfig::get ( "layout.grid.background.repeat.list");
    $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
    $select->label = Lang::get ( "Backgroud repeat" );
    $select->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom class" );
	$text->name = "gridVo[class]";
	$text->value = $gridVo->class;
	$text->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom style" );
	$text->name = "gridVo[style]";
	$text->value = $gridVo->style;
	$text->render ();
?>
</div>
<?php $form->renderEnd ();?>