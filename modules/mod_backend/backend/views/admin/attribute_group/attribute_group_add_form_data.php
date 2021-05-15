<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$attrGroupVo = RequestUtil::get ( "attrGroupVo" );
$form = new FormContainer ();
$form->id = "attrGroupAddFormId";
$form->attributes = 'class="form-horizontal" enctype="multipart/form-data" method="post"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->type= "hidden";
	$text->name = "attrGroupVo[id]";
	$text->value = $attrGroupVo->id;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attrGroupVo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "attrGroupVo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "attrGroupVo[name]";
	$text->value = $attrGroupVo->name;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attrGroupVo[description]" );
	$text->hasError = RequestUtil::isFieldError ( "attrGroupVo[description]" );
	$text->label = Lang::get ( "Description" );
	$text->required = false;
	$text->name = "attrGroupVo[description]";
	$text->value = $attrGroupVo->description;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "attrGroupVo[order]" );
	$text->hasError = RequestUtil::isFieldError ( "attrGroupVo[order]" );
	$text->label = Lang::get ( "Order" );
	$text->required = false;
	$text->type= "number";
	$text->name = "attrGroupVo[order]";
	$text->value = $attrGroupVo->order;
	$text->render ();
	?>
</div>
<?php $form->renderEnd(); ?>
