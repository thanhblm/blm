<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\TextArea;

$contact = RequestUtil::get ( "contact" );

$form = new FormContainer ();
$form->id = "detail_contact_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" id="id" name="contact[id]" value="<?=$contact->id ?>" />
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "contact[fullName]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[fullName]" );
	$text->label = Lang::get ( "Full Name" );
	$text->readonly = true;
	$text->name = "contact[fullName]";
	$text->value = $contact->fullName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "contact[email]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[email]" );
	$text->label = Lang::get ( "Email" );
	$text->readonly = true;
	$text->name = "contact[email]";
	$text->value = $contact->email;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "contact[phone]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[phone]" );
	$text->label = Lang::get ( "Phone" );
	$text->readonly = true;
	$text->name = "contact[phone]";
	$text->value = $contact->phone;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "contact[countryName]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[countryName]" );
	$text->label = Lang::get ( "Country" );
	$text->readonly = true;
	$text->name = "contact[countryName]";
	$text->value = $contact->countryName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "contact[crDate]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[crDate]" );
	$text->label = Lang::get ( "Date" );
	$text->readonly = true;
	$text->name = "contact[crDate]";
	$text->value = $contact->crDate;
	$text->render ();
	
	$text = new TextArea ();
	$text->value = $contact->message;
	$text->name = "contact[message]";
	$text->class = "ckeditor";
	$text->label = Lang::get ( "Message" );
	$text->errorMessage = RequestUtil::getFieldError ( "contact[message]" );
	$text->hasError = RequestUtil::isFieldError ( "contact[message]" );
	$text->required = false;
	$text->render ();
	?>
</div>
<?php $form->renderEnd ();?>
<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>