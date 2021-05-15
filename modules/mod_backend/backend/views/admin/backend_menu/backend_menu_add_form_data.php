<?php
use common\template\extend\FormContainer;
use core\Lang;
use common\template\extend\Text;
use common\template\extend\TextInput;
use common\template\extend\SelectInput;
use core\utils\RequestUtil;

//get data
$backendMenuVo = RequestUtil::get('backendMenuVo');
$backendMenuParentList = RequestUtil::get('backendMenuParentList');

$form = new FormContainer ();
$form->id = "add_backend_menu_form";
$form->renderStart();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[title]" );
	$text->hasError = RequestUtil::isFieldError ( "backendMenuVo[title]" );
	$text->required = true;
	$text->label = Lang::get ( "Title" );
	$text->name = "backendMenuVo[title]";
	$text->value = $backendMenuVo->title;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[link]" );
	$text->hasError = RequestUtil::isFieldError ( "backendMenuVo[link]" );
	$text->label = Lang::get ( "Link" );
	$text->name = "backendMenuVo[link]";
	$text->value = $backendMenuVo->link;
	$text->render ();
	
	$select = new SelectInput();
	$select->value = $backendMenuVo->parentId;
	$select->name = "backendMenuVo[parentId]";
	$select->collections = $backendMenuParentList;
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Parent" );
	$select->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[parentId]" );
	$select->hasError = RequestUtil::isFieldError ( "backendMenuVo[parentId]" );
	$select->required = true;
	$select->render ();
	
//	$text = new TextInput ();
//	$text->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[mod]" );
//	$text->hasError = RequestUtil::isFieldError ( "backendMenuVo[mod]" );
//	$text->required = true;
//	$text->label = Lang::get ( "Module" );
//	$text->name = "backendMenuVo[mod]";
//	$text->value = $backendMenuVo->mod;
//	$text->render ();
//
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[icon]" );
	$text->hasError = RequestUtil::isFieldError ( "backendMenuVo[icon]" );
	$text->label = Lang::get ( "Icon" );
	$text->name = "backendMenuVo[icon]";
	$text->value = $backendMenuVo->icon;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "backendMenuVo[order]" );
	$text->hasError = RequestUtil::isFieldError ( "backendMenuVo[order]" );
	$text->label = Lang::get ( "Order" );
	$text->name = "backendMenuVo[order]";
	$text->value = $backendMenuVo->order;
	$text->type = 'number';
	$text->render ();
	?>
</div>
<?php $form->renderEnd(); ?>