<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$urlRedirect = RequestUtil::get ( "urlRedirect" );

$form = new FormContainer ();
$form->id = "edit_url_redirect_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" id="id" name="urlRedirect[id]" value="<?=$urlRedirect->id ?>" />
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "urlRedirect[oldUrl]" );
	$text->hasError = RequestUtil::isFieldError ( "urlRedirect[oldUrl]" );
	$text->label = Lang::get ( "Old Url" );
	$text->required = true;
	$text->name = "urlRedirect[oldUrl]";
	$text->value = $urlRedirect->oldUrl;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "urlRedirect[newUrl]" );
	$text->hasError = RequestUtil::isFieldError ( "urlRedirect[newUrl]" );
	$text->label = Lang::get ( "New Url" );
	$text->required = true;
	$text->name = "urlRedirect[newUrl]";
	$text->value = $urlRedirect->newUrl;
	$text->render ();
	?>
</div>
<?php $form->renderEnd ();?>