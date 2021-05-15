<?php
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\FormContainer;
use common\utils\FileUtil;
use common\template\extend\TextInput;
use core\utils\RouteUtil;

//get data
$widgetContentLangs = RequestUtil::get ( "widgetContentLanguages" )->getArray ();
$widgetContentVo = RequestUtil::get("widgetContentVo");

$form = new FormContainer();
$form->id = "widget_content_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
<?php
	//widgetContent Id
	echo "<input type='hidden' name='widgetContentVo[id]' value='{$widgetContentVo->id}'>";
	echo "<input type='hidden' name='widgetContentVo[widgetController]' value='{$widgetContentVo->widgetController}'>";
	
	$text = new TextInput();
	$text->label = Lang::get ( "Widget name" );
	$text->required = true;
	$text->errorMessage = RequestUtil::getFieldError ( "widgetContentVo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "widgetContentVo[name]" );
	$text->name = "widgetContentVo[name]";
	$text->value = $widgetContentVo->name;
	$text->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Widget description" );
	$text->name = "widgetContentVo[description]";
	$text->value = $widgetContentVo->description;
	$text->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom class" );
	$text->name = "widgetContentVo[class]";
	$text->value = $widgetContentVo->class;
	$text->render ();
	
	$text = new TextInput();
	$text->label = Lang::get ( "Custom style" );
	$text->name = "widgetContentVo[style]";
	$text->value = $widgetContentVo->style;
	$text->render ();

    $select = new SelectInput();
    $select->value = $widgetContentVo->public;
    $select->name = "widgetContentVo[public]";
    $select->collections = ApplicationConfig::get("layout.yn.list");
    $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
    $select->label = Lang::get("Public");
    $select->render();

	//line
	echo '<hr class="hr-mini">';
	
	//load controller
	FileUtil::loadWidgetController($widgetContentVo);
	
	//run form method
    $mod = RouteUtil::getRoute()->getModule();
	$widgetController = str_replace('mod_', '', $mod) .'\widgets\\'. $widgetContentVo->widgetController;
	$control = new $widgetController($widgetContentVo, $widgetContentLangs);
	$control->form();
?>
</div>
<?php $form->renderEnd ();?>