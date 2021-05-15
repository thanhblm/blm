<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$slideGroupMo = RequestUtil::get ( "slideGroupMo" );
$form = new FormContainer ();
$form->id = "slideGroupAddFormId";
$form->attributes = 'class="form-horizontal" enctype="multipart/form-data" method="post"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "slideGroupMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "slideGroupMo[name]" );
	$text->label = Lang::get ( "Name" );
	$text->required = true;
	$text->name = "slideGroupMo[name]";
	$text->value = $slideGroupMo->name;
	$text->render ();

    $text = new TextInput ();
    $text->errorMessage = RequestUtil::getFieldError ( "slideGroupMo[code]" );
    $text->hasError = RequestUtil::isFieldError ( "slideGroupMo[code]" );
    $text->label = Lang::get ( "Code" );
    $text->required = true;
    $text->name = "slideGroupMo[code]";
    $text->value = $slideGroupMo->code;
    $text->render ();
	
	?>
</div>
<?php $form->renderEnd(); ?>