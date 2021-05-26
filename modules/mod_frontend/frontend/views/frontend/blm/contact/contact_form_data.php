<?php
use core\utils\RequestUtil;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\template\html\base\BaseSelect;
use common\template\extend\SelectInput;
use core\Lang;

$countryList = RequestUtil::get ( "countryList" );
$contact = RequestUtil::get ( "contact" );
?>
<form id="contact-form" name="contact" class="_contact  purlForm" onsubmit="return false;">
	<div class="_form">
		<?php 
		$text = new TextInput();
		$text->type= "text";
		$text->id = "contact-form-fullname";
		$text->class = " ";
		$text->name = "contact[fullName]";
		$text->value = $contact->fullName;
		$text->placeholder =  Lang::get('Fullname');
		$text->hasError = RequestUtil::isFieldError ( "contact[fullName]" );
		$text->errorMessage = "";
		$text->required = "required";
		$text->render();
		
		$text = new TextInput();
		$text->type= "text";
		$text->id = "contact-form-email";
		$text->class = " ";
		$text->name = "contact[email]";
		$text->placeholder =Lang::get('Email');
		$text->hasError = RequestUtil::isFieldError ( "contact[email]" );
		$text->errorMessage = RequestUtil::getFieldError("contact[emailmx]");
		$text->value = $contact->email;
		$text->required = "required";
		$text->render();
		
		$text = new TextInput();
		$text->type= "text";
		$text->id = "contact-form-phone";
		$text->class = " ";
		$text->name = "contact[phone]";
		$text->placeholder =Lang::get('Phone') ;
		$text->hasError = RequestUtil::isFieldError ( "contact[phone]" );
		$text->errorMessage = "";
		$text->value = $contact->phone;
		$text->required = "required";
		$text->render();
		
		$select = new SelectInput();
		$select->id = "contact-form-country";
		$select->class = " ";
		$select->headerKey = "";
		$select->headerValue = Lang::get('Country');
		$select->name = "contact[countryCode]";
		$select->value = $contact->countryCode;
		$select->propertyName = "iso2";
		$select->propertyValue = "name";
		$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
		$select->collections = $countryList;
		$select->hasError = RequestUtil::isFieldError("contact[countryCode]");
		$select->errorMessage = "";
		$select->required = "required";
		$select->render ();
		
		$textArea = new TextArea();
		$textArea->class = " ";
		$textArea->placeholder = Lang::get('Message');
		$textArea->id = "contact-form-message";
		$textArea->name = "contact[message]";
		$textArea->value = $contact->message;
		$textArea->attributes = "wrap=\"soft\" cols=\"15\" rows=\"4\"";
		$textArea->hasError = RequestUtil::isFieldError("contact[message]");
		$textArea->errorMessage = "";
		$textArea->required = "required";
		$textArea->render ();
		?>
	</div>
	<div class="_buttons">
		<button type="submit" onclick="addContact()">
			<span><?=Lang::get('Send Message')?></span>
		</button>
	</div>
</form>