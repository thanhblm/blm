<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;
use common\template\extend\TextArea;
$blockEmail = RequestUtil::get ( "blockEmail" );
$form = new FormContainer ();
$form->id = "edit_block_email_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" name="blockEmail[id]" value="<?=$blockEmail->id?>"/>
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "blockEmail[email]" );
	$text->hasError = RequestUtil::isFieldError ( "blockEmail[email]" );
	$text->label = Lang::get ( "Email" );
	$text->required = true;
	$text->name = "blockEmail[email]";
	$text->value = $blockEmail->email;
	$text->render ();
	
	?>
</div>
<?php $form->renderEnd ();?>