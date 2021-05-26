<?php
use core\Lang;
use common\template\extend\TextInput;
use core\utils\RequestUtil;
use common\template\extend\TextArea;
use common\template\extend\Button;
//$subject = RequestUtil::get('subject');
//$message = RequestUtil::get('message');
?>
<form id="form_order_comment" name="form_order_comment" class="sale-reps-customer-orders">
	<div class="_form">
	<?php 
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "message[Subject]" );
	$text->hasError = RequestUtil::isFieldError ( "message[Subject]" );
	$text->label = Lang::get ( "Subject" );
	$text->required = true;
	$text->id = "history_subject";
	$text->name = "subject";
	//$text->value = $subject;
	$text->render ();
	
	$text = new TextArea();
	$text->errorMessage = RequestUtil::getFieldError ( "message[Message]" );
	$text->hasError = RequestUtil::isFieldError ( "message[Message]" );
	$text->label = Lang::get ( "Message" );
	$text->required = true;
	$text->id = "history_message";
	$text->name = "message";
	//$text->value = $message;
	$text->render ();
	?>
	</div>
	<div class="_buttons text-right" style="padding-right:20px">
	<?php 
		$button = new Button();
		$button->title = Lang::get("Send Message");
		$button->attributes = "type='button' onclick='sendMessageOrder()'";
		$button->render();
	?>
	</div>
</form>