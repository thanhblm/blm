<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use core\config\ApplicationConfig;
use common\template\extend\SelectInput;
use common\template\extend\Select;

$emailTemplate = RequestUtil::get ( "emailTemplate" );
?>
<div class="form-body">
	<?php
	$text = new Text ();
	$text->name = "emailTemplate[id]";
	$text->value = $emailTemplate->id;
	$text->type = "hidden";
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->name = "emailTemplate[title]";
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[title]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[title]" );
	$text->value = $emailTemplate->title;
	$text->label = Lang::get ( "Title" );
	$text->required = true;
	$text->type = "text";
	$text->render ();
	
	$select = new SelectInput('select_input_fluid');
	$select->value = $emailTemplate->sendTo;
	$select->name = "emailTemplate[sendTo]";
	$select->collections = ApplicationConfig::get ( "email.template.send.to.list" );
	$select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Send to" );
	$select->errorMessage = RequestUtil::getFieldError ( "emailTemplate[sendTo]" );
	$select->hasError = RequestUtil::isFieldError ( "emailTemplate[sendTo]" );
	$select->required = true;
	$select->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[subject]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[subject]" );
	$text->label = Lang::get ( "Subject" );
	$text->required = true;
	$text->name = "emailTemplate[subject]";
	$text->value = $emailTemplate->subject;
	$text->render ();
	
	$text = new TextArea ( 'textarea_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[body]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[body]" );
	$text->label = Lang::get ( "Body" );
	$text->required = true;
	$text->value = $emailTemplate->body;
	$text->name = "emailTemplate[body]";
	$text->class = "ckeditor";
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[from]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[from]" );
	$text->label = Lang::get ( "From" );
	$text->name = "emailTemplate[from]";
	$text->value = $emailTemplate->from;
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[to]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[to]" );
	$text->label = Lang::get ( "To" );
	$text->name = "emailTemplate[to]";
	$text->value = $emailTemplate->to;
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[reply]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[reply]" );
	$text->label = Lang::get ( "Reply" );
	$text->name = "emailTemplate[reply]";
	$text->value = $emailTemplate->reply;
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[cc]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[cc]" );
	$text->label = Lang::get ( "Cc" );
	$text->name = "emailTemplate[cc]";
	$text->value = $emailTemplate->cc;
	$text->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->errorMessage = RequestUtil::getFieldError ( "emailTemplate[bcc]" );
	$text->hasError = RequestUtil::isFieldError ( "emailTemplate[bcc]" );
	$text->label = Lang::get ( "Bcc" );
	$text->name = "emailTemplate[bcc]";
	$text->value = $emailTemplate->bcc;
	$text->render ();
	?>
</div>