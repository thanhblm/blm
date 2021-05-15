<?php
use common\persistence\base\vo\GridVo;
use common\services\layout\GridService;
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use common\template\extend\SelectInput;
use common\template\extend\ImageInput;


//get data
$containerId = RequestUtil::get("containerId");
$parentId = RequestUtil::get("parentId");
$gridDataList = RequestUtil::get('gridDataList');

$form = new FormContainer();
$form->id = "grid_add_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
<?php
	echo "<input type='hidden' name='gridVo[containerId]' value='$containerId'>";
	echo "<input type='hidden' name='gridVo[parentId]' value='$parentId'>";
	echo "<input type='hidden' name='gridVo[status]' value='active'>";
	echo "<input type='hidden' name='gridVo[order]' value='999'>";
	
	$select = new SelectInput ();
	$select->value = 12;	
	$select->name = "gridVo[width]";
	$select->collections = ApplicationConfig::get('layout.width.list');
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Width" );
	$select->render ();
	
	$select = new SelectInput ();
	$select->value = 'full_width';	
	$select->name = "gridVo[align]";
	$select->collections = ApplicationConfig::get ( "layout.grid.align.list");
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Content alignment" );
	$select->render ();
	
	$select = new SelectInput ();
	$select->value = 1;	
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
	$image->value = 0;
	$image->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Backgroud color" );
	$text->name = "gridVo[bgColor]";
	$text->value = '';
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = 'auto';
	$select->name = "gridVo[bgSize]";
	$select->collections = ApplicationConfig::get ( "layout.grid.background.size.list");
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Backgroud size" );
	$select->render ();

    $select = new SelectInput ();
    $select->value = 'no-repeat';
    $select->name = "gridVo[bgRepeat]";
    $select->collections = ApplicationConfig::get ( "layout.grid.background.repeat.list");
    $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
    $select->label = Lang::get ( "Backgroud repeat" );
    $select->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom class" );
	$text->name = "gridVo[class]";
	$text->value = '';
	$text->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom style" );
	$text->name = "gridVo[style]";
	$text->value = '';
	$text->render ();

    $select = new SelectInput ();
    $select->name = "gridVo[order]";
    $select->collections = $gridDataList;
    $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
    $select->label = Lang::get('After grid');
    $select->render ();
?>
</div>
<?php $form->renderEnd ();?>